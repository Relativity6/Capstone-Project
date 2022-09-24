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

$errors = '';
$admin_of = $cms->getMembership()->adminOf($id);
$member_of = $cms->getMembership()->memberOf($id);

// If Delete button was pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Remove user from all groups for which they are a member
    foreach ($member_of as $group) {
        $errors = ($cms->getMembership()->removeMember($id, $group['group_id'])) ? '' : 'error';
    }

    // Delete process for all groups that user is admin of
    foreach ($admin_of as $group) {

        // Remove members from groups that will be deleted
        $member_ids = $cms->getMembership()->getMembers((int)$group['group_id']);
        foreach ($member_ids as $mem) {
            $errors = ($cms->getMembership()->removeMember((int)$mem['user_id'], (int)$group['group_id'])) ? '' : 'error';
        }

        // Remove user (the admin) from groups
        $errors = ($cms->getMembership()->removeMember($id, (int)$group['group_id'])) ? '' : 'error';

        // Delete group
        $errors = ($cms->getGroup()->delete($group['group_id'])) ? '' : 'error';
    }

    // Delete user account
    $result = $cms->getMember()->deleteMember($id, $member['profile_pic']);

    if (!$errors && $result) {
        $cms->getSession()->delete();
        redirect('login.php');
    }

    else {
        $error = 'Sorry, there was an error while carrying out your request.';
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
                        Delete Member Profile
                    </p>
                </div>
                <div id = 'info_div'>
                    <div id = 'left_div'>
                        <img src = 'uploads/<?=$member['profile_pic']?>' alt = 'Profile picture'>
                    </div>
                    <div id = 'right_div'>
                        <form action = 'delete-member.php' method = 'POST'>

                            <!-- If there is an error message -->
                            <?php if ($errors) { ?>
                                <p class = 'error_msg'>
                                    <?= $error ?>
                                </p>
                            <?php } ?>

                            <label for = 'delete'>Are you sure you want to delete your <span>LuminHealth</span> account?</label>
                            <input type = 'submit' id = 'delete_button' value = 'Delete'>
                        </form>

                        <a href = 'profile.php' id = 'cancel_button'>
                            <p>
                                Cancel
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            Copyright &copy; 2022 Luminhealth
        </footer>
    </body>
</html>
