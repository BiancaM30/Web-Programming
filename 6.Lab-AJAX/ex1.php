<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Web";

$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['statie-plecare'])) {
    $plecari = "";
    
    $sql = "SELECT DISTINCT plecare FROM rute";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $plecari .= $row["plecare"] . ";";
    }
    echo $plecari;
}
 else {
    $sosiri = "";
    $plecare = $_GET['statie-plecare'];
    $sql = "SELECT DISTINCT sosire FROM rute WHERE plecare = '" . $plecare . "'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $sosiri .= $row["sosire"] . ";";
    }
    echo $sosiri;
}

$conn->close();
?>
