# dashboard-em-php

O que precisa ser adicionado?
Uma pasta com o nome img, dentro dela ter um arquivo com o nome favicon.ico com o ícone de sua preferência para o site, e logo.png de sua preferência. Também tem que criar duas pastas (users e products).

um arquivo na raiz do projeto com o nome db.php seguindo o seguinte:

 $db_name = "nome-do-schema";
 $db_host = "localhost";
 $db_user = "root";
 $db_pass = "";

 $conn = new PDO("mysql:dbname=". $db_name . ";host=". $db_host, $db_user, $db_pass);

 // erros PDO
 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

e no banco de dados seguir o exemplo da imagem do diagrama.

![imagem diagrama](https://github.com/daviidpires/dashboard-em-php/blob/8a2462db5a69f9fc4962553816aaf2c434eca91d/diagrama.png)
