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
        ?>
        <a href="add_games.php"><button>Ajouter un jeu</button></a>
        <form method="GET" action="research.php">
            <label for="game_name">Nom du jeu</label>
            <input type="text" id="game_name" name="game" required>
            <button type="submit">Recherchez</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $game_name = $_POST['game_name'];
            $genre_id = $_POST['genre_id'];
            $platform = $_POST['platform'];
            $req = $conn->prepare("INSERT INTO game (platform, genre_id, game_name) VALUES (?,?,?)");
            $req->bind_param("is", $platform, $genre_id, $game_name);
            $req->execute();
            $req->close();
        }
        ?>

        <form action="" method="post">
            <option value="genre_id"></option>
            </select><br>
            <label>Genre ID :</label><br>
            <select name="genre_id" id="ID">
            <option value="">--Please choose an option--</option>
        <?php
            $result = $conn->query("SELECT * FROM genre");
            foreach ($result as $row){
                echo "<option value=" . $row["id"] . ">" . $row["genre_name"] . "</option>";
            }
            ?>
            <option value="genre_id"></option>
            </select><br>
            <label> Nom du jeu :</label><br>
            <input type="text" id="name" name="game_name"><br>
            <input type="submit" value="Ajouter">
        </form>
    </body><br>
            <?php
            $result = $conn->query("SELECT * FROM platform");
            foreach ($result as $row){
                echo "<a href='platform_game.php?platform=$row[id]'><li>" . $row["platform_name"] . "</li></a>";
            }
            ?>
</html>