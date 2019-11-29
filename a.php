<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Inserir e remover Locais, Items ou Anomalias</h3>
</header>

<body>
    <?php

    function addEntry_LocalPublico($db, $latitude, $longitude, $nome)
    {
        $sql = "INSERT INTO local_publico (nome,latitude,longitude) VALUES (:nome,:latitude,:longitude)";
        $result = $db->prepare($sql);
        $result->execute([':nome' => $nome, ':latitude' => $latitude, ':longitude' => $longitude]);
        header("Location:/a.php");
    }
    function deleteEntry_LocalPublico($db, $latitude, $longitude)
    {
        $sql = "DELETE FROM local_publico WHERE latitude = :latitude AND longitude = :longitude;";
        $result = $db->prepare($sql);
        $result->execute([':latitude' => $latitude, ':longitude' => $longitude]);
        header("Location:/a.php");
    }

    function addEntry_Item($db, $descricao, $localizacao, $coordenadas)
    {
        $coordenadasArray = explode("/", $coordenadas);
        $latitude = $coordenadasArray[0];
        $longitude = $coordenadasArray[1];
        $sql = "INSERT INTO item (id,descricao,localizacao,latitude,longitude) 
        VALUES (default,:descricao,:localizacao,:latitude,:longitude)";
        $result = $db->prepare($sql);
        $result->execute([':descricao' => $descricao,  ':localizacao' => $localizacao, ':latitude' => $latitude, ':longitude' => $longitude]);
        header("Location:/a.php");
    }
    function deleteEntry_Item($db, $id)
    {
        $sql = "DELETE FROM item WHERE id = :id;";
        $result = $db->prepare($sql);
        $result->execute([':id' => $id]);
        header("Location:/a.php");
    }

    function addEntry_Anomalia($db, $zona, $imagem, $lingua, $ts, $descricao, $tem_anomalia_redacao)
    {
        $tem_anomalia_redacao == 'on' ? $tem_anomalia_redacao = 1 : $tem_anomalia_redacao = 0;

        try {
            $db->beginTransaction();

            $sql = "INSERT INTO anomalia (id,zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) 
        VALUES (default,:zona,:imagem,:lingua,:ts,:descricao,:tem_anomalia_redacao)";
            $result = $db->prepare($sql);
            $result->execute([
                ':zona' => $zona, ':imagem' => $imagem, ':lingua' => $lingua,
                ':ts' => $ts, ':descricao' => $descricao, ':tem_anomalia_redacao' => $tem_anomalia_redacao
            ]);


            if (!$tem_anomalia_redacao) {
                $sql = "INSERT INTO anomalia_traducao (id,zona2,lingua2) VALUES (default,:zona2,:lingua2)";
                $result = $db->prepare($sql);
                $result->execute([
                    ':zona2' => $_GET['zona2'], ':lingua2' => $_GET['lingua2']
                ]);
            }

            header("Location:/a.php");
        } catch (PDOException $e) {
            $db->rollBack();
            echo ("<p>ERROR: {$e->getMessage()}</p>");
        }
    }

    function deleteEntry_Anomalia($db, $id)
    {
        $sql = "DELETE FROM anomalia WHERE id = :id;";
        $result = $db->prepare($sql);
        $result->execute([':id' => $id]);
        header("Location:/a.php");
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
        if ($tableName == 'local_publico') {
            echo "<h3>Adicionar um local publico</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"addLocalPublico\"/></p>";
            echo "<p>Nome: <input type=\"text\" name=\"nome\"/></p>";
            echo "<p>Latitude: <input type=\"text\" name=\"latitude\"/></p>";
            echo "<p>Longitude: <input type=\"text\" name=\"longitude\"/></p>";
        } else if ($tableName == 'item') {
            echo "<h3>Adicionar um item</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"addItem\"/></p>";
            echo "<p>Descrição: <input type=\"text\" name=\"descricao\"/></p>";

            $coordenadas = "SELECT latitude,longitude FROM local_publico";
            $result = $db->prepare($coordenadas);
            $result->execute();
            echo "<p>Latitude / Longitude: ";
            echo "<select name=\"coordenadas\">";
            foreach ($result as $row) {
                echo "<option value={$row['latitude']}/{$row['longitude']}>{$row['latitude']}/{$row['longitude']}</option>";
            }
            echo "</select></p>";
            echo "<p>Localização: <input type=\"text\" name=\"localizacao\"/></p>";
        } else {
            echo "<h3>Adicionar uma anomalia</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"addAnomalia\"/></p>";

            echo "<p>Zona: <input type=\"text\" name=\"zona\"/></p>";
            echo "<p>Imagem: <input type=\"text\" name=\"imagem\"/></p>";
            echo "<p>Lingua: <input type=\"text\" name=\"lingua\"/></p>";
            echo "<p>Time stamp: <input type=\"datetime\" name=\"ts\"/></p>";
            echo "<p>Descrição: <input type=\"text\" name=\"descricao\"/></p>";
            echo "<p>Anomalia de Redação: <input type=\"checkbox\" name=\"tem_anomalia_redacao\"/></p>";
        }
        echo "<input type=\"submit\" value=\"Adicionar\"/>";
        echo "</form>";
        echo ("</div>");
    }

    function ShowForm2($zona, $imagem, $lingua, $ts, $descricao, $tem_anomalia_redacao)
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
        echo "<h3>Dados da anomalia de traducao</h3>";
        echo "<input type=\"hidden\" name=\"action\" value=\"addAnomalia\"/></p>";
        echo "<p><input type=\"hidden\" name=\"zona\" value=$zona/></p>";
        echo "<p><input type=\"hidden\" name=\"imagem\" value=$imagem/></p>";
        echo "<p><input type=\"hidden\" name=\"lingua\" value=$lingua/></p>";
        echo "<p><input type=\"hidden\" name=\"ts\" value=$ts/></p>";
        echo "<p><input type=\"hidden\" name=\"descricao\" value=$descricao/></p>";
        echo "<p><input type=\"hidden\" name=\"tem_anomalia_redacao\" value=$tem_anomalia_redacao/></p>";

        echo "<p>Zona 2: <input type=\"text\" name=\"zona2\"/></p>";
        echo "<p>Lingua 2: <input type=\"text\" name=\"lingua2\"/></p>";
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
                case "addLocalPublico":
                    addEntry_LocalPublico($db, $_GET['latitude'], $_GET['longitude'], $_GET['nome']);
                    break;
                case "deleteLocalPublico":
                    deleteEntry_LocalPublico($db, $_GET['latitude'], $_GET['longitude']);
                    break;

                case "addItem":
                    addEntry_Item(
                        $db,
                        $_GET['descricao'],
                        $_GET['localizacao'],
                        $_GET['coordenadas']
                    );
                    break;
                case "deleteItem":
                    deleteEntry_Item($db, $_GET['id']);
                    break;

                case "addAnomalia":
                    if ($_GET['tem_anomalia_redacao'] != 'on' && !isset($_GET['zona2'])) {
                        showForm2(
                            $_GET['zona'],
                            $_GET['imagem'],
                            $_GET['lingua'],
                            $_GET['ts'],
                            $_GET['descricao'],
                            $_GET['tem_anomalia_redacao']
                        );
                    } else {
                        addEntry_Anomalia(
                            $db,
                            $_GET['zona'],
                            $_GET['imagem'],
                            $_GET['lingua'],
                            $_GET['ts'],
                            $_GET['descricao'],
                            $_GET['tem_anomalia_redacao']
                        );
                    }
                    break;
                case "deleteAnomalia":
                    deleteEntry_Anomalia($db, $_GET['id']);
                    break;

                case "showForm":
                    ShowForm($db, $_GET['tableName']);
                    break;
            }
        }


        $local_publico = "SELECT latitude,longitude,nome FROM local_publico";
        $item = "SELECT id,descricao,localizacao,latitude,longitude FROM item";
        $anomalia = "SELECT id,zona,imagem,lingua,ts,descricao,tem_anomalia_redacao FROM anomalia";
        $anomalia_traducao = "SELECT id,zona2,lingua2 FROM anomalia_traducao";


        $result = $db->prepare($local_publico);
        $result->execute();

        echo ("<div style=\"display:flex; flex-direction:column;align-items:center; text-align:center;\">");
        echo ("<div>");
        echo ("<h3>Local Publico</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>nome</td>\n");
        echo ("<td>latitude</td>\n");
        echo ("<td>longitude</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $latitude = $row['latitude'];
            $longitude = $row['longitude'];
            echo ("<tr>");
            echo ("<td>{$row['nome']}</td>\n");
            echo ("<td>{$row['latitude']}</td>\n");
            echo ("<td>{$row['longitude']}</td>\n");
            echo ("<td><a href=\"a.php?action=deleteLocalPublico&latitude=$latitude&longitude=$longitude\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"a.php?action=showForm&tableName=local_publico\">
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
        echo ("<td>latitude</td>\n");
        echo ("<td>longitude</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $id = $row['id'];
            echo ("<tr>");
            echo ("<td>{$row['id']}</td>\n");
            echo ("<td>{$row['descricao']}</td>\n");
            echo ("<td>{$row['localizacao']}</td>\n");
            echo ("<td>{$row['latitude']}</td>\n");
            echo ("<td>{$row['longitude']}</td>\n");
            echo ("<td><a href=\"a.php?action=deleteItem&id=$id\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/></a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"a.php?action=showForm&tableName=item\">
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
            echo ("<td><img src=\"{$row['imagem']}\" width=\"220px\" height=\"200px\"/></td>\n");
            echo ("<td>{$row['lingua']}</td>\n");
            echo ("<td>{$row['ts']}</td>\n");
            echo ("<td>{$row['descricao']}</td>\n");
            echo ("<td>{$row['tem_anomalia_redacao']}</td>\n");
            echo ("<td><a href=\"a.php?action=deleteAnomalia&id=$id\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/></a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("</div>");
        echo ("<a href=\"a.php?action=showForm&tableName=anomalia\">
        <img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>
        </a>");

        $result = $db->prepare($anomalia_traducao);
        $result->execute();

        echo ("<div style=\"display:flex; flex-direction:column; align-items:center\">");
        echo ("<h3>Anomalia de traducao</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>id</td>\n");
        echo ("<td>zona2</td>\n");
        echo ("<td>lingua2</td>\n");;
        echo ("</tr>\n");
        foreach ($result as $row) {
            $id = $row['id'];
            echo ("<tr>");
            echo ("<td>{$row['id']}</td>\n");
            echo ("<td>{$row['zona2']}</td>\n");
            echo ("<td>{$row['lingua2']}</td>\n");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("</div>");
        echo ("</div>");
        $db = null;
    } catch (PDOException $e) {
        echo ("<p>ERROR: {$e->getMessage()}</p>");
    }
    ?>
</body>

</html>