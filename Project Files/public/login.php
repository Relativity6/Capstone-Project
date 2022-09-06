<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

$email = '';
$errors = [
    'email' => '',
    'password' => '',
    'message' => ''
];
$success = $_GET['success'] ?? null;
$member = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors['email'] = Validate::isEmail($email) ? '' : 'Please enter a valid email address';
    $errors['password'] = Validate::isPassword($password) ? '' : 'Passwords must be at least 8 characters and have: <br>
                                                                    <span id = "password_rules">A lowercase letter<br>
                                                                    An uppercase letter<br>
                                                                    A number<br>And a special character</span>';
    $invalid = implode($errors);

    if ($invalid) {
        $errors['message'] = 'Please try again';
    } 
    else {
        $member = $cms->getMember()->login($email, $password);
    }

    if ($member) {
        $cms->getSession()->create($member);
        redirect('profile.php');
    }
    else {
        $errors['message'] = 'Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Login
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/login.css'>
    </head>
    <body>
        <div id = 'container'>
            <img id = 'hero_image' src = 'img/Hero_image4.jpg' alt = ''/>

            <div id = 'content'>
                <img id = 'logo' src = 'img/logo2_transparent.png' alt = 'LuminHealth logo'>
                
                <h1>Sign in</h1>
                <div id = 'form_div'>
                    <form action = 'login.php' method = 'POST'>
                        
                        <!-- If redirected from Register.php -->
                        <?php if ($success && $errors['message'] == '') { ?>
                            <h3>
                                <?= $success ?>
                            </h3>
                        <?php } ?>

                        <!-- Error message -->
                        <?php if ($errors['message']) { ?>
                            <h3 class = 'warning'>
                                <?= $errors['message'] ?>
                            </h3>
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

                        <p id = 'register_prompt'>
                            Don't have an account yet? Register <a href = 'register.php'>here.</a>
                        </p>
                            
                        <input type = 'submit' id = 'submit' value = 'Login'>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
