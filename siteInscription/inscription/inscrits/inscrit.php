<?php
require_once "fonctionsBD.inc.php";
$conn = connexionBase();
//récupère le jour séléctionné
$jourFiltre = filter_input(INPUT_POST, 'filtre');
//liste des jours
$jours = ["mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Inscrits</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <h1>Liste des inscrits</h1>
    <a target="_blank" href="https://edu.ge.ch/site/cfpt-informatique/"><img class="logo" src="../img/logo.png" alt="logo"></a>
    <main>
        <form action="" method="post">
            <?php
            echo '<select name="filtre" id="filtre" onchange="changeDayView()">';
            //création d'un select de filtrage de jours
            foreach ($jours as $value) {

                if ($jourFiltre == $value) {
                    $sel = 'selected';
                } else {
                    $sel = '';
                }
                echo "<option value=\"$value\" $sel>$value</option>";
            }

            echo '</select>'; ?>
            <table>
                <th>Id rendez-vous</th>
                <th>Nom de réservation</th>
                <th>Heure de réservation</th>
                <th>Jour de réservation</th>
                <?php
                //Affiche chaque reservation de la table inscrit 
                $query = "SELECT * FROM inscrits INNER JOIN rdv ON inscrits.idRdv = rdv.idRdv WHERE rdv.jour = '$jourFiltre'";
                $rdv = $conn->query($query);
                if ($rdv->rowCount() > 0) {
                    while ($row = $rdv->fetchAll()) {
                        for ($i = 0; $i < count($row); $i++) { ?> <tr>
                                <td><?= $row[$i]['idRdv']; ?></td>
                                <td><?= $row[$i]['nomReservation'] ?></td>
                                <td><?= $row[$i]['heure'] ?></td>
                                <td><?= $row[$i]['jour'] ?></td>
                                <td><a href="delete.php?idRdv=<?= $row[$i]['idRdv']; ?>">Supprimer</a></td>
                                <td><a href="update.php?idRdv=<?= $row[$i]['idRdv']; ?>">Modifier</a></td>
                            </tr> <?php
                                }
                            }
                        } ?>
            </table>
            <input type="submit" id="submitButton" value="test" hidden>
        </form>
        <a href="../index.php" class="back">Retour</a>
    </main>
    <script>
        function changeDayView() {
            submitButton.click();
        }
    </script>
</body>

</html>