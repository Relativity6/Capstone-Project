<?php
    declare(strict_types = 1);
    include '../src/bootstrap.php';

    $session_id = (isset($_SESSION['id'])) ? $_SESSION['id'] : null;
?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            Luminhealth | Page not found
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/page-not-found.css'>
    </head>
    <body>
        <div id = 'container'>
            <header>
                <a href = 'dashboard.php'>
                    <img id = 'header_logo' src = 'img/logo2_transparent.png' alt = 'LuminHealth logo'>
                </a>

                <?php if (!$session_id) { ?>
                        
                    <nav id = 'header_nav'>
                        <ul class = 'not_logged_in'>
                            <li><a href = 'login.php'><span id = 'bold'>Log in</span></a></li>
                            <li><a href = 'register.php'>Register</a></li>
                        </ul>
                    </nav>

                <?php } else { 
                    $member = $cms->getMember()->get($session->id); ?>
                    
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

                <?php } ?>    
            </header>
            <main>
                <div id = 'content'>
                    <img src = 'img/page-not-found.jpg' alt = 'Page not found.'>

                    <div>
                        <h1>
                            Oops!
                        </h1>

                        <h3>
                            Something went wrong.  Click <a href = 'dashboard.php'>here</a> to go back.
                        </h3>
                    </div>
                </div>
            </main>
            <footer>
                Copyright &copy; 2022 Luminhealth
            </footer>
        </div>
    </body>
</html>
