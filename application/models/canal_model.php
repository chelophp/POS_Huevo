<?
class Canal_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function insert_canal($data_form)
    {
        $this->db->insert('tbl_canal', $data_form);
        return $this->db->insert_id();
    }

    function update_canal($id_canal, $data_form)
    {
        $this->db->update('tbl_canal', $data_form, array('id_canal' => $id_canal));
        return $this->db->affected_rows();
    }

    function canal_por_id($id_canal)
    {
        $sql="
            SELECT
                    tbl_canal.id_canal,
        			tbl_canal.id_cliente,
                    tbl_canal.nombre_canal,
                    tbl_canal.st_canal,
	        		tbl_cliente.id_cliente,
                	IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos,' ',tbl_cliente.rut_doc), CONCAT(tbl_cliente.razon_social,' ',tbl_cliente.rut_doc)) AS cliente_nom
            FROM    tbl_canal, tbl_cliente
            WHERE   tbl_canal.id_canal = ".$this->db->escape($id_canal)."
            AND		tbl_canal.id_cliente = tbl_cliente.id_cliente";
        $result = $this->db->query($sql);
        return $result->row_array();
    }

    function check_canal_por_nombre($canal, $id_canal = 0)
    {
        $sql="
            SELECT
                    tbl_canal.id_canal,
                    tbl_canal.nombre_canal
                    
            FROM    tbl_canal
            WHERE   tbl_canal.nombre_canal = ".$this->db->escape($canal);
        if ($id_canal > 0){
            $sql=$sql."
                AND     tbl_canal.id_canal <> ".$this->db->escape($id_canal);
        }

        $result = $this->db->query($sql);
        return $result->row_array();
    }

    function list_canal_all($data_search)
    {
        $sql='
            SELECT
                        COUNT(1) AS total
            FROM        tbl_canal, tbl_cliente
            WHERE       tbl_canal.id_cliente = tbl_cliente.id_cliente';
        if ($data_search['id_cliente'] != ''){
        	$sql=$sql."
                AND tbl_cliente.id_cliente = ".$this->db->escape($data_search['id_cliente']);
        	 
        }
        if ($data_search['st_canal'] != ''){
            $sql=$sql."
                AND     tbl_canal.st_canal = ".$this->db->escape($data_search['st_canal']);
        }
        $sql=$sql.'
            ORDER BY    tbl_cliente.id_cliente ASC, tbl_canal.id_canal ASC';
        $result = $this->db->query($sql);
        $row = $result->row_array();
        return $row['total'];
    }

    // get persons with paging

    function list_canal($data_search, $limit = 10, $offset = 0)
    {
        $sql="
            SELECT
                        tbl_canal.*,
        				tbl_cliente.id_cliente,
    	            	IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos,' ',tbl_cliente.rut_doc), CONCAT(tbl_cliente.razon_social,' ',tbl_cliente.rut_doc)) AS cliente_nom
            FROM        tbl_canal, tbl_cliente
            WHERE       tbl_canal.id_cliente = tbl_cliente.id_cliente";
        if ($data_search['id_cliente'] != ''){
        	$sql=$sql."
                AND tbl_cliente.id_cliente = ".$this->db->escape($data_search['id_cliente']);
        	 
        }
        if ($data_search['st_canal'] != ''){
            $sql=$sql."
                AND     tbl_canal.st_canal =  ".$this->db->escape($data_search['st_canal']);
        }
        $sql=$sql.'
            ORDER BY    id_canal ASC
            LIMIT ' . $offset . ', ' . $limit;
        $result = $this->db->query($sql);
        return $result->result_array();
    }
      
    
    function opt_canal($id_cliente = 0)
    {
        $sql="
            SELECT
                        tbl_canal.id_canal,
                        tbl_canal.nombre_canal
            FROM        tbl_canal
            WHERE       tbl_canal.id_cliente = ".$this->db->escape($id_cliente)."
            ORDER BY    id_canal ASC";
          
        $result = $this->db->query($sql);
        $data_result = $result->result_array();
        $data[''] = 'Seleccione';
        foreach ($data_result as $row){
            $data[$row['id_canal']] = $row['nombre_canal'];
        }
        return $data;
    }

    function opt_canal_all($id_cliente = 0)
    {
        $sql="
            SELECT
                        tbl_canal.id_canal,
                        tbl_canal.nombre_canal
            FROM        tbl_canal
            WHERE       tbl_canal.id_cliente = ".$this->db->escape($id_cliente)."
            ORDER BY    id_canal ASC";

        $result = $this->db->query($sql);
        $data_result = $result->result_array();
        $data[''] = 'Todas';
        foreach ((array)$data_result as $row){
            $data[$row['id_canal']] = $row['nombre_canal'];
        }
        return $data;
    }
    
    
    
    function opt_canal_por_cliente($id_cliente = ''){
    	$data_canal =  array();
    	$sql="
            SELECT
                        tbl_canal.id_canal,
                        tbl_canal.nombre_canal
            FROM        tbl_canal
            WHERE       tbl_canal.id_cliente = ".$this->db->escape($id_cliente)."
            ORDER BY    tbl_canal.nombre_canal ASC";
    
    	$result = $this->db->query($sql);
    	$data_result = $result->result_array();
    	$data[''] = 'Seleccione';
    	foreach ((array)$data_result as $row){
    		$data[$row['id_canal']] = $row['nombre_canal'];
    	}
    	return $data;
    }
    
    function opt_canal_por_cliente_all($id_cliente = ''){
    	$data_canal =  array();
    	$sql="
            SELECT
                        tbl_canal.id_canal,
                        tbl_canal.nombre_canal
            FROM        tbl_canal
            WHERE       tbl_canal.id_cliente = ".$this->db->escape($id_cliente)."
            ORDER BY    tbl_canal.nombre_canal ASC";
    	$result = $this->db->query($sql);
    	$data_result = $result->result_array();
    	$data[''] = 'Todos';
    	foreach ((array)$data_result as $row){
    		$data[$row['id_canal']] = $row['nombre_canal'];
    	}
    	return $data;
    }
	
}
?>