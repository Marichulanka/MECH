<?php
session_start();
if (!isset($_SESSION['IsLoged'])) 
{   
    if($_SESSION['IsLoged']!=true)
    {
        header('Location: ../log/login.php');
        exit; 
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona Główna</title>
    <link rel="icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../css/body.css">
</head>
<body>
<nav>
        <h1 id="panel">PANEL</h1>
        <?php
            require '../php/navbarprocess.php';

        ?>
        
    </nav>
    <main>
        <header>
            <a href="../Log/logout.php">
                <img src="../img/man.png" alt="pfp" style="height: 70%;">
                <p>
                    <?php
                         require '../log/conect.php';
                        if(isset($_SESSION['login']))
                        {
                            $query = mysqli_query($con,'SELECT nick From `users` where login ="'.$_SESSION['login'].'"');
                            $user = mysqli_fetch_array($query);
                            echo $user['nick'];
                        }
                    ?>
                </p>
            </a>
        </header>
            <section id="container">
                <div class="row" id="row1">
                    <div class="col" id="col1">
                        <?php
                            
                        ?>
                    </div>
                    <div class="col" id="col2">

                    </div>
                </div>
                <div class="row" id="row2">
                    <div class="col" id="col1">

                    </div>
                    <div class="col" id="col2">

                    </div>
                </div>
            </section>
    </main>
</body>
</html>