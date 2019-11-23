<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Inserir e remover Locais, Items ou Anomalias</h3>
</header>

<body>
    <?php
    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    function addEntry_Correcao($db, $email, $nro, $anomalia_id)
    {
        $sql = "INSERT INTO correcao (email,nro,anomalia_id) VALUES (:email,:nro,:anomalia_id)";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nro' => $nro, ':anomalia_id' => $anomalia_id]);
        header("Location:/a.php");
    }
    function deleteEntry_Correcao($db, $latitude, $longitude)
    {
        $sql = "DELETE from local_publico WHERE latitude = :latitude and longitude = :longitude;";
        $result = $db->prepare($sql);
        $result->execute([':latitude' => $latitude, ':longitude' => $longitude]);
        header("Location:/a.php");
    }

    function addEntry_PropostaCorrecao($db, $descricao, $localizacao, $latitude, $longitude)
    {
        $sql = "INSERT INTO item (id,descricao,localizacao,longitude,latitude) 
        VALUES (default,:descricao,:localizacao,:longitude,:latitude)";
        $result = $db->prepare($sql);
        $result->execute([':descricao' => $descricao,  ':localizacao' => $localizacao, ':longitude' => $longitude, ':latitude' => $latitude]);
        header("Location:/a.php");
    }
    function deleteEntry_PropostaCorrecao($db, $id)
    {
        $sql = "DELETE from item WHERE id = :id;";
        $result = $db->prepare($sql);
        $result->execute([':id' => $id]);
        header("Location:/a.php");
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
        if ($tableName == 'correcao') {
            echo "<h3>Adicionar uma Correcao</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"addCorrecao\"/></p>";
            echo "<p>Email: <input type=\"text\" name=\"email\"/></p>";
            echo "<p>Nro: <input type=\"text\" name=\"nro\"/></p>";
            echo "<p>ID da Anomalia: <input type=\"text\" name=\"anomalia_id\"/></p>";
        } else {
            echo "<h3>Adicionar uma Proposta de Correcao</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"addPropostaCorrecao\"/></p>";
            echo "<p>Email: <input type=\"text\" name=\"email\"/></p>";
            echo "<p>Nro: <input type=\"text\" name=\"nro\"/></p>";
            echo "<p>Data/Hora: <input type=\"text\" name=\"data_hora\"/></p>";
            echo "<p>ID da Anomalia: <input type=\"text\" name=\"anomalia_id\"/></p>";
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
            case "addCorrecao":
                addEntry_LocalPublico($db, $_GET['latitude'], $_GET['longitude'], $_GET['nome']);
                break;
            case "editCorrecao":
                addEntry_LocalPublico($db, $_GET['latitude'], $_GET['longitude'], $_GET['nome']);
                break;
            case "deleteCorrecao":
                deleteEntry_LocalPublico($db, $_GET['latitude'], $_GET['longitude']);
                break;

            case "addPropostaCorrecao":
                addEntry_LocalPublico($db, $_GET['latitude'], $_GET['longitude'], $_GET['nome']);
                break;
            case "editPropostaCorrecao":
                addEntry_LocalPublico($db, $_GET['latitude'], $_GET['longitude'], $_GET['nome']);
                break;
            case "deletePropostaCorrecao":
                deleteEntry_LocalPublico($db, $_GET['latitude'], $_GET['longitude']);
                break;

            case "showForm":
                ShowForm($db, $_GET['tableName']);
                break;
        }


        $correcao = "SELECT email,nro,anomalia_id FROM correcao";
        $propostaCorrecao = "SELECT email,nro,data_hora,texto FROM proposta_correcao";

        $result = $db->prepare($correcao);
        $result->execute();

        echo ("<div style=\"display:flex; flex-direction:column;align-items:center; text-align:center;\">");
        echo ("<div>");
        echo ("<h3>Correcao</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>email</td>\n");
        echo ("<td>nro</td>\n");
        echo ("<td>anomalia_id</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $email = $row['email'];
            $nro = $row['nro'];
            $anomalia_id = $row['anomalia_id'];
            echo ("<tr>");
            echo ("<td>{$row['email']}</td>\n");
            echo ("<td>{$row['nro']}</td>\n");
            echo ("<td>{$row['anomalia_id']}</td>\n");
            echo ("<td><a href=\"a.php?action=deleteCorrecao&
            email=$email&nro=$nro&anomalia_id=$anomalia_id\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"a.php?action=showForm&tableName=correcao\">
        <img style=\"margin-top:10px; margin-bottom:100px;\" width=\"30px\" height=\"30px\" src='add.jpeg'/>
        </a>");
        echo ("</div>");

        $result = $db->prepare($propostaCorrecao);
        $result->execute();

        echo ("<div>");
        echo ("<h3>Proposta de Correcao</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>email</td>\n");
        echo ("<td>nro</td>\n");
        echo ("<td>data_hora</td>\n");
        echo ("<td>texto</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $email = $row['email'];
            $nro = $row['nro'];
            echo ("<tr>");
            echo ("<td>{$row['email']}</td>\n");
            echo ("<td>{$row['nro']}</td>\n");
            echo ("<td>{$row['data_hora']}</td>\n");
            echo ("<td>{$row['texto']}</td>\n");
            echo ("<td><a href=\"a.php?action=deletePropostaCorrecao&email=$email&nro=$nro\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/></a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"a.php?action=showForm&tableName=proposta_de_correcao\">
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