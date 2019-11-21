<html>

<header>
    <a href="index.php">
        <h1>Base de Dados 2019/2020 Parte III</h1>
    </a>
    <h3>Inserir, editar e remover correções e propostas de correção</h3>
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

        $sql = "SELECT * FROM local_publico, item, duplicado";
        $result = $db->prepare($sql);
        $result->execute();

        echo ("<table border=\"1\">\n");
        echo ("<tr><td>local_publico</td><td>item</td><td>duplicado</td></tr>\n");
        foreach ($result as $row) {
            echo ("<tr><td>");
            echo ($row['local_publico']);
            echo ("</td><td>");
            echo ($row['item']);
            echo ("</td><td>");
            echo ($row['duplicado']);
            echo ("</td></tr>\n");
        }
        echo ("</table>\n");

        $db = null;
    } catch (PDOException $e) {
        echo ("<p>ERROR: {$e->getMessage()}</p>");
    }
    ?>
</body>

</html>