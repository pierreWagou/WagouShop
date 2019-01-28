<?php session_start();?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Compte</title>
</head>
<body>

<?php

if (!$conn=oci_connect('nf17p086', 'ja5JoTbY', '//sme-oracle.sme.utc:1521/nf26'))
    echo 'erreur connexion';
$query = oci_parse($conn, ' select pseudo from utilisateurs');
oci_execute($query);
//echo $query[0];
while($row=oci_fetch_array($query, OCI_NUM))
{
    echo $row[0];
    echo '<br>';
}

oci_close($conn);

?>
</body>
</html>
