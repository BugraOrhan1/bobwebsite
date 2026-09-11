<?php

use Uniform\Form;


return function ($site, $pages, $page)
{

    $form = new Form([
        'fullName' => [
            'rules' => ['required'],
            'message' => 'Please enter your name',
        ],
        'email' => [
            'rules' => ['required', 'email'],
            'message' => 'Please enter a valid email address',
        ],
        'phone' => [
            'rules' => ['required'],
            'message' => 'Please enter a valid phone number',
        ],
        'filefield' => [
            'rules' => [
                //'required',
                'file',
                'mime' => ['image/jpeg'],
                'filesize' => 2000,
            ],
            'message' => [
                'Please choose a jpeg foto.',
                'Please choose a jpeg foto.',
                'Please choose a jpeg.',
                'Please choose a jpeg foto that is smaller than 2 MB.',
            ],
        ],
        'message' => [],
    ]);
 
    if (r::is('POST')) {

        $uid = md5(uniqid(time()));

        $form->uploadAction(['fields' => [
            'filefield' => [
                'target' => kirby()->roots()->content(),
                //'prefix' => 'up_'.$uid."_"
            ],
        ]])->logAction([
            'file' => kirby()->roots()->site().'/uploadAction.log',
        ]);
         
       
        $snippet = snippet('email/my-email',
            ['fullname' => '2']
            , true);

        $form->emailAction([
            'to' => 'y.gungormus@gmail.com',
            'from' => 'De Reinigingsdokter <mail@rwesselink.nl>',
            // Dynamically generate the subject with a template.
            'subject' => 'Bedankt voor je contact met De Reinigingsdokter v3',
            //'snippet' => 'email/my-email',
            //'snippet' => 'email-html',
            'service' => 'phpmailer',
            'service-options' => [
                 'attachment' => $_FILES['filefield'],
           ],
        ]);

        //echo 'content: ' . kirby()->roots()->content();

        //die("Error bij het versturen van de email:" . $form->success());

        if ($form->success()) {
            go(page('contact/bedankt')->url());
        } else {
            die("Error bij het versturen van de email");
        }
    }

    return compact('form');
};

