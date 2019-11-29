<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Registar incidencias e duplicados</h3>
</header>

<body>
    <?php

    function registerIncidencia($db, $anomalia_id, $item_id, $email)
    {
        $sql = "INSERT INTO incidencia (anomalia_id,item_id,email) VALUES (:anomalia_id,:item_id,:email)";
        $result = $db->prepare($sql);
        $result->execute([':anomalia_id' => $anomalia_id, ':item_id' => $item_id, ':email' => $email]);
        header("Location:/d.php");
    }
    function registerDuplicado($db, $item1, $item2)
    {
        $sql = "INSERT INTO duplicado (item1,item2) VALUES (:item1,:item2)";
        $result = $db->prepare($sql);
        $result->execute([':item1' => $item1, ':item2' => $item2]);
        header("Location:/d.php");
    }

    function ShowForm($db, $tableName)
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
        if ($tableName == 'incidencia') {
            echo "<h3>Registar uma Incidencia</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"registerIncidencia\"/></p>";

            $anomalia_id = "SELECT id FROM anomalia ORDER BY id ASC";
            $result = $db->prepare($anomalia_id);
            $result->execute();
            echo "<p>ID da anomalia: ";
            echo "<select name=\"anomalia_id\">";
            foreach ($result as $row) {
                echo "<option value={$row['id']}>{$row['id']}</option>";
            }
            echo "</select></p>";

            $item_id = "SELECT id FROM item ORDER BY id ASC";
            $result = $db->prepare($item_id);
            $result->execute();
            echo "<p>ID do item: ";
            echo "<select name=\"item_id\">";
            foreach ($result as $row) {
                echo "<option value={$row['id']}>{$row['id']}</option>";
            }
            echo "</select></p>";

            $email = "SELECT email FROM utilizador ORDER BY email ASC";
            $result = $db->prepare($email);
            $result->execute();
            echo "<p>Email: ";
            echo "<select name=\"email\">";
            foreach ($result as $row) {
                echo "<option value={$row['email']}>{$row['email']}</option>";
            }
            echo "</select></p>";
        } else {
            echo "<h3>Registar um duplicado</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"registerDuplicado\"/></p>";

            $item1 = "SELECT id FROM item ORDER BY id ASC";
            $result = $db->prepare($item1);
            $result->execute();
            echo "<p>Item Original: ";
            echo "<select name=\"item1\">";
            foreach ($result as $row) {
                echo "<option value={$row['id']}>{$row['id']}</option>";
            }
            echo "</select></p>";

            $item2 = "SELECT id FROM item ORDER BY id ASC";
            $result = $db->prepare($item2);
            $result->execute();
            echo "<p>Item Duplicado: ";
            echo "<select name=\"item2\">";
            foreach ($result as $row) {
                echo "<option value={$row['id']}>{$row['id']}</option>";
            }
            echo "</select></p>";
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

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                case "registerIncidencia":
                    registerIncidencia($db, $_GET['anomalia_id'], $_GET['item_id'], $_GET['email']);
                    break;
                case "registerDuplicado":
                    registerDuplicado($db, $_GET['item1'], $_GET['item2']);
                    break;

                case "showForm":
                    ShowForm($db, $_GET['tableName']);
                    break;
            }
        }

        $incidencia = "SELECT anomalia_id,item_id,email FROM incidencia ORDER BY anomalia_id ASC";
        $duplicado = "SELECT item1,item2 FROM duplicado ORDER BY item1 ASC, item2 ASC";

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
        echo ("<td>Original</td>\n");
        echo ("<td>Duplicado</td>\n");
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