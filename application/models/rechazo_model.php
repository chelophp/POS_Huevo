<?
class Rechazo_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function insert_rechazo($data_form)
    {
        $this->db->insert('tbl_rechazo', $data_form);
        return $this->db->insert_id();
    }

    function update_rechazo($id_rechazo, $data_form)
    {
        $this->db->update('tbl_rechazo', $data_form, array('id_rechazo' => $id_rechazo));
        return $this->db->affected_rows();
    }

    function rechazo_por_id($id_rechazo)
    {
        $sql="
            SELECT
                    tbl_rechazo.id_rechazo,
                    tbl_rechazo.nombre_rechazo,
					tbl_rechazo.tipo_rechazo,        		          
                    tbl_rechazo.st_rechazo,
	        		tbl_cliente.id_cliente,
                	IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos,' ',tbl_cliente.rut_doc), CONCAT(tbl_cliente.razon_social,' ',tbl_cliente.rut_doc)) AS cliente_nom
        		
            FROM    tbl_rechazo, tbl_cliente
            WHERE   tbl_rechazo.id_rechazo = ".$this->db->escape($id_rechazo)."
           	AND		tbl_rechazo.id_cliente = tbl_cliente.id_cliente";
        $result = $this->db->query($sql);
        return $result->row_array();
    }

    function check_rechazo_por_nombre($rechazo, $id_rechazo = 0)
    {
        $sql="
            SELECT
                    tbl_rechazo.id_rechazo,
                    tbl_rechazo.nombre_rechazo
                    
            FROM    tbl_rechazo
            WHERE   tbl_rechazo.nombre_rechazo = ".$this->db->escape($rechazo);
        if ($id_rechazo > 0){
            $sql=$sql."
                AND     tbl_rechazo.id_rechazo <> ".$this->db->escape($id_rechazo);
        }

        $result = $this->db->query($sql);
        return $result->row_array();
    }

    function list_rechazo_all($data_search)
    {
        $sql='
            SELECT
                        COUNT(1) AS total
            FROM        tbl_rechazo, tbl_cliente
            WHERE       tbl_rechazo.id_cliente = tbl_cliente.id_cliente';
        if ($data_search['id_cliente'] != ''){
        	$sql=$sql."
                AND     tbl_rechazo.id_cliente = ".$this->db->escape($data_search['id_cliente']);
        }
        if ($data_search['st_rechazo'] != ''){
            $sql=$sql."
                AND     tbl_rechazo.st_rechazo = ".$this->db->escape($data_search['st_rechazo']);
        }
        if ($data_search['tipo_rechazo'] != ''){
        	$sql=$sql."
                AND     tbl_rechazo.tipo_rechazo = ".$this->db->escape($data_search['tipo_rechazo']);
        }
        $sql=$sql.'
            ORDER BY    id_rechazo ASC';
        $result = $this->db->query($sql);
        $row = $result->row_array();
        return $row['total'];
    }

    // get persons with paging

    function list_rechazo($data_search, $limit = 10, $offset = 0)
    {
        $sql="
            SELECT
                        tbl_rechazo.*,
		        		tbl_cliente.id_cliente,
    	            	IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos,' ',tbl_cliente.rut_doc), CONCAT(tbl_cliente.razon_social,' ',tbl_cliente.rut_doc)) AS cliente_nom
            FROM        tbl_rechazo, tbl_cliente
            WHERE       tbl_rechazo.id_cliente = tbl_cliente.id_cliente";
        if ($data_search['id_cliente'] != ''){
        	$sql=$sql."
                AND     tbl_rechazo.id_cliente = ".$this->db->escape($data_search['id_cliente']);
        }
        if ($data_search['st_rechazo'] != ''){
            $sql=$sql."
                AND     tbl_rechazo.st_rechazo =  ".$this->db->escape($data_search['st_rechazo']);
        }
        if ($data_search['tipo_rechazo'] != ''){
        	$sql=$sql."
                AND     tbl_rechazo.tipo_rechazo = ".$this->db->escape($data_search['tipo_rechazo']);
        }
        $sql=$sql.'
            ORDER BY    id_rechazo ASC
            LIMIT ' . $offset . ', ' . $limit;
        $result = $this->db->query($sql);
        return $result->result_array();
    }
      
    
    function opt_rechazo_local()
    {
    	$sql="
            SELECT
                        tbl_rechazo.id_rechazo,
                        tbl_rechazo.nombre_rechazo
            FROM        tbl_rechazo
            WHERE       tbl_rechazo.st_rechazo = 'activo'
            ORDER BY    nombre_rechazo ASC";
    
    	$result = $this->db->query($sql);
    	$data_result = $result->result_array();
    	$data[0] = '-';
    	foreach ($data_result as $row){
    		$data[$row['id_rechazo']] = utf8_encode(utf8_decode($row['nombre_rechazo']));
    	}
    	return $data;
    }
    
    function opt_rechazo_equip()
    {
    	$sql="
            SELECT
                        tbl_rechazo.id_rechazo,
                        tbl_rechazo.nombre_rechazo
            FROM        tbl_rechazo
            WHERE       tbl_rechazo.st_rechazo = 'activo'
            ORDER BY    nombre_rechazo ASC";
    	//tbl_rechazo.tipo_rechazo = 'equipamiento'
    	$result = $this->db->query($sql);
    	$data_result = $result->result_array();
    	$data[0] = '-';
    	foreach ($data_result as $row){
    		$data[$row['id_rechazo']] = utf8_encode(utf8_decode($row['nombre_rechazo']));
    	}
    	return $data;
    }
    
    function opt_rechazo()
    {
        $sql='
            SELECT
                        tbl_rechazo.id_rechazo,
                        tbl_rechazo.nombre_rechazo
            FROM        tbl_rechazo
            WHERE       1
            ORDER BY    nombre_rechazo ASC';
          
        $result = $this->db->query($sql);
        $data_result = $result->result_array();
        $data[0] = '-';
        foreach ($data_result as $row){
            $data[$row['id_rechazo']] = utf8_encode(utf8_decode($row['nombre_rechazo']));
        }
        return $data;
    }

    function opt_rechazo_all()
    {
        $sql='
            SELECT
                        tbl_rechazo.id_rechazo,
                        tbl_rechazo.nombre_rechazo
            FROM        tbl_rechazo
            WHERE       1
            ORDER BY    nombre_rechazo ASC';

        $result = $this->db->query($sql);
        $data_result = $result->result_array();
        $data['0'] = 'Todos';
        foreach ((array)$data_result as $row){
            $data[$row['id_rechazo']] = $row['nombre_rechazo'];
        }
        return $data;
    }
    
    
    
	
	
}
?>