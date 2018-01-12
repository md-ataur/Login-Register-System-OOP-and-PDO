<?php
include 'inc/header.php';
include 'lib/User.php';
Session::checkLogin();
?>
<?php
	$user = new User();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
		$userRegi = $user->userRegistration($_POST);
	}

?>

<div class="mt-3 mb-3">
    <div class="titl"><h5>User Registration</h5></div>
    <div class="panel">
        <div class="loginform">
        	<div class="showMsg">
        		<?php
		        	if(isset($userRegi)){
		        		echo $userRegi;
		        	}
		        ?>
        	</div>
            <form name="chatform" id="chatform" action="" method="POST">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" class="form-control" >                    
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" id="email" name="email" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" >
                </div>
                <button type="submit" name="register" class="btn btn-success">Submit</button>
            </form>
        </div>	
    </div>
</div>

<?php
include 'inc/footer.php';
?>
