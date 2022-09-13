<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

// Initialize variables
$group = [
    'gname' => '',
    'password' => '',
    'admin_id' => ''
];

$errors = [
    'gname' => '',
    'password' => '',
    'confirm' => '',
    'admin_id' => ''
];

$destination = '';
$saved = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {                                                         // If form was submitted

    // Get form data
    $group['gname']        = $_POST['gname'];
    $group['password']     = $_POST['password'];
    $confirm_password       = $_POST['confirm'];
    $group['admin_id']    = $_POST['admin_id'];

    // Validate form data
    $errors['gname']     = Validate::isText($group['gname'], 1, 20)
        ? '' : 'Name must be 1-20 characters';
    $errors['password']  = Validate::isPassword($group['password'])
        ? '' : 'Passwords must be at least 8 characters and have:<br> 
                A lowercase letter<br>An uppercase letter<br>A number 
                <br>And a special character';
//    $errors['phone_num'] = Validate::isPhoneNum($member['phone_num'])
//        ? '' : 'Must be a valid 11 digit phone number';

    $invalid = implode($errors);                                                                    // Join error messages

    if (!$invalid) {                                                                                // If no errors
        $result = $cms->getGroup()->create($group, $destination);                          // Create group

        if ($result === false) {                                                                    // If result is false, name is already in use
            $errors['gname'] = 'Name already used';
        }
        
        // Change redirect
        else {                                                                                      // If successful, redirect to login
            redirect('group.php', ['success' => 'Thanks for joining! Please log in.']);        
        }
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Create a group
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/create-group.css'>
    </head>
    <body>
        <div id = 'container'>
            <!-- Change image -->
            <img id = 'hero_image' src = 'img/jed-villejo-pumko2FFxY0-unsplash.jpg' alt = ''/>

            <div id = 'content'>
                <img id = 'logo' src = 'img/logo2_transparent.png' alt = 'LuminHealth logo'>

                <h1>Create a group</h1>
                <h3>Get started by entering your information below</h3>


                <div id = 'form_div'>
                    <form action = 'new-group.php' method = 'POST' enctype = 'multipart/form-data'>

                        <?php if (implode($errors)) { ?>

                            <h3 class = 'warning'>
                                Please correct the errors below.
                            </h3>

                        <?php } ?>

                        <!-- Group name -->
                        <label for = 'gname'>Group name:</label>
                        <input type = 'text' name = 'gname'>
                        <?php if ($errors['gname']) {?>
                                <p class = 'warning'>
                                    <?= $errors['gname'] ?>
                                </p>
                        <?php } ?>

                        <!-- Password -->
                        <label for = 'password'>Password:</label>
                        <input type = 'password' name = 'password'>
                        <?php if ($errors['password']) {?>
                                <p class = 'warning'>
                                    <?= $errors['password'] ?>
                                </p>
                        <?php } ?>

                        <!-- Confirm password -->
                        <label for = 'confirm'>Confirm password:</label>
                        <input type = 'password' name = 'confirm'>
                        <?php if ($errors['confirm']) {?>
                                <p class = 'warning'>
                                    <?= $errors['confirm'] ?>
                                </p>
                        <?php } ?>

                        <!-- Group Admin test -->
                        <label for = 'admin_id'>Admin ID:</label>
                        <input type = 'admin_id' name = 'admin_id'>
                        <?php if ($errors['admin_id']) {?>
                                <p class = 'warning'>
                                    <?= $errors['admin_id'] ?>
                                </p>
                        <?php } ?>

                        <input type = 'submit' id = 'submit'>
                    </form>

                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
