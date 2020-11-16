<?php 
session_start();

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
	# code...
	require_once 'inc/db.php';
	require_once 'inc/functions.php';

	$req = $pdo->prepare("SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL");
	$req->execute(['username' => $_POST['username']]);
	$user = $req->fetch();

	if (password_verify($_POST['password'], $user->password)) {
		# code...
		$_SESSION['auth'] = $user;
		$_SESSION['flash']['success'] = "Vous êtes maintenant connecté.";
		header('location:account.php');
		die();
	}else {
		$_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrecte.";
	}

}

include 'inc/header.php'; 
?>

<div class="container">
	<h2>Authentification</h2>

	<div class="row">
		<div class="col-md-5">
			<form action="" method="post">
				<div class="form-group">
					<label for="username">Pseudo ou Email</label>
					<input type="text" id="username" name="username" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Mot de passe <a href="forget.php">(J'ai oublié mon mot de passe)</a></label>
					<input type="password" id="password" name="password" class="form-control">
				</div>
				<button type="submit" class="btn btn-primary">Se connecter</button>
			</form>
		</div>
	</div>
</div>
<?php include 'inc/footer.php'; ?>