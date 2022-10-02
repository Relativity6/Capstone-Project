<?php
define('DEV', true);                                                                  // Development = true | Live = false
define('DOMAIN', 'http://localhost:8888'); 

define("DOC_ROOT", DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR );            // Document root (public_html in Linux)

// Database settings
$type = 'mysql';
$server = 'localhost';
$db = 'luminhealth';
$port = '3306';
$charset = 'utf8mb4';
$username = 'user';
$password = 'IFT402_Capstone';

$dsn = "$type:host=$server;dbname=$db;port=$port;charset=$charset";

// SMTP server settings
$email_config = [
    'server'      => 'smtp.sendgrid.net',
    'port'        => '587',
    'username'    => 'paste username here',
    'password'    => 'paste key here',
    'security'    => 'tls',
    'admin_email' => 'Luminhealth402@outlook.com',
    'debug'       => 0
];

// File upload settings
define('UPLOADS', DOC_ROOT . 'uploads' . DIRECTORY_SEPARATOR); //Image upload folder
define('MEDIA_TYPES', ['image/jpeg', 'image/png', 'image/gif',]);                    // Allowed file types
define('FILE_EXTENSIONS', ['jpeg', 'jpg', 'png', 'gif',]);                           // Allowed file extensions
define('MAX_SIZE', '5242880');                                                       // Max file size
