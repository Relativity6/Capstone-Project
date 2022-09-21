<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

// Redirect checks
$id = (int) $_SESSION['id'];
if (!$id) {
    redirect('login.php');
}

$member = $cms->getMember()->get($id);
if (!$member) {
    redirect('page-not-found.php');
}

// Initialize variables
$group = [
    'name'       => '',
    'password'   => '',
    'admin_id'   => ''
];

$errors = [
    'name'       => '',
    'password'   => '',
    'confirm'    => ''
];

$membership_args = [
    'user_id'    => '',
    'group_id'   => '',
    'role'       => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data and populate Group array
    $group['name']          = $_POST['name'];
    $group['password']      = $_POST['password'];
    $confirm                = $_POST['confirm'];
    $group['admin_id']      = $id;

    // Error validation
    $errors['name']      = Validate::isText($group['name'], 1, 20)
        ? '' : 'Name must be 1-20 characters';
    $errors['password']  = Validate::isPassword($group['password'])
        ? '' : 'Passwords must be at least 8 characters and have:<br> 
                A lowercase letter<br>An uppercase letter<br>A number 
                <br>And a special character';
    $errors['confirm']   = ($group['password'] == $confirm) ? '' : 'Passwords do not match';

    $invalid = implode($errors);

    // If no errors, call Create function
    if (!$invalid) {
        $result = $cms->getGroup()->create($group);

        if ($result == false) {
            $errors['name'] = 'Name already in use.';
        }

        // If Group Create function successful, use "getByGroupName" function to retrieve group ID
        // and create a new Membership instance with user_id and group_id with the role of "admin"
        else {
            $group_info = $cms->getGroup()->getByGroupName($group['name']);

            $membership_args['user_id']    = $id;
            $membership_args['group_id']   = $group_info['id'];
            $membership_args['role']       = 'admin';
            
            $membership_result = $cms->getMembership()->joinGroup($membership_args);

            // If no errors, redirect to group.php with the group_id in the query string
            if ($membership_result) {
                redirect('group.php', ['group_id' => $group_info['id']]);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | New Group
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/new-group.css'>
    </head>
    <body>
        <div id = 'container'>
            <img id = 'hero_image' src = '' alt = ''/>

            <div id = 'content'>
                <img id = 'logo' src = 'img/logo2_transparent.png' alt = 'LuminHealth logo'>

                <h1>Create a group</h1>

                <div id = 'form_div'>
                    <form action = 'new-group.php' method = 'POST'>

                        <!-- Error prompt -->
                        <?php if (implode($errors)) { ?>
                            <h3 class = 'warning'>
                                Please correct the errors below.
                            </h3>
                        <?php } ?>

                        <!-- Group name -->
                        <label for = 'name'>Group name:</label>
                        <input type = 'text' name = 'name'>
                        <?php if ($errors['name']) {?>
                                <p class = 'warning'>
                                    <?= $errors['name'] ?>
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

                        <input type = 'submit' id = 'create_button' value = 'Create group'>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
