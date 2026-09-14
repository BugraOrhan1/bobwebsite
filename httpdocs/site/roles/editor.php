<?php

// site/roles/editor.php
return [
    'name'        => 'Editor',
    'default'     => false,
    'permissions' => [
        '*'                 => true,
        'panel.widget.site' => false
    ]
];