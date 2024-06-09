<?php
session_start();
if (!isset($_SESSION['IsLoged'])) 
{   
    if($_SESSION['IsLoged']!=true)
    {
        header('Location: ../log/login.php');
        exit; 
    }
    if(isset($_GET['error']))
    {
        if($_GET['error']=='nocar')
            echo "<script>console.log('podane auto nie istnieje w bazie danych');</script>";
        else if($_GET['error']=='nocustom')
            echo "<script>console.log('auto nie ma takiego customa');</script>";
        else if($_GET['error']=='noemployee')
            echo "<script>console.log('user nie ma przypisanego pracownika');</script>";
        else
            echo "<script>console.log('nie znany błąd');</script>";
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
    <link rel="stylesheet" href="../css/customsphp.css">
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
                    <h1>W Robocie</h1>
                    <h1>
                        <?php   
                            $query = mysqli_query($con,'SELECT * FROM `customs` where status = 0');
                            echo mysqli_num_rows($query);
                            ?>
                    </h1>
                    <img src="../img/work-in-progress.png" alt="WIP" style="height: 50%; margin-left: 0;">
                </div>
                <div class="col" id="col2">
                    <h1>Ukończone</h1>
                    <h1>
                        <?php   
                            $query = mysqli_query($con,'SELECT * FROM `customs` where status = 1');
                            echo mysqli_num_rows($query);
                            ?>
                    </h1>
                    <img src="../img/done1.png" alt="ended" style="height: 70%; margin-left: 0;">
                </div>
                <div class="col" id="col3">
                    <h1>Skonfiskowane</h1>
                    <h1>
                        <?php   
                            $query = mysqli_query($con,'SELECT * FROM `customs` where status = 3');
                            echo mysqli_num_rows($query);
                            ?>
                    </h1>
                    <img src="../img/rental-car.png" alt="ended" style="height: 50%; margin-left: 0;">
                </div>
            </div>
            <div class="row" id="row2" ss-container>
                <div class="col" id="col1">
                    <link rel="stylesheet" href="../css/flipcard.css">
                    <div class="form-container">
                        <form action="../php/proccesCustoms.php" method="post" class="form">
                            <div class="form-group">
                                <label for="name">Imie</label>
                                <input required="" name="name" id="email" type="text">
                            </div>
                            <div class="form-group">
                                <label for="surname">Nazwisko</label>
                                <input required="" name="surname" id="email" type="text">
                            </div>
                            <div class="form-group">
                                <label for="basic">AUTO</label>
                                <input required="" name="basic" id="email" type="text" list="carlist">
                                <datalist id="carlist">

                                    <?php
                                        $query = mysqli_query($con,'SELECT * FROM `customcar`');
                                        for($i = 0;$i<mysqli_num_rows($query);$i++)
                                        {
                                            $query1 = mysqli_fetch_array($query);
                                            echo '<option value="'.$query1['basic'].'"></option>';
                                        }
                                    ?>
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label for="custom">Custom</label>
                                <input required="" name="custom" id="email" type="text" list="customlist">
                                <datalist id="customlist">

                                    <?php
                                        header('Content-Type: application/json');
                                        $query = mysqli_query($con,'SELECT * FROM `customcar`');
                                        for($i = 0;$i<mysqli_num_rows($query);$i++)
                                        {
                                            $query1 = mysqli_fetch_array($query);
                                            echo '<option value="'.$query1['custom'].'"></option>';
                                        }
                                    ?>
                                </datalist>
                            </div>
                            <div class="button-container">
                                <button type="submit" class="form-submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col" id="col2">
                    <table>
                        <tr>
                            <th id="th1">
                                Klient
                            </th>
                            <th id="th2">
                                Auto
                            </th>
                            <th id="th3">
                                Custom
                            </th>
                            <th id="th4">
                                Koszt
                            </th>
                            <th id="th5">
                                Wykonaj
                            </th>
                        </tr>
                        <?php
                            $query = mysqli_query($con,'SELECT id , auto , custom , imie , nazwisko , koszt FROM customs WHERE status = 0');
                            for($i = 0;$i < mysqli_num_rows($query); $i++)
                            {
                                $customs = mysqli_fetch_array($query);
                                echo '<tr><td>'.$customs['imie'].' '.$customs['nazwisko'].'</td><td>'.$customs['auto'].'</td><td>'.$customs['custom'].'</td><td>'.$customs['koszt'].'</td><td>
                                <a href="../php/proccesCustoms.php?car='.$customs['id'].'" class="tableA">
                                    <div>
                                        DONE
                                    </div>
                                </a></td></tr>';
                            }
                        ?>
                    </table>
                </div>
        </section>
    </main>
</body>

</html>