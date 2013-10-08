<?php /* FILEVERSION: v1.0.1b */ ?>
<?php $cpanel = new controlPanel; ?>

<div class="page-header">
	<h1>Application Configuration</h1>
</div>
<div class="clearfix spacer"></div>
<div class="container well">
	<div class="col-md-12 panel-body">
		<div class="panel-group" id="accordion">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseUser"><div class="panel-title">Account Information</div></a>
		    	</div>
			    <div id="collapseUser" class="panel-collapse collapse">
		    		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?p=cpnl" method="post" class="form">
		    		<div class="col-md-12 panel-body">
		    			<div class="col-md-6">
		    				<label class="form-label">Name</label>
		    				<div class="help-block"><span>Change Username</span></div>
		    			</div>
			    		<div class="col-md-6">
				        	<input type="text" class="form-control" name="existingUserName" value="<?php echo $cpanel::$username;?>" required=required>
				        </div>
				    </div>
				    <div class="clearfix"></div>
			        <div class="col-md-12 panel-body">
				        <div class="col-md-6">
			    			<label class="form-label">Email Address</label>
			    			<div class="help-block"><span>Login</span></div>
			    		</div>
			    		<div class="col-md-6">
				        	<input type="text" class="form-control" name="existingUserEmail" value="<?php echo $_SESSION['email'];?>" required=required>
				        </div>
				    </div>
			        <div class="clearfix"></div>
			        <div class="col-md-12 panel-body">
				        <div class="col-md-6">
			    			<label class="form-label">Password</label>
			    			<div class="help-block"><span>Change password</span></div>
			    		</div>
			    		<div class="col-md-6">
				        	<input type="password" class="form-control" name="existingUserPass" required=required>
				        	<input type="hidden" name="existingUserPermLevel" value="<?php echo $cpanel::$perm_level;?>">
				        	<input type="hidden" name="curUser" value="curUser">
				        </div>
				    </div>
				    <div class="clearfix"></div>
			        <div class="col-md-12 panel-body">
				        <div class="col-md-6">
			    			<label class="form-label">Confirm Password</label>
			    		</div>
			    		<div class="col-md-6">
				        	<input type="password" class="form-control" name="existingUserPassConfrim" required=required>
				        </div>
				    </div>
				    <div class="clearfix"></div>
				    <div class="col-md-12 panel-body">
				        <div class="col-md-6 col-md-offset-3">
			    			<input type="submit" class="btn btn-success form-control" value="Update User Information">
			    		</div>
				    </div>
				    <div class="clearfix"></div>
			        </form>
			    </div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
<?php 
	$acceptedUsers = array ("admin","poweruser");
	if(in_array($cpanel::$perm_level,$acceptedUsers)){
?>
	<div class="col-md-12 panel-body">
		<div class="panel-group" id="accordion">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseCore"><div class="panel-title">Core Settings</div></a>
		    	</div>
		    	<div id="collapseCore" class="panel-collapse collapse">
		    		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?p=cpnl" method="post" class="form">
						<?php echo $cpanel->settings->controlPanelDisplay(); ?>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-12 panel-body">
		<div class="panel-group" id="accordion">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseUpdate"><div class="panel-title">Application Update</div></a>
		    	</div>
		    	<div id="collapseUpdate" class="panel-collapse collapse">
		    		<div class="alert-info">
		    			<div class="alert alert-body">
		    				<p>Clicking the "<i>Check for Update</i>" button below will send a request to the Perspektive Designs update server. If there are updates available for your application a zip file will begin downloading. Once the download is complete, upload the zip file below and click "<i>Apply Update</i>."<br><br>Easy as 1-2-3.</p>
		    			</div>
		    		</div>
		    		<form action="http://perspektivedesigns.com/receiveupdaterequest.php" target="update-iframe" method="post" class="form update-btn">
						<?php echo $cpanel->update->fileInfoForm(); ?>
						<input type="hidden" name="updateCheck" value="merchant_manager">
						<input type="submit" class="btn btn-success form-control" value="Check for Update">
					</form>
					<form action="index.php?p=cpnl" method="post" class="form update-btn" enctype="multipart/form-data">
						<div class="update-upload">
							<input type="file" name="updateFile" required=required>
						</div>
						<div class="clearfix"></div>
						<br>
						<input type="hidden" name="p" value="cpnl">
						<input type="submit" class="btn btn-default form-control" value="Apply Update">
					</form>
					<iframe class="update-iframe" name="update-iframe" src="iframe.php"></iframe>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-12 panel-body">
		<div class="panel-group" id="accordion">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseNewUser"><div class="panel-title">Create a New User</div></a>
		    	</div>
			    <div id="collapseNewUser" class="panel-collapse collapse">
		    		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?p=cpnl" method="post" class="form">
		    		<div class="col-md-12 panel-body">
		    			<div class="col-md-6">
		    				<label class="form-label">New User Name</label>
		    				<div class="help-block"><span>This is how you will be greeted. Generally your first name is used.</span></div>
		    			</div>
			    		<div class="col-md-6">
				        	<input type="text" class="form-control" name="newUserName" required=required>
				        </div>
				    </div>
				    <div class="clearfix"></div>
			        <div class="col-md-12 panel-body">
				        <div class="col-md-6">
			    			<label class="form-label">Email Address (login)</label>
			    		</div>
			    		<div class="col-md-6">
				        	<input type="text" class="form-control" name="newUserEmail" required=required>
				        </div>
				    </div>
			        <div class="clearfix"></div>
			        <div class="col-md-12 panel-body">
				        <div class="col-md-6">
			    			<label class="form-label">Password</label>
			    		</div>
			    		<div class="col-md-6">
				        	<input type="password" class="form-control" name="newUserPass" required=required>
				        </div>
				    </div>
				    <div class="clearfix"></div>
			        <div class="col-md-12 panel-body">
				        <div class="col-md-6">
			    			<label class="form-label">Confirm Password</label>
			    		</div>
			    		<div class="col-md-6">
				        	<input type="password" class="form-control" name="newUserPassConfrim" required=required>
				        </div>
				    </div>
				    <div class="clearfix"></div>
				    <div class="col-md-12 panel-body">
				        <div class="col-md-6">
			    			<label class="form-label">Permission Level</label>
			    		</div>
			    		<div class="col-md-6">
				        	<select class="form-control" name="newUserPermLevel" required=required>
				        		<option value="demo">Demo User</option>
				        		<option value="user">Standard User</option>
				        		<option value="poweruser">Power User</option>
				        		<option value="admin">Admin User</option>
				        	</select>
				        </div>
				    </div>
				    <div class="clearfix"></div>
				    <div class="col-md-12 panel-body">
				        <div class="col-md-6 col-md-offset-3">
				        	<input type="hidden" name="newUser" value="newUser">
			    			<input type="submit" class="btn btn-success form-control" value="Add New User">
			    		</div>
				    </div>
				    <div class="clearfix"></div>
			        </form>
			    </div>
			</div>
		</div>
	</div>
<?php
}
?>
</div>

</div><!--FOOTER START -->