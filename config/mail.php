<?php
return array(
    'driver' => 'smtp',
    'host' => 'mail.smtp2go.com',
    'port' => 2525, // Or try 587, 25, or 8025
    'from' => array('address' => env('MAIL_FROM_ADDRESS', 'noreply@dusolutions.io'), 'name' => env('MAIL_FROM_NAME', 'Dusolutions')),
    'encryption' => 'tls',
    'username' => env('MAIL_USERNAME', 'dusolutions.io'),
    'password' => env('MAIL_PASSWORD', 'yhrWM1TapAZe9Ava'),
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
);
