<?php 
require_once 'inc/functions.php';

session_start();

if (!empty($_POST)) {
	# code...
	$errors = array();

	require_once 'inc/db.php';

	if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
		# code...
		$errors['username'] = "Votre nom d'utilisateur n'est pas valide (alphanumérique).";
	}else {
		$req = $pdo->prepare("SELECT id FROM users WHERE username = ?");
		$req->execute([$_POST['username']]);
		$user = $req->fetch();
		if ($user) {
			# code...
			$errors['username'] = "Ce pseudo est déjà pris.";
		}
	}

	if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		# code...
		$errors['email'] = "Votre email n'est pas valide.";
	}else {
		$req = $pdo->prepare("SELECT id FROM users WHERE email = ?");
		$req->execute([$_POST['email']]);
		$user = $req->fetch();
		if ($user) {
			# code...
			$errors['email'] = "Cet email est déjà pris.";
		}
	}

	if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
		# code...
		$errors['password'] = "Vous devez rentrer un mot de passe valide.";
	}

	if (empty($errors)) {
		# code...
		$req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?");
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$token = str_random(60);
		$req->execute([$_POST['username'], $password,$_POST['email'], $token]);
		$user_id = $pdo->lastInsertId();
		mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/ressources/register/confirm.php?id=$user_id&token=$token");
		$_SESSION['flash']['success'] = "Un mail vous a été envoyé pour valider votre compte.";
		header('location:login.php');
		exit();
	}

}

include 'inc/header.php'; 

?>

<main class="container" role="main">
	<div class="row">
		<div class="col-md-5">
			<h1>S'inscrire</h1>

			<?php if (!empty($errors)): ?>
				<div class="alert alert-danger">
					<p>Vous n'avez pas rempli le formulaire correctement.</p>
					<?php foreach($errors as $error): ?>
						<li><?= $error; ?></li>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<form action="" method="post">
				<div class="form-group">
					<label for="name">Votre pseudo</label>
					<input type="text" id="name" name="username" class="form-control">
				</div>
				<div class="form-group">
					<label for="email">Adresse Email</label>
					<input type="email" id="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Mot de passe</label>
					<input type="password" id="password" name="password" class="form-control">
				</div>
				<div class="form-group">
					<label for="password_confirm">Confirmez le mot de passe</label>
					<input type="password" id="password_confirm" name="password_confirm" class="form-control">
				</div>

				<button type="submit" class="btn btn-primary">S'insrire</button>
			</form>
		</div>
	</div>
</main>

<?php include 'inc/footer.php'; ?>