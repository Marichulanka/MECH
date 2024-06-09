<?php
session_start();
require 'db.php';
require 'conect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $user = getUser($login , $password , $con);
    if(!$user)
    {
        $_SESSION['IsLoged'] = true;
        $_SESSION['login'] = $login;
        $query = mysqli_query($con , 'Select id from users where login ="'.$login.'"');
        $query = mysqli_fetch_array($query);
        $query = mysqli_query($con,'SELECT employee.id_stanowiska FROM employee JOIN users ON employee.user_id = users.id WHERE users.id =' . $query['id'] );
        $query = mysqli_fetch_array($query);
        $_SESSION['Acces'] = $query['id_stanowiska'];
        mysqli_close($con);
        header('Location: ../html/employee.php');
        exit;
    }
mysqli_close($con);
$_SESSION['error'] = $user;
header('Location: login.php');
exit;
}
?>
