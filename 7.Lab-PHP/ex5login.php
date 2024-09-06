<?php

    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "Web";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['email']) && isset($_POST['parola']) and isset($_POST['login'])) {
        $email = $_POST['email'];
        $parola = $_POST['parola'];
        $stmt = $conn->prepare("SELECT * FROM utilizatori WHERE email = ? and parola = ?");
        $stmt->bind_param('ss', $email, $parola);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            setcookie("email", $email);
            header('Location:ex5upload.php');
        } else {
            echo "<p>Username sau parola gresite!</p><br>";
        }
    }
    else {
        echo "<p>Trebuie completate ambele campuri!</p><br>";
    }
?>