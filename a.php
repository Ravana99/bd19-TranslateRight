<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Inserir e remover Locais, Items ou Anomalias</h3>
</header>

<body>
    <?php
    function deleteEntry($db, $tableName, $whereArgs)
    {
        $db->exec("DELETE from $tableName where $whereArgs");
        header("Location:/a.php");
    }
    function addEntry($db, $tableName)
    {
        if ($tableName == 'local_publico') {
            $nome = $_GET['nome'];
            $longitude = $_GET['longitude'];
            $latitude = $_GET['latitude'];
            $db->exec("INSERT INTO $tableName (nome,longitude,latitude) 
            VALUES ('$nome',$longitude,$latitude)");
            header("Location:/a.php");
        } else if ($tableName == 'item') {
            $descricao = $_GET['descricao'];
            $localizacao = $_GET['localizacao'];
            $longitude = $_GET['longitude'];
            $latitude = $_GET['latitude'];
            $db->exec("INSERT INTO $tableName (id,descricao,localizacao,longitude,latitude) 
            VALUES (default,'$descricao','$localizacao',$longitude,$latitude)");
            header("Location:/a.php");
        } else {
            $zona = $_GET['zona'];
            $imagem = $_GET['imagem'];
            $lingua = $_GET['lingua'];
            $ts = $_GET['ts'];
            $descricao = $_GET['descricao'];
            $tem_anomalia_redacao = $_GET['tem_anomalia_redacao'];
            if ($tem_anomalia_redacao == 'on') {
                $tem_anomalia_redacao = true;
            } else {
                $tem_anomalia_redacao = false;
            }
            $db->exec("INSERT INTO $tableName (id,zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) 
            VALUES (default,$zona,'$imagem','$lingua','$ts','$descricao',$tem_anomalia_redacao)");
            header("Location:/a.php");
        }
    }

    function ShowForm($db, $tableName)
    {
        echo ("<div style=\"
        width:400px;
        height:400px;
        background-color:red;
        position:absolute;
        left:50%;
        top:50%;
        transform:translate(-50%,-50%);
        display:flex; 
        flex-direction:column;
        align-items:center; 
        text-align:center;\">");

        echo "<form name=\"form\" method=\"get\">";
        echo "<input type=\"hidden\" name=\"add\" value=\"true\"/></p>";
        if ($tableName == 'local_publico') {
            echo "<h3>Adicionar um local publico</h3>";
            echo "<input type=\"hidden\" name=\"tableName\" value=\"local_publico\"/></p>";

            echo "<p>Nome: <input type=\"text\" name=\"nome\"/></p>";
            echo "<p>Longitude: <input type=\"text\" name=\"longitude\"/></p>";
            echo "<p>Latitude: <input type=\"text\" name=\"latitude\"/></p>";
        } else if ($tableName == 'item') {
            echo "<h3>Adicionar um item</h3>";
            echo "<input type=\"hidden\" name=\"tableName\" value=\"item\"/></p>";

            echo "<p>Descrição: <input type=\"text\" name=\"descricao\"/></p>";
            echo "<p>Localização: <input type=\"text\" name=\"localizacao\"/></p>";
            echo "<p>Longitude: <input type=\"text\" name=\"longitude\"/></p>";
            echo "<p>Latitude: <input type=\"text\" name=\"latitude\"/></p>";
        } else {
            echo "<h3>Adicionar uma anomalia</h3>";
            echo "<input type=\"hidden\" name=\"tableName\" value=\"anomalia\"/></p>";

            echo "<p>Zona: <input type=\"text\" name=\"zona\"/></p>";
            echo "<p>Imagem: <input type=\"text\" name=\"imagem\"/></p>";
            echo "<p>Lingua: <input type=\"text\" name=\"lingua\"/></p>";
            echo "<p>Time stamp: <input type=\"text\" name=\"ts\"/></p>";
            echo "<p>Descrição: <input type=\"text\" name=\"descricao\"/></p>";
            echo "<p>Anomalia de Redação: <input type=\"checkbox\" name=\"tem_anomalia_redacao\"/></p>";
        }
        echo "<input type=\"submit\" value=\"Adicionar\"/>";
        echo "</form>";
        echo ("</div>");
    }

    try {
        $host = "db.ist.utl.pt";
        $user = "ist189476";
        $password = "bd123";
        $dbname = $user;


        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['delete'])) {
            deleteEntry($db, $_GET['tableName'], $_GET['whereArgs']);
        }
        if (isset($_GET['show'])) {
            ShowForm($db, $_GET['tableName']);
        }
        if (isset($_GET['add'])) {
            $tableName = $_GET['tableName'];
            addEntry($db, $tableName);
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
        echo ("<td>nome</td>\n");
        echo ("<td>longitude</td>\n");
        echo ("<td>latitude</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $latitude = $row['latitude'];
            $longitude = $row['longitude'];
            echo ("<tr>");
            echo ("<td>{$row['nome']}</td>\n");
            echo ("<td>{$row['longitude']}</td>\n");
            echo ("<td>{$row['latitude']}</td>\n");
            echo ("<td><a href=\"a.php?delete=true&tableName=local_publico&whereArgs=latitude=$latitude and longitude=$longitude;\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"a.php?show=true&tableName=local_publico\">
        <img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>
        </a>");
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
        echo ("<td>longitude</td>\n");
        echo ("<td>latitude</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $id = $row['id'];
            echo ("<tr>");
            echo ("<td>{$row['id']}</td>\n");
            echo ("<td>{$row['descricao']}</td>\n");
            echo ("<td>{$row['localizacao']}</td>\n");
            echo ("<td>{$row['longitude']}</td>\n");
            echo ("<td>{$row['latitude']}</td>\n");
            echo ("<td><a href=\"a.php?delete=true&tableName=item&
            whereArgs=id=$id;\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/></a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"a.php?show=true&tableName=item\">
        <img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>
        </a>");
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
            $id = $row['id'];
            echo ("<tr>");
            echo ("<td>{$row['id']}</td>\n");
            echo ("<td>{$row['zona']}</td>\n");
            echo ("<td>{$row['imagem']}</td>\n");
            echo ("<td>{$row['lingua']}</td>\n");
            echo ("<td>{$row['ts']}</td>\n");
            echo ("<td>{$row['descricao']}</td>\n");
            echo ("<td>{$row['tem_anomalia_redacao']}</td>\n");
            echo ("<td><a href=\"a.php?delete=true&tableName=anomalia&
            whereArgs=id=$id;\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/></a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("</div>");
        echo ("<a href=\"a.php?show=true&tableName=anomalia\">
        <img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>
        </a>");
        echo ("</div>");
        $db = null;
    } catch (PDOException $e) {
        echo ("<p>ERROR: {$e->getMessage()}</p>");
    }
    ?>
</body>

</html>