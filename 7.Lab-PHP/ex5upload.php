<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


echo "<h3> Profilul meu</h3> ";
$email = $_COOKIE["email"];
echo "<p> Email:" . $email . "</p> ";
echo "<p> Adauga o fotografie noua </p> ";
echo '<form method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="image">
        <br><br>
        <input type="submit" name="upload" value="Upload"><br></form>
        <br>';

echo '<form method="post">';
loadFotografii();
echo '<input type="submit" name="delete" value="Delete"><br>';
echo '</form><br>';

echo '<h3>Fotografiile mele</h3>';
displayMyImages();

echo '<h3>Vizualizeaza fotografiile utilizatorilor</h3>';
showOtherUsersProfiles();


if (isset($_POST['upload'])) {
    if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
        echo 'Please select an image!';
    } else {
        $numeFoto = addslashes($_FILES['image']['name']);
        $stmt = $GLOBALS['conn']->prepare("INSERT INTO fotografii(email, numeFoto) VALUES (?,?)");
        $stmt->bind_param('ss', $_COOKIE['email'], $numeFoto);
        $stmt->execute();
        echo '<p>Fotografie salvata</p>';
    }
    setcookie("email", $email);
    header('Location:ex5upload.php');
}

if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM fotografii WHERE numeFoto = ? AND email = ?");
    $stmt->bind_param('ss', $_POST['selectStergere'], $_COOKIE['email']);
    $stmt->execute();
    echo '<p>Fotografie stearsa</p>';
    setcookie("email", $email);
    header('Location:ex5upload.php');
}


function loadFotografii()
{
    $stmt = $GLOBALS['conn']->prepare("SELECT numeFoto FROM fotografii where email = ?");
    $stmt->bind_param('s', $_COOKIE['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<select name="selectStergere">';
        echo '<option selected">Sterge imaginea</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option>' . $row['numeFoto'] . ' </option>';
        }
        echo '</select>';
    }
}


function displayMyImages()
{
    $stmt =$GLOBALS['conn']->prepare("SELECT numeFoto FROM fotografii where email = ?");
    $stmt->bind_param('s', $_COOKIE['email']);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<img style="margin:20px" height="150" width="150" src=images-p5/' . $row['numeFoto'] . ' alt="not found">';
        }
    }
}


function showOtherUsersProfiles()
{
    $stmt = $GLOBALS['conn']->prepare("SELECT email FROM utilizatori");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<a href="ex5profile.php?profile=' . $row['email'] . '">' . $row['email'] . '</a> <br>';
        }
    }
}
