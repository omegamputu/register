<?php 

if (!empty($_POST) && !empty($_POST['email'])) {
	# code...
	require_once 'inc/db.php';
	require_once 'inc/functions.php';

	$req = $pdo->prepare("SELECT * FROM users WHERE email = :email AND confirmed_at IS NOT NULL");
	$req->execute(['email' => $_POST['email']]);
	$user = $req->fetch();

	if ($user) {
		# code...
		session_start();
		$reset_token = str_random(60);
		$pdo->prepare("UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?")->execute([$reset_token, $user->id]);
		$_SESSION['auth'] = $user;
		$_SESSION['flash']['success'] = "Les instructions du rappel du mot de passe vous ont été envoyées par email.";
		mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de réinitialiser votre compte merci de cliquer sur ce lien\n\nhttp://localhost/ressources/register/reset.php?id={$user->id}&token=$reset_token");
		header('location:login.php');
		die();
	}else {
		$_SESSION['flash']['danger'] = "Aucun compte ne correspond à cet adresse.";
	}

}

include 'inc/header.php'; 
?>


<div class="container">
	<div class="row">
		<div class="col-md-5">
			<h1>Mot de passe oublié</h1>
			<form action="" method="post">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" class="form-control">
				</div>
				<button type="submit" class="btn btn-primary">Envoyer</button>
			</form>
		</div>
	</div>
</div>

<?php include 'inc/footer.php'; ?>