<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8"/>
    <title>Le bon coin</title>
    <link rel="stylesheet" type="text/css" href="application.css">
</head>

<body>

    <h1 id="menuNav">Menu de navigation</h1><br/>
    <ul>
        <li><a href="poster_annonces.php">Poster une annonce</a></li>
        <li><a href="annonces.php">Voir les annonces</a></li>
       <li><a href='account.php'>Voir mon compte</a></li>
        <?php
        if (isset($_SESSION['login']))
        {

            echo "<form action='connection.php' method='POST'>
                    <li><input type='submit' value='Déconnexion' name='deco'>  $_SESSION[login]<br/></li>
                  </form>";
        }
        else
        {
            echo "<li><a href='connection.php'>Se connecter avec un compte existant</a></li>";
            echo "<li><a href='creer_compte.php'>Créer un compte</a></li>";
        }
        ?>
    </ul>

</body>
</html>
