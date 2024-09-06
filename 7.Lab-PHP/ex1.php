<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function main()
{
    generateHTML();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $plecare = test_input($_POST["statie_plecare"]);
        $sosire = test_input($_POST["statie_sosire"]);
    }

    if (isset($_POST['direct']) && isset($_POST['legatura'])) {
        echo "<h1>Nu puteti avea active ambele filtre!</h1>";
    } else if (isset($_POST['direct'])) {
        getTrenuriDirecte($plecare, $sosire);
    } else if (isset($_POST['legatura'])) {
        getTrenuriLegatura($plecare, $sosire);
    }
    echo "</center></body></html>";
    $GLOBALS['conn']->close();
}

main();

function generateHTML()
{
    echo "<!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Trenuri</title>
        <style>
            table{
                border: 1px solid black;
            }
            td{
                width: 150px; 
                text-align: center;
            }
        </style>
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

function getTrenuriDirecte($plecare, $sosire)
{
    $query = "SELECT * FROM trenuri WHERE loc_plecare = ? AND loc_sosire = ?";
    $stmt = $GLOBALS['conn']->prepare($query);
    $stmt->bind_param('ss', $plecare, $sosire);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<h3>Trenuri directe intre $plecare si $sosire</h3>";
        $table = "<table border='1px'> 
                    <tr>
                        <th>Numar tren</th> 
                        <th>Tip tren</th>
                        <th>Localitate plecare</th>
                        <th>Localitate sosire</th>
                        <th>Ora plecare</th>
                        <th>Ora sosire</th>
                    </tr>";

        while ($row = $result->fetch_assoc()) {
            $table .= "<tr>"
                . "<td>" . $row["numar"] . "</td>"
                . "<td>" . $row["tip"] . " </td>"
                . "<td>" . $row["loc_plecare"] . " </td>"
                . "<td>" . $row["loc_sosire"] . " </td>"
                . "<td>" . $row["ora_plecare"] . " </td>"
                . "<td>" . $row["ora_sosire"] . " </td>"
                . "</tr>";
        }
        $table .= "</table>";
        echo $table;
    } else {
        echo "Nu exista trenuri directe intre localitatile introduse";
    }
}

function getTrenuriLegatura($plecare, $sosire)
{

    $query = "select t1.numar as numar1, t1.loc_plecare as loc_plecare1, t1.loc_sosire as loc_sosire1, t1.ora_plecare as ora_plecare1, t1.ora_sosire as ora_sosire1, 
             t2.numar as numar2, t2.loc_plecare as loc_plecare2, t2.loc_sosire as loc_sosire2, t2.ora_plecare as ora_plecare2, t2.ora_sosire as ora_sosire2, 
            t2.ora_sosire-t1.ora_plecare as time 
            from trenuri t1
            join trenuri t2 on (t2.loc_plecare=t1.loc_sosire
            and t2.ora_plecare>t1.ora_sosire)
            where t1.loc_plecare=?
            and t2.loc_sosire=?
            order by time";
    $stmt = $GLOBALS['conn']->prepare($query);
    $stmt->bind_param('ss', $plecare, $sosire);
    $stmt->execute();

    $result1 = $stmt->get_result();
    if ($result1->num_rows > 0) {
        echo "<h3>Rute indirecte intre $plecare si $sosire</h3>";
        $i = 1;
        while ($row1 = $result1->fetch_assoc()) {
            $table = '<table border="1px">
                      <tr>
                        <th>Index tren</th>
                        <th>Numar</th>
                        <th>Directia</th>
                        <th>Ore</th>
                       </tr>';

            $train1_info = '';
            $train1_info .= $row1['numar1'];
            $table .= "<tr>"
                . "<td>" . "Tren 1" . "</td>"
                . "<td>" . $row1['numar1'] . "</td>"
                . "<td>" . $row1['loc_plecare1'] . " - " . $row1['loc_sosire1'] . "</td>"
                . "<td>" . $row1['ora_plecare1'] . " - " . $row1['ora_sosire1'] . "</td>"
                . "</tr>";

            $table .= "<tr>"
                . "<td>" . "Tren 2" . "</td>"
                . "<td>" . $row1['numar2'] . "</td>"
                . "<td>" . $row1['loc_plecare2'] . " - " . $row1['loc_sosire2'] . "</td>"
                . "<td>" . $row1['ora_plecare2'] . " - " . $row1['ora_sosire2'] . "</td>"
                . "</tr>";

            $table .= '</table>';
            echo $table;
            echo "<br><br>";
        }
    } else {
        echo "Nu exista rute cu o singura legatura intre localitatile introduse";
    }
}
