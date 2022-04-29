<?php
declare(strict_types = 1);
include 'includes/database-connection.php';
include 'includes/functions.php';
include 'includes/validate.php';

//Initialize arrays
$member = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'password' => '',
];

$errors = [
    'warning' => '',
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'password' => '',
];

$successful = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {   //If form submitted

    //Populate $member array
    $member['firstname'] = $_POST['firstname'];
    $member['lastname'] = $_POST['lastname'];
    $member['email'] = $_POST['email'];
    $member['password'] = $_POST['password'];

    //Input validation
    $errors['firstname'] = (is_text($member['firstname'], 1, 100)) ? '' : 'Name should be 1-100 characters.';
    $errors['lastname'] = (is_text($member['lastname'], 1, 100)) ? '' : 'Name should be 1-100 characters.';
    $errors['email'] = (is_email($member['email'])) ? '' : 'Please enter a valid email.';
    $errors['password'] = (is_password($member['password'])) ? '' : 'Please enter a valid password.';

    $invalid = implode($errors);

    //Check if any errors
    if ($invalid) {
        $errors['warning'] = 'Please correct errors.';
    }

    //If no errors, insert data into database 
    else {
        $arguments = $member;
        $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password);";

        try {
            pdo($pdo, $sql, $arguments);
            $successful = true;
        }

        //If exception thrown, check if broken uniqueness constraint, otherwise rethrow exception
        catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                $errors['warning'] = 'Email already in use.';
            }

            else {
                throw $e;
            }
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Sprint 3</title>
        <link rel = "stylesheet" type = "text/css" href = "styles/styles.css">
    </head>

    <body>

        <header>
            <div id = "logo_div">

            </div>

            <nav>

            </nav>
        </header>
        <div id = "container">
            <h2>Sign Up</h2>


            <div>
                <p id = "warning">
                    <?php if ($errors['warning']) {
                        echo $errors['warning'];
                    }

                    if ($successful == true) {
                        echo "User info submitted";
                    }
                    ?>
                </p>
            </div>

            <form action = "index.php" method = "post">

                <div class = "form_group">
                    <label for = "firstname">First name </label>
                    <input type = "text" name = "firstname" id = "firstname" value = "<?= html_escape($member['firstname']) ?>" class = "form_control">
                    <br><span class = "error"><?= $errors['firstname'] ?></span>
                </div>

                <div class = "form_group">
                    <label for = "lastname">Last name </label>
                    <input type = "text" name = "lastname" id = "lastname" value = "<?= html_escape($member['lastname']) ?>" class = "form_control">
                    <br><span class = "error"><?= $errors['lastname'] ?></span>
                </div>

                <div class = "form_group">
                    <label for = "email">Email </label>
                    <input type = "text" name = "email" id = "email" value = "<?= html_escape($member['email']) ?>" class = "form_control">
                    <br><span class = "error"><?= $errors['email'] ?></span>
                </div>

                <div class = "form_group">
                    <label for = "password">Password </label>
                    <input type = "password" name = "password" id = "password" value = "<?= html_escape($member['password']) ?>" class = "form_control">
                    <br><span class = "error"><?= $errors['password'] ?></span>
                </div>

                <input type = "submit" value = "Sign up" class = "submit_button">

                <p id = "agreement">
                    By clicking Submit, you agree to Blank's <strong>User Agreement, Privacy Policy,</strong> and <strong>Cookie Policy.</strong>
                </p>

            </form>
        </div>
    </body>

    <footer>

    </footer>
</html>