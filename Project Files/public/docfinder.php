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


?>

<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>
            LuminHealth | DocFinder
        </title>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <meta charset = 'utf-8'>
        <meta name = 'description' content = ''>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
        <link rel = 'stylesheet' href = 'css/docfinder.css'>
        <script type = 'module' src = 'js/docfinder.js'></script>
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
                        DocFinder
                    </p>
                </div>
                
                <div id = 'map'></div>
                <p id = 'prompt'>
                    Use the <span class = 'docfinder'>DocFinder</span> tool to locate doctors near you.  
                    The <span class = 'docfinder'>DocFinder</span> map will place markers on all found 
                    results within a 5km radius.  Hover over any of these markers to see it's name 
                    and address.  (Note. You must allow browser geolocation to use the 
                    <span class = 'docfinder'>DocFinder</span> tool.  Select "Allow" when the notification box appears.)
                </p>
            </div>
        </main>
    </body>
    <footer>
        Copyright &copy; 2022 Luminhealth
    </footer>
    <script defer
        src="https://maps.googleapis.com/maps/api/js?key=KEY_PLACEHOLDER&libraries=places&callback=initMap">    
    </script>
</html>
