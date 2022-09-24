<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

// If not logged in, redirect to login.php
$user_id = (int) $_SESSION['id'];
if (!$user_id) {
    redirect('login.php');
}

// If user with given ID not found, redirect to page-not-found.php
$user = $cms->getMember()->get($user_id);
if (!$user) {
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
if($user_id != $admin_id['user_id']) {
    redirect("group.php?group_id=$group_id");
}

// Initialize variables
$member_ids     = $cms->getMembership()->getMembers($group_id);
$delete_id      = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT) ?? null;
$errors = [];

if (isset($delete_id)) {
    $result = $cms->getMembership()->removeMember($delete_id, $group_id);
    if ($result) {
        redirect("edit-group.php?group_id=$group_id");
    }
    else {
        $errors['delete'] = "We couldn't complete your delete request at this time. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Edit Group
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/edit-group.css'>
    </head>
    <body>
        <header>
            <a href = 'dashboard.php'>
                <img id = 'header_logo' src = 'img/logo2_transparent.png' alt = 'LuminHealth logo'>
            </a>

            <nav id = 'header_nav'>
                <a href = 'profile.php'>
                    <img id = 'thumbnail' src = 'uploads/<?=$user['profile_pic']?>' alt = 'User profile picture'>
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
                <div id = 'header_div'>
                    <div class = 'section_header'>
                        <p>Group Name</p>
                    </div>
                    <p><?= $group['name'] ?></p>
                </div>

                <div id = 'member_list'>
                    <div class = 'section_header'>
                        <p>Member List</p>
                    </div>

                    <div id = 'table_div'>
                        <table>
                            <tr>
                                <th>Picture</th>
                                <th>Name</th>
                                <th></th>
                            </tr>

                            <?php
                                if ($member_ids) {
                                    foreach($member_ids as $member_id) {
                                        $member_info = $cms->getMember()->get((int)$member_id['user_id']); ?>

                                        <tr>
                                            <td><img id = 'mini_thumbnail' src = 'uploads/<?=$member_info['profile_pic']?>'></td>
                                            <td><?=$member_info['fname']?> <?=$member_info['lname']?></td>
                                            <td>
                                                <a class = 'remove_button' href = 'edit-group.php?group_id=<?=$group_id?>&delete_id=<?=$member_id['user_id']?>'>
                                                    <p>
                                                        Remove
                                                    </p>
                                                </a>
                                            </td>
                                        </tr>
                            <?php 
                                    }
                                } ?>
                        </table>
                    </div>

                    <div id = 'cancel_div'>
                        <a id = 'cancel_button' href = 'group.php?group_id=<?=$group_id?>'>
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