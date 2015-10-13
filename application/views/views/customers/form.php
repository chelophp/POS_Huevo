<?php $this->load->view("partial/header"); ?>
<script languaje="javascript">
$(document).ready(function(){
        $("#id_region").change(function(){
            valor_select = $(this).val(); //valor del item seleccionado
            if (valor_select == ''){
                $("#id_ciudad").html('<option value="" selected="selected">Seleccione</option>')
            }else{
                $("#id_ciudad").html('<option selected="selected" value="">Cargando...</option>')
                // Llamado a la pagina php para llenar el combo
                $.post("<?=$url_combo_ciudad?>",{
                    id_region:$(this).val()//Valor seleccionado y pasado por post
                },function(data){
                    $("#id_ciudad").html(data);//Toma el resultado devuelto y lo carga en el combo indicado por el #
                })
           }
        })
})
</script>
<div id="content-header" class="hidden-print">
	<h1 > <i class="fa fa-pencil"></i>  <?php  if(!$person_info->person_id) { echo lang($controller_name.'_new'); } else { echo lang($controller_name.'_update'); }    ?>	</h1>
</div>

<div id="breadcrumb" class="hidden-print">
	<?php echo create_breadcrumb(); ?>
</div>
<div class="clear"></div>
<div class="row" id="form">
	<div class="col-md-12">
		<?php echo lang('common_fields_required_message'); ?>
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5><?php echo lang("customers_basic_information"); ?></h5>
			</div>
			<div class="widget-content ">
				<?php echo form_open_multipart('customers/save/'.$person_info->person_id,array('id'=>'customer_form','class'=>'form-horizontal')); 	?>

				
