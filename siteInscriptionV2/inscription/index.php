<?php
session_start();
date_default_timezone_set('Europe/Paris');
$hidden = false;
require_once "inscrits/fonctionsBD.inc.php";
if (filter_has_var(INPUT_POST, "heureDebut")) {
    $hidden = false;
    $nbPerson = filter_input(INPUT_POST, 'nbPerson', FILTER_VALIDATE_INT);
    $jour = filter_input(INPUT_POST, 'jour', FILTER_SANITIZE_STRING);
    $heureDebut = date('H:i');
    $_SESSION["nbPersonne"] =  $nbPerson;
    $_SESSION["heureDebut"] =  $heureDebut;
    $_SESSION["jour"] =  $jour;
}
if (filter_has_var(INPUT_POST, "heureFin")) {
    $hidden = true;
    $heureFin = date('H:i');
    addInscrit($_SESSION["nbPersonne"], $_SESSION["heureDebut"], $heureFin, $_SESSION["jour"]);
    header("Location : index.php");
}
$getInscrits = getInscrits();
$results = "";
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
            <img class="logo" src="img/logo.png" alt="logo">
            <div id="MyClockDisplay" class="clock" onload="showTime()"></div>

            <p>
                Nombre de personnes :
                <input type="number" name="nbPerson" id="nbPerson" min="1" max="3" class="nbPerson" required value="<?php if (isset($_SESSION['nbPersonne'])) {
                                                                                                                        echo $_SESSION['nbPersonne'];
                                                                                                                    } else {
                                                                                                                        echo "3";
                                                                                                                    } ?>">
                <br>
                <?php
                // var_dump($_SESSION['nbPerson']);
                ?>
                Le jour :
                <select name="jour">
                    <option value="vendredi"> vendredi</option>
                    <option value="samedi"> samedi</option>
                </select>
            </p>
        </header>
        <button name="heureDebut" value="submit_" id="submit">
            Debut

        </button>
        <br>
        <button name="heureFin" value="submit_" <?php
                                                if ($hidden == true) {
                                                    echo "style='display:none'";
                                                }
                                                ?> id="submit">Fin</button>
        <table>
            <tr>
                <td>Id</td>
                <td>Nombre de personnes</td>
                <td>Heure de debut</td>
                <td> Heure de fin</td>
                <td>jour</td>
            </tr>

            <?php
            foreach ($getInscrits as $inscrit) {
                $results .= "<tr> 
                        <td>" . $inscrit["idInscrit"] . "</td>
                        <td>" . $inscrit["nbPersonne"] . "</td>
                        <td> " . $inscrit["heureDebut"] . " </td>
                        <td>" . $inscrit["heureFin"] . "</td>
                        <td> " . $inscrit["jour"] . "</td>
                        <td><a href='inscrits/delete.php?idInscrit=" . $inscrit["idInscrit"]  . "'>Supprimer</a></td>
                      </tr>";
            }
            echo $results;
            ?>

        </table>

        </main>
    </form>
    <script>
        function showTime() {
            let date = new Date();
            let h = date.getHours(); // 0 - 23
            let m = date.getMinutes(); // 0 - 59
            let s = date.getSeconds(); // 0 - 59
            let session = "AM";

            if (h == 0) {
                h = 12;
            }

            if (h > 12) {
                h = h - 12;
                session = "PM";
            }

            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;

            let time = h + ":" + m + ":" + s + " " + session;
            document.getElementById("MyClockDisplay").innerText = time;
            document.getElementById("MyClockDisplay").textContent = time;

            setTimeout(showTime, 1000);

        }

        showTime();

        //verification du champs nombre
        const NUMBER_MAX = 3;
        const NUMBER_MIN = 1;
        const inputNumber = document.getElementById("nbPerson");
        let number = document.getElementById("nbPerson");

        inputNumber.addEventListener('change', verifNumber);

        function verifNumber() {
            if (number.value > NUMBER_MAX) {
                document.getElementById("nbPerson").value = NUMBER_MAX;
            } else if (number.value < NUMBER_MIN) {
                document.getElementById("nbPerson").value = NUMBER_MIN;
            }

        }
    </script>
</body>
<html>