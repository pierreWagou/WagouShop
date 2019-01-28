<?php session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <title>New account</title>
  </head>
  <body>
    <?php
        if (isset($_POST['login']))
        {
          if (!$conn=oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
              echo 'Erreur connexion';
          $query = oci_parse($conn, "SELECT pseudo FROM Utilisateurs WHERE pseudo='$_POST[login]'");
          oci_execute($query);

          if (!($row=oci_fetch_array($query)))
          {
            $query=oci_parse($conn, "INSERT INTO Utilisateurs(pseudo, nom, prenom, photo, statut, badge ) VALUES ('$_POST[login]', '$_POST[nom]', '$_POST[prenom]', '$_POST[photo]', 'user', listebadgeobtenu())");
            if (!oci_execute($query, OCI_DEFAULT))
              echo'Erreur insertion';
            oci_commit($conn);
            $query =  oci_parse($conn, "SELECT ref(i) FROM Utilisateurs i WHERE pseudo='$_POST[login]'");
            oci_execute($query);
            echo "Compte créé <br/>";

            $_SESSION['login']=$query;
            setcookie('identifictaion', "$_POST[login]", time()+15*24*3600, null, null, false, true );
            echo "<a href='annonces.php'>Revenir aux annonces<a/>";
          }
          else
          {
            echo "Désolé, ce login existe déjà, merci d'en choisir un autre<br/>";
            echo "<a href='creer_compte.php'>Revenir à la créarion du compte</a>";
          }
        }
        else
        {
          echo "Vous devez remplir tous les champs";
          echo "<a href='creer_compte.php'>Revenir à la créarion du compte</a>";
        }
    ?>
  </body>
</html>
