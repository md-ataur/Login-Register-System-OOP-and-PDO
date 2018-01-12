<?php
	$filepath = realpath(dirname(__FILE__))	;
	include_once $filepath.'/../lib/Session.php';
	Session::init();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Register System PHP</title>
	<link rel="stylesheet" type="text/css" href="inc/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="inc/style.css">
	<script src="inc/jquery.min.js" ></script>
</head>
<?php
	if (isset($_GET['action']) && $_GET['action'] == 'Logout') {
		Session::destroy();
	}
?>
<body>
	<div class="container">
		<nav class="navbar navbar-light">
			<div class="container-fluid">
				<div class="navbar-brand">
					<a href="index.php" class="navbar-brand">Login Register System PHP & PDO</a>
				</div>
				<ul class="nav float-right">
					<?php
						$id = Session::get('id');
						$userLogin = Session::get('login');
						if ($userLogin == true) {
							
					?>
					<li><a class="nav-link" href="index.php">Home</a></li>
					<li><a class="nav-link" href="profile.php?id=<?php echo $id;?>">Profile</a></li>
					<li><a class="nav-link" href="?action=Logout">Logout</a></li>

					<?php } else {?>

					<li><a class="nav-link" href="login.php">Login</a></li>
					<li><a class="nav-link" href="register.php">Register</a></li>

					<?php } ?>
				</ul>
			</div>
		</nav>