<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

// If the user is not logged in, redirect to login
$id = (int) $_SESSION['id'];
if (!$id) {
    redirect('login.php');
}

//If no user is found with ID, redirect to page-not-found
$member = $cms->getMember()->get($id);
if (!$member) {
    redirect('page-not-found.php');
}

$error = '';

// If Delete button was pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $cms->getMember()->deleteMember($id, $member['profile_pic']);
    
    if ($result === false) {
        $error = 'Sorry, there was an error while carrying out your request.';
    }

    else {
        $cms->getSession()->delete();
        redirect('login.php');
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Delete Profile
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/delete-member.css'>
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
                    <li><a href = 'dashboard.php?id=<?=$id?>'><span>Dashboard</span></a></li>
                    <li><a href = 'groups.php?id=<?=$id?>'>Groups</a></li>
                    <li><a href = 'profile.php?id=<?=$id?>'>Profile</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div id = 'container'>
                <div id = 'container_header'>
                    <h2>
                        Delete Member Profile
                    </h2>
                </div>
                <div id = 'info_div'>
                    <div id = 'left_div'>
                        <img src = 'uploads/<?=$member['profile_pic']?>' alt = 'Profile picture'>
                    </div>
                    <div id = 'right_div'>
                        <form action = 'delete-member.php' method = 'POST'>

                            <!-- If there is an error message -->
                            <?php if ($error) { ?>
                                <p class = 'error_msg'>
                                    <?= $error ?>
                                </p>
                            <?php } ?>

                            <label for = 'delete'>Are you sure you want to delete your <span>LuminHealth</span> account?</label>
                            <input type = 'submit' id = 'delete_button' value = 'Delete'>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
