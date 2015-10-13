<?php
class Giro extends CI_Model
{
	
	function opt_giros()
	{
		$giro = $this->db->dbprefix('giro');
		$sql="
			SELECT
		
						$giro.*
		
	       	FROM    	$giro
	   		WHERE		1
			ORDER BY	$giro.codigo_actividad ASC";
		$result = $this->db->query($sql);
		$data_result = $result->result_array();
		$data = array();
		foreach ($data_result as $row){
			$data[$row['id_giro']] = $row['codigo_actividad'].' - '.$row['nombre_giro'];
		}
		return $data;
	}
	
}
?>