<?php
    declare(strict_types = 1);
    include '../src/bootstrap.php';
?>
<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            Template
        </title>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'styles/Template_styles.css'>
    </head>
    <body>
        <div id = 'container'>
            <header>
                <a href = 'template.php'>
                    <img id = 'header_logo' src = 'img/logo2_transparent.png' alt = 'LuminHealth logo'>
                </a>

                <?php if ($sess == 0) { ?>
                        
                    <nav id = 'header_nav'>
                        <ul class = 'not_logged_in'>
                            <li><a href = 'login.php'><span id = 'bold'>Log in</span></a></li>
                            <li><a href = 'register.php'>Register</a></li>
                        </ul>
                    </nav>

                <?php } else { ?>

                    <nav id = 'header_nav'>
                        <a href = ''>
                            <img id = 'thumbnail' src = 'uploads/<?=$member['profile_pic']?>' alt = 'User profile picture'>
                        </a>
                        <ul>
                            <li><a href = 'dashboard.php?id=<?=$member['id']?>'><span id = 'current'>Dashboard</span></a></li>
                            <li><a href = ''>Groups</a></li>
                            <li><a href = ''>Profile</a></li>
                        </ul>
                    </nav>

                <?php } ?>    
            </header>
            <main>

            </main>
            <footer>

            </footer>
        </div>
    </body>
</html>
