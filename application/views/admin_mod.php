<?php $this->load->view("partial/header");?>
<div id="content-header" class="hidden-print">
	<h1><i class="icon fa fa-table"></i> <?=$this->arr_nombre_modulos_nuevos[$this->uri->segment(2)]?></h1>
</div>
<div id="breadcrumb" class="hidden-print">
	<?php echo create_breadcrumb(); ?><a class="current" href="<?=site_url('admin_mod/'.$this->uri->segment(2));?>"><?=$this->arr_nombre_modulos_nuevos[$this->uri->segment(2)]?></a>
</div>
<div class="clear"></div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="widget-box">
			<!-- ini crud -->
				<?php echo $output; ?>
			<!-- fin crud -->
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("partial/footer");?>