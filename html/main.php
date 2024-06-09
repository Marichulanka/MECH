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
    <link rel="stylesheet" href="../css/Body.css">
    <link rel="stylesheet" href="../css/Mainphp.css">
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
                    <h1>Employee</h1>
                    <div id="inside">
                        <p>
                            <?php
                                    $query = mysqli_query($con , 'SELECT COUNT(*) AS "employeers" FROM `employee`');
                                    $query = mysqli_fetch_array($query);
                                    echo $query['employeers'];
                                ?>
                        </p>
                        <img src="../img/contributor-agreement.png" alt="car">
                    </div>
                </div>
                <div class="col" id="col2">
                    <h1>Customs On Going</h1>
                    <div id="inside">
                        <p>
                            <?php
                                    $query = mysqli_query($con , 'SELECT COUNT(*) AS "customs" FROM `customs` where status = 0');
                                    $query = mysqli_fetch_array($query);
                                    echo $query['customs'];
                                ?>
                        </p>
                        <img src="../img/car2.png" alt="car">
                    </div>
                </div>
                <div class="col" id="col3">
                    <h1>Fund</h1>
                    <div id="inside">
                        <p>
                            <?php
                                    $query = mysqli_query($con , 'SELECT funda FROM `operations` order by id desc');
                                    $query = mysqli_fetch_array($query);
                                    echo $query['funda'];
                                ?>
                        </p>
                        <img src="../img/cash.png" alt="cash">
                    </div>
                </div>
            </div>
            <div class="row" id="row2">
                <div class="col" id="col1">
                    <h1>UPDATES</h1>
                </div>
                <div class="col" id="col2">
                    <a href="https://discord.gg/b5qJ7X8tC4">
                        <img src="../img/discord.png" alt="discord">
                    </a>
                </div>
            </div>
            <div class="row" id="row3">
                <div class="col" id="col1">
                    <h2>Ostantnie
                        <?php 
                                $query = mysqli_query($con,'Select who , amount , fundb,funda from operations order by id desc limit 5');
                                echo mysqli_num_rows($query);
                            ?>
                        Transakcji</h2>
                    <div id="tableL">
                        <table>
                            <tr id="tableRow">
                                <td>WHO</td>
                                <td>AMOUNT</td>
                                <td>FUND BEFORE</td>
                                <td>FUND AFTER</td>
                            </tr>
                            <?php
                                    for($i = 1 ; mysqli_num_rows($query) >= $i ; $i++)
                                    {
                                        $ArrayQ = mysqli_fetch_array($query);
                                        echo "<tr><td>".$ArrayQ['who']."</td><td>".$ArrayQ['amount']." $</td><td>".$ArrayQ['fundb']." $</td><td>".$ArrayQ['funda']." $</td></tr>";
                                    }
                                    
                                ?>
                        </table>
                    </div>
                </div>
                <div class="col" id="col2">
                    <h1>Godziny wyrobione w tym tygodniu:</h1>
                    <?php
                            $query = mysqli_query($con , 'SELECT SUM(hours) AS allhour , COUNT(*) AS pracownikow FROM employee;');
                            $arrayQ = mysqli_fetch_array($query);
                            $sum = $arrayQ['allhour'];
                            $numR = $arrayQ['pracownikow'];
                            if($sum < $numR*7)
                                echo ('<p class="hours" style="color: red;">'.$sum.'</p>');
                            else if($sum >= $numR * 7 && $sum < $numR*14)
                                echo ('<p class="hours" style="color: green;">'.$sum.'</p>');
                            else if($sum >= $numR * 15 && $sum < $numR * 20)
                                echo ('<p class="hours" style="color: yellow;">'.$sum.'</p>');
                            else 
                                echo ('<p class="hours" id="hours">'.$sum.'</p>');
                        ?>

                </div>
            </div>
        </section>
    </main>
</body>

</html>