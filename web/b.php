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

    function addCorrecao($db, $email, $nro, $anomalia_id)
    {
        $sql = "INSERT INTO correcao (email,nro,anomalia_id) VALUES (:email,:nro,:anomalia_id)";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nro' => $nro, ':anomalia_id' => $anomalia_id]);

        header("Location:b.php");
    }

    function addPropostaCorrecao($db, $email, $texto)
    {
        try {
            $db->beginTransaction();

            $sql = "SELECT nro AS total FROM proposta_de_correcao WHERE email=:email AND
                nro>=ALL(SELECT nro FROM proposta_de_correcao WHERE email=:email);";
            $result = $db->prepare($sql);
            $result->execute([':email' => $email]);
            foreach ($result as $row) {
                $nro = $row['total'];
            }
            $nro += 1;

            $sql = "INSERT INTO proposta_de_correcao (email,nro,data_hora,texto) 
        VALUES (:email,:nro,:data_hora,:texto)";
            $result = $db->prepare($sql);
            $result->execute([':email' => $email, ':nro' => $nro, ':data_hora' => date('Y-m-d H:i:s'), ':texto' => $texto]);

            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
            echo ("<p>ERROR: {$e->getMessage()}</p>");
        }


        header("Location:b.php");
    }

    function editEntry($db, $email, $nro, $texto, $email_old)
    {
        try {
            $db->beginTransaction();

            if ($texto) {
                $sql = "UPDATE proposta_de_correcao SET texto = :texto WHERE email = :email AND nro=:nro;";
                $result = $db->prepare($sql);
                $result->execute([
                    ':texto' => $texto, ':email' => $email_old, ':nro' => $nro
                ]);
            }

            if ($email != $email_old) {

                $sql = "SELECT nro AS total FROM proposta_de_correcao WHERE email=:email AND
                nro>=ALL(SELECT nro FROM proposta_de_correcao WHERE email=:email);";
                $result = $db->prepare($sql);
                $result->execute([':email' => $email]);
                foreach ($result as $row) {
                    $nro_new = $row['total'];
                }
                $nro_new += 1;

                $sql = "UPDATE proposta_de_correcao SET email = :email, nro=:nro_new WHERE email = :email_old AND nro=:nro;";
                $result = $db->prepare($sql);
                $result->execute([
                    ':email' => $email, ':nro' => $nro, ':email_old' => $email_old, ':nro_new' => $nro_new
                ]);

                $sql = "UPDATE correcao SET email = :email, nro=:nro_new WHERE email = :email_old AND nro=:nro";
                $result = $db->prepare($sql);
                $result->execute([
                    ':email' => $email, ':nro' => $nro, ':email_old' => $email_old, ':nro_new' => $nro_new
                ]);
            }

            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
            echo ("<p>ERROR: {$e->getMessage()}</p>");
        }
        
        header("Location:b.php");
    }

    function deleteEntryCorrecao($db, $email, $nro, $anomalia_id)
    {
        $sql = "DELETE FROM correcao WHERE email = :email AND nro = :nro AND anomalia_id=:anomalia_id;";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nro' => $nro, ':anomalia_id' => $anomalia_id]);
        header("Location:b.php");
    }
    function deleteEntryPropostaCorrecao($db, $email, $nro)
    {
        $sql = "DELETE FROM proposta_de_correcao WHERE email = :email AND nro = :nro;";
        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nro' => $nro]);
        header("Location:b.php");
    }

    function ShowForm($db, $add, $tableName) #add is a flag, 1 if adding, 0 if editing
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
        if ($tableName == 'propostaCorrecao') {
            if ($add == true) {
                echo "<h3>Adicionar uma Proposta de Correcao</h3>";
                echo "<input type=\"hidden\" name=\"action\" value=\"addPropostaCorrecao\"/></p>";
            } else {
                $email_old = $_GET['email'];
                $nro = $_GET['nro'];
                echo "<h3>Editar Proposta de Correcao</h3>";
                echo "<input type=\"hidden\" name=\"action\" value=\"edit\"/></p>";
                echo "<input type=\"hidden\" name=\"email_old\" value=\"$email_old\"/></p>";
                echo "<input type=\"hidden\" name=\"nro\" value=\"$nro\"/></p>";
            }

            $email = "SELECT email FROM utilizador_qualificado";
            $result = $db->prepare($email);
            $result->execute();
            echo "<p>Email: ";
            echo "<select name=\"email\">";
            foreach ($result as $row) {
                echo "<option value={$row['email']}>{$row['email']}</option>";
            }
            echo "</select></p>";

            echo "<p>Texto: <input type=\"text\" name=\"texto\"/></p>";
            
        } else {
            echo "<h3>Adicionar uma Correcao</h3>";
            echo "<input type=\"hidden\" name=\"action\" value=\"addCorrecao\"/></p>";
            $anomalia_id = "SELECT anomalia_id FROM incidencia";
            $result = $db->prepare($anomalia_id);
            $result->execute();
            echo "<p>ID da anomalia: ";
            echo "<select name=\"anomalia_id\">";
            foreach ($result as $row) {
                echo "<option value={$row['anomalia_id']}>{$row['anomalia_id']}</option>";
            }
            echo "</select></p>";

            $email = "SELECT DISTINCT email FROM proposta_de_correcao";
            $result = $db->prepare($email);
            $result->execute();
            echo "<p>Email: ";
            echo "<select name=\"email\">";
            foreach ($result as $row) {
                echo "<option value={$row['email']}>{$row['email']}</option>";
            }
            echo "</select></p>";

            echo "<p>Nro: <input type=\"text\" name=\"nro\"/></p>";
        }

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

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                case "addCorrecao":
                    addCorrecao($db, $_GET['email'], $_GET['nro'], $_GET['anomalia_id']);
                    break;
                case "addPropostaCorrecao":
                    addPropostaCorrecao($db, $_GET['email'], $_GET['texto']);
                    break;

                case "edit":
                    editEntry(
                        $db,
                        $_GET['email'],
                        $_GET['nro'],
                        $_GET['texto'],
                        $_GET['email_old']
                    );
                    break;
                case "deleteCorrecao":
                    deleteEntryCorrecao($db, $_GET['email'], $_GET['nro'], $_GET['anomalia_id']);
                    break;
                case "deletePropostaCorrecao":
                    deleteEntryPropostaCorrecao($db, $_GET['email'], $_GET['nro']);
                    break;

                case "showForm":
                    ShowForm($db, $_GET['add'], $_GET['tableName']);
                    break;
            }
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
            echo ("<td><a href=\"b.php?action=deleteCorrecao&email=$email&nro=$nro&anomalia_id=$anomalia_id\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='close.png'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"b.php?add=1&action=showForm&tableName=correcao\">
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
            echo ("<td><a href=\"b.php?add=0&action=showForm&tableName=propostaCorrecao&
            email=$email&texto=$texto&nro=$nro\">
            <img style=\"float:right;\" width=\"30px\" height=\"30px\" src='edit.jpeg'/>
            </a></td>");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("<a href=\"b.php?add=1&action=showForm&tableName=propostaCorrecao\">
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