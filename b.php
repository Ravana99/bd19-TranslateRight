<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Inserir, editar e remover correcoes e propostas de correcao</h3>
</header>

<body>
    <?php
    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    function addEntry_Correcao($db, $email, $anomalia_id)
    {
        $pre_sql = "SELECT count(*) AS total FROM proposta_de_correcao WHERE email=:email GROUP BY email";
        $result = $db->prepare($pre_sql);
        $result->execute([':email' => $email]);
        #console_log($result);
        foreach ($result as $row) {
            $nro = $row['total'];
        }
        #$nro += 1;

        $sql = "INSERT INTO correcao (email,nro,anomalia_id) VALUES (:email,:nro,:anomalia_id)";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nro' => $nro, ':anomalia_id' => $anomalia_id]);
        header("Location:/b.php");
    }
    function editEntry_Correcao($db, $email, $nro, $anomalia_id, $email_old, $anomalia_id_old)
    {
        if (!$email) {
            $email = $email_old;
        }
        if (!$anomalia_id) {
            $anomalia_id = $anomalia_id_old;
        }

        $sql = "UPDATE correcao SET email = :email and anomalia_id=:anomalia_id 
        WHERE email = :email_old and nro=:nro and anomalia_id=:anomalia_id_old;";

        $result = $db->prepare($sql);
        $result->execute([
            ':email' => $email, ':nro' => $nro, ':anomalia_id' => $anomalia_id,
            ':email_old' => $email_old, ':anomalia_id_old' => $anomalia_id_old
        ]);
    }
    /*
    function deleteEntry_Correcao($db, $email, $nro, $anomalia_id)
    {
        $sql = "DELETE from correcao WHERE email = :email and nro = :nro and anomalia_id = :anomalia_id;";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nro' => $nro, ':anomalia_id' => $anomalia_id]);
        header("Location:/b.php");
    }*/


    function addEntry_PropostaCorrecao($db, $email, $texto)
    {
        $pre_sql = "SELECT count(*) AS total FROM proposta_de_correcao WHERE email=:email GROUP BY email";
        $result = $db->prepare($pre_sql);
        $result->execute([':email' => $email]);
        #console_log($result);

        foreach ($result as $row) {
            $nro = $row['total'];
        }
        $nro += 1;

        $sql = "INSERT INTO proposta_de_correcao (email,nro,data_hora,texto) 
        VALUES (:email,:nro,:data_hora,:texto)";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nro' => $nro, ':data_hora' => date('Y-m-d H:i:s'), ':texto' => $texto]);
        header("Location:/b.php");
    }
    function editEntry_PropostaCorrecao($db, $email, $texto, $nro, $email_old, $texto_old)
    {
        console_log($email);
        #if left in blank, value stays the same
        if (!$texto) {
            $texto = $texto_old;
        }
        if (!$email) {
            $email = $email_old;
        }
        console_log($email);
        $sql = "UPDATE proposta_de_correcao SET email = :email and texto=:texto 
        WHERE email = :email_old and nro=:nro;";

        $result = $db->prepare($sql);
        $result->execute([
            ':email' => $email, ':texto' => $texto, ':nro' => $nro, ':email_old' => $email_old
        ]);
    }
    function deleteEntry_PropostaCorrecao($db, $email, $nro)
    {
        $sql = "DELETE from proposta_de_correcao WHERE email = :email and nro = :nro;";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nro' => $nro]);
        header("Location:/b.php");
    }

    function ShowForm($tableName, $add) #add is a flag, 1 if adding, 0 if editing
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
            if (!$add) {
                $email_old = $_GET['email'];
                $anomalia_id_old = $_GET['anomalia_id'];
                $nro = $_GET['nro'];
                echo "<h3>Editar uma Correcao</h3>";
                echo "<input type=\"hidden\" name=\"action\" value=\"editCorrecao\"/></p>";
                echo "<input type=\"hidden\" name=\"email_old\" value=\"$email_old\"/></p>";
                echo "<input type=\"hidden\" name=\"anomalia_id_old\" value=\"$anomalia_id_old\"/></p>";
                echo "<input type=\"hidden\" name=\"nro\" value=\"$nro\"/></p>";
            } else {
                echo "<h3>Adicionar uma Correcao</h3>";
                echo "<input type=\"hidden\" name=\"action\" value=\"addCorrecao\"/></p>";
            }
            echo "<p>Email: <input type=\"text\" name=\"email\"/></p>";
            echo "<p>ID da anomalia: <input type=\"text\" name=\"anomalia_id\"/></p>";
        } else {
            if (!$add) {
                $email_old = $_GET['email'];
                $texto_old = $_GET['texto'];
                $nro = $_GET['nro'];
                echo "<h3>Editar uma Proposta de Correcao</h3>";
                echo "<input type=\"hidden\" name=\"action\" value=\"editPropostaCorrecao\"/></p>";
                echo "<input type=\"hidden\" name=\"nro\" value=\"$nro\"/></p>";
                echo "<input type=\"hidden\" name=\"email_old\" value=\"$email_old\"/></p>";
                echo "<input type=\"hidden\" name=\"texto_old\" value=\"$texto_old\"/></p>";
            } else {
                echo "<h3>Adicionar uma Proposta de Correcao</h3>";
                echo "<input type=\"hidden\" name=\"action\" value=\"addPropostaCorrecao\"/></p>";
            }
            echo "<p>Email: <input type=\"text\" name=\"email\"/></p>";
            echo "<p>Texto: <input type=\"text\" name=\"texto\"/></p>";
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
                addEntry_Correcao($db, $_GET['email'], $_GET['anomalia_id']);
                break;
            case "editCorrecao":
                editEntry_Correcao(
                    $db,
                    $_GET['email'],
                    $_GET['anomalia_id'],
                    $_GET['nro'],
                    $_GET['email_old'],
                    $_GET['anomalia_id_old']
                );
                break;
            case "deleteCorrecao":
                deleteEntry_PropostaCorrecao($db, $_GET['email'], $_GET['nro']);
                #deleteEntry_Correcao($db, $$_GET['email'], $_GET['nro'], $_GET['anomalia_id']);
                break;

            case "addPropostaCorrecao":
                addEntry_PropostaCorrecao($db, $_GET['email'], $_GET['texto']);
                break;
            case "editPropostaCorrecao":
                editEntry_PropostaCorrecao(
                    $db,
                    $_GET['email'],
                    $_GET['texto'],
                    $_GET['nro'],
                    $_GET['email_old'],
                    $_GET['texto_old']
                );
                break;
            case "deletePropostaCorrecao":
                deleteEntry_PropostaCorrecao($db, $_GET['email'], $_GET['nro']);
                break;

            case "showForm":
                ShowForm($_GET['tableName'], $_GET['add']);
                break;
        }


        $correcao = "SELECT email,nro,anomalia_id FROM correcao";
        $propostaCorrecao = "SELECT email,nro,data_hora,texto FROM proposta_de_correcao";

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
            echo ("<td>{$email}</td>\n");
            echo ("<td>{$nro}</td>\n");
            echo ("<td>{$anomalia_id}</td>\n");
            echo ("<td><a href=\"b.php?action=deleteCorrecao&email=$email&nro=$nro\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/>
            </a></td>");
            echo ("<td><a href=\"b.php?action=showForm&tableName=correcao&email=$email&nro=$nro&anomalia_id=$anomalia_id\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='edit.jpeg'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"b.php?add=true&action=showForm&tableName=correcao\">
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
            $data_hora = $row['data_hora'];
            $texto = $row['texto'];
            echo ("<tr>");
            echo ("<td>{$email}</td>\n");
            echo ("<td>{$nro}</td>\n");
            echo ("<td>{$data_hora}</td>\n");
            echo ("<td>{$texto}</td>\n");
            echo ("<td><a href=\"b.php?action=deletePropostaCorrecao&email=$email&nro=$nro\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/></a></td>");
            echo ("<td><a href=\"b.php?action=showForm&tableName=proposta_de_correcao&
            email=$email&texto=$texto&nro=$nro\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='edit.jpeg'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"b.php?add=true&action=showForm&tableName=proposta_de_correcao\">
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