<?php
	include 'lib/User.php';
	include 'inc/header.php';
	Session::checkSessoin();
	
?>
<?php
	$loginmsg = Session::get("loginmsg");
	if (isset($loginmsg)) {
		echo $loginmsg;
	}
	Session::set("loginmsg", NULL);
?>

<div class="mt-3 mb-3">
	<div class="titl"><h5>User List <span class="float-right"><strong>Welcome !</strong>
		<?php
			$name = Session::get("name");
			if (isset($name)) {
				echo $name;
			}
		?>
	</span></h5></div>
	<div class="panel">
		<table class="table table-striped mb-0">
			<tr>
				<th width="20%">Serial</th>
				<th width="20%">Name</th>
				<th width="20%">Username</th>
				<th width="20%">Email Address</th>
				<th width="20%">Action</th>
			</tr>
			<?php
				$user = new User();
				$userData = $user->getUserData();
				if($userData){
					$i = 0;
					foreach ($userData as $data) {
						$i++;
			?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $data['name'];?></td>
				<td><?php echo $data['username'];?></td>
				<td><?php echo $data['email'];?></td>
				<td>
					<a class="btn btn-primary" href="profile.php?id=<?php echo $data['id'];?>">View</a>
				</td>
			</tr>
			<?php } } else {?>
				<tr><td colspan="5"><h3>No user Data found</h3></td></tr>
			<?php }?>
		</table>
	</div>
</div>

<?php
	include 'inc/footer.php';
?>
