<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profesor</title>
</head>

<body>
    <center>
        <?php
        echo "<h3> Completare catalog</h3>";

        $email = test_input($_POST["email"]);
        $parola = test_input($_POST["parola"]);

        try {
            $info = getProfInfo($email, $parola);
            $profId = $info[0];
            $profNume = $info[1];
            echo "<p>" . "Autentificat ca: $profNume" . "</p>";
        } catch (Exception $ex) {
            echo "<h1>Autentificare esuata!</h1>";
        }
        ?>

        <form method='post' action='ex3nota.php' target="_blank">
            <table height="100">
                <?php
                populateStudentiDiscipline($profId);
                ?>

                <tr>
                    <td>
                        Grade:
                    </td>
                    <td>
                        <input type='text' name='nota'>
                    </td>
                </tr>
                <tr>
                    <td><input type='hidden' name='profesorId' value='<?php echo $profId ?>'></td>
                </tr>
            </table>
            <input type='submit' name='addNota'>
        </form>
    </center>
</body>

</html>
<?php

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getProfInfo($email, $parola)
{
    $stmt = $GLOBALS['conn']->prepare('SELECT pID, nume FROM profesori WHERE email = ? AND parola = ?');
    $stmt->bind_param('ss', $email, $parola);
    $stmt->execute();
    $result = $stmt->get_result();
    $lista_info = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $profId = $row['pID'];
            $nume = $row['nume'];
            array_push($lista_info, $profId);
            array_push($lista_info, $nume);
            return $lista_info;
        }
    }
    throw new Exception;
}



function populateStudentiDiscipline($profId)
{
    $stmt = $GLOBALS['conn']->prepare('SELECT nume, prenume FROM studenti');
    $stmt->execute();
    $result = $stmt->get_result();
    $select = "<td><select name='studentNume'>";

    $text = "<tr><td>Studenti:</td>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $numeComplet = $row['nume'] . ' ' . $row['prenume'];
            $select .= "<option> $numeComplet </option>";
        }
        $select .= "</select> ";
    }
    $text .= $select . "</td></tr>";
    echo $text;
    echo '<br>';

    $stmt = $GLOBALS['conn']->prepare('SELECT dID FROM discipline_prof WHERE pID = ?');
    $stmt->bind_param('s', $profId);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<tr><td>Discipline:</td>";
    echo "<td><select name='disciplinaNume'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dID = $row['dID'];
            $stmt1 = $GLOBALS['conn']->prepare('SELECT nume FROM discipline WHERE dID = ?');
            $stmt1->bind_param('s', $dID);
            $stmt1->execute();
            $result2 = $stmt1->get_result();
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    $disc = $row2['nume'];
                    echo "<option>" . $disc . "</option>";
                }
            }
        }
    }
    echo "</select></td></tr>";

    $GLOBALS['conn']->close();
}
