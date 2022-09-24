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

// If no Group ID provided in query string, redirect to page-not-found
$group_id = filter_input(INPUT_GET, 'group_id', FILTER_VALIDATE_INT);
if (!$group_id) {
    redirect('page-not-found.php');
}

// If no group was found with given ID, redirect to page-not-found
$group = $cms->getGroup()->get($group_id);
if (!$group) {
    redirect('page-not-found.php');
}

// If user is not currently a member of the group, redirect
$isMember = $cms->getMembership()->isMember($id, $group_id);
if (!$isMember) {
    redirect('page-not-found.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Remove entry in Membership table
    $result = $cms->getMembership()->removeMember($id, $group_id);

    if (!$result) {
        $error = 'Sorry, we could not process your request at this time.';
    }  

    else {
        redirect('dashboard.php');
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Leave Group
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/leave-group.css'>
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
                <div class = 'section_header'>
                    <p>
                        Leave Group
                    </p>
                </div>

                <h3>
                    Are you sure you want to leave <span id = 'title'><?=$group['name']?></span>?
                </h3>

                <form action = 'leave-group.php?group_id=<?=$group_id?>' method = 'POST'>
                    <input type = 'submit' value = 'Leave'>
                </form>

                <a id = 'cancel_button' href = 'group.php?group_id=<?=$group_id?>'>
                    <p>
                        Cancel
                    </p>
                </a>
            </div>
        </main>
        <footer>
            Copyright &copy; 2022 Luminhealth
        </footer>
    </body>
