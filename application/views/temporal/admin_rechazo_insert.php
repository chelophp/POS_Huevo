<?=form_open($url_accion, 'name="Formulario"')?>
<section>
	<div class="top-pop">
  		<div class="left"><h2>Rechazos&nbsp;&raquo;&nbsp;Nuevo</h2></div>
  		<div class="right">
  		</div>
 	</div>
	<!--- Comentario -->
	<!--- Comentario -->
	<div class="main-content-pop strict-pop">
  		<fieldset>
  			 <table class="tabla-form">
  			 			 		<tr>
     				<th>Cliente</th>
                    <td><?=form_dropdown('data_form[id_cliente]', $opt_cliente, $data_form['id_cliente'])?></td>
                </tr>
    			<tr>
     				<th>Nombre</th>
                    <td><?=form_input('data_form[nombre_rechazo]', $data_form['nombre_rechazo'], 'size="40"')?></td>
                </tr>
                <tr>
                	<th>Tipo</th>
                	<td><?=form_dropdown('data_form[tipo_rechazo]', $opt_tipo_rechazo, $data_form['tipo_rechazo'])?></td>
            	</tr>
            </table>
		</fieldset>
		<div class="formulario-botones">
   			<?=form_submit('guardar','Guardar', 'class="boton-azul"')?>&nbsp;<?=form_checkbox('insertar_otro','on', ($insertar_otro == 'on' ? TRUE : FALSE))?>&nbsp;INSERTAR OTRO
  		</div>
	</div>
</section>
<?=form_close()?>