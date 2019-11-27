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
        background-color:white;
        border:1px black solid;
        position:absolute;
        left:50%;
        top:50%;
        transform:translate(-50%,-50%);
        display:flex; 
        flex-direction:column;
        align-items:center;
        text-align:left;
        padding:0 20px;\">");

        echo "<form name=\"form\" method=\"get\">";
        echo "<h3>Escolha os dois locais</h3>";
        echo "<input type=\"hidden\" name=\"action\" value=\"showAnomalias\"/></p>";

        echo "<p>Nome do Local Publico 1: <input type=\"text\" name=\"local1_name\"/></p>";
        echo "<p>Nome do Local Publico 2: <input type=\"text\" name=\"local2_name\"/></p>";

        echo "<input type=\"submit\" value=\"Listar anomalias\"/>";
        echo "</form>";
        echo ("</div>");
    }

    function showAnomalias($db, $local1_nome, $local2_nome)
    {
        $local1 = "SELECT latitude AS latitude1, longitude AS longitude1 
        FROM local_publico WHERE nome=:local1_nome";

        $result = $db->prepare($local1);
        $result->execute([':local1_nome' => $local1_nome]);
        foreach ($result as $row) {
            $latitude1 = $row['latitude1'];
            $longitude1 = $row['longitude1'];
        }

        $local2 = "SELECT latitude AS latitude2, longitude AS longitude2 
        FROM local_publico WHERE nome=:local2_nome";

        $result = $db->prepare($local2);
        $result->execute([':local2_nome' => $local2_nome]);
        foreach ($result as $row) {
            $latitude2 = $row['latitude2'];
            $longitude2 = $row['longitude2'];
        }

        $latitude1 < $latitude2 ? ($minLatitude = $latitude1) && ($maxLatitude = $latitude2)
            : ($minLatitude = $latitude2) && ($maxLatitude = $latitude1);
        $longitude1 < $longitude2 ? ($minLongitude = $longitude1) && ($maxLongitude = $longitude2)
            : ($minLongitude = $longitude2) && ($maxLongitude = $longitude1);

        #console_log($minLatitude);
        #console_log($maxLatitude);
        #console_log($minLongitude);
        #console_log($maxLongitude);

        $anomalias = "SELECT anomalia.id,zona,imagem,lingua,ts,anomalia.descricao,tem_anomalia_redacao
        FROM incidencia,anomalia,item WHERE anomalia.id=anomalia_id AND item.id=item_id AND 
        latitude>=:minLatitude AND latitude<=:maxLatitude AND 
        longitude>=:minLongitude AND longitude<=:maxLongitude";

        $result = $db->prepare($anomalias);
        $result->execute([
            ':minLatitude' => $minLatitude, ':maxLatitude' => $maxLatitude,
            ':minLongitude' => $minLongitude, ':maxLongitude' => $maxLongitude
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
            echo ("<td><img src=\"{$row['imagem']}\" width=\"220px\" height=\"200px\"/></td>\n");
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

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                case "showAnomalias":
                    showAnomalias($db, $_GET['local1_name'], $_GET['local2_name']);
                    break;
            }
        } else {
            showForm();
        }
    } catch (PDOException $e) {
        echo ("<p>ERROR: {$e->getMessage()}</p>");
    }
    ?>
</body>

</html>