<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Listar todas as anomalias registadas nos ultimos
        três meses a mais ou menos (dX,dY) graus de (latitude,longitude)</h3>
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
        echo "<h3>Insira os valores</h3>";
        echo "<input type=\"hidden\" name=\"action\" value=\"showAnomalias\"/></p>";

        echo "<p>dX: <input type=\"text\" name=\"dx\"/></p>";
        echo "<p>dY: <input type=\"text\" name=\"dy\"/></p>";
        echo "<p>Longitude: <input type=\"text\" name=\"longitude\"/></p>";
        echo "<p>Latitude: <input type=\"text\" name=\"latitude\"/></p>";

        echo "<input type=\"submit\" value=\"Listar anomalias\"/>";
        echo "</form>";
        echo ("</div>");
    }

    function showAnomalias($db, $latitude, $longitude, $dx, $dy)
    {
        $anomalias = "SELECT anomalia.id,zona,imagem,lingua,ts,anomalia.descricao,tem_anomalia_redacao
        FROM incidencia,anomalia,item WHERE anomalia.id=anomalia_id AND item.id=item_id AND 
        latitude>=:minLatitude AND latitude<=:maxLatitude AND 
        longitude>=:minLongitude AND longitude<=:maxLongitude AND
        ts>=CURRENT_DATE-interval '3 month' AND ts<=CURRENT_DATE";

        $result = $db->prepare($anomalias);
        $result->execute([
            ':minLatitude' => $latitude - $dx, ':maxLatitude' => $latitude + $dx,
            ':minLongitude' => $longitude - $dy, ':maxLongitude' => $longitude + $dy
        ]);

        echo ("<div style=\"display:flex; flex-direction:column;align-items:center; text-align:center;\">");
        echo ("<div>");
        echo ("<h3>Anomalias</h3>");
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
            echo ("</tr>\n");
        }
        echo ("</table>\n");
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
            case "showAnomalias":
                showAnomalias($db, $_GET['latitude'], $_GET['longitude'], $_GET['dx'], $_GET['dy']);
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