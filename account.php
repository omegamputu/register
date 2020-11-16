<?php 
require 'inc/functions.php';
logged_only();

if (!empty($_POST)) {
	# code...
	if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
		# code...
		$_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas.";
	}else {
		$user_id = $_SESSION['auth']->id;
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		require_once 'inc/db.php';
		$pdo->prepare("UPDATE users SET password = ?")->execute([$password]);
		$_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour.";
	}
}
include 'inc/header.php'; 
?>

<div class="container">
	<h2>Bonjour <?= $_SESSION['auth']->username; ?></h2>

	<div class="row">
		<div class="col-md-5">
			<form action="" method="post">
		<div class="form-group">
			<input type="password" id="password" name="password" placeholder="Changer de mot de passe" class="form-control">
		</div>
		<div class="form-group">
			<input type="password" id="password" name="password_confirm" placeholder="Confirmation de mot de passe" class="form-control">
		</div>
		<button type="submit" class="btn btn-primary">Changer de mot de passe</button>
	</form>
		</div>
	</div>
</div>
<?php include 'inc/footer.php'; ?>