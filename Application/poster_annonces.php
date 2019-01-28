<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Poster annonces</title>
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
              if (!$conn=oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
                  echo "Erreur connexion";
              $request="select max(a.ID) as maxID from annonces a";
              $query=oci_parse($conn, $request);
              oci_execute($query);
              $row=oci_fetch_array($query);
              $ID= intval($row['MAXID'])+1;
            echo "
                <form action='update_annonces.php' method='POST'>
                <input type='hidden' name='ID' value='$ID'><br><br>
                  Nom de l'enseigne <input type='text' name='enseigne'><br><br>
                    Categorie <select name='categories'>
                        <option value='Informatique'>Informatique</option>
                        <option value='Voiture'> Voiture</option>
                        <option value='Loisir'>Loisir</option>
                        <option value='Service'>Service</option>
                    </select>
                    <br><br>
                    URL vers l'image <input type='text' name='image'><br>
                    <br>
                    Lien vers l'annonce <input type='text' name='lien'><br>
                    <br>
                    Code de l'annonce <input type='text' name='code'><br>
                    <br>
                    <input type='hidden' name='pseudo' value='$_SESSION[login]'><br>
                    <br>
                    <input type='submit' name='submit' value='Valider'>
                    </form> ";
       }
      //verification de l'unicite du login ATTENTION FAUT FAIRE UN TRUC DU GENRE
// $req=$bdd->query ("SELECT * FROM annonces where ID = 'ID'");
// $data=$req->fetch();
//
// if($data['ID'] != "" )
//
// {
// echo "L'ID que vous avez saisi est déjà utilisé sur une autre annonce<br>";
// $erreur = true;
// }
    ?>
    </body>
</html>
<?php
