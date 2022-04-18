<?php
    declare(strict_types=1);
    require 'validate.php';

    $user = [
        'email' => '',
        'password' => ''
    ];

    $errors = [
        'email' => '',
        'password' => ''
    ];

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $user['email'] = $_POST['email'];
        $user['password'] = $_POST['password'];

        $errors['email'] = is_email($user['email']) ? '' : 'Invalid email';
        $errors['password'] = is_password($user['password']) ? '' : 'Invalid password';

        $invalid = implode($errors);

        if ($invalid) {
            $message = 'Please correct the following errors:';
        }
        
        else {
            $message = 'Valid input';
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Sprint 2
        </title>

        <link rel="stylesheet" type="text/css" href="Sprint2-2.css"/>
    </head>

    <body>
        <div id = "content">
            <div id = "container">
                <h1>
                    Login
                </h1>

                <div id = "formdiv">
                    <form action = "Sprint2-2.php" method = "POST">

                        <div id = "msgdiv">
                            <p>
                                <?= $message ?>
                            </p>
                        </div>

                        <div class = "labeldiv">
                            <label for ="email" class = "label">Email</label>
                            <span class = "error"><?= $errors['email']?></span>
                        </div>
                        
                        <div>
                            <input type = "text" id = "email" name = "email" value = "<?= htmlspecialchars($user['email']) ?>"/>
                        </div>

                        <div class = "labeldiv">
                            <label for ="password" class = "label">Password</label>
                            <span class = "error"><?= $errors['password']?></span>

                        </div>

                        <div>
                            <input type = "password" id = "password" name = "password" value = "<?= htmlspecialchars($user['password']) ?>"/>
                        </div>

                        <div>
                            <input type = "submit" id = "submit" name = "submit" value = "Submit"/>
                        </div>

                        <div>
                            <p>
                                By clicking Submit, you agree to Blank's <strong>User Agreement, Privacy Policy,</strong> and <strong>Cookie Policy.</strong>
                            </p>

                            <p id = "register">
                                Don't have an account yet? <a href = "">Register now</a>
                            </p>
                        </div>

                    </form>

                    <p>

                    </p>
                </div> <!--formdiv-->
            </div> <!--container-->
            <div id = "container2">
                <div id = "img1">

                </div>

                <div id = "img2">

                </div>

                <div id = "img3">
                    
                </div>
            </div>
        </div> <!--content-->
    </body>
</html>
