<?php
session_start();
if(!isset($_SESSION['login'])){
	$_SESSION['login']="incorreto";
}
if($_SESSION['login']=="correto" && isset($_SESSION['login'])){
	if($_SERVER['REQUEST_METHOD']=='GET'){
	if(isset($_GET['museus'])&& is_numeric($_GET['museus'])){
		$idAtor = $_GET['museus'];
		$con = new mysqli("localhost","root","","museus");

		if ($con->connect_errno!=0){
			echo "Ocorreu um erro no acesso a base de dados.<br>".$con->connect_error;
			exit;

		}
		else{
			$sql = "delete from museus where id_museu=?";
			$stm = $con->prepare($sql);
			if($stm!=false){
				$stm->bind_param("i",$id_museu);
				$stm->execute();
				$stm->close();
				echo '<script>alert("Museu eliminado com sucesso");</script>';
				echo 'Aguarde um momento.A reencaminhar página';
				header('refresh:5; url= index.museus.php');

			}
			else{
				echo '<br>';
				echo ($con->error);
				echo '<br>';
				echo "Aguarde um momento.A reencaminhar página";
				echo '<br>';
				header("refresh:5;url=index.museus.php");
			}
		}
	}
	else{
		echo "<h1>Houve um erro ao processar o seu pedido!<br>Irá ser reencaminhado!</h1>";
		header("refresh:5; url=index.museus.php");
	}
}
else{
	echo "<h1>Houve um erro ao processar o seu pedido!<br>Irá ser reencaminhado!</h1>";
	header("refresh:5; url=index.museus.php");
}

}
else{
	echo 'Para entrar nesta pagina necessita de efetuar<a href="login.php">login</a>';
	header('refresh:2;url=login.php');
	
}

