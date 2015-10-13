<!DOCTYPE html>
<html lang="en">
	<head>
	    <title><?=$this->config->item('company').' -- www.tradesoft.cl';?></title>
	    <meta charset="UTF-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	    <base href="<?=base_url();?>" />
	    <link rel="icon" href="<?=base_url();?>favicon.ico" type="image/x-icon"/>
	    <link rel="stylesheet" rev="stylesheet" href="<?=base_url();?>css/bootstrap.min.css" />
	    <link rel="stylesheet" rev="stylesheet" href="<?=base_url();?>css/font-awesome.min.css" />
	    <link rel="stylesheet" rev="stylesheet" href="<?=base_url();?>css/unicorn-login.css" />
	    <link rel="stylesheet" rev="stylesheet" href="<?=base_url();?>css/unicorn-login-custom.css" />
	    <script src="<?=base_url();?>js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	    <script src="<?=base_url();?>js/bootstrap.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>

		<script type="text/javascript">
		$(document).ready(function()
		{
			$(".login-form input:first").focus();
		});
		</script>
	</head>
	<body>
		<div id="container">
			<h1>Bienvenido a</h1>
			<div id="loginbox">
				<?=form_open('acceso/recuperar_clave_paso_tres/'.$key,array('class'=>'form login-form')) ?>
					<div id="logo"><?=img(array('src' => $this->Appconfig->get_logo_image(),)); ?></div>	
            		<p>Ingrese una nueva <b>Clave</b> para continuar.</p>
            		<hr />
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<?=form_password(array(
								'name'=>'password', 
								'class'=>'form-control', 
								'placeholder'=>'Clave nueva', 
								'size'=>'20')); ?>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<?=form_password(array(
								'name'=>'confirm_password', 
								'class'=>'form-control', 
								'placeholder'=> 'Confirme la clave', 
								'size'=>'20')); ?>
					</div>
					<hr />
					<div class="form-actions">
						<div class="pull-left">
							<?=anchor('acceso/index', 'Login'); ?>
						</div>
						<div class="pull-right"><input type="submit" class="btn btn-success" value="Actualizar Clave" /></div>
					</div>
				<?=form_close();?>

			</div>
			<?php if (isset($error_message)) {?>
				<div class="alert alert-danger">
					<strong><?php echo json_encode(lang('common_error')); ?></strong>
					<?php echo $error_message; ?>
				</div>
			<?php } ?>
		</div>
	</body>
</html>