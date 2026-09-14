<?php
/**
 * Mailversturing De Reinigingsdokter.
 * Voorkeur: SMTP (mail.mijndomein.nl) zodra ingesteld in beheer;
 * anders terugval op PHP mail(). Elke poging wordt gelogd in
 * data/mail.log zodat problemen op afstand diagnoseerbaar zijn.
 * PHP 7.4-compatibel.
 */

function mail_log(string $line): void
{
    $file = DATA_DIR . '/mail.log';
    @file_put_contents($file, date('Y-m-d H:i:s') . ' ' . $line . "\n", FILE_APPEND | LOCK_EX);
    if (@filesize($file) > 60000) {
        $lines = @file($file);
        if ($lines) @file_put_contents($file, implode('', array_slice($lines, -100)));
    }
}

function mail_log_tail(int $n = 12): string
{
    $lines = @file(DATA_DIR . '/mail.log');
    if (!$lines) return '(nog geen mail-verkeer gelogd)';
    return implode('', array_slice($lines, -$n));
}

/**
 * Verstuur een e-mail. Retourneert [bool gelukt, string foutmelding].
 */
function rds_mail_send(string $to, string $subject, string $body, string $replyTo = ''): array
{
    if ($to === '') return [false, 'Geen ontvanger'];

    $host = trim((string)setting('smtp_host'));
    $user = trim((string)setting('smtp_user'));
    $pass = (string)setting('smtp_pass');
    $port = (int)(setting('smtp_port') ?: 587);

    $fromMail = trim((string)setting('contact_email')) ?: ($user ?: 'info@reinigingsdokter.nl');
    $subjectEnc = '=?UTF-8?B?' . base64_encode($subject) . '?=';

    $headers = 'From: ' . setting('site_title') . ' <' . $fromMail . ">\r\n"
        . ($replyTo !== '' ? 'Reply-To: ' . $replyTo . "\r\n" : '')
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: text/plain; charset=UTF-8\r\n"
        . "Content-Transfer-Encoding: 8bit\r\n"
        . 'Date: ' . date('r') . "\r\n"
        . 'Message-ID: <' . bin2hex(random_bytes(8)) . '@reinigingsdokter.nl>' . "\r\n";

    if ($host !== '' && $user !== '' && $pass !== '') {
        return rds_smtp_send($host, $port, $user, $pass, $fromMail, $to, $subjectEnc, $body, $headers);
    }

    $ok = @mail($to, $subjectEnc, $body, $headers);
    mail_log('mail() -> ' . $to . ' : ' . ($ok ? 'OK' : 'FOUT (mail() gaf false)'));
    return [$ok !== false, $ok ? '' : 'PHP mail() gaf false terug'];
}

/**
 * Minimale SMTP-client met STARTTLS/SSL en AUTH LOGIN.
 */
function rds_smtp_send(string $host, int $port, string $user, string $pass, string $from,
                       string $to, string $subjectEnc, string $body, string $headers): array
{
    $errno = 0;
    $errstr = '';
    $remote = ($port === 465 ? 'ssl://' : '') . $host;
    $fp = @stream_socket_client($remote . ':' . $port, $errno, $errstr, 15);
    if (!$fp) {
        mail_log('SMTP connect FOUT (' . $remote . ':' . $port . '): ' . $errno . ' ' . $errstr);
        return [false, 'Kon geen verbinding maken met ' . $host . ':' . $port . ' (' . $errstr . ')'];
    }
    stream_set_timeout($fp, 15);

    $read = function () use ($fp): string {
        $data = '';
        while (($line = fgets($fp, 512)) !== false) {
            $data .= $line;
            if (isset($line[3]) && $line[3] === ' ') break;
        }
        return $data;
    };
    $err = '';
    $expect = function (array $codes) use ($read, &$err): bool {
        $resp = $read();
        if (!in_array((int)substr($resp, 0, 3), $codes, true)) {
            $err = trim($resp);
            return false;
        }
        return true;
    };
    $cmd = function (string $c) use ($fp): void { fwrite($fp, $c . "\r\n"); };
    $fail = function (string $step) use ($fp, &$err): array {
        mail_log('SMTP ' . $step . ' FOUT: ' . $err);
        fclose($fp);
        return [false, $step . ' mislukt: ' . $err];
    };

    if (!$expect([220])) return $fail('banner');
    $cmd('EHLO reinigingsdokter.nl');
    if (!$expect([250])) return $fail('EHLO');

    if ($port !== 465) {
        $cmd('STARTTLS');
        if (!$expect([220])) return $fail('STARTTLS');
        if (!@stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            $err = 'TLS-onderhandeling mislukt';
            return $fail('TLS');
        }
        $cmd('EHLO reinigingsdokter.nl');
        if (!$expect([250])) return $fail('EHLO2');
    }

    $cmd('AUTH LOGIN');
    if (!$expect([334])) return $fail('AUTH-start');
    $cmd(base64_encode($user));
    if (!$expect([334])) return $fail('AUTH-user');
    $cmd(base64_encode($pass));
    if (!$expect([235])) return $fail('AUTH-wachtwoord (controleer SMTP-wachtwoord)');

    $cmd('MAIL FROM:<' . $from . '>');
    if (!$expect([250])) return $fail('MAIL FROM');
    $cmd('RCPT TO:<' . $to . '>');
    if (!$expect([250, 251])) return $fail('RCPT TO');
    $cmd('DATA');
    if (!$expect([354])) return $fail('DATA');

    $crlfBody = str_replace("\r\n", "\n", $body);
    $crlfBody = str_replace("\n", "\r\n", $crlfBody);
    $crlfBody = str_replace("\r\n.", "\r\n..", $crlfBody); // dot-stuffing
    $msg = 'To: ' . $to . "\r\n"
        . 'Subject: ' . $subjectEnc . "\r\n"
        . $headers . "\r\n"
        . $crlfBody . "\r\n.";
    $cmd($msg);
    if (!$expect([250])) return $fail('verzend-bevestiging');

    $cmd('QUIT');
    fclose($fp);
    mail_log('SMTP -> ' . $to . ' : OK (' . $host . ':' . $port . ')');
    return [true, ''];
}
