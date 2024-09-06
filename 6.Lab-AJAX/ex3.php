<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    $sql = "SELECT id FROM Studenti";
    $ids = '';
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $ids .= $row['id'] . ';';
    }
    echo $ids;
} elseif (!isset($_GET['nume'])) {
    $sql = "SELECT * FROM Studenti WHERE id=" . $_GET['id'];
    $student = '';
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $student .= $row['nume'] . ';' . $row['prenume'] . ';' . $row['facultate'] . ';' . $row['grupa'];
    }
    echo $student;
} else {
    $sql = "UPDATE Studenti SET nume = '" . $_GET['nume'] . "', prenume = '" . $_GET['prenume'] . "',facultate='" . $_GET['facultate'] . "',grupa='" . $_GET['grupa'] . "' WHERE id=" . $_GET['id'];
    if ($conn->query($sql) === TRUE) {
        echo "Datele au fost actualizate";
    } else {
        echo "Eroare la actualizarea datelor: " . $conn->error;
    }
}

$conn->close();
