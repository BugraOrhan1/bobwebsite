<?php

// PHPMailer bestanden inladen (omzeilt Kirby volledig)
require_once kirby()->roots()->index() . '/site/plugins/phpmailer/Exception.php';
require_once kirby()->roots()->index() . '/site/plugins/phpmailer/PHPMailer.php';
require_once kirby()->roots()->index() . '/site/plugins/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

return function ($site, $pages, $page) {
    $alert = array('succes' => false);
    $errorForm = [];

    $data = array(
        'fullName'   => htmlspecialchars(get('fullName') ?? '', ENT_QUOTES),
        'phone'      => get('phone'),
        'email'      => get('email'),
        'woonplaats' => htmlspecialchars(get('woonplaats') ?? '', ENT_QUOTES),
        'lead'       => get('lead'),
        'message'    => htmlspecialchars(get('message') ?? '', ENT_QUOTES),
    );

    if (r::is('POST')) {

        // Validatie van de formuliervelden
        $rules = array(
            'fullName' => array('required'),
            'email'    => array('required', 'email'),
            'message'  => array('required', 'min' => 6, 'max' => 500),
        );
        
        $messages = array(
            'fullName' => 'Vul uw naam in',
            'email'    => 'Vul een geldig e-mailadres in',
            'message'  => 'Dit veld is verplicht. Vul tussen de 6 en 500 karakters in.',
        );

        // Bijlage controleren (max 2MB)
        $file = $_FILES['filefield'] ?? null;
        if (!empty($file['tmp_name'])) {
            $maxSize = 2 * 1024 * 1024;
            if ($file['size'] > $maxSize) {
                $errorForm['filefield'] = array('De bestanden moeten kleiner zijn dan 2MB.');
            }
        }

        $invalid = invalid($data, $rules, $messages);
        if ($invalid) {
            $errorForm = array_merge($errorForm, $invalid);
        }

        if (empty($errorForm)) {

            $mail = new PHPMailer(true);

            try {
                // Server instellingen (SMTP)
               // SMTP Instellingen specifiek voor Mijndomein.nl
				$mail->isSMTP();
				$mail->Host       = 'mail.mijndomein.nl';                // De vaste SMTP server van Mijndomein
				$mail->SMTPAuth   = true;                                // Authenticatie verplicht
				$mail->Username   = 'info@reinigingsdokter.nl';          // Volledige e-mailadres
				$mail->Password   = 'Havikstraat124!';         // Het wachtwoord van dit e-mailaccount
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        // Gebruik SSL
				$mail->Port       = 465;                                 // Vaste SSL-poort bij Mijndomein

// Beveiligingsinstelling om certificaatfouten tussen servers te voorkomen
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer'       => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true
    )
);

                // Ontvangers & Afzender
                $mail->setFrom('info@reinigingsdokter.nl', 'De Reinigingsdokter Formulier');
                $mail->addAddress('info@reinigingsdokter.nl');
                $mail->addReplyTo($data['email'], $data['fullName']);
                //$mail->addBCC('mail@rwesselink.nl');

                // Bijlage toevoegen indien aanwezig
                if (!empty($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) {
                    $mail->addAttachment($file['tmp_name'], $file['name']);
                }

                // E-mail inhoud
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = $data['fullName'] . ' | ' . $data['email'];
                $mail->Body    = snippet('email/mail', $data, true);

                // Verzenden
                $mail->send();

                go(page('contact/bedankt')->url());
                $alert = array(
                    'succes' => true,
                    'cleanPost' => true
                );

            } catch (Exception $e) {
                echo '<pre>Fout bij verzenden: ' . $mail->ErrorInfo . '</pre>';
                die();
            }
        }
    }

    return compact('alert', 'errorForm', 'data');
};