<div class="row">
	<div class="col-md-12">
	
		<div class="form-group">
			<?php echo form_label('Tipo de Cliente:', 'tipo_persona',array('class'=>' col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
			<div class="col-sm-9 col-md-9 col-lg-10">
				<?php echo form_dropdown('tipo_persona', $tipo_persona, $person_info->tipo_persona, 'class="form-control form-inps" id="tipo_persona"');?>
			</div>
		</div> 
		<div class="form-group">
			<?php echo form_label('Rut/Otro:', 'rut',array('class'=>' col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
			<div class="col-sm-9 col-md-9 col-lg-10">
				<?php echo form_input('rut', $person_info->rut, 'class="form-control form-inps" id="rut"');?>
			</div>
		</div>
		<div class="form-group">
			<?php 
			$required = ($controller_name == "suppliers") ? "" : "required";
			echo form_label('Nombre/Raz&oacute;n Social:', 'first_name',array('class'=>$required.' col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
			<div class="col-sm-9 col-md-9 col-lg-10">
				<?php echo form_input(array(
					'class'=>'form-control',
					'name'=>'first_name',
					'id'=>'first_name',
					'class'=>'form-inps',
					'value'=>$person_info->first_name)
				);?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label(lang('common_last_name').':', 'last_name',array('class'=>' col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
			<div class="col-sm-9 col-md-9 col-lg-10">
			<?php echo form_input(array(
				'class'=>'form-control',
				'name'=>'last_name',
				'id'=>'last_name',
				'class'=>'form-inps',
				'value'=>$person_info->last_name)
			);?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Giro:', 'id_giro',array('class'=>' col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
			<div class="col-sm-9 col-md-9 col-lg-10">
				<?php echo form_dropdown('id_giro',$opt_giro, $person_info->id_giro, 'class="form-control form-inps" id="id_giro"');?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Lista de precio:', 'id_lista_precio',array('class'=>' col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
			<div class="col-sm-9 col-md-9 col-lg-10">
				<?php echo form_dropdown('id_lista_precio', $opt_lista_precio, $person_info->id_lista_precio, 'class="form-control form-inps" id="id_lista_precio"');?>
			</div>
		</div>

					<div class="form-group">
			<?php echo form_label(lang('common_email').':', 'email',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label '.($controller_name == 'employees' ? 'required' : 'not_required'))); ?>
			<div class="col-sm-9 col-md-9 col-lg-10">
			<?php echo form_input(array(
				'class'=>'form-control',
				'name'=>'email',
				'id'=>'email',
				'class'=>'form-inps',
				'value'=>$person_info->email)
				);?>
			</div>
		</div>
					<div class="form-group">	
		<?php echo form_label(lang('common_phone_number').':', 'phone_number',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
			<div class="col-sm-9 col-md-9 col-lg-10">
			<?php echo form_input(array(
				'class'=>'form-control',
				'name'=>'phone_number',
				'id'=>'phone_number',
				'class'=>'form-inps',
				'value'=>$person_info->phone_number));?>
			</div>
		</div>
		
		
		<div class="form-group">	
<?php echo form_label(lang('common_address_1').':', 'address_1',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
	<div class="col-sm-9 col-md-9 col-lg-10">
	<?php echo form_input(array(
		'class'=>'form-control form-inps',
		'name'=>'address_1',
		'id'=>'address_1',
		'value'=>$person_info->address_1));?>
	</div>
</div>


<div class="form-group">	
<?php echo form_label('Regi&oacute;n:', 'id_region',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
	<div class="col-sm-9 col-md-9 col-lg-10">
	<?php echo form_dropdown('id_region', $opt_region, $person_info->id_region, 'class="form-control form-inps" id="id_region"');?>
	</div>
</div>

			<div class="form-group">	
<?php echo form_label('Ciudad:', 'id_ciudad',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
	<div class="col-sm-9 col-md-9 col-lg-10">
	<?php echo form_dropdown('id_ciudad', $opt_ciudad, $person_info->id_ciudad, 'class="form-control form-inps" id="id_ciudad"');?>
	</div>
</div>



	<div class="form-group">	
<?php echo form_label(lang('common_comments').':', 'comments',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
	<div class="col-sm-9 col-md-9 col-lg-10">
	<?php echo form_textarea(array(
		'name'=>'comments',
		'id'=>'comments',
		'value'=>$person_info->comments,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
	</div>
</div>

						<div class="form-group">	
							<?php echo form_label(lang('customers_taxable').':', 'taxable',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_checkbox('taxable', '1', $person_info->taxable == '' ? TRUE : (boolean)$person_info->taxable,'id="noreset"');?>
							</div>
						</div>
	</div>
	
</div>
				
				
				
				
				
				<?php					
				if($this->config->item('customers_store_accounts') && $this->Employee->has_module_action_permission('customers', 'edit_store_account_balance', $this->Employee->get_logged_in_employee_info()->person_id)) 
				{
				?>
				<div class="form-group">	
					<?php echo form_label(lang('customers_store_account_balance').':', 'balance',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'balance',
							'id'=>'balance',
							'class'=>'balance',
							'value'=>$person_info->balance ? to_currency_no_money($person_info->balance) : '0.00')
							);?>
						</div>
					</div>
				<?php
				}
				?>
				<div class="form-group">	
							<?php if (!empty($tiers)) { ?>
						<div class="form-group">	
							<?php echo form_label(lang('customers_tier_type').':', 'tier_type',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_dropdown('tier_id', $tiers, $person_info->tier_id);?>
							</div>
						</div>
						<?php } ?>

						<?php if($person_info->cc_token && $person_info->cc_preview) { ?>
						<div class="control-group">	
							<?php echo form_label(lang('customers_delete_cc_info').':', 'delete_cc_info',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_checkbox('delete_cc_info', '1');?>
							</div>
						</div>
						<?php } ?>

						<?php echo form_hidden('redirect_code', $redirect_code); ?>

						<div class="form-actions">
							<?php
							if ($redirect_code == 1)
							{
								echo form_button(array(
							    'name' => 'cancel',
							    'id' => 'cancel',
								 'class' => 'btn btn-danger',
							    'value' => 'true',
							    'content' => lang('common_cancel')
								));
							
							}
							?>
							
							<?php
							echo form_submit(array(
								'name'=>'submitf',
								'id'=>'submitf',
								'value'=>lang('common_submit'),
								'class'=>' btn btn-primary')
							);
							?>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>

	<script type='text/javascript'>
					$('#image_id').imagePreview({ selector : '#avatar' }); // Custom preview container
						//validation and submit handling
						$(document).ready(function()
						{
							$("#cancel").click(cancelCustomerAddingFromSale);
							setTimeout(function(){$(":input:visible:first","#customer_form").focus();},100);
							var submitting = false;
							$('#customer_form').validate({
								submitHandler:function(form)
								{
									$.post('<?php echo site_url("customers/check_duplicate");?>', {term: $('#first_name').val()+' '+$('#last_name').val()},function(data) {
										<?php if(!$person_info->person_id) { ?>
											if(data.duplicate)
											{

												if(confirm(<?php echo json_encode(lang('customers_duplicate_exists'));?>))
												{
													doCustomerSubmit(form);
												}
												else 
												{
													return false;
												}
											}
											<?php } else ?>
											{
												doCustomerSubmit(form);
											}} , "json")
									.error(function() { 
									});
									
								},
								rules: 
								{
									<?php if(!$person_info->person_id) { ?>
										account_number:
										{
											remote: 
											{ 
												url: "<?php echo site_url('customers/account_number_exists');?>", 
												type: "post"

											} 
										},
										<?php } ?>
										first_name: "required",
										
										email: "email"
									},
									errorClass: "text-danger",
									errorElement: "span",
										highlight:function(element, errorClass, validClass) {
											$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
										},
										unhighlight: function(element, errorClass, validClass) {
											$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
										},
									messages: 
									{
										<?php if(!$person_info->person_id) { ?>
											account_number:
											{
												remote: <?php echo json_encode(lang('common_account_number_exists')); ?>
											},
											<?php } ?>
											first_name: <?php echo json_encode(lang('common_first_name_required')); ?>,
											last_name: <?php echo json_encode(lang('common_last_name_required')); ?>,
											email: <?php echo json_encode(lang('common_email_invalid_format')); ?>
										}
									});
});

var submitting = false;

function doCustomerSubmit(form)
{
	$("#form").mask(<?php echo json_encode(lang('common_wait')); ?>);
	if (submitting) return;
	submitting = true;

	$(form).ajaxSubmit({
		success:function(response)
		{
			$("#form").unmask();
			submitting = false;
			gritter(response.success ? <?php echo json_encode(lang('common_success')); ?> +' #' + response.person_id : <?php echo json_encode(lang('common_error')); ?> ,response.message,response.success ? 'gritter-item-success' : 'gritter-item-error',false,false);
			if(response.redirect_code==1 && response.success)
			{ 
				$.post('<?php echo site_url("sales/select_customer");?>', {customer: response.person_id}, function()
				{
					window.location.href = '<?php echo site_url('sales'); ?>'
				});
			}
			else if(response.redirect_code==2 && response.success)
			{
				window.location.href = '<?php echo site_url('customers'); ?>'
			}
		},
		<?php if(!$person_info->person_id) { ?>
			resetForm: true,
			<?php } ?>
			dataType:'json'
		});
}

function cancelCustomerAddingFromSale()
{
	if (confirm(<?php echo json_encode(lang('customers_are_you_sure_cancel')); ?>))
	{
		window.location = <?php echo json_encode(site_url('sales')); ?>;
	}
}
</script>
<?php $this->load->view("partial/footer"); ?>
