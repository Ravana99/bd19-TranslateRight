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

    function addEntry($db, $email, $anomalia_id, $texto)
    {
        $sql = "SELECT nro AS total FROM proposta_de_correcao WHERE email=:email AND
                nro>=ALL(SELECT nro FROM proposta_de_correcao WHERE email=:email);";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email]);
        $nro = 0;
        foreach ($result as $row) {
            $nro = $row['total'];
        }
        $nro += 1;

        try {
            $db->beginTransaction();

            $sql = "INSERT INTO proposta_de_correcao (email,nro,data_hora,texto) 
        VALUES (:email,:nro,:data_hora,:texto)";
            $result = $db->prepare($sql);
            $result->execute([':email' => $email, ':nro' => $nro, ':data_hora' => date('Y-m-d H:i:s'), ':texto' => $texto]);

            $sql = "INSERT INTO correcao (email,nro,anomalia_id) VALUES (:email,:nro,:anomalia_id)";
            $result = $db->prepare($sql);
            $result->execute([':email' => $email, ':nro' => $nro, ':anomalia_id' => $anomalia_id]);

            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
            echo ("<p>ERROR: {$e->getMessage()}</p>");
        }


        header("Location:b.php");
    }
    function editEntry($db, $email, $nro, $anomalia_id, $texto, $email_old, $anomalia_id_old, $texto_old)
    {
        try {
            $db->beginTransaction();
            #if value is null, value in db stays unchanged
            if ($email) {
                $sql = "UPDATE correcao SET email = :email WHERE email = :email_old AND nro=:nro AND anomalia_id=:anomalia_id_old;";
                $result = $db->prepare($sql);
                $result->execute([
                    ':email' => $email, ':nro' => $nro, ':email_old' => $email_old, ':anomalia_id_old' => $anomalia_id_old
                ]);

                $sql = "UPDATE proposta_de_correcao SET email = :email WHERE email = :email_old AND nro=:nro;";
                $result = $db->prepare($sql);
                $result->execute([
                    ':email' => $email, ':nro' => $nro, ':email_old' => $email_old
                ]);
            } else {
                $email = $email_old;
            }

            if ($anomalia_id) {
                $sql = "UPDATE correcao SET anomalia_id = :anomalia_id WHERE email = :email AND nro=:nro AND anomalia_id=:anomalia_id_old;";
                $result = $db->prepare($sql);
                $result->execute([
                    ':anomalia_id' => $anomalia_id, ':email' => $email, ':nro' => $nro, ':anomalia_id_old' => $anomalia_id_old
                ]);
            }
            if ($texto) {
                $sql = "UPDATE proposta_de_correcao SET texto = :texto WHERE email = :email AND nro=:nro;";
                $result = $db->prepare($sql);
                $result->execute([
                    ':texto' => $texto, ':email' => $email, ':nro' => $nro
                ]);
            }

            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
            echo ("<p>ERROR: {$e->getMessage()}</p>");
        }
        header("Location:b.php");
    }

    function deleteEntry($db, $email, $nro)
    {
        $sql = "DELETE FROM proposta_de_correcao WHERE email = :email AND nro = :nro;";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nro' => $nro]);
        header("Location:b.php");
    }

    function ShowForm($add) #add is a flag, 1 if adding, 0 if editing
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
        if ($add) {
            echo "<h3>Adicionar uma Correcao/Proposta de Correcao</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"add\"/></p>";
        } else {
            $email_old = $_GET['email'];
            $anomalia_id_old = $_GET['anomalia_id'];
            $texto_old = $_GET['texto'];
            $nro = $_GET['nro'];
            echo "<h3>Editar Correcao/Proposta de Correcao</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"edit\"/></p>";
            echo "<input type=\"hidden\" name=\"email_old\" value=\"$email_old\"/></p>";
            echo "<input type=\"hidden\" name=\"anomalia_id_old\" value=\"$anomalia_id_old\"/></p>";
            echo "<input type=\"hidden\" name=\"texto_old\" value=\"$texto_old\"/></p>";
            echo "<input type=\"hidden\" name=\"nro\" value=\"$nro\"/></p>";
        }
        echo "<p>Email: <input type=\"text\" name=\"email\"/></p>";
        echo "<p>ID da anomalia: <input type=\"text\" name=\"anomalia_id\"/></p>";
        echo "<p>Texto: <input type=\"text\" name=\"texto\"/></p>";

        echo "<input type=\"submit\" value=\"Submeter\"/>";
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
            case "add":
                addEntry($db, $_GET['email'], $_GET['anomalia_id'], $_GET['texto']);
                break;

            case "edit":
                editEntry(
                    $db,
                    $_GET['email'],
                    $_GET['nro'],
                    $_GET['anomalia_id'],
                    $_GET['texto'],
                    $_GET['email_old'],
                    $_GET['anomalia_id_old'],
                    $_GET['texto_old']
                );
                break;
            case "delete":
                deleteEntry($db, $_GET['email'], $_GET['nro']);
                break;

            case "showForm":
                ShowForm($_GET['add']);
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
            echo ("<td><a href=\"b.php?action=delete&email=$email&nro=$nro\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/>
            </a></td>");
            echo ("<td><a href=\"b.php?action=showForm&email=$email&nro=$nro&anomalia_id=$anomalia_id\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='edit.jpeg'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
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
            echo ("<td><a href=\"b.php?action=delete&email=$email&nro=$nro\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/></a></td>");
            echo ("<td><a href=\"b.php?action=showForm&
            email=$email&texto=$texto&nro=$nro\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='edit.jpeg'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"b.php?add=true&action=showForm\">
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