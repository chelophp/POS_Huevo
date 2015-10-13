<!DOCTYPE html>
<html>
	<head>
		<title><?=$this->config->item('company').' -- www.tradesoft.cl';?></title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<base href="<?=base_url();?>" />
		<link rel="icon" href="<?=base_url();?>favicon.ico" type="image/x-icon"/>
		<?php foreach(get_css_files() as $css_file) { ?>
			<link rel="stylesheet" rev="stylesheet" href="<?=base_url().$css_file['path']?>" media="<?=$css_file['media'];?>" />
		<?php } ?>
		<script type="text/javascript">
			var SITE_URL= "<?=site_url();?>";
		</script>
		<?php foreach(get_js_files() as $js_file) { ?>
			<script src="<?=base_url().$js_file['path'];?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
		<?php } ?>	
		
		
	<?php foreach($css_files as $file): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php endforeach; ?>
	<?php foreach($js_files as $file): ?>
		<script src="<?php echo $file; ?>"></script>
	<?php endforeach; ?>

		<script type="text/javascript">
			COMMON_SUCCESS = <?=json_encode(lang('common_success')); ?>;
			COMMON_ERROR = <?=json_encode(lang('common_error')); ?>;
			$.ajaxSetup ({
				cache: false,
				headers: { "cache-control": "no-cache" }
			});
			$(document).ready(function()
			{
				//Ajax submit current location
				$("#employee_current_location_id").change(function()
				{
					$("#form_set_employee_current_location_id").ajaxSubmit(function()
					{
						window.location.reload(true);
					});
				});
				//Keep session alive by sending a request every 5 minutes
				setInterval(function(){$.get('<?=site_url('home/keep_alive'); ?>');}, 300000);
			});
		</script>
	</head>
	<body data-color="grey" class="flat">
		<div class="modal fade hidden-print" id="myModal"></div>
		<div id="wrapper" <?=$this->uri->segment(1)=='sales' || $this->uri->segment(1)=='receivings'  ? 'class="minibar"' : ''; ?> >
		<div id="header" class="hidden-print">
			<h1><a href="<?=site_url('home'); ?>"><?=img(array('src' => base_url().'img/logo_ts.png','class'=>'hidden-print header-log','id'=>'header-logo',));?></a></h1>		
			<a id="menu-trigger" href="#"><i class="fa fa-bars fa fa-2x"></i></a>	
			
			<div class="clear"></div>
			
		</div>
		
		<div id="user-nav" class="hidden-print hidden-xs">
			<ul class="btn-group ">
				<? 
				//customers items item_kits suppliers reports receivings sales employees giftcards config locations
				$arr_modulos_header = array('sales', 'customers'); 
				?>
				<?php foreach($allowed_modules->result() as $module) { ?>
					<?php if (in_array($module->module_id, $arr_modulos_header)){?>
						<li class="btn  hidden-xs">
							<a href="<?php echo site_url("$module->module_id");?>"><i class="fa fa-<?php echo $module->icon; ?>"></i><span class="hidden-minibar"><?php echo lang("module_".$module->module_id) ?></span></a>
						</li>
					<?php }?>
				<?php }	?>			
				<?php if (count($authenticated_locations) > 1) { ?>
				<li id="location-top" class="btn location-drops">
			        <?php echo form_open('home/set_employee_current_location_id', array('id' => 'form_set_employee_current_location_id')) ?>
		    	  		<?php echo form_dropdown('employee_current_location_id', $authenticated_locations,$this->Employee->get_logged_in_employee_current_location_id(),'id="employee_current_location_id"'); ?>
		        	<?php echo form_close(); ?>
				</li>
				<?php } ?>
				<li class="btn  hidden-xs">
					<a title="" href="<?=site_url('acceso/cambiar_usuario')?>" data-toggle="modal" data-target="#myModal" ><i class="icon fa fa-user fa-2x"></i> <span class="text"><b><?=$user_info->first_name." ".$user_info->last_name;?></b></span></a>
				</li>
				<?php if ($this->Employee->has_module_permission('config', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
					<li class="btn "><?php echo anchor("config",'<i class="icon fa fa-cog"></i><span class="text">'.lang("common_settings").'</span>'); ?></li>
				<?php } ?>
        		<li class="btn  ">
					<?php
					if ($this->config->item('track_cash') && $this->Sale->is_register_log_open()){
						echo anchor("sales/closeregister?continue=logout",'<i class="fa fa-power-off"></i><span class="text">'.lang("common_logout").'</span>');
					} else {
						echo anchor("home/logout",'<i class="fa fa-power-off"></i><span class="text">'.lang("common_logout").'</span>');
					}
					?>
				</li>
			</ul>
		</div>
		<?php 
		$sidebar_class = "";
		$sales_content_class = "";
		if ($this->router->fetch_class() == "sales" || $this->router->fetch_class() == "receivings") {
			$sidebar_class = "sales_minibar";
			$sales_content_class = "sales_content_minibar";
		}?>
		<?php 
			$arr_modulos_panel = array('items', 'item_kits', 'suppliers', 'reports', 'receivings', 'employees', 'giftcards', 'config', 'locations');
		?>
		<div id="sidebar" class="hidden-print minibar <?php echo $sidebar_class?>">
			<ul>
				<li <?php echo $this->uri->segment(1)=='home'  ? 'class="active"' : ''; ?>><a href="<?php echo site_url('home'); ?>"><i class="icon fa fa-dashboard"></i><span class="hidden-minibar"><?php echo lang('common_dashboard'); ?></span></a></li>
				<?php foreach($allowed_modules->result() as $module) { ?>
					<?php if (in_array($module->module_id, $arr_modulos_panel)){?>
						<li <?php echo $module->module_id==$this->uri->segment(1)  ? 'class="active"' : ''; ?>><a href="<?php echo site_url("$module->module_id");?>"><i class="fa fa-<?php echo $module->icon; ?>"></i><span class="hidden-minibar"><?php echo lang("module_".$module->module_id) ?></span></a></li>
					<?php } ?>
				<?php } ?>
				
				<li <?=($this->uri->segment(2) == 'giros') ? 'class="active"' : ''; ?>><a href="<?=site_url('admin_mod/giros');?>"><i class="fa fa-table"></i><span class="hidden-minibar"><?=$this->arr_nombre_modulos_nuevos['giros']?></span></a></li>
				<li <?=($this->uri->segment(2) == 'tipo_producto') ? 'class="active"' : ''; ?>><a href="<?=site_url('admin_mod/tipo_producto');?>"><i class="fa fa-table"></i><span class="hidden-minibar"><?=$this->arr_nombre_modulos_nuevos['tipo_producto']?></span></a></li>
				<li <?=($this->uri->segment(2) == 'descuento_tipo') ? 'class="active"' : ''; ?>><a href="<?=site_url('admin_mod/descuento_tipo');?>"><i class="fa fa-table"></i><span class="hidden-minibar"><?=$this->arr_nombre_modulos_nuevos['descuento_tipo']?></span></a></li>
				<li <?=($this->uri->segment(2) == 'lista_precio') ? 'class="active"' : ''; ?>><a href="<?=site_url('admin_mod/lista_precio');?>"><i class="fa fa-table"></i><span class="hidden-minibar"><?=$this->arr_nombre_modulos_nuevos['lista_precio']?></span></a></li>
				<li <?=($this->uri->segment(2) == 'correlativos') ? 'class="active"' : ''; ?>><a href="<?=site_url('admin_mod/correlativos');?>"><i class="fa fa-table"></i><span class="hidden-minibar"><?=$this->arr_nombre_modulos_nuevos['correlativos']?></span></a></li>
				<li <?=($this->uri->segment(2) == 'bancos') ? 'class="active"' : ''; ?>><a href="<?=site_url('admin_mod/bancos');?>"><i class="fa fa-table"></i><span class="hidden-minibar"><?=$this->arr_nombre_modulos_nuevos['bancos']?></span></a></li>
				
				<?php /*
				<li <?=($this->uri->segment(1) == 'admin_tipo_producto') ? 'class="active"' : ''; ?>><a href="<?=site_url('admin_tipo_producto/index');?>"><i class="fa fa-table"></i><span class="hidden-minibar">Tipo Productos</span></a></li>
				<li <?=($this->uri->segment(1) == 'admin_lista_precio') ? 'class="active"' : ''; ?>><a href="<?=site_url('admin_lista_precio/index');?>"><i class="fa fa-table"></i><span class="hidden-minibar">Lista Precio</span></a></li>
				*/?>
				<?php	if ($this->config->item('track_cash') && $this->Sale->is_register_log_open()) {	?> 
                <li><?=anchor("sales/closeregister?continue=logout",'<i class="fa fa-power-off"></i><span class="hidden-minibar">'.lang("common_logout").'</span>');?></li>
                <?php 	}	?>
			</ul>
		</div>
        <div id="content"  class="clearfix <?php echo $sales_content_class?>" >
        <?php /*<pre></pre>*/?>
	