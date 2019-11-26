<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Registar incidencias e duplicados</h3>
</header>

<body>
    <?php
    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    function registerIncidencia($db, $anomalia_id, $item_id, $email)
    {
        $sql = "INSERT INTO incidencia (anomalia_id,item_id,email) VALUES (:anomalia_id,:item_id,:email)";
        $result = $db->prepare($sql);
        $result->execute([':anomalia_id' => $anomalia_id, ':item_id' => $item_id, ':email' => $email]);
        header("Location:/d.php");
    }
    function registerDuplicado($db, $item1, $item2)
    {
        #to make sure that item1 is the one with the lowest id
        if ($item1 > $item2) {
            $temp = $item1;
            $item1 = $item2;
            $item2 = $temp;
        }

        $sql = "INSERT INTO duplicado (item1,item2) VALUES (:item1,:item2)";
        $result = $db->prepare($sql);
        $result->execute([':item1' => $item1, ':item2' => $item2]);
        header("Location:/d.php");
    }

    function ShowForm($tableName)
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
        if ($tableName == 'incidencia') {
            echo "<h3>Registar uma Incidencia</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"registerIncidencia\"/></p>";
            echo "<p>ID da Anomalia: <input type=\"text\" name=\"anomalia_id\"/></p>";
            echo "<p>ID do Item: <input type=\"text\" name=\"item_id\"/></p>";
            echo "<p>Email: <input type=\"text\" name=\"email\"/></p>";
        } else {
            echo "<h3>Registar um duplicado</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"registerDuplicado\"/></p>";
            echo "<p>Item Original: <input type=\"text\" name=\"item2\"/></p>";
            echo "<p>Item Duplicado: <input type=\"text\" name=\"item1\"/></p>";
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

        switch ($_GET['action']) {
            case "registerIncidencia":
                registerIncidencia($db, $_GET['anomalia_id'], $_GET['item_id'], $_GET['email']);
                break;
            case "registerDuplicado":
                registerDuplicado($db, $_GET['item1'], $_GET['item2']);
                break;

            case "showForm":
                ShowForm($_GET['tableName'], $_GET['add']);
                break;
        }

        $incidencia = "SELECT anomalia_id,item_id,email FROM incidencia";
        $duplicado = "SELECT item1,item2 FROM duplicado";

        $result = $db->prepare($incidencia);
        $result->execute();

        echo ("<div style=\"display:flex; flex-direction:column;align-items:center; text-align:center;\">");
        echo ("<div>");
        echo ("<h3>Incidencia</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>anomalia_id</td>\n");
        echo ("<td>item_id</td>\n");
        echo ("<td>email</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $anomalia_id = $row['anomalia_id'];
            $item_id = $row['item_id'];
            $email = $row['email'];
            echo ("<tr>");
            echo ("<td>{$anomalia_id}</td>\n");
            echo ("<td>{$item_id}</td>\n");
            echo ("<td>{$email}</td>\n");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"d.php?action=showForm&tableName=incidencia\">
        <img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>
        </a>");
        echo ("</div>");

        $result = $db->prepare($duplicado);
        $result->execute();

        echo ("<div>");
        echo ("<h3>Duplicados</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>Duplicado</td>\n");
        echo ("<td>Original</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $item1 = $row['item1'];
            $item2 = $row['item2'];
            echo ("<tr>");
            echo ("<td>{$item1}</td>\n");
            echo ("<td>{$item2}</td>\n");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"d.php?action=showForm&tableName=duplicado\">
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