<?php
declare(strict_types = 1);
include '../src/bootstrap.php';
use Twilio\Rest\Client;

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
$member_phone_nums = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get ID's of all groups that the user is in
    $member_of = $cms->getMembership()->memberof($id);
    $admin_of = $cms->getMembership()->adminof($id);

    // if - elseif's to handle possible false boolean returned from memberof and adminof functions
    if ($member_of && $admin_of) {
        $inGroups = array_merge($member_of, $admin_of);
    }

    elseif ($member_of && !$admin_of) {
        $inGroups = $member_of;
    }

    elseif ($admin_of && !$member_of) {
        $inGroups = $admin_of;
    }

    // Get ID's of all members that the user is associated with
    foreach ($inGroups as $group) {
        $member_ids = $cms->getMembership()->getAllBesidesUser((int)$group['group_id'], $id);
        if ($member_ids) {
            $members = array_merge($members, $member_ids);
        }
    }

    // Remove duplicate entries in $members array
    $members = array_unique($members, SORT_REGULAR);

    foreach ($members as $mem) {

        // Get emails of all members in $members array
        $email_address = $cms->getMember()->getEmail((int)$mem['user_id']);
        array_push($member_emails, $email_address);

        // Get phone numbers of all members in $members array
        $phone_num = $cms->getMember()->getPhoneNum((int)$mem['user_id']);
        $formatted_num = Validate::formatPhoneNum($phone_num['phone_num']);
        array_push($member_phone_nums, $formatted_num);
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

    // Twilio SMS parameters
    $sid = 'ACc63ed1aeb62ebcecf3ddb754425e7c05';
    $token = 'c8a9ad33a89b9ee17ee278dd16b26795';
    $twilio = new Client($sid, $token);

    // Send Twilio messages for each number
    foreach ($member_phone_nums as $num) {
        $message = $twilio->messages->create($num,
                                            [
                                                "body" => "LuminHealth Alert Message - You have possibly been exposed to COVID-19. Taking a COVID-19 test is highly recommended.",
                                                "from" => "+16182437035"
                                            ]
                                        );
    }

    if ($result) {
        redirect('dashboard.php');
    }
}



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
            <div id = 'container'>
                <h3>
                    COVID-19 Alert System
                </h3>

                <p id = 'prompt'>
                    By clicking the Alert button below, you will anonymously notify the members of your groups of their 
                    possible exposure to <span id = 'c19'>COVID-19</span>.  Your name and other personal information will not be shared.
                </p>

                <form action = 'alert_phones.php' method = 'POST'>
                    <input type = 'submit' id = 'alert_button' value = 'Alert'>
                </form>

                <a id = 'back_button' href = 'dashboard.php'>
                    <p>
                        Back
                    </p>
                </a>

                <?=var_dump($member_phone_nums)?>
            </div>
        </main>
        <footer>
            Copyright &copy; 2022 Luminhealth
        </footer>
    </body>