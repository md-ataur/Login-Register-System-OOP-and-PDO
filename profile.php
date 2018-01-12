<?php
	include 'lib/User.php';
	include 'inc/header.php';
	Session::checkSessoin();
?>
<?php
	if (isset($_GET['id'])) {
		$userid = $_GET['id'];
	}

	$user = new User();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
		$update = $user->updateUserData($userid, $_POST);
	}

?>
<div class="mt-3 mb-3">
	<div class="titl"><h5>User Profile <span class="float-right"><a href="index.php" class="btn btn-primary">Back</a></span></h5></div>
	<div class="panel">
		<div class="loginform">
			<?php
				if (isset($update)) {
					echo $update;
				}
			?>
			<?php
				$userdata = $user->getUserById($userid);
				if ($userdata) {

			?>
			<form action="" method="POST">
				<div class="form-group">
					<label for="name">Your Name</label>
					<input type="text" id="name" name="name" value="<?php echo $userdata->name;?>" class="form-control">
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" value="<?php echo $userdata->username;?>" class="form-control">
				</div>
				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="text" id="email" name="email" value="<?php echo $userdata->email;?>" class="form-control">
				</div>
				<?php
					$snId = Session::get('id');
					if ($userid == $snId) {
						
				?>
				<button type="submit" name="update" class="btn btn-success">Update</button>
				<a class="btn btn-info" href="changepassword.php?id=<?php echo $userdata->id?>">Change Password</a>
				<?php } ?>
			</form>
			<?php }?>
		</div>	
	</div>
</div>

<?php
include 'inc/footer.php';
?>
