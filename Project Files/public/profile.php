<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

$id = (int) $_SESSION['id'];                                      // Get id from $_SESSION
if (!$id) {                                                 // If no id in $_SESSION, user not logged in
    redirect('login.php');                                  // Redirect to login.php
}

$member = $cms->getMember()->get($id);                      // Find user with given id
if (!$member) {                                             // If user not found in DB
    redirect('page-not-found.php');                         // Redirect to page-not-found.php
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Profile
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/profile.css'>
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
                    <li><a href = 'dashboard.php?id=<?=$member['id']?>'><span>Dashboard</span></a></li>
                    <li><a href = 'groups.php?id=<?=$member['id']?>'>Groups</a></li>
                    <li><a href = 'profile.php?id=<?=$member['id']?>'>Profile</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class = 'vert_div' id = 'vert_1'>
                <div class = 'section'>
                    <div class = 'section_header'>
                        <p>
                            Profile Information
                        </p>
                    </div>

                    <div id = 'info_list'>
                        <table>
                            <tr>
                                <th>First name:</th>
                                <td><?=$member['fname']?></td>
                            </tr>
                            <tr>
                                <th>Last name:</th>
                                <td><?=$member['lname']?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?=$member['email']?></td>
                            </tr>
                            <tr>
                                <th>Phone number:</th>
                                <td><?=$member['phone_num']?></td>
                            </tr>
                        </table>
                    </div>

                    <a id = 'edit_button' href = 'edit-profile.php'>
                        <p>
                            Edit profile info
                        </p>
                    </a>
                </div>

                <div class = 'section'>
                    <div class = 'section_header'>
                        <p>
                            Profile Picture
                        </p>
                    </div>

                    <img id = 'profile_picture' src = 'uploads/<?=$member['profile_pic']?>' alt = 'User profile picture'>

                    <?php if ($member['profile_pic'] == 'Default.jpg') { ?>                     
                        <p id = 'no_picture_message'>
                            You haven't uploaded a profile picture yet!  You can do so by clicking 
                            <a href = 'update-picture.php'>here</a>
                            .
                        </p>
                    <?php } else { ?>
                        <a id = 'update_button' href = 'update-picture.php'>
                            <p>
                                Update profile picture
                            </p>
                        </a>
                    <?php } ?>
                </div>
            </div>

            <div class = 'vert_div' id = 'vert_2'>
                <div class = 'section'>
                    <div class = 'section_header'>
                        <p>
                            Profile Options
                        </p>
                    </div>

                    <a id = 'logout' href = 'logout.php'>
                        <p>
                            Logout
                        </p>
                    </a>

                    <a id = 'delete' href = 'delete-member.php'>
                        <p>
                            Delete profile
                        </p>
                    </a>
                </div>
            </div>
        </main>
        <footer>
            Copyright &copy; 2022 Luminhealth
        </footer>
    </body>
