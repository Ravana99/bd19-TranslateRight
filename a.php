<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Inserir e remover Locais, Items ou Anomalias</h3>
</header>

<body>
    <?php
    function deleteEntry_localPublico($db, $latitude, $longitude)
    {
        $db->exec("DELETE from local_publico where latitude=38.234783 and longitude=-7.543872;");
        header("Location:/a.php");
    }


    try {
        $host = "db.ist.utl.pt";
        $user = "ist189476";
        $password = "bd123";
        $dbname = $user;


        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['exec'])) {
            deleteEntry($db, $_GET['latitude'], $_GET['longitude']);
        }

        $local_publico = "SELECT latitude,longitude,nome FROM local_publico";
        $item = "SELECT id,descricao,localizacao,latitude,longitude FROM item";
        $anomalia = "SELECT id,zona,imagem,lingua,ts,descricao,tem_anomalia_redacao FROM anomalia";

        $result = $db->prepare($local_publico);
        $result->execute();

        echo ("<div style=\"display:flex; flex-direction:column;align-items:center; text-align:center;\">");
        echo ("<div>");
        echo ("<h3>Local Publico</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>latitude</td>\n");
        echo ("<td>longitude</td>\n");
        echo ("<td>nome</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $latitude = $row['latitude'];
            $longitude = $row['longitude'];
            echo ("<tr>");
            echo ("<td>{$row['latitude']}</td>\n");
            echo ("<td>{$row['longitude']}</td>\n");
            echo ("<td>{$row['nome']}</td>\n");
            echo ("<td><a href=\"a.php?exec=true&latitude=$latitude&longitude=$longitude\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>");
        echo ("</div>");

        $result = $db->prepare($item);
        $result->execute();

        echo ("<div>");
        echo ("<h3>Item</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>id</td>\n");
        echo ("<td>descricao</td>\n");
        echo ("<td>localizacao</td>\n");
        echo ("<td>latitude</td>\n");
        echo ("<td>longitude</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            echo ("<tr>");
            echo ("<td>{$row['id']}</td>\n");
            echo ("<td>{$row['descricao']}</td>\n");
            echo ("<td>{$row['localizacao']}</td>\n");
            echo ("<td>{$row['latitude']}</td>\n");
            echo ("<td>{$row['longitude']}</td>\n");
            echo ("<td><img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>");
        echo ("</div>");
        $result = $db->prepare($anomalia);
        $result->execute();

        echo ("<div>");
        echo ("<h3>Anomalia</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>id</td>\n");
        echo ("<td>zona</td>\n");
        echo ("<td>imagem</td>\n");
        echo ("<td>lingua</td>\n");
        echo ("<td>ts</td>\n");
        echo ("<td>descricao</td>\n");
        echo ("<td>tem_anomalia_redacao</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            echo ("<tr>");
            echo ("<td>{$row['id']}</td>\n");
            echo ("<td>{$row['zona']}</td>\n");
            echo ("<td>{$row['imagem']}</td>\n");
            echo ("<td>{$row['lingua']}</td>\n");
            echo ("<td>{$row['ts']}</td>\n");
            echo ("<td>{$row['descricao']}</td>\n");
            echo ("<td>{$row['tem_anomalia_redacao']}</td>\n");
            echo ("<td><img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("</div>");
        echo ("<img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>");
        echo ("</div>");
        $db = null;
    } catch (PDOException $e) {
        echo ("<p>ERROR: {$e->getMessage()}</p>");
    }
    ?>
</body>

</html>