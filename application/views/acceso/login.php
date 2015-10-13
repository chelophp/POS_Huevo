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
	            if ($("#location_id").val() == ''){
	                $("#location_id").focus();                   
	            }else{
		            if ($("#username").val() == ''){
		                $("#username").focus();                   
		            }else{
		                $("#password").focus();
		            }
	            }
			});
	    </script>
	</head>
	<body>
	<?php if ($ie_browser_warning) { ?>
	    <div id="container">
			<div class="alert alert-danger">
				Este navegador no es compatible. Es requerido actualizar para un optimo funcionamiento.<br>
				Puede utilizar alguno de los siguientes nevegadores: <a href="http://getfirefox.com" target="_blank">Firefox</a> o <a href="http://google.com/chrome" target="_blank">Chrome</a>.';
			</div>
		</div>
	<?php
	 die();
	} ?>
    <div id="container">
    	<?php if (validation_errors() || $ie_browser_warning) {?>
            <div class="alert alert-danger">
    	        <strong><?=lang('common_error'); ?></strong>
                <?=validation_errors(); ?>
	        </div>
        <?php } ?>
        <?php if ($success){	?>
         <div class="alert alert-success">
                    <strong><?=lang('common_success'); ?></strong> 
                    <?=$success; ?>
                </div>
        <?php }	?>        
	    
    	<h1>Bienvenido a</h1>
        <div id="loginbox">
        	
            <?=form_open('acceso/index', array('class' => 'form login-form', 'id'=>'loginform', 'autocomplete'=> 'off')) ?>
            	<div id="logo"><?=img('img/logo_ts.png'); ?></div>	
            	<p>Para ingresar al Punto de Venta seleccione <b>Sucursal, Usuario y Clave</b>.</p>
            	<hr />
            	<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-home"></i></span>
                    <?=form_dropdown('location_id', array(''=>'Seleccione') + $this->Location->opt_location(), '', 'id="location_id" class="form-control"'); ?>
                </div>
				<div class="input-group">
                	<span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <?=form_input(array(
                        	'name'=>'username', 
							'id'=>'username', 
                            'value'=> $username,
                            'class'=> 'form-control',
                            'placeholder'=>'Usuario',
                            'size'=>'20')); 
                    ?>
				</div>
                <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <?=form_password(array(
                    		'name'=>'password', 
							'id' => 'password',
                            'value'=>$password,
                            'class'=>'form-control',
                            'placeholder'=>'Clave',
                            'size'=>'20')); 
                   	?>
                </div>
                <div class="form-actions">
                	<div class="pull-left">
                    	<a href="#" class="flip-link to-recover"><?=anchor('acceso/recuperar_clave', '&iquest;Olvid&oacute; su clave?'); ?></a>
                    </div>
                    <div class="pull-right">
                    	<input type="submit" class="btn btn-success" value="Login" />
                    </div>
				</div>
             <?=form_close()?>
		</div>
	</div>
	</body>
</html>