<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentNume = $_POST['studentNume'];
    $disciplina = $_POST['disciplinaNume'];
    $nota = $_POST['nota'];
    $pId = $_POST['profesorId'];

    $studentNume = explode(' ', $studentNume);
    $nume = $studentNume[0];
    $prenume = $studentNume[1];
    $studentId = getStudentId($nume, $prenume);

    $disciplinaId = getDisciplinaId($disciplina);
    $date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare('INSERT INTO note(sID, pID, dID, valoare, data) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $studentId, $pId, $disciplinaId, $nota, $date);
    $result = $stmt->execute();
    if ($result == 1) {
        echo "Nota a fost adaugata cu succes!";
    } else echo "Date invalide!";

    $conn->close();
}


function getStudentId($nume, $prenume)
{
    $stmt = $GLOBALS['conn']->prepare('SELECT sID FROM studenti WHERE nume = ? AND prenume = ?');
    $stmt->bind_param('ss', $nume, $prenume);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $studID = $row['sID'];
            return $studID;
        }
    }
}


function getDisciplinaId($nume)
{
    $stmt = $GLOBALS['conn']->prepare('SELECT dID FROM discipline WHERE nume = ?');
    $stmt->bind_param('s', $nume);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $discId = $row['dID'];
            return $discId;
        }
    }
}
