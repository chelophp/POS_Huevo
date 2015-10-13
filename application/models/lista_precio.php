<?php
class Lista_precio extends CI_Model
{
	
	function opt_lista_precio()
	{
		$lista_precio = $this->db->dbprefix('lista_precio');
		$sql="
			SELECT
		
						$lista_precio.*
		
	       	FROM    	$lista_precio
	   		WHERE		1
			ORDER BY	$lista_precio.nombre_lista ASC";
		$result = $this->db->query($sql);
		$data_result = $result->result_array();
		$data = array();
		foreach ($data_result as $row){
			$data[$row['id_lista_precio']] = $row['nombre_lista'];
		}
		return $data;
	}

	
	/*
	 Gets information about a particular price list
	*/
	function get_info($id_lista_precio)
	{
		$this->db->from('lista_precio');
		$this->db->where('id_lista_precio',$id_lista_precio);
	
		$query = $this->db->get();
	
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $location_id is NOT a location
			$location_obj=new stdClass();
	
			//Get all the fields from locations table
			$fields = $this->db->list_fields('lista_precio');
	
			foreach ($fields as $field)
			{
				$location_obj->$field='';
			}
	
			return $location_obj;
		}
	}
}
?>