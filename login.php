<?php
include 'inc/header.php';
include 'lib/User.php';
Session::checkLogin();
?>
<?php
	$user = new User();
	$userLogin = '';
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
		$userLogin = $user->userLogin($_POST);
	}

?>
<div class="mt-3 mb-3">
	<div class="titl"><h5>User Login</h5></div>
	<div class="panel">
		<div class="loginform">
			<div class="showMsg">
        		<?php
		        	if(isset($userLogin)){
		        		echo $userLogin;
		        	}
		        ?>
        	</div>
			<form action="" method="POST">
				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="text" id="email" name="email" class="form-control" >
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" class="form-control">
				</div>
				<button type="submit" name="login" class="btn btn-success">Login</button>
			</form>
		</div>	
	</div>
</div>

<?php
	include 'inc/footer.php';
?>
