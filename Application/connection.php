<?php
    session_start();
    if (isset($_POST['deco']))
    {
        setcookie('id','',time());;
        unset($_SESSION['login']);
    }



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Connection</title>
    </head>
    <body>
    <?php
        include "application.php";
        echo "
                    <form action='account.php' method='POST'>
                        <input type='text' name='login'/> Login <br/>
                        <input type='submit' name='submit' value='Valider'/>
                    </form>";
    ?>


</html>
