<?php
require_once "fonctionsBD.inc.php";
echo "<p style='font-size: 40px; text-align: center;'>Voulez-vous vraiment supprimé ce joueur ?</p>";
echo "<form action='#' method='POST'>";
echo "<button name='Ok'>Oui</button><br>";
echo "<button name='Non'>Non</button>";
echo "</form>";
if (isset($_POST['Ok'])) {
    deleteRdv();
} else if (isset($_POST['Non'])) {
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete inscription</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

</body>

</html>