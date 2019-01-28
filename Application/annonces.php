<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Annonces</title>
    </head>
    <body>

    <?php include "application.php";?>
    <form action="annonces.php" method="POST">
        Recherche par catégories
        <select name='categories'>
          <option value='Tout' selected>Tout</option>
            <option value='Informatique'>Informatique</option>
            <option value='Voiture'> Voiture</option>
            <option value='Loisir'>Loisir</option>
            <option value='Service'>Service</option>
        </select>
        <input type="submit" name="choix" value="Recherche !">
    </form>
    <?php
    if (!$conn=oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
        echo 'erreur connexion';

    if (isset($_POST["categories"]) and ($_POST["categories"] != 'Tout'))
    {
      // il faudra changer etat=0 à etat=1 quand on pourra valider les annonces par un admin
      $query = oci_parse($conn, 'SELECT a.ID, a.date_debut FROM Annonces a WHERE etat=0 AND categorie='."'".$_POST['categories']."'".' order by a.ID, a.date_debut');
      oci_execute($query);
      echo "Categorie recherchee : ".$_POST['categories']."<br>";
      //echo 'La requete est : select a.ID, a.date_debut from Annonces a where etat=0 and categorie='."'".$_POST['categories']."'".' order by a.ID, a.date_debut';
    }
    else
    {
      $query = oci_parse($conn, 'SELECT a.ID, a.date_debut FROM Annonces a WHERE etat=0 ORDER BY a.ID, a.date_debut');
      oci_execute($query);
    }
    echo "<ul>";
    while($row=oci_fetch_array($query, OCI_BOTH))
        {
            echo "
                <form action='visu_annonce.php' method='POST'>
                    <input type='hidden' value='$row[ID]' name='hidden'>
                    <li>
                        <input type='submit' name='submit' value='L utilisateur avec l ID $row[0] a posté cette annonce à cette date :$row[1]'>
                    </li>
                </form>
                ";
        }
    echo "</ul>";
    oci_close($conn);
    ?>
    </body>
</html>
