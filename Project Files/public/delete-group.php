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

// If group ID not provided in query string, redirect to page-not-found.php
$group_id = filter_input(INPUT_GET, 'group_id', FILTER_VALIDATE_INT);
if (!$group_id) {
    redirect('page-not-found.php');
}

// If group with given ID not found, redirect to page-not-found.php
$group = $cms->getGroup()->get($group_id);
if (!$group) {
    redirect('page-not-found.php');
}

// If user is not admin, redirect to group.php
$admin_id = $cms->getMembership()->getAdmin($group_id);
if($id != $admin_id['user_id']) {
    redirect("group.php?group_id=$group_id");
}

$errors = '';

// If Delete button was pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get ID's of members of the group and remove their membership
    $member_ids = $cms->getMembership()->getMembers((int)$group_id);
        if ($member_ids) {
            foreach ($member_ids as $mem) {
                $errors = ($cms->getMembership()->removeMember((int)$mem['user_id'], (int)$group_id)) ? '' : 'error';
            }
        }

    // Remove user (the admin) from group
    $errors = ($cms->getMembership()->removeMember($id, (int)$group_id)) ? '' : 'error';

    // Delete group
    $errors = ($cms->getGroup()->delete($group_id)) ? '' : 'error';

    if (!$errors) {
        redirect('dashboard.php');
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Delete Group
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/delete-group.css'>
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
                        Delete Group
                    </p>
                </div>
                <div id = 'info_div'>
                    <p id = 'delete_prompt'>
                        Are you sure you want to delete <span><?=$group['name']?></span>?
                    </p>
                    <form action = 'delete-group.php?group_id=<?=$group_id?>' method = 'POST'>

                        <!-- If there is an error message -->
                        <?php if ($errors) { ?>
                            <p class = 'error'>
                                Sorry, we could not complete your request at this time.
                            </p>
                        <?php } ?>

                        <input type = 'submit' id = 'delete_button' value = 'Delete'>
                    </form>

                    <a href = 'group.php?group_id=<?=$group_id?>' id = 'cancel_button'>
                        <p>
                            Cancel
                        </p>
                    </a>
                </div>
            </div>
        </main>
        <footer>
            Copyright &copy; 2022 Luminhealth
        </footer>
    </body>
</html>
