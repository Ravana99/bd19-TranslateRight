<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Listar todas as anomalias de incidências registadas
        na área compreendida entre dois locais públicos</h3>
</header>

<body>
    <?php
    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    function ShowForm()
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
        echo "<h3>Escolha os dois locais</h3>";
        echo "<input type=\"hidden\" name=\"action\" value=\"showIncidencias\"/></p>";

        echo "<p>Nome do Local Publico 1: <input type=\"text\" name=\"local1_name\"/></p>";
        echo "<p>Nome do Local Publico 2: <input type=\"text\" name=\"local2_name\"/></p>";

        echo "<input type=\"submit\" value=\"Listar anomalias\"/>";
        echo "</form>";
        echo ("</div>");
    }

    function showIncidencias($db, $local1_nome, $local2_nome)
    {
        $local1 = "SELECT latitude as latitude1, longitude as longitude1 
        FROM local_publico WHERE nome=:local1_nome";

        $result = $db->prepare($local1);
        $result->execute([':local1_nome' => $local1_nome]);
        foreach ($result as $row) {
            $latitude1 = $row['latitude1'];
            $longitude1 = $row['longitude1'];
            console_log($latitude1);
            console_log($longitude1);
        }

        $local2 = "SELECT latitude as latitude2, longitude as longitude2 
        FROM local_publico WHERE nome=:local2_nome";

        $result = $db->prepare($local2);
        $result->execute([':local2_nome' => $local2_nome]);
        foreach ($result as $row) {
            $latitude2 = $row['latitude2'];
            $longitude2 = $row['longitude2'];
            console_log($latitude2);
            console_log($longitude2);
        }

        $latitude1 < $latitude2 ? ($minLatitude = $latitude1) && ($maxLatitude = $latitude2)
            : ($minLatitude = $latitude2) && ($maxLatitude = $latitude1);
        $longitude1 < $longitude2 ? ($minLongitude = $longitude1) && ($maxLongitude = $longitude2)
            : ($minLongitude = $longitude2) && ($maxLongitude = $longitude1);

        console_log($minLatitude);
        console_log($maxLatitude);
        console_log($minLongitude);
        console_log($maxLongitude);

        $anomalia = "SELECT anomalia_id,zona,imagem,lingua,ts,descricao,tem_anomalia_redacao,item_id
        FROM incidencia,anomalia,item WHERE anomalia_id=:anomalia_id and item_id=:item_id ";

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
            echo ("<td><a href=\"a.php?action=deleteLocalPublico&latitude=$latitude&longitude=$longitude\">
        <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/>
        </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"a.php?action=showForm&tableName=local_publico\">
    <img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>
    </a>");
        echo ("</div></div>");

        $db = null;
    }

    try {
        $host = "db.ist.utl.pt";
        $user = "ist189476";
        $password = "bd123";
        $dbname = $user;

        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        switch ($_GET['action']) {
            case "showIncidencias":
                showIncidencias($db, $_GET['local1_name'], $_GET['local2_name']);
                break;
            default:
                showForm();
                break;
        }
    } catch (PDOException $e) {
        echo ("<p>ERROR: {$e->getMessage()}</p>");
    }
    ?>
</body>

</html>