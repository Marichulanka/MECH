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
    <link rel="stylesheet" href="../css/fundphp.css">
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
                    <div class="card">
                        <div class="title">
                            <h1 class="title-text">
                                FUNDS

                                <h1 class="percent">
                                    <?php
                                    $today = new DateTime();
                                    $today = $today->format('Y-m-d');
                                    $query = mysqli_query($con, "SELECT funda FROM `operations` WHERE `date` = '$today' ORDER BY `id` DESC");
                                    if (!$query || mysqli_num_rows($query) == 0) {
                                        echo '0%';
                                    } else {
                                        $query = mysqli_fetch_array($query);
                                        $query1 = mysqli_query($con, "SELECT funda FROM `operations` WHERE `date` != '$today' ORDER BY `id` DESC");
                                        if ($query1 && mysqli_num_rows($query1) > 0) {
                                            $query1 = mysqli_fetch_array($query1);
                                            if ($query1['funda'] > $query['funda']) {
                                                echo round((($query['funda'] - $query1['funda']) / $query1['funda'])*100,1) . '%';
                                                echo ' <img src="../img/down.png" alt="down"> ';
                                            } elseif ($query1['funda'] < $query['funda']) {
                                                echo round((($query['funda'] - $query1['funda']) / $query1['funda'])*100,1) . '%';
                                                echo ' <img src="../img/up.png" alt="up"> ';
                                            } else {
                                                echo '0%';
                                            }
                                        } else {
                                            echo '0%';
                                        }
                                    }
                                    ?>
                                </h1>
                            </h1>
                        </div>
                        <div class="data">
                            <h1>
                                <?php   
                                    $query = mysqli_query($con , 'SELECT funda FROM `operations` order by id desc');
                                    if(!$query || mysqli_num_rows($query) == 0)
                                    {
                                        echo 'No Value in DataBase';
                                    }
                                    else    
                                    {
                                        $query = mysqli_fetch_array($query);
                                        echo $query['funda']."$";
                                    }
                                ?>
                            </h1>

                            <div class="range">
                                <div class="fill">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                </div>
                <div class="col" id="col2">
                    <div class="card">
                        <div class="title">
                            <h1 class="title-text">
                                RECENT

                                <h1 class="percent">
                                    <?php
                                    $query = mysqli_query($con, "SELECT funda FROM `operations` ORDER BY `id` DESC LIMIT 2");
                                    if (!$query || mysqli_num_rows($query) != 2) {
                                        echo '0%';
                                    } else {
                                        $query1 = mysqli_fetch_array($query);
                                        $query2 = mysqli_fetch_array($query);
                                        if ($query1['funda'] < $query2['funda']) {
                                            echo round((($query1['funda'] - $query2['funda']) / $query2['funda'])*100,1) . '%';
                                            echo ' <img src="../img/down.png" alt="down"> ';
                                        } elseif ($query1['funda'] > $query2['funda']) {
                                            echo round((($query1['funda'] - $query2['funda']) / $query2['funda'])*100,1) . '%';
                                            echo ' <img src="../img/up.png" alt="up"> ';
                                        } else {
                                            echo '0%';
                                        }
                                    }
                                    ?>
                                </h1>
                            </h1>
                        </div>
                        <div class="data">
                            <h1>
                                <?php   
                                    $query = mysqli_query($con, "SELECT funda FROM `operations` ORDER BY `id` DESC LIMIT 2");
                                    if(!$query || mysqli_num_rows($query) == 0)
                                    {
                                        echo 'No Value in DataBase';
                                    }
                                    else if (mysqli_num_rows($query) == 1)
                                    {
                                        $query = mysqli_fetch_array($query);
                                        echo $query['funda']."$";
                                    }
                                    else    
                                    {
                                        $query1 = mysqli_fetch_array($query);
                                        $query2 = mysqli_fetch_array($query);
                                        echo $query1['funda']-$query2['funda']."$";
                                    }
                                ?>
                            </h1>

                            <div class="range">
                                <div class="fill">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                </div>
                <div class="col" id="col3">
                    <div class="card">
                        <div class="title">
                            <h1 class="title-text">
                                WHO?
                                <h1 class="percent">
                                    <?php
                                    $query = mysqli_query($con , 'SELECT who FROM `operations` order by id desc limit 1');
                                    if(!$query || mysqli_num_rows($query) == 0)
                                    {
                                        echo 'No Value in DataBase';
                                    }
                                    else    
                                    {
                                        $query = mysqli_fetch_array($query);
                                        echo $query['who'];
                                    }
                                    ?>
                                </h1>
                            </h1>
                        </div>
                        <div class="data">
                            <h1>
                                <?php   
                                    $query = mysqli_query($con , 'SELECT amount FROM `operations` order by id desc');
                                    if(!$query || mysqli_num_rows($query) == 0)
                                    {
                                        echo 'No Value in DataBase';
                                    }
                                    else    
                                    {
                                        $query = mysqli_fetch_array($query);
                                        echo 'Value: '.$query['amount']."$";
                                    }
                                ?>
                            </h1>

                            <div class="range">
                                <div class="fill">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                </div>
            </div>
            </div>
            <div class="row" id="row2">
                <div class="col" id="col1">
                    <link rel="stylesheet" href="../css/flipcard.css">
                    <div class="form-container">
                        <form action="../php/proccesOperation.php" method="post" class="form">
                            <div class="form-group">
                                <label for="price">Koszt</label>
                                <input required="" name="price" id="email" type="text">
                            </div>
                            <div class="form-group">
                                <label for="opis">Opis</label>
                                <textarea required="" cols="50" rows="5" id="textarea" name="opis">          </textarea>
                            </div>
                            <div class="button-container">
                                <button type="submit" class="form-submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col" id="col2">
                    <h2>Ostantnie Transakcje</h2>
                    <div id="tableL">
                        <table>
                            <tr id="tableRow">
                                <td>WHO</td>
                                <td>AMOUNT</td>
                                <td>FUND BEFORE</td>
                                <td>FUND AFTER</td>
                            </tr>
                            <?php
                            $query = mysqli_query($con,'Select who , amount , fundb,funda from operations order by id desc limit 17');
                            for($i = 1 ; mysqli_num_rows($query) >= $i ; $i++)
                            {
                                $ArrayQ = mysqli_fetch_array($query);
                                echo "<tr><td>".$ArrayQ['who']."</td><td>".$ArrayQ['amount']." $</td><td>".$ArrayQ['fundb']." $</td><td>".$ArrayQ['funda']." $</td></tr>";
                            }
                            
                        ?>
                        </table>
                    </div>
                </div>
        </section>
    </main>
</body>

</html>