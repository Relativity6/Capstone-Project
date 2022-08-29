<?php
declare(strict_types = 1);
use Capstone\Validate\Validate;

include '../src/bootstrap.php';

// Initialize arrays
$member = [];
$errors = [
    'fname' => '',
    'lname' => '',
    'email' => '',
    'password' => '',
    'confirm' => '',
    'phone_num' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {                                     // If form was submitted

    // Get form data
    $member['fname']        = $_POST['fname'];
    $member['lname']        = $_POST['lname'];
    $member['email']        = $_POST['email'];
    $member['password']     = $_POST['password'];
    $confirm_password       = $_POST['confirm'];
    $member['phone_num']    = $_POST['phone_num'];

    // Validate form data
    $errors['fname']     = Validate::isText($member['fname'], 1, 20)
        ? '' : 'First name must be 1-20 characters';
    $errors['lname']     = Validate::isText($member['lname'], 1, 20)
        ? '' : 'Last name must be 1-20 characters';
    $errors['email']     = Validate::isEmail($member['email'])
        ? '' : 'Please enter a valid email';
    $errors['password']  = Validate::isPassword($member['password'])
        ? '' : 'Passwords must be at least 8 characters and have:<br> 
                A lowercase letter<br>An uppercase letter<br>A number 
                <br>And a special character';
    $errors['confirm']   = ($member['password'] = $confirm)
        ? '' : 'Passwords do not match';
    $errors['phone_num'] = Validate::isPhoneNum($member['phone_num'])
        ? '' : 'Must be a valid 11 digit phone number';

    $invalid = implode($errors);                                            // Join error messages

    if (!$invalid) {                                                        // If no errors
        $result = $cms->getMember()->create($member);                       // Create member

        if ($result === false) {                                            // If result is false, email is already in use
            $errors['email'] = 'Email address already used';
        }
        
        else {                                                              // If successful, redirect to login
            redirect('login.php', ['success' => 'Thanks for joining! Please log in.']);        
        }
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Register
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/styles_register.css'>
    </head>
    <body>
        <div id = 'container'>
            <img id = 'hero_image' src = 'img/jed-villejo-pumko2FFxY0-unsplash.jpg' alt = ''/>

            <div id = 'content'>
                <img id = 'logo' src = 'img/logo2_transparent.png' alt = 'LuminHealth logo'>

                <h1>Create your free account</h1>
                <h3>Get started by entering your information below</h3>

                <form action = 'register.php' method = 'POST' enctype = 'multipart/form-data' accept = 'image/*'>
                    <!-- First name -->
                    <label for = 'fname'>First name:</label>
                    <input type = 'text' name = 'fname'>
                    <?php if ($errors['fname']) {?>
                            <p class = 'warning'>
                                <?= $errors['fname'] ?>
                            </p>
                    <?php } ?>
                    
                    <!-- Last Name -->
                    <label for = 'lname'>Last name:</label>
                    <input type = 'text' name = 'lname'>
                    <?php if ($errors['lname']) {?>
                            <p class = 'warning'>
                                <?= $errors['lname'] ?>
                            </p>
                    <?php } ?>

                    <!-- Email -->
                    <label for = 'email'>Email:</label>
                    <input type = 'email' name = 'email'>
                    <?php if ($errors['email']) {?>
                            <p class = 'warning'>
                                <?= $errors['email'] ?>
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

                    <!-- Phone number -->
                    <label for = 'phone_num'>Phone number (Format: X-XXX-XXX-XXXX):</label>
                    <input type = 'tel' name = 'phone_num'  pattern = '[0-9]{1}-[0-9]{3}-[0-9]{3}-[0-9]{4}' id = 'phone_num'>
                    <?php if ($errors['phone_num']) {?>
                            <p class = 'warning'>
                                <?= $errors['phone_num'] ?>
                            </p>
                    <?php } ?>

                    <!-- Profile picture -->
                    <label for = 'profile_pic'>Profile picture:</label>
                    <input type = 'file' name = 'profile_pic'>

                    <input type = 'submit' id = 'submit'>
                </form>
            </div>
        </div>
    </body>
</html>