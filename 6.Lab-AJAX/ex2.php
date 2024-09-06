<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['nr'])) {
    $count = 0;
    $nrOfPages = 0;
    $sql = "SELECT * FROM Persoane";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
    }
    $nrOfPages = ceil($count / 3);
    echo $nrOfPages;
} else {
    $offset = ($_GET['page'] - 1) * 3;
    $persoane = '';
    $sql = "SELECT * FROM Persoane LIMIT 3 OFFSET " . $offset;
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $persoane .= $row["nume"] . "," . $row["prenume"] . "," . $row["telefon"] . "," . $row["email"] . ";";
    }
    echo substr($persoane, 0, -1);
}
$conn->close();
