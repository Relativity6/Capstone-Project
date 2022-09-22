<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

$group = [
    'id' => '',
    'gname' => '',
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
    $gname = $_POST['gname'];
    $password = $_POST['password'];

    $group = $cms->getGroup()->getId($gname);
    
    if (!$group){
        $error = 'No group found with that name';
        //redirect('page-not-found.php');
    }

    else{

        //Checks if admin_id matches user id
        if($id == $group['admin_id']){

            //Checks if passwords match

            if(password_verify($password, $group['password'])){
                $result = $cms->getGroup()->deleteGroup($group['id']);

                if ($result === false) {
                    $error = 'Sorry, there was an error while carrying out your request.';
                }
    
                else {
                    redirect('profile.php');
                }
            }
            else{
                $error= 'Incorrect password';
            }
        }
            else{
            $error = "Sorry you are not the admin for this group.";
            }
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
                    <li><a href = 'groups.php'>Groups</a></li>
                    <li><a href = 'profile.php'>Profile</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div id = 'container'>
                <div id = 'container_header'>
                    <h2>
                        Delete Group
                    </h2>
                </div>
                <div id = 'info_div'>
                    <form action = 'delete-group.php' method = 'POST'>

                        <!-- If there is an error message -->
                        <?php if ($error) { ?>
                            <p class = 'error_msg'>
                                <?= $error ?>
                            </p>
                        <?php } ?>

                    <!-- Group Name -->
                    <label for = 'gname'>Group name:</label>
                    <input type = 'text' name = 'gname'>

                    <!-- Password -->
                    <label for = 'password'>Password:</label>
                    <input type = 'password' name = 'password'>

                        <label for = 'delete'>Are you sure you want to delete your <span>LuminHealth</span> group?</label>
                        <input type = 'submit' id = 'delete_button' value = 'Delete'>
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
