<?=form_open($url_accion, 'name="Formulario"')?>
<section>
	<div class="top-pop">
  		<div class="left"><h2>Rechazos&nbsp;&raquo;&nbsp;Ficha</h2></div>
  		<div class="right">
  		</div>
 	</div>
	<!--- Comentario -->
	<!--- Comentario -->
	<div class="">
  		<fieldset>
  			<table class="tabla-form">
    			<tr>
     				<th>Id</th>
                <td><?=$data_form['id_rechazo']?></td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td><?=$data_form['cliente_nom']?></td>
            </tr
            <tr>
                <th>Nombre</th>
                <td><?=$data_form['nombre_rechazo']?></td>
            </tr>
            <tr>
                <th>Tipo</th>
                <td><?=$data_form['tipo_rechazo']?></td>
            </tr>
            <tr>
                <th>Estado</th>
                <td><?=$data_form['st_rechazo']?></td>
                  
    			</tr>
            </table>
		</fieldset>
		<div class="formulario-botones">
   			    <?php if ($pdf == false):?>
        			<div class="acciones"><?=$url_pdf;?></div>
   				 <?php endif; ?>
  		</div>
	</div>
</section>
<?=form_close()?>