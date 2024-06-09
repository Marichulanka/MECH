<?php
require 'conect.php';

function getUser($login , $password ,$con) {
    $query = mysqli_query($con , "SELECT login ,password FROM users");
    for($i = 0;$i <= mysqli_num_rows($query);$i++)
    {
        $log = mysqli_fetch_array($query);
        if($login == $log['login'])
        {
            if($password == $log['password'])
            {
                return false;
            }
            else
            {
                return 'wrong password';
            }
        }
        else if($i == mysqli_num_rows($query))
        {
            return 'wrong login';
        }
    }
}

?>
