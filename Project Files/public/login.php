<?php
// Session start
session_start();
 
// Takes you to welcome screen but need to change to profile page
// *************Need to change location***********************************************************
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// *****************************Change location of config.php if needed***************************
require_once "../config/config.php";
 
// Initialize variables as empty values 
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processes the data from the form
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username and/or password is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Checks login information
    if(empty($username_err) && empty($password_err)){
        
        // Makes a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters

            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters

            $param_username = $username;
            
            //Execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Saves result
                mysqli_stmt_store_result($stmt);
                
                // Checks if the username exists and if the password is correct
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Binds variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // If password is correct for username it will start session
                            session_start();
                            
                            // Puts data for session into variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Takes you to welcome screen but need to change to profile page
                            // *************Need to change location***********************************************************
                            header("location: welcome.php");
                        } else{
                            // Gives error if password is not correct
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Gives error if the username doesn't exist
                    $login_err = "Invalid username or password.";
                }
            } 
            else{
                echo "Something went wrong. Please try again later.";
            }


            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyles.css">
</head>

<body> 
    <div class="form">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form">
                <!-- Might have to correct link -->
                <h2><img src="../Graphics/Hatchful_Logos/logo_transparent.png" alt="LuminHealth" style="width:100px;height:100px;"></h2>
                <h2>Login</h2>
                
                <?php 
                if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }        
                ?>
                

            </div>

            <div class="form">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>  

            <div class="form">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>

            <div class="button">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>

<!-- Change to correct register.php file/location-->            
            <p>Create an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>
