<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

$group = [
    'id' => '',
    'name' => '',
    'password' => '',
    'admin_id' => ''
];

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
    $name = $_POST['name'];

    $group = $cms->getGroup()->getID($name);
    
    if (!$group){
        $error = 'No group found with that name';
    }

    else{
        redirect('group.php?group_id='.$group['id']);
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Group Search
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/group-search.css'>
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
                    <li><a href = 'groups.php'>Groups</a></li>
                    <li><a href = 'profile.php'>Profile</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div id = 'container'>
                <div id = 'container_header'>
                    <h2>
                        Group Search
                    </h2>
                </div>
                <div id = 'info_div'>
                    <form action = 'group-search.php' method = 'POST'>

                        <!-- If there is an error message -->
                        <?php if ($error) { ?>
                            <p class = 'error_msg'>
                                <?= $error ?>
                            </p>
                        <?php } ?>

                    <!-- Group Name -->
                    <label for = 'name'>Group name:</label>
                    <input type = 'text' name = 'name'>
                            <!-- update css submit_button to search_button-->
                        <label for = 'search'>Search for a <span>LuminHealth</span> group?</label>
                        <input type = 'submit' id = 'search_button' value = 'Search'>
                    </form>

                    <a href = 'profile.php' id = 'cancel_button'>
                        <p>
                            Cancel
                        </p>
                    </a>
                    
                </div>
            </div>
        </main>
    </body>
</html>
