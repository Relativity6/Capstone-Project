<?php
    declare(strict_types = 1);

    //Initialize user array, errors array, and message string
    $user = [
        'firstname' => '',
        'lastname' => ''
    ];

    $errors = [
        'firstname' => '',
        'lastname' => ''
    ];

    $message = '';

    //Function for text validation
    function is_text($text, $min = 0, $max = 1000) {
        $length = mb_strlen($text);
        return ($length >= $min and $length <= $max);
    } 

    //Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        //Populate user array
        $user['firstname'] = $_POST['firstname'];
        $user['lastname'] = $_POST['lastname'];

        //Validate data
        $errors['firstname'] = is_text($user['firstname'], 2,20) ? '' : 'Must be 2-20 characters';
        $errors['lastname'] = is_text($user['lastname'], 2,20) ? '' : 'Must be 2-20 characters';

        //Join error messages
        $invalid = implode($errors);

        //Process data or not
        if ($invalid) {
            $message = 'Please correct the following errors:';
        }
        
        else {
            $message = 'Your data was valid';
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Sprint 2 Sample Form with PHP
        </title>

        <link rel="stylesheet" type="text/css" href="SprintTwoPracticePHP.css"/>
    </head>

    <body>

        <header>
            <img src = "../HatchfulExport-logo/logo_transparent.png" id = "logo"/>
        </header>

        <nav>

        </nav>

        <div id = "container">
            <h1>
                Sign Up
            </h1>

            <fieldset>
                <legend>User Information</legend>

                <form action = "SprintTwoPractice.php" method = "POST">

                    <div id = "firstfield">
                        <span id = "valmsg">
                            <?= $message ?>
                        </span>
                    </div>

                    <div>
                        <label for = "firstname" class = "title">First Name:</label>
                        <input type = "text" id = "firstname" name = "firstname" value = "<?= htmlspecialchars($user['firstname']) ?>"/>
                    </div>

                    <div>
                        <p id = "errmsg1" class = "error"><?= $errors['firstname'] ?></p>
                    </div>
        
                    <div>
                        <label for = "lastname" class = "title">Last Name:</label>
                        <input type = "text" id = "lastname" name = "lastname" value = "<?= htmlspecialchars($user['lastname']) ?>"/>
                    </div>

                    <div>
                        <p id = "errmsg2" class = "error"><?= $errors['lastname'] ?></p>
                    </div>

                    <div id = "submitbutton">
                        <input type = "submit" id = "submit" value = "Submit"/>
                    </div>
                </form>
            </fieldset>
        </div>

    </body>

    <footer>

    </footer>
</html>