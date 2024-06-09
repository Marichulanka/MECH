<?php  
session_start();
require '../log/db.php';
$currentDate = new DateTime();
$currentDate = $currentDate->format('Y-m-d');
if(isset($_POST['imie']) || isset($_POST['nazwisko'])|| isset($_POST['basic'])|| isset($_POST['custom']))
{       
    $query = mysqli_query($con , 'SELECT * FROM `customcar` where basic = "'.$_POST['basic'].'"');
    if(mysqli_num_rows($query) == 0)
    {
        header('location: ../html/customs.php?error=nocar');
        die();
    }
    else
    {
        $query = mysqli_query($con , 'SELECT * FROM `customcar` where basic = "'.$_POST['basic'].'" AND custom = "'.$_POST['custom'].'"');
        if(mysqli_num_rows($query) == 0)
        {
            header('location: ../html/customs.php?error=nocustom');
            die();
        }
        else
        {
            $Qarray = mysqli_fetch_array($query);
            $query = mysqli_query($con ,"SELECT employee.id From employee JOIN users ON user_id = users.id WHERE users.login = '".$_SESSION['login']."'");
            if(mysqli_num_rows($query) == 0)
            {
                header('location: ../html/customs.php?error=noemployee');
                die();
            }
            else
            {
                $Q2array = mysqli_fetch_array($query);
                $car = $con->real_escape_string($_POST['basic']);
                $custom = $con->real_escape_string($_POST['custom']);
                $name = $con->real_escape_string($_POST['name']);
                $surname = $con->real_escape_string($_POST['surname']);
                $price = $con->real_escape_string($Qarray['price']);
                $currentDate = $con->real_escape_string($currentDate);
                $employeeId = $con->real_escape_string($Q2array['id']);
                $query = "INSERT INTO `customs` (auto, custom, imie, nazwisko, koszt, date, id_employee , status) 
                VALUES ('$car', '$custom', '$name', '$surname', $price, '$currentDate', $employeeId , 0)";
                mysqli_query($con , $query);
            }
            
        }
        
        
    }
    
}
if(isset($_GET['car']))
{
    $query = mysqli_query($con,'UPDATE customs SET status = 1 WHERE id = '.$_GET['car']);
    $query = mysqli_query($con,'UPDATE customs SET data_oddania = "'.$currentDate.'" WHERE id = '.$_GET['car']);
}
header('location: ../html/customs.php');
?>