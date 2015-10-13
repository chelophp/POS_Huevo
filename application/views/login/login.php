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
				<?=lang('login_unsupported_browser');?>
			</div>
		</div>
	<?php
	 die();
	} ?>
    <div id="container">
    	<h1>Bienvenido a</h1>
        <div id="loginbox">
            <?php echo form_open('login', array('class' => 'form login-form', 'id'=>'loginform', 'autocomplete'=> 'off')) ?>
            	<div id="logo"><?=img('img/logo_ts.png'); ?></div>
            	<p><?php echo lang('login_welcome_message'); ?></p>
            	<hr />
            	<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-home"></i></span>
                    <?php echo form_dropdown('location_id', array(''=>'Seleccione') + $this->Location->opt_location(), '', 'id="location_id" class="form-control"'); ?>
                </div>
				<div class="input-group">
                	<span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <?php echo form_input(array(
                        	'name'=>'username', 
							'id'=>'username', 
                            'value'=> $username,
                            'class'=> 'form-control',
                            'placeholder'=> lang('login_username'),
                            'size'=>'20')); 
                    ?>
				</div>
                <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <?php echo form_password(array(
                    		'name'=>'password', 
							'id' => 'password',
                            'value'=>$password,
                            'class'=>'form-control',
                            'placeholder'=> lang('login_password'),
                            'size'=>'20')); 
                   	?>
                </div>
                <div class="form-actions">
                	<div class="pull-left">
                    	<a href="#" class="flip-link to-recover"><?php echo anchor('login/reset_password', lang('login_reset_password').'?'); ?></a><br />
                    </div>
                    <div class="pull-right">
                    	<input type="submit" class="btn btn-success" value="<?php echo lang('login_login'); ?>" />
                    </div>
				</div>
             <?=form_close()?>
		</div>
        <?php if (validation_errors() || $ie_browser_warning) {?>
            <div class="alert alert-danger">
    	        <strong><?php echo lang('common_error'); ?></strong>
                <?php echo validation_errors(); ?>
	        </div>
        <?php } ?>
	    </div>
	</body>
</html>