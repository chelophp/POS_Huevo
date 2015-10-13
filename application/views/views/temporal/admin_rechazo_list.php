<?php $this->load->view("partial/header"); ?>        
<section>
	<?=form_open($url_accion, 'id="form_1"')?>
	<div class="top">
		<h2>Rechazos</h2>
  		<div class='search'>
            <table>
                <tr>
                	<th>Cliente</th>
                    <td><?=form_dropdown('data_search[id_cliente]', $opt_cliente, $data_search['id_cliente'])?></td>
                	<th>Tipo</th>
                	<td><?=form_dropdown('data_search[tipo_rechazo]', $opt_tipo_rechazo, $data_search['tipo_rechazo'])?></td>
                    <th>Estado</th>
                    <td><?=form_dropdown('data_search[st_rechazo]', $opt_st_rechazo, $data_search['st_rechazo'])?></td>
                    <td><?=form_submit('buscar','Buscar', 'class="boton-azul"')?></td>
                </tr>
            </table>
        </div>
 	</div>
 	<div class="main-content">
		<div class="acciones"><a href="javascript:void(0)" title="Nuevo" onclick="colorbox('<?=$url_nuevo;?>',900,600)" class="add">Nuevo</a>&nbsp;<?=$url_csv;?></div>
         <table class="tabla">
                <thead>
                    <tr>
                        <?php foreach((array)$arr_data[0] as $id => $nom): ?>
                            <th class="celda"><?=$nom;?></th>
                        <?php endforeach;?>
                        <?php unset($arr_data[0]); ?>
                    </tr>
                </thead>
                <tbody id="html_table_body">
                    <?php foreach((array)$arr_data as $id => $values): ?>
                        <tr class="fila" id="<?=$id?>">
                             <?php foreach((array)$values as $id2 => $nom): ?>
                                <td><font color="<?=$arr_color[$id]?>"><?=$nom;?></font></td>
                            <?php endforeach; ?>
	                     </tr>
                    <?php endforeach;?>
                </tbody>
       	</table>
       	<div class="pagination">
			<div class="right">
        		<input type="text" name="limit" value="<?= $limit; ?>" size="4" maxlength="4"><?= $pagination; ?>
      		</div>
    	</div>
	</div>
	<?=form_close()?>
</section>
<?php $this->load->view("partial/footer"); ?>