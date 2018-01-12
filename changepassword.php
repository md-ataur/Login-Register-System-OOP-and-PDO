<?php
	include 'lib/User.php';
	include 'inc/header.php';
	Session::checkSessoin();

?>
<?php
	if (isset($_GET['id'])) {
		$userid = $_GET['id'];
		$snId = Session::get('id');
		if ($userid != $snId) {
			header("Location:index.php");
		}
	}

	$user = new User();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatepass'])){
		$updatepass = $user->updatePassword($userid, $_POST);
	}

?>


<div class="mt-3 mb-3">
	<div class="titl"><h5>Change Password <span class="float-right"><a href="profile.php?id=<?php echo $userid;?>" class="btn btn-primary">Back</a></span></h5></div>
	<div class="panel">
		<div class="loginform">
			<?php
				if (isset($updatepass)) {
					echo $updatepass;
				}
			?>
			<form action="" method="POST">
				<div class="form-group">
					<label for="oldpass">Old Password</label>
					<input type="password" id="oldpass" name="oldpass" class="form-control">
				</div>
				<div class="form-group">
					<label for="newpass">New Password</label>
					<input type="password" id="newpass" name="newpass" class="form-control">
				</div>
				<button type="submit" name="updatepass" class="btn btn-success">Update</button>
			</form>
			
		</div>	
	</div>
</div>

<?php
include 'inc/footer.php';
?>
