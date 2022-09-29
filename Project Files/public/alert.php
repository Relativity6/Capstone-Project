<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

// If the user is not logged in, redirect to login
$id = (int) $_SESSION['id'];
if (!$id) {
    redirect('login.php');
}

// If no user is found with ID, redirect to page-not-found
$member = $cms->getMember()->get($id);
if (!$member) {
    redirect('page-not-found.php');
}

$members = [];
$member_emails = [];

// Get ID's of all groups that the user is in
$member_of = $cms->getMembership()->memberof($id);
$admin_of = $cms->getMembership()->adminof($id);
$inGroups = array_merge($member_of, $admin_of);

// Get ID's of all members that the user is associated with. "members" is a multidimensional array. (eg. $members[0]['user_id'])
foreach ($inGroups as $group) {
    $member_ids = $cms->getMembership()->getMembersAndAdmin($group['group_id']);
    $members = array_merge($members, $member_ids);
}

// Remove duplicate entries in members array
$members = array_unique($members, SORT_REGULAR);

// Get emails of all members in $members array. $member_emails array is a multidimensional array.  (eg. $member_emails[0]['email'])
foreach ($members as $mem) {
    $email_address = $cms->getMember()->getEmail($mem['user_id']);
    array_push($member_emails, $email_address);
}

// Email parameters
$email      = new Email ($email_config);
$from       = $email_config['admin_email'];
$subject    = 'LuminHealth Alert Message';
$message    = 'You have possibly been exposed to COVID-19. Taking a COVID-19 test is highly recommended.';

// Add member emails to recipient list
foreach ($member_emails as $address) {
    $email->AddAddress($address['email']);
}

// Send email
$result = $email->sendEmail($from, $subject, $message);

?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Alert
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/alert.css'>
    </head>
    <body>
        <header>
            <a href = 'dashboard.php'>
                <img id = 'header_logo' src = 'img/logo2_transparent.png' alt = 'LuminHealth logo'>
            </a>

            <nav id = 'header_nav'>
                <a href = 'profile.php'>
                    <img id = 'thumbnail' src = 'uploads/<?=$member['profile_pic']?>' alt = 'User profile picture'>
                </a>
                <ul>
                    <li><a href = 'dashboard.php'>Dashboard</a></li>
                    <li><a href = 'group-search.php'>Group Search</a></li>
                    <li><a href = 'profile.php'>Profile</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <?=var_dump($members)?>
            <?=var_dump($members[0]['user_id'])?>
            <?=var_dump($member_emails)?>
            <?=var_dump($member_emails[0]['email'])?>
        </main>
        <footer>
            Copyright &copy; 2022 Luminhealth
        </footer>
    </body>
