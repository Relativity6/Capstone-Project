<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

$id = (int) $_SESSION['id'];                                              // If the user is not logged in, redirect to login
if (!$id) {
    redirect('login.php');
}

$member = $cms->getMember()->get($id);                                    // If no user is found with ID, redirect to page-not-found
if (!$member) {
    redirect('page-not-found.php');
}

$group_id = filter_input(INPUT_GET, 'group_id', FILTER_VALIDATE_INT);     // If no Group ID provided in query string, redirect to page-not-found
if (!$group_id) {
    redirect('page-not-found.php');
}

$group = $cms->getGroup()->get($group_id);                                // If no group was found with given ID, redirect to page-not-found
if (!$group) {
    redirect('page-not-found.php');
}

// Is user a member of the group?
$isMember = $cms->getMembership()->isMember($id, $group_id);

// If member, retrieve group info
if ($isMember) {
    $isAdmin = ($id == $group['admin_id']) ? true : false;
    $admin_info = $cms->getMember()->get((int)$group['admin_id']);
    $groupMembers = $cms->getMembership()->getMembers((int)$group_id);
}

// If not member
else {
    $errors = [
        'password' => '',
        'message' => ''
    ];

    $password = '';
    $validated = false;
    $args = [];
    $result = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Password check
        $password = $_POST['password'];    
        if (password_verify($password, $group['password'])) {
            $validated = true;
        }
        else {
            $errors['password'] = 'Invalid password.';
        }

        // If validated, join group and reload page
        if ($validated) {
            $args = [
                'user_id' => $id,
                'group_id' => $group_id,
                'role' => 'member'
            ];

            $result = $cms->getMembership()->joinGroup($args);
            if (!$result) {
                $errors['message'] = 'Sorry, could not complete your request at this time.';
            }
            else {
                redirect('group.php', ['group_id' => $group_id]);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Group Page
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/group.css'>
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
            <?php if (!$isMember) { ?>

                <!-- Page structure if user not member of group -->
                <div id = 'container_nonmember'>
                    <img src = 'img/group_img.jpg' alt = 'Group picture'>
                    <div>
                        <h2>
                            Join <span class = 'title'><?= $group['name']; ?></span>
                        </h2>
                        <form action = 'group.php?group_id=<?=$group_id?>' method = 'POST'>
                            <?php if ($errors['password']) { ?>
                                <p>
                                    <?= $errors['password'] ?>
                                </p>
                            <?php } ?>
                            <label for = 'password'>Enter group password:</label>
                            <input type = 'password' name = 'password'>
                            <input id = 'submit_button' type = 'submit' value = 'Join'>
                        </form>
                    </div>
                </div>
                
            <?php } else { ?>
                <!-- Page structure if user is member of group -->
                <div id = 'container_member'>
                    <div id = 'column_left'>
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
                            <table>
                                <tr>
                                    <th>Picture</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                </tr>

                                <!-- Table row for admin -->
                                <tr>
                                    <td>
                                        <img id = 'mini_thumbnail' src = 'uploads/<?=$admin_info['profile_pic']?>'> 
                                    </td>
                                    <td><?=$admin_info['fname']?> <?=$admin_info['lname']?></td>
                                    <td>Admin</td>
                                </tr>

                                <!-- Add table row for each member -->
                                <?php 
                                    if ($groupMembers) {
                                        foreach ($groupMembers as $mem) { 
                                            $member_info = $cms->getMember()->get((int)$mem['user_id']) ?>
                                            <tr>
                                                <td><img id = 'mini_thumbnail' src = 'uploads/<?=$member_info['profile_pic']?>'></td>
                                                <td><?= $member_info['fname'] ?> <?= $member_info['lname'] ?></td>
                                                <td>Member</td>
                                            </tr>
                                <?php   }
                                    } ?>
                            </table>
                        </div>
                    </div>
                    <div id = 'column_right'>
                        <div id = 'alert_section'>
                            <p id = 'alert_prompt1'>
                                Had a positive test?
                            </p>
                            <p id = 'alert_prompt2'>
                                Alert your group members by clicking the button below.
                            </p>
                            <a href = 'alert.php' id = 'alert_button'>
                                <p>
                                    Alert
                                </p>
                            </a>
                        </div>
                        <div id = 'options_section'>
                            <div class = 'section_header'>
                                <p>
                                    Group Options
                                </p>
                            </div>

                            <?php
                                if ($isAdmin) { ?>
                                    <a href = 'edit-group.php?group_id=<?=$group_id?>' id = 'edit_button'>
                                        <p>
                                            Edit group
                                        </p>
                                    </a>

                                    <a href = 'delete-group.php?group_id=<?=$group_id?>' id = 'delete_button'>
                                        <p>
                                            Delete group
                                        </p>
                                    </a>
                            <?php 
                                } else { ?>
                                    <a href = 'leave-group.php?group_id=<?=$group_id?>' id = 'leave_button'>
                                        <p>
                                            Leave group
                                        </p>
                                    </a>
                            <?php
                                } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </main>
        <footer>
            Copyright &copy; 2022 Luminhealth
        </footer>
    </body>
