# dashboard-em-php

O que precisa ser adicionado?
Uma pasta com o nome img, dentro dela ter um arquivo com o nome favicon.ico com o ícone de sua preferência para o site, e logo.png de sua preferência. Também tem que criar duas pastas (users e products).

um arquivo na raiz do projeto com o nome db.php seguindo o seguinte:
<?php

    $db_name = "nome-do-schema";
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";

    $conn = new PDO("mysql:dbname=". $db_name . ";host=". $db_host, $db_user, $db_pass);

    // erros PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

?>
