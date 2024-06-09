<?php
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
<div class="nav">
    <p>Navigation</p>
    <ol>
        <?php
            require '../log/conect.php';
            if($_SESSION['Acces']<=3)
            {
                echo('
                    <li>
                        <a href="main.php">
                            <div>
                                <img src="../img/gear.png" alt="logo">
                                <p>Dashboard</p>
                            </div>
                        </a>
                    </li>
                ');
            }
            if($_SESSION['Acces'])
            {
                echo('
                    <li>
                        <a href="employee.php">
                            <div class="selected">
                                <img src="../img/officer.png" alt="logo">
                                <p>Employee</p>
                            </div>
                        </a>
                    </li>
                ');
            }
            if($_SESSION['Acces']<3)
            {
                echo('
                     <li>
                        <a href="fund.php">
                            <div>
                                <img src="../img/bank.png" alt="logo">
                                <p>Funds</p>
                            </div>
                        </a>
                    </li>
                ');
            }
            if($_SESSION['Acces']<=4)
            {
                echo('
                      <li>
            <a href="customs.php">
                <div>
                    <img src="../img/car.png" alt="logo">
                    <p>Customs</p>
                </div>
            </a>
        </li>
                ');
            }
            if($_SESSION['Acces']<3)
            {
                echo('
                     <li>
            <a href="AdminPanel.php">
                <div>
                    <img src="../img/software-engineer.png" alt="logo">
                    <p>Admin Panel</p>
                </div>
            </a>
        </li>
                ');
            }
        ?>
    </ol>
</div>