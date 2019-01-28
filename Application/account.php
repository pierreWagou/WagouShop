<?php session_start();?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Compte</title>
    </head>
    <body>
    <?php

    if (isset($_POST['submit']))
    {
        if (!$conn=oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
            echo "Erreur connexion";

        $query = oci_parse($conn,"SELECT pseudo from utilisateurs where pseudo='$_POST[login]'");
        oci_execute($query);
        if ($row=oci_fetch_array($query))
        {
            //$queryOID= oci_parse($conn, "select ref(i) as OID from utilisateurs i where pseudo= '$_POST[login]'");
            //oci_execute($queryOID);
            //$rowOID=oci_fetch_array($queryOID);
            //echo $rowOID['OID'];
            $_SESSION['login']=$_POST['login'];
            setcookie('id', "$_POST[login]", time()+15*24*3600, null, null, false, true );
            include "application.php";
            $request= "select a.ID, a.categorie, a.enseigne, a.image, a.etat, a.date_debut from annonces a where a.pseudo.pseudo = '$_SESSION[login]'";
            $query = oci_parse($conn, $request);
            oci_execute($query);
            echo "<ul>";
            while ($row=oci_fetch_array($query))
            {
                echo "
                <li>
                <form action='visu_annonce.php' method='POST'>
                    <input type='hidden' value='$row[ID]' name='hidden'>
                    <input type='submit' name='submit' value='$row[CATEGORIE], $row[ENSEIGNE], $row[IMAGE], $row[etat], $row[DATE_DEBUT]'>
                </form>
                </li>";
            }
            echo "</ul>";

        }
        else
        {
            echo "Erreur lors de votre authentification, veuillez recommencer <br/>";
            echo "
                    <form action=\"account.php\" method=\"POST\">
                        <input type=\"text\" name=\"login\"/> Login <br/>
                        <input type=\"password\" name=\"password\"/> Password <br/>
                        <input type=\"submit\" name=\"submit\" value=\"Valider\"/>
                    </form>";

        }
    }
    else
    {
        if (isset($_SESSION['login']))
        {
            if (!$conn=oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
                echo "Erreur connexion";
            include "application.php";
            echo "Liste des annonces que vous avez passées";
            $request= "select a.ID, a.categorie, a.enseigne, a.image, a.etat, a.date_debut from annonces a where a.pseudo.pseudo = '$_SESSION[login]'";
            $query = oci_parse($conn, $request);
            oci_execute($query);
            echo "<ul>";
            while ($row=oci_fetch_array($query))
            {
                echo "
                <li>
                <form action='visu_annonce.php' method='POST'>
                    <input type='hidden' value='$row[ID]' name='hidden'>
                    <input type='submit' name='submit' value='$row[CATEGORIE], $row[ENSEIGNE], $row[IMAGE], $row[ETAT], $row[DATE_DEBUT]'>
                </form>
                </li>";
            }
            echo "</ul>";
        }
        else
        {
            echo "Vous devez être connecté pour voir votre compte";

        }
    }

    ?>
    </body>
</html>
