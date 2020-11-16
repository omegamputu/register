<?php 
require 'inc/functions.php';
logged_only();
include 'inc/header.php'; 
?>

<div class="container">
	<h2>Bonjour <?= $_SESSION['auth']->username; ?></h2>
</div>
<?php include 'inc/footer.php'; ?>