<?
class Localidad extends CI_Model {

   
    
    function opt_region()
    {
    	$region = $this->db->dbprefix('region');
        $sql="
            SELECT
                        $region.id_region,
                        $region.nombre_region
            FROM        $region
            WHERE       1
            ORDER BY    id_region ASC";
          
        $result = $this->db->query($sql);
        $data_result = $result->result_array();
        $data[''] = 'Seleccione';
        foreach ($data_result as $row){
            $data[$row['id_region']] = $row['nombre_region'];
        }
        return $data;
    }

    function opt_region_all()
    {
      	$region = $this->db->dbprefix('region');
        $sql="
            SELECT
                        $region.id_region,
                        $region.nombre_region
            FROM        $region
            WHERE       1
            ORDER BY    id_region ASC";

        $result = $this->db->query($sql);
        $data_result = $result->result_array();
        $data[''] = 'Todas';
        foreach ((array)$data_result as $row){
            $data[$row['id_region']] = $row['nombre_region'];
        }
        return $data;
    }
    
    

    function opt_ciudad_por_region($id_region = ''){
    	$ciudad = $this->db->dbprefix('ciudad');
        $data_ciudad =  array();
        $sql="
            SELECT
                        $ciudad.id_ciudad,
                        $ciudad.nombre_ciudad
            FROM        $ciudad
            WHERE       $ciudad.id_region = ".$this->db->escape($id_region)."
            ORDER BY    $ciudad.nombre_ciudad ASC";

        $result = $this->db->query($sql);
        $data_result = $result->result_array();
        $data[''] = 'Seleccione';
        foreach ((array)$data_result as $row){
            $data[$row['id_ciudad']] = $row['nombre_ciudad'];
        }
        return $data;
    }

    function opt_ciudad_por_region_all($id_region = ''){
    	$ciudad = $this->db->dbprefix('ciudad');
        $data_ciudad =  array();
        $sql="
            SELECT
                        $ciudad.id_ciudad,
                        $ciudad.nombre_ciudad
            FROM        $ciudad
            WHERE       $ciudad.id_region = ".$this->db->escape($id_region)."
            ORDER BY    $ciudad.nombre_ciudad ASC";
        $result = $this->db->query($sql);
        $data_result = $result->result_array();
        $data[''] = 'Todas';
        foreach ((array)$data_result as $row){
            $data[$row['id_ciudad']] = $row['nombre_ciudad'];
        }
        return $data;
    }
    
	
	
}
?>