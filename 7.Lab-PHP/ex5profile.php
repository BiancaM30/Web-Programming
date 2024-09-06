<?php

 $servername = "localhost";
 $username = "root";
 $password = "password";
 $dbname = "Web";

 $conn = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }


if (isset($_GET['profile'])) {
        echo '<h3>'. "Utilizator: " . $_GET['profile']. '</h3>';
        displayImages();
}

function displayImages()
{
    $stmt =$GLOBALS['conn']->prepare("SELECT numeFoto FROM fotografii where email = ?");
    $stmt->bind_param('s', $_GET['profile']);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<img style="margin:20px" height="150" width="150" src=images-p5/' . $row['numeFoto'] . ' alt="not found">';
        }
    }
}
