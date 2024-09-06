<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function main(){
    generateHTML();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nume = test_input($_POST["nume"]);
        $prenume = test_input($_POST["prenume"]);
        consultareCatalog($nume, $prenume);
    }
    echo "</center></body></html>";
}

main();

function generateHTML()
{
    echo "<!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Student</title>
    </head>
    <body><center>";
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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

function getNote($studentId)
{
    $stmt = $GLOBALS['conn']->prepare('SELECT pID, dID, valoare, data FROM note WHERE sID = ?');
    $stmt->bind_param('s', $studentId);
    $stmt->execute();
    $lista_note = array();
    $i=0;
    $result = $stmt->get_result();
     if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $profID = $row['pID'];
            $discID = $row['dID'];
            $nota = $row['valoare'];
            $data = $row['data'];
            $lista_note[$i] = array($profID, $discID, $nota, $data);
            $i +=1;
        }       
    }
    return $lista_note;
}

function getNumeProf($profId)
{
    $stmt = $GLOBALS['conn']->prepare('SELECT nume FROM profesori WHERE pID = ?');
    $stmt->bind_param('s', $profId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
           $profNume = $row['nume'];
           return $profNume;
       }       
    }
}

function getNumeDisciplina($disciplinaId)
{
    $stmt = $GLOBALS['conn']->prepare('SELECT nume FROM discipline WHERE dID = ?');
    $stmt->bind_param('s', $disciplinaId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
           $discNume = $row['nume'];
           return $discNume;
       }       
    }
}

function consultareCatalog($nume, $prenume)
{
    echo "<h3>Consultare catalog: " . $nume . " " . $prenume . "</p>";

    $table = "<table cellpadding='10' border='1px'> 
                <tr>
                    <th>Materie</th> 
                    <th>Profesor</th>
                    <th>Nota</th>
                    <th>Data</th> 
                </tr> ";

    $studentId = getStudentId($nume, $prenume);   
    $noteInfo = getNote($studentId);

    for($i = 0; $i < count($noteInfo); ++$i) {
        $numeProf = getNumeProf($noteInfo[$i][0]);
        $numeDisciplina = getNumeDisciplina($noteInfo[$i][1]);
        $nota = $noteInfo[$i][2];
        $data = $noteInfo[$i][3];

        $table .= "<tr>"
        . "<td>" . $numeDisciplina . "</td>"
        . "<td>" . $numeProf . " </td>"
        . "<td>" . $nota . " </td>"
        . "<td>" . $data . " </td>"
        . "</tr>";
    }

    $table .= "</table>";
    echo $table;
}
