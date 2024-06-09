<?php  
session_start();
require '../log/db.php';
if(isset($_POST['description']) || isset($_POST['price']))
{       
    $query = mysqli_query($con , 'SELECT funda FROM `operations` order by id desc');
    $query1 = mysqli_query($con,'SELECT nick From `users` where login ="'.$_SESSION['login'].'"');
    $currentDate = date('Y-m-d');
    $price = $_POST['price'];
    $description = $_POST['description'];
    $query = mysqli_fetch_array($query);
    $FundBefore = $query['funda'];
    $FundSuma = $price+$FundBefore;
    $user = mysqli_fetch_array($query1);
    $nick = $user['nick'];
    $sql = "INSERT INTO operations (description, amount, fundB, fundA, date, who) 
    VALUES ('$description', '$price', '" . $FundBefore . "', '$FundSuma', '$currentDate', '" . $nick . "')";
    mysqli_query($con , $sql);
}
header('location: ../html/fund.php');
?>