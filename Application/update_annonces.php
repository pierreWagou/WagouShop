<?php session_start();?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Update annonces</title>
    </head>
    <body>
    <?php
        if (isset($_POST['enseigne']) and isset($_POST['categories']) and isset($_POST['image']))
        {
          if (!$conn=oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
            echo "Erreur connexion";
          $request="
          declare
            ref1 ref utilisateurT;
          begin

            select ref(i) into ref1
            from utilisateurs i
            where pseudo='$_POST[pseudo]';

            insert into annonces (ID, enseigne, categorie, image, etat, date_debut, date_fin, lien, code, pseudo, pseudo_moderateur, commentaires, signal_annonce, vote_annonce) values ($_POST[ID], '$_POST[enseigne]', '$_POST[categories]', '$_POST[image]', 0, SYSDATE, NULL, '$_POST[lien]','$_POST[code]', ref1, NULL, listeCommentaire(), listeutilisateur(), listevoteAnnonce());
          end;";
          $query = oci_parse($conn, $request);
          oci_execute($query);
          oci_commit($conn);
          echo '<h3> Récapitulatif de votre annonce :  </h3>
                Enseigne : '.$POST['enseigne'].' <br>
                Catégorie : '.$POST['categories'].'<br>
                Lien image : '.$POST['image'].'<br>
                Date de publication : '.SYSDATE.'<br>';
          // if (isset($query['DATE_FIN']))
          //   echo 'Date de retrait : '.$query['DATE_FIN'].'<br>';
          echo ' Lien : '.$POST['lien'].'<br>';
        }
    ?>
    </body>
</html>
