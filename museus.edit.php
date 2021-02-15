<?php
session_start();
if(!isset($_SESSION['login'])){
	$_SESSION['login']="incorreto";
}
if($_SESSION['login']=="correto" && isset($_SESSION['login'])){
	if($_SERVER['REQUEST_METHOD']=="GET"){
	if(isset($_GET['museus'])&& is_numeric($_GET['museus'])){
	$idAtor=$_GET['museus'];
	$con = new mysqli ("localhost","root","","museus");

	if($con->connect_errno!=0){
	echo "<h1>Ocorreu um erro no acesso à base de dados. <br>".$con->connect_error."</h1>";
	exit();
	}
	$sql="Select * from museus where id_ator=?";
	$stm=$con->prepare($sql);
	if($stm!=false){
	$stm->bind_param("i",$idMuseu);
	$stm-> execute();

	$res=$stm->get_result();
	$ator=$res->fetch_assoc();
	$stm->close();
	}
	?>
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="ISO_8859-1">
	<title>Editar Museu</title>
	</head>
	<body>
	<h1>Editar Museu</h1>
	<form action="museus.update.php"method="post">
	<label>Nome</label><input type="text" name="nome_museu" required value="<?php echo $museus['nome'];?>"><br>
	<label>Visitantes</label><input type="text" name="Visitantes" required value="<?php echo $museus['Visitantes'];?>"><br>
	<input type="hidden" name="id_museu" required value="<?php echo $museus['id_museu'];?>">
	<input type="submit" name="enviar"><br>
	</form>
	</body>
	<?php
	}
	else{
	echo ('<h1>Houve um erro ao processar o seu pedido.<br>Dentro de segundos será reencaminhado!</h1>');
	header("refresh:5,url=index.museus.php");
	}
	}


}
else{
	echo 'Para entrar nesta pagina necessita de efetuar<a href="login.php">login</a>';
	header('refresh:2;url=login.php');
	
}


