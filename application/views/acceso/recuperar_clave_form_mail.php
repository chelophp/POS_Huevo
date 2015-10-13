<!DOCTYPE html>
<html>
	<head>
		<title><?php echo lang('login_reset_password'); ?></title>
	</head>
	<body>
		<?php echo lang('login_reset_password_message'); ?><br /><br />
		<?php echo anchor('acceso/recuperar_clave_nueva/'.$reset_key, lang('login_reset_password')); ?>
	</body>
</html>