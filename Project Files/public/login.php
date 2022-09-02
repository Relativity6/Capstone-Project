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
        redirect('profile.php', ['id' => $member['id'],]);
    }
    else {
        $errors['message'] = 'Please try again.';
    }
}

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="../Graphics/Hatchful_Logos/favicon.ico">
    <link rel="stylesheet" href="css/test.css">
</head>

<body> 
    <div class="form">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form">
                <!-- Might have to correct link -->
                <h2><img src="../Graphics/Hatchful_Logos/logo_transparent.png" alt="LuminHealth" style="width:100px;height:100px;"></h2>
                <h2>Login</h2>                
            </div>

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
                            
                        <input type = 'submit' id = 'submit' value = 'Login'>
<!-- Change to correct register.php file/location-->            
            <p>Create an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>