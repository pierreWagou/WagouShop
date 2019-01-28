<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Creer un compte</title>
    </head>
    <body>
    <?php include "application.php" ?>
        <form action="new_account.php" method="POST">
              Pseudo <input type="text" name="login"><br>
              Nom <input type="text" name="nom"><br>
              Prenom <input type="text" name="prenom"><br>
              Lien photo <input type="text" name="photo"><br>
              <input type="submit" name="submit" value="Creer un compte">
        </form>
    </body>
</html>
