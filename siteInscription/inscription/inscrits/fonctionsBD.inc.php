<?php
require_once "constante.php";

function connexionBase()
{
    static $connexionBase = null;
    try {
        if ($connexionBase === null) {
            $connexionString = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $dbb = new PDO($connexionString, DB_USER, DB_PASS);
        }
    } catch (PDOException $error) {
        die("Erreur: " . $error->getMessage());
    }
    return $dbb;
}
//recupère les nom des groupes de la table "inscits"
function getInscrits()
{
    $query = connexionBase()->prepare("SELECT nomReservation , jour,heure FROM inscrits INNER JOIN rdv ON inscrits.idRdv = rdv.idRdv ");
    $query->execute();
    $query->fetchAll(PDO::FETCH_ASSOC);
}
//recuppère le jour et l'heure de la table "rdv"
function getTime($jour)
{
    $query = connexionBase()->prepare("SELECT heure FROM rdv WHERE jour = :jour");
    $query->bindParam(':jour', $jour, PDO::PARAM_STR);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_COLUMN);
    // $result2 = array();
    // foreach ($result as $key => $value) {
    //     array_push($result2, $value);
    // }
    // return $result2;
}

function addRdv($day, $hour, $nomReservation, $nbPersonne)
{
    $conn = connexionBase();
    $query = $conn->prepare('INSERT INTO rdv (jour,heure) VALUES (:jour,:heure)');
    $query->bindParam(':jour', $day, PDO::PARAM_STR);
    $query->bindParam(':heure', $hour, PDO::PARAM_STR);
    $query->execute();
    $lastest_id = $conn->lastInsertId();
    addInscrit($nomReservation, $nbPersonne, $lastest_id);
}
function addInscrit($nomReservation, $nbPersonne, $lastest_id)
{
    $conn = connexionBase();
    $query = $conn->prepare('INSERT INTO inscrits (nomReservation,nbPersonne,idRdv) VALUES (:nomReservation,:nbPersonne,:idRdv)');
    $query->bindParam(':nomReservation', $nomReservation, PDO::PARAM_STR);
    $query->bindParam(':nbPersonne', $nbPersonne, PDO::PARAM_INT);
    $query->bindParam(':idRdv', $lastest_id, PDO::PARAM_INT);
    $query->execute();
}


function deleteRdv()
{
    $conn = connexionBase();
    $idRdv = $_GET['idRdv'];
    //supprimer un rendez-vous
    try {
        $query = $conn->prepare("delete from rdv where idRdv = $idRdv");
        if ($query->execute()) {
            header("location:inscrit.php");
        }
    } catch (PDOException $Exception) {
        echo "Error: " . $Exception->getMessage();
    }
}
