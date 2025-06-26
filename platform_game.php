<?php
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cours PHP / MySQL</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="cours.css">
    </head>
    <body>
        <h1>Bases de données MySQL</h1>  
        <button>
            <a href=index.php>Revenir à la liste des consoles</a>
        </button><br>
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
        <?php
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'video_games';
                
            //On établit la connexion
            $conn = new mysqli($servername, $username, $password, $database);
            
            //On vérifie la connexion
            if($conn->connect_error){
                die('Erreur : ' .$conn->connect_error);
            }
            echo 'Connexion réussie <br>';
            $query = "SELECT game_name, publisher_name, release_year FROM game_platform
                                    INNER JOIN game_publisher ON game_platform.game_publisher_id = game_publisher.id
                                    INNER JOIN game ON game_publisher.game_id = game.id
                                    INNER JOIN publisher ON game_publisher.publisher_id = publisher.id
                                    WHERE platform_id = ?";
            $result = $conn->execute_query($query, [$_GET["platform"]]);
            
            foreach ($result as $row){
                echo "<tr>";
                echo("<td>") . $row["game_name"] . ("<th>") . "<br>";
            }
            ?>
            <caption>
            Front-end web developer course 2021
            </caption>
            <thead>
                <tr>
                <th scope="col">Person</th>
                <th scope="col">Most interest in</th>
                <th scope="col">Age</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">Chris</th>
                <td>HTML tables</td>
                <td>22</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>