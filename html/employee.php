<?php
session_start();
require '../log/conect.php';
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
    <link rel="stylesheet" href="../css/employeephp.css">
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
            <div id="main">
                <div  id="col1" <?php
                if($_SESSION['Acces']<=3)
                        echo 'class="col"';
                else
                    echo 'class="singlecol"';
                ?>>
                    <div class="row" id="row1">
                        <form action="employee.php" method="post" id="serchbar">
                            <input required="" placeholder="search" value="<?php if(!empty($_POST['search'])) echo $_POST['search'];?>" name="search" type="text" list="employeelist">
                            <datalist id="employeelist">
                                <?php
                                $query = mysqli_query($con,'SELECT employee.id , employee.imie , employee.nazwisko , position.nazwa FROM employee JOIN position ON employee.id_stanowiska = position.id order by employee.imie ');
                                for($i = 0;$i<mysqli_num_rows($query);$i++)
                                {
                                    $query1 = mysqli_fetch_array($query);
                                    echo '<option value="'.$query1['id'].'. '.$query1['imie'].' '.$query1['nazwisko'].'">Stanowisko: '.$query1['nazwa'].'</option>';
                                }
                                ?>
                            </datalist>
                            <button type="submit" style="display:none;">
                            </button>
                        </form>
                    </div>
                    <?php
                    if(!empty($_POST['search']))
                    {   
                        $parts = explode(' ',$_POST['search']);
                        if(sizeof($parts)==3)
                        {
                            $id = $parts[0];
                            $imie = $parts[1];
                            $nazwisko = $parts[2];
                            str_replace('.','',$id);
                        }
                    }
                    ?>
                    <div class="row" id="row2">
                        <div class="col2" id="col21">
                            <?php
                             if(!empty($_POST['search']) && !empty($id))
                             {  
                                $query = mysqli_query($con,'SELECT position.nazwa FROM employee JOIN position ON employee.id_stanowiska = position.id WHERE employee.id = '.$id);
                                $Qarray = mysqli_fetch_array( $query);
                                echo '<h1> '.$Qarray['nazwa'].' </h1>';
                             }
                            ?>
                        </div>
                        <div class="col2" id="col22">
                            <?php
                             if(!empty($_POST['search']) && !empty($id))
                             {  
                                $query = mysqli_query($con,'SELECT hours FROM employee WHERE employee.id = '.$id);
                                $Qarray = mysqli_fetch_array( $query);
                                if($Qarray['hours'] >= 7 && $Qarray['hours'] <= 20)
                                {
                                   echo '<h1 style="color: green;"> '.$Qarray['hours'].' h</h1>';
                                }
                                else if($Qarray['hours'] > 20)
                                {
                                   echo '<h1 style="color: gold;"> '.$Qarray['hours'].' h</h1>';
                                }
                                else
                                {
                                   echo '<h1 style="color: red;"> '.$Qarray['hours'].' h</h1>';
                                }
                             }
                            ?>
                        </div>
                        <div class="col2" id="col23">
                            <?php
                                if(!empty($_POST['search']) && !empty($id))
                                {  
                                    $query = mysqli_query($con,'SELECT * FROM urlopy WHERE employee_id = '.$id.' order by id DESC');
                                    if(mysqli_num_rows($query) == 0)
                                    {
                                        echo 'Brak Danych';
                                    } 
                                    else 
                                    {
                                        $Qarray = mysqli_fetch_array( $query);
                                        $date1 = new DateTime($Qarray['odkiedy']);
                                        $date2 = new DateTime($Qarray['dokiedy']);
                                        $today = new DateTime();
                                        $today = $today->format('Y-m-d');
                                        echo 'Ostatni urlop: <br><br> od: '.$date1->format('Y-m-d') .'<br>do: ';
                                        echo $date2->format('Y-m-d');
                                    }
                                }
                                ?>
                        </div>
                    </div>
                    <div class="row" id="row3">
                        <?php
                        if(!empty($_POST['search']) && !empty($id))
                        {  
                            $query = mysqli_query($con,'SELECT * FROM warns WHERE employee_id = '.$id.' order by id DESC');
                            echo '<table> <tr> <th>opis</th><th>data</th></tr>';
                            for($i = 0; $i < mysqli_num_rows($query) ; $i++)
                            {
                                $Qarray = mysqli_fetch_array( $query);
                                echo '<tr><td>'.$Qarray['opis'].'</td><td>'.$Qarray['date'].'</td></tr>';
                            } 
                            echo '</table>';
                        }
                        ?>
                    </div>
                </div>
                <?php
                    if($_SESSION['Acces']<=3)
                    {
                    echo '<div class="col" id="col2">
                    </div>';
                    }
                ?>
            </div>
        </section>
    </main>
</body>

</html>