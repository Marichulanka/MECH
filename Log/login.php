<?php
    if (isset($_SESSION['IsLoged'])) 
    {   
        header('Location: ../log/logout.php');
        exit; 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/form.css">
    <link rel="icon" href="../img/favicon.png">
</head>
<body>
    <main>
        <form id="loginForm" action="process_login.php" method="post">
            <p id="error">
                <?php
                    session_start();
                    if(isset($_SESSION['error']))
                    {
                        echo $_SESSION['error'];
                    }
                ?>
            </p>
            <input id="loginInput" type="text" name="login" placeholder="Login" />
            <input id="passwordInput" type="password" name="password" placeholder="Password" />
            <button id="submitButton" type="submit">Log In</button>
        </form>
    </main>
</body>
</html>