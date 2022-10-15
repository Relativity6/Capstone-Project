<?php
declare(strict_types = 1);
include '../src/bootstrap.php';

$id = (int) $_SESSION['id'];
if (!$id) {
    redirect('login.php');
}

$member = $cms->getMember()->get($id);
if (!$member) {
    redirect('page-not-found.php');
}

// Initialize variables
$errors = '';
$destination = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $temp = $_FILES['profile_pic']['tmp_name'];
    
    if ($_FILES['profile_pic']['error'] === 1) {
        $errors = 'File too big. ';
    }

    //Picture file upload
    if (is_uploaded_file($temp) and $_FILES['profile_pic']['error'] == 0) {

        //Validate file type and size
        if (!in_array(mime_content_type($temp), MEDIA_TYPES)) {
            $errors .= 'Wrong file type. ';
        }
        $extension = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, FILE_EXTENSIONS)) {
            $errors .= 'Wrong file extension. ';
        }
        if ($_FILES['profile_pic']['size'] > MAX_SIZE) {
            $errors .= 'File too big. ';
        }

        //Create a destination file name and save to uploads folder
        if ($errors == '') {
            
            $new_filename = create_filename($_FILES['profile_pic']['name'], 'uploads/');
            $destination = 'uploads/' . $new_filename;
            move_uploaded_file($temp, $destination);

            $result = $cms->getMember()->changePicture($id, $member['profile_pic'], $new_filename);

            if ($result === false) {
                $error = 'Sorry, could not update your picture at this time.';
            }

            else {
                redirect('profile.php');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | Update Profile Picture
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/update-picture.css'>
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
                    <li><a href = 'dashboard.php'>Dashboard</a></li>
                    <li><a href = 'group-search.php'>Group Search</a></li>
                    <li><a href = 'profile.php'>Profile</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div id = 'container'>
                <div class = 'section_header'>
                    <p>
                        Update Profile Picture
                    </p>
                </div>
                <div id = 'left_div'>
                    <h3>
                        Current profile picture
                    </h3>

                    <?php if ($member['profile_pic'] == 'Default.jpg') { ?>
                        <p>
                            You haven't uploaded a profile picture yet.
                        </p>
                    <?php } else { ?>

                        <img src = 'uploads/<?=$member['profile_pic']?>' alt = 'Profile picture'>

                    <?php } ?>
                </div>
                <div id = 'right_div'>
                    <h3>
                        File upload
                    </h3>
                    <form action = 'update-picture.php' method = 'POST' enctype = 'multipart/form-data' accept = 'image/*'>
                        <label for = 'profile_pic'>Upload a new profile picture:</label>
                        <input type = 'file' name = 'profile_pic'>

                        <input type = 'submit' id = 'submit' value = 'Submit picture'>
                    </form>

                    <a id = 'back_button' href = 'profile.php'>
                        <p>
                            Back to profile page
                        </p>
                    </a>
                </div>
            </div>
        </main>
        <footer>
            Copyright &copy; 2022 Luminhealth
        </footer>
    </body>
</html>
