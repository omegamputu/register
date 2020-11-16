<?php 
session_start();

if (isset($_GET['id']) && isset($_GET['token'])) {
	# code...
	require 'inc/db.php';
	$req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
	$req->execute([$_GET['id'], $_GET['token']]);
	$user = $req->fetch();

	if ($user) {
		# code...
		if (!empty($_POST)) {
			# code...
			if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
				# code...
				$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
				$req = $pdo->prepare("UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL")->execute([$password]);
				session_start();
				$_SESSION['flash']['success'] = "Votre mot de passe a bien été passé.";
				$_SESSION['auth'] = $user;
				header('location:account.php');
				exit();

			}
		}
	}else {
		session_start();
		$_SESSION['flash']['danger'] = "Ce token n'est pas valide.";
		header('location:login.php');
		exit();
	}
}else{
	header('location:login.php');
	exit();
}

include 'inc/header.php'; 
?>

<div class="container">
	<h2>Réinitialiser votre mot de passe</h2>

	<div class="row">
		<div class="col-md-5">
			<form action="" method="post">
				<div class="form-group">
					<label for="password">Mot de passe</label>
					<input type="password" id="password" name="password" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Confirmation du mot de passe</label>
					<input type="password" id="password" name="password_confirm" class="form-control">
				</div>
				<button type="submit" class="btn btn-primary">Réinitialiser</button>
			</form>
		</div>
	</div>
</div>
<?php include 'inc/footer.php'; ?>