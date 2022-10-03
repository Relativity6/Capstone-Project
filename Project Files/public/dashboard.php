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

$member_of = $cms->getMembership()->memberof($id);
$admin_of = $cms->getMembership()->adminof($id);

?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Dashboard
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/dashboard.css'>
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
                    <li><span class = 'current'>Dashboard</span></li>
                    <li><a href = 'group-search.php'>Group Search</a></li>
                    <li><a href = 'profile.php'>Profile</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div id = 'container'>
                <div id = 'left_column'>
                    <div class = 'section_left' id = 'welcome_msg'>
                        <h2>
                            Welcome, <?= $member['fname'] ?>!
                        </h2>
                    </div>

                    <!-- Group List section -->
                    <div class = 'section_left' id = 'group_list'>
                        <div class = 'section_header'>
                            <p>
                                Group List
                            </p>
                        </div>

                        <div id = 'table_div'>
                            <!-- Make a table only if user is a part of atleast one group -->
                            <?php if ($member_of || $admin_of) { ?>
                                <table>
                                    <tr>
                                        <th>Group name</th>
                                        <th>Members</th>
                                        <th>Role</th>
                                        <th></th>
                                    </tr>
                                    
                                    <!-- Print admin'ed groups first -->
                                    <?php if ($admin_of) {
                                            foreach($admin_of as $group) {
                                                $group_info = $cms->getGroup()->get((int)$group['group_id']);
                                                $members = $cms->getMembership()->getNumberOfMembers((int)$group['group_id']); ?>
                                            <tr>
                                                <td><?=$group_info['name']?></td>
                                                <td><?= $members ?></td>
                                                <td>Admin</td>
                                                <td>
                                                    <a id = 'go_button' href = 'group.php?group_id=<?=$group['group_id']?>'>
                                                        <p>
                                                            Go
                                                        </p>
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php } } ?>

                                    <!-- Print other groups -->
                                    <?php if ($member_of) {
                                        foreach($member_of as $group) {
                                            $group_info = $cms->getGroup()->get((int)$group['group_id']);
                                            $members = $cms->getMembership()->getNumberOfMembers((int)$group['group_id']); ?>  
                                            <tr>
                                                <td><?=$group_info['name']?></td>
                                                <td><?=$members?></td>
                                                <td>Member</td>
                                                <td>
                                                    <a id = 'go_button' href = 'group.php?group_id=<?=$group['group_id']?>'>
                                                        <p>
                                                            Go
                                                        </p>
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php } } ?>
                                </table>

                        <!-- If user is not in any groups yet -->
                        <?php } else { ?>              
                            <p id = 'no_groups_msg'>
                                You haven't joined any groups yet!
                            </p>
                        <?php } ?>

                        </div>

                        <!-- Buttons -->
                        <div id = 'button_div'>
                            <a id = 'new_button' href = 'new-group.php'>
                                <p>
                                    New Group
                                </p>
                            </a>

                            <a id = 'search_button' href = 'group-search.php'>
                                <p>
                                    Group Search
                                </p>
                            </a>
                        </div>
                    </div>

                    <div class = 'section_left' id = 'empty_section'>
                        <div class = 'section_header'>
                            <p>
                                Empty Section (Idk what to add here but there was space for it)
                            </p>
                        </div>
                    </div>
                </div>

                <div id = 'right_column'>
                    <!-- Alert button -->
                    <div class = 'section_right' id = 'alert_section'>
                        <p class = 'bold'>
                            Had a positive test?
                        </p>
                        <p>
                            Alert your group members by clicking the button below.
                        </p>
                        <a href = 'alert.php' id = 'alert_button'>
                            <p>
                                Alert
                            </p>
                        </a>
                    </div>

                    <!-- DocFinder button -->
                    <div class = 'section_right' id = 'docfinder'>
                        <p class = 'bold'>
                            DocFinder
                        </p>
                        <p id = 'docfinder_prompt'>
                            Click the button below to find a doctor near you.
                        </p>
                        <a href = '' id = 'docfinder_button'>
                            <p>
                                Find Doctor
                            </p>
                        </a>
                    </div>

                    <!-- CDC Twitter feed -->
                    <div class = 'section_right' id = 'twitter_feed'>
                        <div class = 'section_header'>
                            <p>
                                CDC Twitter Feed
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            Copyright &copy; 2022 Luminhealth
        </footer>
    </body>
