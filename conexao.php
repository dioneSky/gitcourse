https://www.devmedia.com.br/crud-com-php-pdo/28873  

  <?php
    function OpenCon()
     {
     $dbhost = "localhost";
     $dbuser = "root";
     $dbpass = "1234";
     $db = "example";
     $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
     
     return $conn;
     }
     
    function CloseCon($conn)
     {
     $conn -> close();
     }
       
    ?>
	
	
	/* MySQLi Procedural Query  */
	
	    <?php
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $db = "dbname";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password,$db);
    // Check connection
    if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully";
    ?>
	
	/* Connect MySQL Database with PHP Using PDO */
	
	    <?php
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $db = "dbname";
    try {
       $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password, $db);
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       echo "Connected successfully";
       }
    catch(PDOException $e)
       {
       echo "Connection failed: " . $e->getMessage();
       }
    ?>

/*check connection*/

    <?php
    include 'db_connection.php';
     
    echo "Connected Successfully";
    mysqli_close($conn);
    ?>
	
/* *** */

Connecting to MySQL Database Server

In PHP you can easily do this using the mysqli_connect() function. All communication between PHP and the MySQL database server takes place through this connection. Here're the basic syntaxes for connecting to MySQL using MySQLi and PDO extensions:

Syntax: MySQLi, Procedural way
$link = mysqli_connect("hostname", "username", "password", "database");

Syntax: MySQLi, Object Oriented way
$mysqli = new mysqli("hostname", "username", "password", "database");

Syntax: PHP Data Objects (PDO) way
$pdo = new PDO("mysql:host=hostname;dbname=database", "username", "password"); 

<?php
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];

    include_once 'conexao.php';

    $sql = "insert into cliente values(null,
            '".$nome."','".$email."','".$tel."')";
    //echo $sql;

    if(mysql_query($sql,$con)){
        $msg = "Gravado com sucesso!";
    }else{
        $msg = "Erro ao gravar!";
    }
    mysql_close($con);
?>

/***  Insert usando PHP PDO  */

<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=meuBancoDeDados', $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare('INSERT INTO minhaTabela (nome) VALUES(:nome)');
  $stmt->execute(array(
    ':nome' => 'Ricardo Arrigoni'
  ));

  echo $stmt->rowCount();
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();

   ?>
   
/* Update com mysql_ */

<?php

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $id = $_POST["id"];

    include_once 'conexao.php';

    $sql = "update cliente set
            nome = '".$nome."', email = '".$email."',telefone = '".$tel."'
            where idcliente = ".$id;

    if(mysql_query($sql,$con)){
        $msg = "Atualizado com sucesso!";
    }else{
        $msg = "Erro ao atualizar!";
    }
    mysql_close($con);

    ?>

/* Update usando PDO * /

<?php

$id = 5;
$nome = "Novo nome do Ricardo";

try {
  $pdo = new PDO('mysql:host=localhost;dbname=meuBancoDeDados', $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare('UPDATE minhaTabela SET nome = :nome WHERE id = :id');
  $stmt->execute(array(
    ':id'   => $id,
    ':nome' => $nome
  ));

  echo $stmt->rowCount();
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
?>

/* Excluindo dados usando mysql_ */

<?php
    $id = $_GET["id"];
    include_once 'conexao.php';

    $sql = "delete from cliente where idcliente = ".$id;

    if(mysql_query($sql,$con)){
        $msg = "Deletado com sucesso!";
    }else{
        $msg = "Erro ao deletar!";
    }
    mysql_close($con);

    ?>
	
/* Excluindo com PDO */

<?php
$id = 5;

try {
  $pdo = new PDO('mysql:host=localhost;dbname=meuBancoDeDados', $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare('DELETE FROM minhaTabela WHERE id = :id');
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  echo $stmt->rowCount();
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
?>

/** Select em PDO **/

<?php
$consulta = $pdo->query("SELECT nome, usuario FROM login;");


while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    echo "Nome: {$linha['nome']} - Usuário: {$linha['usuario']}<br />";
}
?>

