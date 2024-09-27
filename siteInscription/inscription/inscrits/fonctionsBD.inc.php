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
//recupère les nom des groupes de la table "inscrits"
function getInscrits()
{
    $query = connexionBase()->prepare("SELECT nomReservation , jour,heure FROM inscrits INNER JOIN rdv ON inscrits.idRdv = rdv.idRdv ");
    $query->execute();
    $query->fetchAll(PDO::FETCH_ASSOC);
}
//recupère le jour et l'heure de la table "rdv"
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
//ajouter un rdv
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
//ajoute une personne
function addInscrit($nomReservation, $nbPersonne, $lastest_id)
{
    $conn = connexionBase();
    $query = $conn->prepare('INSERT INTO inscrits (nomReservation,nbPersonne,idRdv) VALUES (:nomReservation,:nbPersonne,:idRdv)');
    $query->bindParam(':nomReservation', $nomReservation, PDO::PARAM_STR);
    $query->bindParam(':nbPersonne', $nbPersonne, PDO::PARAM_INT);
    $query->bindParam(':idRdv', $lastest_id, PDO::PARAM_INT);
    try {
        $query->execute();
    } catch (PDOException $Exception) {
        echo "Error: " . $Exception->getMessage();

        die;
    }
}
//supprime un rdv
function deleteRdv()
{
    $conn = connexionBase();
    $idRdv = filter_input(INPUT_GET, 'idRdv', FILTER_VALIDATE_INT);
    //supprimer un rendez-vous
    try {
        $query = $conn->prepare("DELETE FROM rdv WHERE idRdv = $idRdv");
        $query2 = $conn->prepare("DELETE FROM inscrits WHERE idRdv = $idRdv");
        if ($query->execute() && $query2->execute()) {
            header("location:inscrit.php");
            die;
        }
    } catch (PDOException $Exception) {
        echo "Error: " . $Exception->getMessage();
    }
}
//modifier un rdv
function updateRdv($idRdv, $name, $day, $nbPersonne, $hour)
{
    $conn = connexionBase();
    try {
        $sql = "UPDATE rdv SET jour = :jour, heure = :heure  WHERE  idRdv = $idRdv ";
        $update = $conn->prepare($sql);
        $update->bindParam(':heure', $hour, PDO::PARAM_STR);
        $update->bindParam(':jour', $day, PDO::PARAM_STR);
        $update->execute();
        $sql = "UPDATE inscrits, rdv SET  nomReservation = :nomReservation, nbPersonne = :nbPersonne WHERE rdv.idRdv = inscrits.idRdv AND rdv.idRdv = $idRdv ";
        $update = $conn->prepare($sql);
        $update->bindParam(':nomReservation', $name, PDO::PARAM_STR);
        $update->bindParam(':nbPersonne', $nbPersonne, PDO::PARAM_INT);
        $update->execute();

        header("Location:inscrit.php");
        die;
    } catch (PDOException $Exception) {
        die("Une erreure est survenue lors de la modification " . $Exception->getMessage());
    }
}
//récuperer le total de personnes
function getTotalOfPersons()
{
    $conn = connexionBase();
    try {
        $sql = "SELECT SUM(nbPersonne) FROM `inscrits`";
        $nbPersonneTotal = $conn->prepare($sql);
        $nbPersonneTotal->execute();
        return $nbPersonneTotal->fetch()[0];
    } catch (PDOException $Exception) {
        die("Une erreure est survenue" . $Exception->getMessage());
    }
}
//récuperer le total de rdv
function getTotalOfRdv()
{
    $conn = connexionBase();
    try {
        $sql = "SELECT count(*) FROM `rdv`";
        $nbRdvTotal = $conn->prepare($sql);
        $nbRdvTotal->execute();
        return $nbRdvTotal->fetch()[0];
    } catch (PDOException $Exception) {
        die("Une erreure est survenue" . $Exception->getMessage());
    }
}
