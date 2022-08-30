<?php
define('DEV', true);                                                                  // Development = true | Live = false
define('DOMAIN', 'http://localhost:8888'); 

// Folder Constants
$this_folder   = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));                  // Folder this file is in
$parent_folder = dirname($this_folder);                                               // Parent of this folder


define("DOC_ROOT", DIRECTORY_SEPARATOR . 'Capstone' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);                                      // Document root (Capstone/public/)

// Database settings
$type = 'mysql';
$server = 'localhost';
$db = 'luminhealth';
$port = '3306';
$charset = 'utf8mb4';
$username = 'user';
$password = 'IFT402_Capstone';

$dsn = "$type:host=$server;dbname=$db;port=$port;charset=$charset";

// File upload settings
define('UPLOADS', DOC_ROOT . 'uploads' . DIRECTORY_SEPARATOR); //Image upload folder
define('MEDIA_TYPES', ['image/jpeg', 'image/png', 'image/gif',]);                    // Allowed file types
define('FILE_EXTENSIONS', ['jpeg', 'jpg', 'png', 'gif',]);                           // Allowed file extensions
define('MAX_SIZE', '5242880');                                                       // Max file size
