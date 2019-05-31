<?php
include("db.inc.php");
include("header.inc.php");
if($ErrMsg != '')
	$ErrMsg = "<div class='row'><div class='col-md-12 bg-danger'>" . $ErrMsg . "</div></div>";
echo $ErrMsg;
?>
<div class="container">
<form method='POST' action='dologin.php' class="form-signin">
	<div class="row"><div class="col-3 text-center"><h4>Please Login</h4><hr></div></div>
	<div class="row"><div class="col-3">
		<div class="input-group mb-2 mr-sm-2 mb-sm-0">
			<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
			<input type="email" name="usrname" class="form-control form-control-sm" id="usrname" placeholder="you@example.com" required autofocus>
		</div>
	</div>
	</div>
	<div class="row"><div class="col-3">
		<div class="form-group">
			<label class="sr-only" for="usrpass">Password</label>
			<div class="input-group mb-2 mr-sm-2 mb-sm-0">
				<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
					<input type="password" name="usrpass" class="form-control form-control-sm" id="usrpass" placeholder="Password" required>
			</div>
		</div>
		</div>
	</div>
	<div class="row"><div class="col-3"><button type='submit' class='btn btn-sm btn-outline-danger float-right'><i class='fa fa-sign-in'></i> Login</button></div></div>
</form>
</div>
<?php
include("footer.inc.php");
?>