<?php
//appel des fonctions de la base de donnée
require_once "inscrits/fonctionsBD.inc.php";
//declaration des constantes
define("HEURE_DEBUT", 9);
define("HEURE_FIN", 19);
define("NUMBER_MAX", 3);
//declaration des variables
$errorMessage = "";
//tableau des jours
$jours = ["mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche"];

//pour chaque jour du tableau
foreach ($jours as $jour) {
    //appel de la fonction qui recupere le temps de chaque jour
    $listTime[$jour] = getTime($jour);
}
//si validation du formulaire
if (isset($_POST['submit'])) {
    //recupération des champs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $day = filter_input(INPUT_POST, 'day', FILTER_SANITIZE_STRING);
    $nbPerson = filter_input(INPUT_POST, 'nbPerson', FILTER_SANITIZE_STRING);
    $hour = explode("_", $_POST["submit"])[1];
    //vérification des champs nom et nombre de personnnes
    if (intval($nbPerson) > NUMBER_MAX || intval($nbPerson) == null) {
        $errorMessage = "Le nombre de personne n'est pas valide";
    } else if ($name == "") {
        $errorMessage = "Le champs nom est obligatoire";
    } else {
        //ajout du rdv
        addRdv($day, $hour, $name, $nbPerson);
        header("Location:inscrits/inscrit.php");
    }
}

//création du tableau des heures
function afficherTableauHeures()
{
    $tableauMinutes = ["00", "20", "40"];
    echo "<table required id=\"tableHeure\">";
    for ($i = HEURE_DEBUT; $i <= HEURE_FIN; $i++) {
        echo "<tr>";
        foreach ($tableauMinutes as $value) {
            echo "<td id=\"" . $i . "h" . $value . "\" onclick='heureChoisie(\"" . $i . "h" . $value . "\", this)'>" . $i . "h" . $value . "</td>";
        }
        echo "</tr>";
    }


    echo "</table>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription a l'escape game</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form action="index.php" method="post">
        <header>
            <h1>INSCRIPTION ESCAPE GAME</h1>
            <a target="_blank" href="https://edu.ge.ch/site/cfpt-informatique/"><img class="logo" src="img/logo.png" alt="logo"></a>
            <p>
                Nom de réservation :
                <input type="text" name="name" required>
            </p>
            <p>
                Nombre de personnes :
                <input type="number" name="nbPerson" id="nbPerson" min="1" max="3" required>
            </p>
            <p>Jour :
                <select required name="day" id="day" onchange="changeDay()">
                    <option value="mardi">mardi</option>
                    <option value="mercredi">mercredi</option>
                    <option value="jeudi">jeudi</option>
                    <option value="vendredi">vendredi</option>
                    <option value="samedi">samedi</option>
                    <option value="dimanche">dimanche</option>
                </select>
            </p>
            <?php echo "<p class='erreur'>" . $errorMessage . "</p>"; ?>
        </header>
        <main>
            <?php afficherTableauHeures(); ?>
            <br>
            <button type="submit" name="submit" value="submit_" id="submit">Valider</button>
            <br>
            <a href="inscrits/inscrit.php" class="listeRDV">Liste des rdv</a>
            <br>
            <br>
            <br>
            <br>
            <a href="info.php" class="listeRDV">Info</a>
        </main>
    </form>
    <script>
        // séléction des heures
        function heureChoisie(heure, sender) {
            if (sender.getAttribute("class") !== null && sender.getAttribute("class").includes("pris")) {
                return false;
            }
            let button = document.getElementById("submit");
            let ancienneHeureChoisi = button.getAttribute("value").split('_')[1]; //en cas de changement
            if (ancienneHeureChoisi != "" && ancienneHeureChoisi != null) {
                document.getElementById(ancienneHeureChoisi).setAttribute("class", "");
                button.setAttribute("value", "submit_");
            }
            sender.setAttribute("class", "selected");
            let value = "submit_" + heure;
            button.setAttribute("value", value);
        }
    </script>
    <script>
        var jh = new Array();
        <?php
        echo "jh = {";
        foreach ($listTime as $jour => $arr) {
            echo "'$jour' : [";
            for ($i = 0; $i < count($arr); $i++) {
                echo "'$arr[$i]'";
                if ($i < count($arr) - 1) {
                    echo ", ";
                }
            }
            echo "] ";
            if ($jour != "dimanche") {
                echo ", ";
            }
        }
        echo "};";
        ?>

        //seléction des dates déja prises
        function changeDay() {
            let day = document.getElementById("day");
            let rdvPris = jh[day.value];

            let table = document.getElementById("tableHeure");
            for (let i in table.rows) {
                let row = table.rows[i];
                for (let j in row.cells) {
                    let col = row.cells[j];
                    if (col.nodeName == "TD") {
                        col.setAttribute("class", "");
                        if (rdvPris.includes(col.id)) {
                            col.setAttribute("class", "pris");
                        }
                    }
                }
            }
        }
        //verification du champs nombre
        const NUMBER_MAX = 3;
        const NUMBER_MIN = 1;
        const inputNumber = document.getElementById("nbPerson");
        let number = document.getElementById("nbPerson");

        inputNumber.addEventListener('change', verifNumber);

        function verifNumber() {
            if (number.value > NUMBER_MAX) {
                document.getElementById("nbPerson").value = NUMBER_MAX;
            }
            else if (number.value < NUMBER_MIN) {
                document.getElementById("nbPerson").value = NUMBER_MIN;
            }
        }
        changeDay();
    </script>


</body>

</html>