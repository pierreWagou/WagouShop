<?php session_start();?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>New account</title>
    </head>
    <body>
      <?php
        include "application.php";
        if (!isset($_SESSION['login']))
        {
            echo "Vous devez être connecté pour poster une annonce";
        }
        else
        {
            if (isset($_POST['contenu']))
            {
              if (!$conn=oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
                  echo 'Erreur connexion';
              $query=oci_parse($conn, "INSERT INTO Commentaires(ID_commentaire, pseudo, texte) VALUES (0, '$_SESSION['login']', '$_POST[contenu]')");
              if (!oci_execute($query, OCI_DEFAULT))
                  echo'Erreur insertion';
              oci_commit($conn);
              echo "Commentaire posté <br/>";
              echo "<a href='annonces.php'>Revenir aux annonces<a/>";
            }
            else
            {
                echo "Les commentaires vides ne sont pas constructifs.";
                echo "<a href='annonces.php'>Revenir à l'annonce'</a>";
            }
          }
        ?>
      </body>
  </html>
