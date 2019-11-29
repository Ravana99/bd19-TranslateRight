<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Listar Utilizadores</h3>
</header>

<body>
    <?php

    try {
        $host = "db.ist.utl.pt";
        $user = "ist189476";
        $password = "bd123";
        $dbname = $user;

        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $utilizador = "SELECT email FROM utilizador ORDER BY email ASC";

        $result = $db->prepare($utilizador);
        $result->execute();

        echo ("<div style=\"display:flex; flex-direction:column;align-items:center; text-align:center;\">");
        echo ("<div>");
        echo ("<h3>Utilizadores</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>email</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $email = $row['email'];
            echo ("<tr>");
            echo ("<td>{$email}</td>\n");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("</div>");

        $utilizador_qualificado = "SELECT email FROM utilizador_qualificado ORDER BY email ASC";

        $result = $db->prepare($utilizador_qualificado);
        $result->execute();

        echo ("<div>");
        echo ("<div style=\"display:flex; flex-direction:column;align-items:center; text-align:center;\">");
        echo ("<h3>Utilizadores Qualificados</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>email</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $email = $row['email'];
            echo ("<tr>");
            echo ("<td>{$email}</td>\n");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("</div>");

        $utilizador_regular = "SELECT email FROM utilizador_regular ORDER BY email ASC";

        $result = $db->prepare($utilizador_regular);
        $result->execute();

        echo ("<div>");
        echo ("<div style=\"display:flex; flex-direction:column;align-items:center; text-align:center;\">");
        echo ("<h3>Utilizadores Regulares</h3>");
        echo ("<table border=\"1\">\n");
        echo ("<tr>");
        echo ("<td>email</td>\n");
        echo ("</tr>\n");
        foreach ($result as $row) {
            $email = $row['email'];
            echo ("<tr>");
            echo ("<td>{$email}</td>\n");
            echo ("</tr>\n");
        }
        echo ("</table>\n");
        echo ("</div>");
        $db = null;
    } catch (PDOException $e) {
        echo ("<p>ERROR: {$e->getMessage()}</p>");
    }
    ?>
</body>

</html>