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

// Initialize errors array
$errors = [
    'fname' => '',
    'lname' => '',
    'phone_num' => '',
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Update Member array with form data
    $member['fname']            = $_POST['fname'];
    $member['lname']            = $_POST['lname'];
    $member['phone_num']        = $_POST['phone_num'];

    // Validate form data
    $errors['fname']     = Validate::isText($member['fname'], 1, 20)
            ? '' : 'First name must be 1-20 characters';
    $errors['lname']     = Validate::isText($member['lname'], 1, 20)
            ? '' : 'Last name must be 1-20 characters';
    $errors['phone_num'] = Validate::isPhoneNum($member['phone_num'])
            ? '' : 'Must be a valid 11 digit phone number';

    $invalid = implode($errors);

    // If no validation errors, update Members table
    if (!$invalid) {
        $result = $cms->getMember()->update($id, $member);

        if ($result === false) {
            $errors['message'] = 'Sorry, there was an error while carrying out your request.';
        }

        else {
            redirect('profile.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Edit Profile
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/edit-profile.css'>
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
            <div id = 'container'>
                <div id = 'container_header'>
                    <h2>
                        Update Profile Info
                    </h2>
                </div>

                <form action = 'edit-profile.php' method = 'POST'>
                    <!-- Error message -->
                    <?php if (implode($errors)) { ?>
                        <h3 class = 'warning'>
                            Please correct the errors below.
                        </h3>
                    <?php } ?>

                    <!-- First name -->
                    <label for = 'fname'>First name:</label>
                    <input type = 'text' name = 'fname' value = '<?=$member['fname']?>'>
                    <?php if ($errors['fname']) {?>
                            <p class = 'warning'>
                                <?= $errors['fname'] ?>
                            </p>
                    <?php } ?>

                    <!-- Last Name -->
                    <label for = 'lname'>Last name:</label>
                    <input type = 'text' name = 'lname' value = '<?=$member['lname']?>'>
                    <?php if ($errors['lname']) {?>
                            <p class = 'warning'>
                                <?= $errors['lname'] ?>
                            </p>
                    <?php } ?>

                    <!-- Phone number -->
                    <label for = 'phone_num'>Phone number (Format: X-XXX-XXX-XXXX):</label>
                    <input type = 'tel' name = 'phone_num'  pattern = '[0-9]{1}-[0-9]{3}-[0-9]{3}-[0-9]{4}' id = 'phone_num'
                        value = '<?=$member['phone_num']?>'>
                    <?php if ($errors['phone_num']) {?>
                            <p class = 'warning'>
                                <?= $errors['phone_num'] ?>
                            </p>
                    <?php } ?>

                    <input type = 'submit' id = 'update_button' value = 'Update'>
                </form>

                <a id = 'cancel_button' href = 'profile.php'>
                    <p>
                        Cancel
                    </p>
                </a>

            </div>
        </main>
    </body>
