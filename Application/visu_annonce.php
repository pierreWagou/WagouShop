<?php session_start();?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Visualiser annonce</title>
  </head>
  <body>

    <?php
      include "application.php";
      if (isset($_POST['hidden']) and !isset($_POST['aimer']))
      {
        if (!$conn=oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
          echo "Erreur connexion";

          $query = oci_parse($conn,"SELECT enseigne,categorie,image,date_debut,date_fin,lien,a.pseudo.pseudo as pseudo FROM annonces a WHERE ID=$_POST[hidden]");
          oci_execute($query);
          $queryLike= oci_parse($conn, "select count(v.utilisateur) as likeAnn from annonces i, table(i.vote_annonce) v where ID= $_POST[hidden]");
          oci_execute($queryLike);
          if ($row=oci_fetch_array($query, OCI_ASSOC))
          {
              $rowLike=oci_fetch_array($queryLike);
              echo 'Enseigne : '.$row['ENSEIGNE'].' <br>
                Catégorie : '.$row['CATEGORIE'].'<br>
                Lien image : '.$row['IMAGE'].'<br>
                Auteur : '.$row['PSEUDO'].'<br>
                Date de publication : '.$row['DATE_DEBUT'].'<br>';
              if (isset($row['DATE_FIN']))
                echo 'Date de retrait : '.$row['DATE_FIN'].'<br>';
               echo ' Lien : '.$row['LIEN'].'<br>
                Likes : '.$rowLike['LIKEANN'].'<br>';
              $query = oci_parse($conn,"SELECT v.utilisateur.pseudo as pseudoUt FROM annonces a, table(a.vote_annonce) v WHERE ID=$_POST[hidden] and v.utilisateur.pseudo= '$_SESSION[login]'");
              oci_execute($query);
              if (!(oci_fetch_array($query)))
                echo '<form method="POST" action="visu_annonce.php">
                    <input type="hidden" name="hidden" value='.$_POST['hidden'].'>
                    <input type="submit" value="Aimer cette annonce" name="aimer">
                    </form>';
          }
          else
              echo "Erreur requete";

      }
      else if (isset($_POST['aimer'])) {
          if (!$conn = oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
              echo "Erreur connexion";
          $query = oci_parse($conn, "
            declare
                ref1 ref utilisateurT;
            begin
                select ref(i) into ref1
                from utilisateurs i
                where i.pseudo= '$_SESSION[login]';
                
                insert into the (select a.vote_annonce from  annonces a where ID= $_POST[hidden])
                values (voteannonceT(ref1, 1));
             end;");
          if (!oci_execute($query, OCI_DEFAULT))
              echo 'Erreur mise à jour';
          oci_commit($conn);
          $query = oci_parse($conn, "SELECT enseigne,categorie,image,date_debut,date_fin,lien,a.pseudo.pseudo as pseudo FROM annonces a WHERE ID=$_POST[hidden]");
          oci_execute($query);
          $queryLike = oci_parse($conn, "select count(v.utilisateur) as likeAnn from annonces i, table(i.vote_annonce) v where ID= $_POST[hidden]");
          oci_execute($queryLike);
          if ($row = oci_fetch_array($query, OCI_ASSOC)) {
              $rowLike = oci_fetch_array($queryLike);
              echo 'Enseigne : ' . $row['ENSEIGNE'] . ' <br>
                Catégorie : ' . $row['CATEGORIE'] . '<br>
                Lien image : ' . $row['IMAGE'] . '<br>
                Auteur : ' . $row['PSEUDO'] . '<br>
                Date de publication : ' . $row['DATE_DEBUT'] . '<br>
                Date de retrait : ' . $row['DATE_FIN'] . '<br>
                Lien : ' . $row['LIEN'] . '<br>
                Likes : ' . $rowLike['LIKEANN'];
          }
      }
    ?>
  </body>
</html>
