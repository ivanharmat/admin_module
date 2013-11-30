<?php echo form_open('', 'class="form-signin" id="sign_in_form"');?>
	<h2 class="form-signin-heading">Please sign in</h2>
	<input type="email" class="form-control" placeholder="Your Email" required autofocus name="email">
	<input type="password" class="form-control" placeholder="Password" required name="password">
	<button class="btn btn-lg btn-custom-gharbieh btn-block" type="submit" id="sign_in_button"><i class="fa fa-lock"></i> Sign In</button>
<?php echo form_close();?>
<br>
<div id="sign_in_results"></div>