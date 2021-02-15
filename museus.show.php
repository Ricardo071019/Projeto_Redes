<?php
session_start();
if(!isset($_SESSION['login'])){
	$_SESSION['login']="incorreto";
}
if($_SESSION['login']=="correto" && isset($_SESSION['login'])){
	if($_SERVER['REQUEST_METHOD']=="GET"){

	if(!isset($_GET['ator'])|| !is_numeric($_GET['ator'])){
		echo '<script>alert("Erro ao abrir atores");</script>';
		echo 'Aguarde um momento.A reencaminhar página';
		header("refresh:5; url=index_atores.php");
		exit();

     }
		     $idAtores=$_GET['ator'];
		     $con= new mysqli("localhost","root","","filmes");

		     if($con->connect_errno!=0){
		     	echo 'Ocorreu um erro no acesso á base de dados.<br>'.$con->connect_error;
		     	exit;
		     }
		     else{
		     	$sql='select * from atores where id_ator = ?';
		     	$stm = $con->prepare($sql);
		     	if($stm!=false){
		     		$stm->bind_param('i', $idAtores);
		     		$stm->execute();
		     		$res=$stm->get_result();
		     		$ator = $res->fetch_assoc();
		     		$stm->close();
		     	}
		     	else{
		     		echo '<br>';
		     		echo ($con ->error);
		     		echo '<br>';
		     		echo "Aguarde um momento.A reencaminhar página";
		     		echo '<br>';
		     		header("refresh:5; url=index_atores.php");


		     	}


		     }//end if -if($con->connect_errno!=0)
	}//if($_SERVER['REQUEST_METHOD']=="GET")

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>Detalhes</title>
</head>
<body>
	<h1>Detalhes do Ator</h1>
	<?php
		if(isset($ator)){
			echo '<br>';
			echo $ator['nome'];
			echo '<br>';
			echo $ator['nacionalidade'];
			echo '<br>';
			echo $ator['data_nascimento'];
			echo '<br>';
		}
		else{
			echo '<h2>Parece que o Ator selecionado nao existe.<br>Confirme a sua seleçao.</h2>';
		}
		?>
		<a href="atores_edit.php?ator=1">Editar</a><br>
		<br>
		<a href="atores_delete.php?ator=1">Eliminar</a>
	</body>
	</html>

</body>
</html>
<?php
}
else
{
	echo 'Para entrar nesta pagina necessita de efetuar<a href="login.php">login</a>';
	header('refresh:2;url=login.php');
	
}
?>