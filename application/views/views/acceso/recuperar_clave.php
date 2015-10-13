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
				//If we have an empty username focus
				if ($("#login_form input:first").val() == ''){
					$("#login_form input:first").focus();					
				}else{
					$("#login_form input:last").focus();
				}
			});
		</script>
	</head>
	<body>
		<div id="container">
			<h1>Bienvenido a</h1>
            <div id="loginbox">  
				<?=form_open('acceso/recuperar_clave_paso_dos',array('class'=>'form login-form')); ?>
					<div id="logo"><?=img(array('src' => $this->Appconfig->get_logo_image(),)); ?></div> 
					<p>Ingrese su nombre de <b>Usuario</b> para recuperar su clave.</p>
					<hr />
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
                    		<?=form_input(array(
                            'name'=>'username_or_email', 
                            'class'=>'form-control', 
                            'placeholder'=>lang('login_username'), 
                            'size'=>'20')); ?>
					</div>
					<hr />
					<div class="form-actions">
						<div class="pull-left">
							<?=anchor('acceso', 'Login'); ?>
						</div>
						<div class="pull-right"><input type="submit" class="btn btn-success" value="Recuperar" /></div>
					</div>
				<?=form_close()?>
			</div>
			<?php if (isset($error)) {?>
                <div class="alert alert-danger">
                    <strong><?=lang('common_error'); ?></strong>
            		 <?=$error;?>
                </div>
			<?php } else if(isset($success)){ ?>
                <div class="alert alert-success">
                    <strong><?=lang('common_success'); ?></strong> 
                    <?=$success; ?>
                </div>
            <?php } ?>
        </div>
	</body>
</html>