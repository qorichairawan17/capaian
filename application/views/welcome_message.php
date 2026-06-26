<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<div id="body">
		<?php if ($this->session->flashdata('success')): ?>
			<p style="color: green; font-weight: bold; background-color: #e6ffe6; padding: 10px; border: 1px solid green; border-radius: 4px;">
				<?php echo $this->session->flashdata('success'); ?>
			</p>
		<?php endif; ?>

		<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>
		
		<p style="background-color: #f1f8ff; border: 1px solid #c8e1ff; padding: 15px; border-radius: 4px; margin-top: 15px; margin-bottom: 15px;">
			<i class="mdi mdi-account"></i> <strong>Logged In User Details:</strong><br>
			&bull; Name: <?php echo html_escape($this->session->userdata('name')); ?><br>
			&bull; Username: <?php echo html_escape($this->session->userdata('username')); ?><br>
			&bull; Email: <?php echo html_escape($this->session->userdata('email')); ?>
		</p>

		<p><a href="<?php echo site_url('auth/logout'); ?>" style="display: inline-block; padding: 8px 16px; background-color: #d9534f; color: white; border-radius: 4px; font-weight: bold; text-decoration: none;">Logout</a></p>

		<p>If you would like to edit this page you'll find it located at:</p>
		<code>application/views/welcome_message.php</code>

		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/Welcome.php</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="userguide3/">User Guide</a>.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
