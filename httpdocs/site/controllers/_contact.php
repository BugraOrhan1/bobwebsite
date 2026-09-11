<?php

return function ($site, $pages, $page) {

    $alert = array('succes' => false);
    $errorForm = array();

    $data = array(
        'fullName' => get('fullName'),
        'phone'    => get('phone'),
        'email'    => get('email'),
        'message'  => get('message')
    );

    if (r::is('POST')) {

        // 1. Validatieregels voor tekstvelden
        $rules = array(
            'fullName' => array('required'),
            'email'    => array('required', 'email'),
            'message'  => array('required', 'min' => 6, 'max' => 500)
        );

        $messages = array(
            'fullName' => 'Vul uw naam in',
            'email'    => 'Vul een geldig e-mailadres in',
            'message'  => 'Dit veld is verplicht. Vul tussen de 6 en 500 karakters in.'
        );

        // Formuliervelden valideren via Kirby v2 invalid()
        if ($invalid = invalid($data, $rules, $messages)) {
            $errorForm = $invalid;
        }

        // 2. Bestand uit $_FILES valideren en voorbereiden
        $attachments = array();
        if (isset($_FILES['filefield']) && $_FILES['filefield']['error'] === UPLOAD_ERR_OK) {
            
            // Check bestandsgrootte (2MB = 2097152 bytes)
            if ($_FILES['filefield']['size'] > 2097152) {
                $errorForm['filefield'] = 'Het bestand moet kleiner zijn dan 2MB.';
            } else {
                // Sla de tijdelijke uploadlocatie op voor de bijlage
                $attachments[] = $_FILES['filefield']['tmp_name'];
            }
        } elseif (isset($_FILES['filefield']) && $_FILES['filefield']['error'] !== UPLOAD_ERR_NO_FILE) {
            $errorForm['filefield'] = 'Er is een fout opgetreden bij het uploaden van het bestand.';
        }

        // 3. Als er geen validatiefouten zijn, de mail versturen
        if (empty($errorForm)) {

            $email = email(array(
                'to'          => 'info@reinigingsdokter.nl',
                'from'        => 'info@reinigingsdokter.nl',
                'replyTo'     => $data['email'],
                'subject'     => 'Contactformulier: ' . $data['fullName'],
                'service'     => 'mail',
                'body'        => snippet('email/mail', $data, true),
                'serviceParams' => array(
                    'attachments' => $attachments
                )
            ));

            if ($email->send()) {
                // Succesvol verzonden: stuur door naar de bedanktpagina
                go(page('contact/bedankt')->url());
            } else {
                $errorForm['general'] = 'Er is een fout opgetreden bij het versturen: ' . $email->error()->getMessage();
            }

        }

    }

    return compact('alert', 'errorForm', 'data');
};