<?php

return function($site, $pages, $page) {
    $alert = array('succes' => false);

    if (r::is('post') && get('contactme')  ) {

        $data = array(
            'fullName' => get('fullName'),
            'phone' => get('phone'),
            'email' => get('email'),
            'filefield' => get('filefield'),
            'message' => get('message')
        );
        $rules = array(
            'fullName' => array('required'),
            'email' => array('required', 'email'),
            'message' => array('required', 'min' => 3, 'max' => 3000),
            'filefield' => ['mime' => ['image/jpeg'], 'filesize' => 1000,],
        );
        $messages = array(
            'fullName' => 'please enter a valid fullName',
            'email' => 'please enter a valid email address',
            'message' => 'please enter a reaction between 3 and 3000 characters',
            'filefield' => [
                'Verstuur alleen jpg bestand types.',
                'De bestanden moet kleiner zijn dan 1MB .',
            ],
        );

        if ($invalid = invalid($data, $rules, $messages)) {
            $alert = $invalid;
        } else {
            $filefields = kirby()->request()->files()['filefield'];
            echo " Contact filefields => ";
            dump($filefields);

            $uploads = kirby()->request()->files();
            $attachments = [];
            $content=null;
            foreach ($uploads as $upload) {

                echo "<br/> Contact upload [1]=> ";
                dump($upload);

                // if no file is uploaded (its not required)
                if ($upload['error'] === 4) {

                    // do nothing

                } else {


//                    $tmp_name = $upload['tmp_name'];
//                    $name     = $upload['name'];
//                    echo "<br/> Contact name => ";
//                    dump($name);

                    //$tmpName  = pathinfo($name);
                    // sanitize the original filename
                    //$filename = $tmpName['dirname']. '/'. F::safeName($upload['name']);

//                    if (rename($upload['tmp_name'], $filename)) {
//                        $name = $filename;
//                    }
                    // add the files to the attachments array
                    //$attachments[0] = $tmp_name . '/' . $name;
//
//                    $name     = $upload['tmp_name'];
//                    $tmpName  = pathinfo($name);
//                    $filename = $tmpName['dirname']. '/'. F::safeName($upload['name']);
//                    if (rename($upload['tmp_name'], $filename)) {
//                        $filePath = $filename;
//                    }
//
//                    $fileSize   = filesize($filePath);
//                    $handle     = fopen($filePath, "r");
//                    $content    = fread($handle, $fileSize);
//                    fclose($handle);
//                    $content = chunk_split(base64_encode($content));
                    // add the files to the attachments array

                }
            }
            echo "<br/> content => ";
            var_dump($content);


            $emailData = email(array(
                'to' => 'Ron <mail@rwesselink.nl>',
                'from' => 'Website reinigingsdokter <mail@rwesselink.nl>',
                'subject' => C::get('email.subject') . $data['fullName'],
            ));

            $body = snippet('email/mail', $data, true);

/////////////////////

$upload  = kirby()->request()->files()['filefield'];



$name     = $upload['tmp_name'];
$tmpName  = pathinfo($name);
$filename = $tmpName['dirname']. '/'. F::safeName($upload['name']);
if (rename($upload['tmp_name'], $filename)) {
    $filePath = $filename;
}

$fileSize   = filesize($filePath);
$handle     = fopen($filePath, "r");
$content    = fread($handle, $fileSize);
fclose($handle);
$content = chunk_split(base64_encode($content));
$uid = md5(uniqid(time()));
$name = basename($filePath);

//echo "<br/> name => ".$name;
//echo "<br/> filePath => ".$filePath;
//echo "<br/> fileSize => " . $fileSize;
//var_dump($tmpName);
//echo "<br/> content => ";
//var_dump($content);
//die();

$eol = PHP_EOL;

// Basic headers
$header = "From: " . $emailData->from .$eol;
$header .= "Reply-To: ".$emailData->replyTo.$eol;
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"";

// Put everything else in $message
$message = "--".$uid.$eol;
$message .= "Content-Type: text/html; charset=ISO-8859-1".$eol;
$message .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$message .= $body.$eol;
$message .= "--".$uid.$eol;
$message .= "Content-Type: image/jpeg; name=\"".$name."\"".$eol;
$message .= "Content-Disposition: attachment; filename=\"".$name."\" size=\"".$fileSize."\"".$eol;
$message .= "Content-Transfer-Encoding: base64".$eol . $content . $eol;
$message .= "--".$uid."--";


$send = mail($emailData->to, $emailData->subject, $message, $header);






//            ini_set('sendmail_from', $emailData->from);
//            $send = mail($emailData->to,
//                str::utf8($emailData->subject),
//                str::utf8($body),
//                implode(PHP_EOL, $headers));
//            ini_restore('sendmail_from');

//            $send = $site->email([
//                'to' => 'Ron <mail@rwesselink.nl>',
//                'from' => 'Website reinigingsdokter <mail@rwesselink.nl>',
//                'subject' => 'Welcome!',
//                'body' => 'Here are some attachments',
//                'attachments' => [
//                    $content
//                ]
//
//            ])->isSent();

            die('<br/>end log :' . $send);

            if(!$send) {
                $alert = array($emailData->error());
                throw new Error('The email could not be sent');
            } else {

                go( $site->find('contact'). '/#goed' );

                $alert = array(
                    'succes' => true,
                    'cleanPost' => true
                );
                return compact('alert');
            }
        }
    } else {

        $alert = array('succes' => false);
    }

    return compact('alert');
};