<?php
$host = 'localhost';    // Serveur MySQL
$user = 'root';         // Utilisateur MySQL
$password = '';     // Mot de passe root
$database = 'video_games';   // Nom de la base de données
 
$conn = new mysqli($host, $user, $password, $database);
 
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
 
$game = "%" . $_GET['game'] . "%";
 
$query = "
SELECT
    game.game_name,
    genre.genre_name,
    publisher.publisher_name,
    region.region_name,
    region_sales.num_sales,
    platform.platform_name,
    game_platform.release_year
FROM game
INNER JOIN genre ON game.genre_id = genre.id
INNER JOIN game_publisher ON game_publisher.game_id = game.id
INNER JOIN publisher ON publisher.id = game_publisher.publisher_id
INNER JOIN game_platform ON game_publisher.id = game_platform.game_publisher_id
INNER JOIN region_sales ON region_sales.game_platform_id = game_platform.id
INNER JOIN region ON region.id = region_sales.region_id
INNER JOIN platform ON platform.id = game_platform.platform_id
WHERE game.game_name LIKE ?
ORDER BY game_platform.release_year ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $game);
$stmt->execute();
$result = $stmt->get_result();

?>
        
<!DOCTYPE html>
<html>
    <head>
        <title>Cours PHP / MySQL</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="cours.css">
<style>

    table {
    border-collapse: collapse;
    border: 2px solid rgb(140 140 140);
    font-family: sans-serif;
    font-size: 0.8rem;
    letter-spacing: 1px;
    }

    caption {
    caption-side: bottom;
    padding: 10px;
    font-weight: bold;
    }

    thead,
    tfoot {
    background-color: rgb(228 240 245);
    }

    th,
    td {
    border: 1px solid rgb(160 160 160);
    padding: 8px 10px;
    }

    td:last-of-type {
    text-align: center;
    }

    tbody > tr:nth-of-type(even) {
    background-color: rgb(237 238 242);
    }

    tfoot th {
    text-align: right;
    }

    tfoot td {
    font-weight: bold;
    }
</style>
    </head>
    <body>
        <h1>Bases de données MySQL</h1>  
    
        <br><a href="index.php"><button>Revenir à la page d'accueil</button></a>
        
<table>
    <thead>
        <tr>
            <th>Nom du jeu</th>
            <th>Nom de l'éditeur</th>
            <th>Région</th>
            <th>Prix</th>
            <th>Nom de la plateforme</th>
            <th>Date de la publication</th>
        </tr>
    </thead>
    <tbody>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["game_name"] . "</td>";
        echo "<td>" . $row["genre_name"] . "</td>";
        echo "<td>" . $row["publisher_name"] . "</td>";
        echo "<td>" . $row["region_name"] . "</td>";
        echo "<td>" . $row["num_sales"] . "</td>";
        echo "<td>" . $row["platform_name"] . "</td>";
        echo "<td>" . $row["release_year"] . "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

    </body>
</html>