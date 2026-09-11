<?php

Kirby::plugin('jobkit/application', [
    'hooks' => [
        'kirbytags:after' => function ($text, $data, $options) {
            $session = kirby()->session();

            if ($job = $session->get('reference')) {
                if ($page = page('jobs')->children()->findBy('reference', urldecode($job))) {
                    $title = $page->title() . ' - Reference ' . $job;
                }
            }

            return Str::template($text, [
                'job'   => $title ?? '',
                'name'  => $session->get('name') ?? ''
            ]);
        }
    ],
]);