<?
class Cliente_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
        
    function insert_cliente($data_form)
    {
    	$data_form['fecha'] = date('Y-m-d');
    	if ($data_form['tipo_cliente'] == 'natural'){
    		$data_form['razon_social'] = '';
    		$data_form['giro'] = '';
    	}
    	if ($data_form['tipo_cliente'] == 'juridico'){
    		$data_form['nombre'] = '';
    		$data_form['apellidos']  = '';
    	}
    	unset($data_form['id_region']);
    	$this->db->insert('tbl_cliente', $data_form);
    	return $this->db->insert_id();
    }
    
  
    
    function update_cliente($id_cliente, $data_form)
    {
    	if ($data_form['tipo_cliente'] == 'particular'){
    		$data_form['razon_social'] = '';
    		$data_form['giro'] = '';
    	}
    	if ($data_form['tipo_cliente'] == 'empresa'){
    		$data_form['nombre'] = '';
    		$data_form['apellidos']  = '';
    	}
    	unset($data_form['id_region']);
    	$this->db->update('tbl_cliente', $data_form, array('id_cliente' => $id_cliente));
    	return $this->db->affected_rows();
    }
    
   
    
  
    
    function cliente_por_id($id_cliente)
    {
    	$sql="
            SELECT
                    tbl_cliente.*,
                    IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos), tbl_cliente.razon_social) AS cliente_nom,
                    DATE_FORMAT(tbl_cliente.fecha, '%d-%m-%Y') AS fecha_format,
    				tbl_region.id_region,
    				tbl_ciudad.nombre_ciudad,
        			tbl_region.nombre_region
    
            FROM    tbl_cliente, tbl_region, tbl_ciudad
            WHERE   tbl_cliente.id_cliente = ".$this->db->escape($id_cliente)."
            AND		tbl_cliente.id_ciudad = tbl_ciudad.id_ciudad
        	AND 	tbl_ciudad.id_region = tbl_region.id_region";
    	$result = $this->db->query($sql);
    	return $result->row_array();
    }
    
    
    
    function cliente_por_rut_doc($rut_doc)
    {
    	$sql="
            SELECT
                    tbl_cliente.*,
                    IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos), tbl_cliente.razon_social) AS cliente_nom,
                    DATE_FORMAT(tbl_cliente.fecha, '%d-%m-%Y') AS fecha_format,
    				tbl_region.id_region,
    				tbl_ciudad.nombre_ciudad,
        			tbl_region.nombre_region
    
            FROM    tbl_cliente, tbl_region, tbl_ciudad
            WHERE   tbl_cliente.rut_doc = ".$this->db->escape($rut_doc)."
            AND		tbl_cliente.id_ciudad = tbl_ciudad.id_ciudad
        	AND 	tbl_ciudad.id_region = tbl_region.id_region";
    	$result = $this->db->query($sql);
    	return $result->row_array();
    }
    
    function cliente_por_mail($mail)
    {
    	$sql="
            SELECT
                    tbl_cliente.*,
                    IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos), tbl_cliente.razon_social) AS cliente_nom,
                    DATE_FORMAT(tbl_cliente.fecha, '%d-%m-%Y') AS fecha_format,
    				tbl_region.id_region,
    				tbl_ciudad.nombre_ciudad,
        			tbl_region.nombre_region
    
    	FROM    tbl_cliente, tbl_region, tbl_ciudad
    	WHERE   tbl_cliente.email = ".$this->db->escape($mail)."
            AND		tbl_cliente.id_ciudad = tbl_ciudad.id_ciudad
        	AND 	tbl_ciudad.id_region = tbl_region.id_region";
    	$result = $this->db->query($sql);
    	return $result->row_array();
    }
    
    function check_cliente_rut_doc($rut_doc, $id_cliente = 0)
    {
    	$sql="
            SELECT
                    tbl_cliente.id_cliente
            FROM    tbl_cliente
            WHERE   tbl_cliente.rut_doc = ".$this->db->escape($rut_doc);
    	if ($id_cliente > 0){
    		$sql=$sql."
                AND     tbl_cliente.id_cliente <> ".$this->db->escape($id_cliente);
    	}
    	$result = $this->db->query($sql);
    	return $result->row_array();
    }
    
    function check_cliente_email($email, $id_cliente = 0)
    {
    	$sql="
    		SELECT
    				tbl_cliente.id_cliente
    		FROM    tbl_cliente
    		WHERE   tbl_cliente.email = ".$this->db->escape($email);
    	if ($id_cliente > 0){
    		$sql=$sql."
    		AND     tbl_cliente.id_cliente <> ".$this->db->escape($id_cliente);
    	}
    	$result = $this->db->query($sql);
    	return $result->row_array();
    }
    
    
    
   
    
    function list_cliente_all($data_search)
    {
    	$sql='
            SELECT
                    COUNT(1) AS total
            FROM    tbl_cliente, tbl_ciudad, tbl_region
        	WHERE	tbl_cliente.id_ciudad = tbl_ciudad.id_ciudad
        	AND 	tbl_ciudad.id_region = tbl_region.id_region';
    	if ($data_search['nombre'] != ''){
    		$sql=$sql."
                AND (CONCAT(tbl_cliente.rut_doc, ' ', tbl_cliente.razon_social, ' ', tbl_cliente.nombre, ' ', tbl_cliente.apellidos, ' ', tbl_cliente.giro, ' ', tbl_cliente.email, ' ', tbl_cliente.direccion, ' ', tbl_region.nombre_region, ' ', tbl_ciudad.nombre_ciudad) LIKE '%".$this->db->escape_like_str($data_search['nombre'])."%'";
    	}
    	if ($data_search['tipo_cliente'] != ''){
    		$sql=$sql."
                AND tbl_cliente.tipo_cliente = ".$this->db->escape($data_search['tipo_cliente']);
    	}
    	if ($data_search['st_cliente'] != ''){
    		$sql=$sql."
                AND tbl_cliente.st_cliente = ".$this->db->escape($data_search['st_cliente']);
    	}
    	if ($data_search['id_ciudad'] != ''){
    		$sql=$sql."
                AND tbl_ciudad.id_ciudad = ".$this->db->escape($data_search['id_ciudad']);
    	}
    	if ($data_search['id_region'] != ''){
    		$sql=$sql."
                AND tbl_region.id_region = ".$this->db->escape($data_search['id_region']);
    	}
    	if ($data_search['cliente_logistica'] != ''){
    		$sql=$sql."
                AND tbl_cliente.cliente_logistica = ".$this->db->escape($data_search['cliente_logistica']);
    	}
    	if ($data_search['cliente_promociones'] != ''){
    		$sql=$sql."
                AND tbl_cliente.cliente_promociones = ".$this->db->escape($data_search['cliente_promociones']);
    	}
    	$sql=$sql.'
        	GROUP BY 	tbl_cliente.id_cliente
            ORDER BY tbl_cliente.id_cliente ASC';
    	$result = $this->db->query($sql);
    	$row = $result->row_array();
    	return $row['total'];
    }
    
    // get persons with paging
    
    function list_cliente($data_search, $limit = 10, $offset = 0)
    {
    	$sql="
            SELECT
                    tbl_cliente.*,
                    IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos), tbl_cliente.razon_social) AS cliente_nom,
                    DATE_FORMAT(tbl_cliente.fecha, '%d-%m-%Y') AS fecha_format,
        			tbl_region.nombre_region, 
    				tbl_ciudad.nombre_ciudad, 
                    CONCAT(tbl_region.nombre_region, ', ', tbl_ciudad.nombre_ciudad, ', ', tbl_cliente.direccion) AS direccion_total
    
          	FROM    tbl_cliente, tbl_ciudad, tbl_region
        	WHERE	tbl_cliente.id_ciudad = tbl_ciudad.id_ciudad
        	AND 	tbl_ciudad.id_region = tbl_region.id_region";
    	if ($data_search['nombre'] != ''){
    		$sql=$sql."
                AND (CONCAT(tbl_cliente.rut_doc, ' ', tbl_cliente.razon_social, ' ', tbl_cliente.nombre, ' ', tbl_cliente.apellidos, ' ', tbl_cliente.giro, ' ', tbl_cliente.email, ' ', tbl_cliente.direccion, ' ', tbl_region.nombre_region, ' ', tbl_ciudad.nombre_ciudad) LIKE '%".$this->db->escape_like_str($data_search['nombre'])."%'";
    	}
    	if ($data_search['tipo_cliente'] != ''){
    		$sql=$sql."
                AND tbl_cliente.tipo_cliente = ".$this->db->escape($data_search['tipo_cliente']);
    	}
    	if ($data_search['st_cliente'] != ''){
    		$sql=$sql."
                AND tbl_cliente.st_cliente = ".$this->db->escape($data_search['st_cliente']);
    	}
    	if ($data_search['id_ciudad'] != ''){
    		$sql=$sql."
                AND tbl_ciudad.id_ciudad = ".$this->db->escape($data_search['id_ciudad']);
    	}
    	if ($data_search['id_region'] != ''){
    		$sql=$sql."
                AND tbl_region.id_region = ".$this->db->escape($data_search['id_region']);
    	}
    	if ($data_search['cliente_logistica'] != ''){
    		$sql=$sql."
                AND tbl_cliente.cliente_logistica = ".$this->db->escape($data_search['cliente_logistica']);
    	}
    	if ($data_search['cliente_promociones'] != ''){
    		$sql=$sql."
                AND tbl_cliente.cliente_promociones = ".$this->db->escape($data_search['cliente_promociones']);
    	}
    	$sql=$sql.'
        	GROUP BY 	tbl_cliente.id_cliente
            ORDER BY 	tbl_cliente.id_cliente ASC
            LIMIT ' . $offset . ', ' . $limit;
    	$result = $this->db->query($sql);
    	return $result->result_array();
    }
    
    
    
    
    
    function opt_cliente_all()
    {
    
    	$sql="
            SELECT
                        tbl_cliente.id_cliente,
                        IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos,' ',tbl_cliente.rut_doc), CONCAT(tbl_cliente.razon_social,' ',tbl_cliente.rut_doc)) AS cliente_nom
            FROM        tbl_cliente
            WHERE       1
            ORDER BY    cliente_nom ASC";
    
    	$result = $this->db->query($sql);
    	$data_result = $result->result_array();
    	$data[''] = 'Todos';
    	foreach ($data_result as $row){
    		$data[$row['id_cliente']] = $row['cliente_nom'];
    	}
    	return $data;
    }
    
    function opt_cliente()
    {
    
    	$sql="
            SELECT
                        tbl_cliente.id_cliente,
                        IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos,' ',tbl_cliente.rut_doc), CONCAT(tbl_cliente.razon_social,' ',tbl_cliente.rut_doc)) AS cliente_nom
            FROM        tbl_cliente
            WHERE       1
            ORDER BY    cliente_nom ASC";
    
    	$result = $this->db->query($sql);
    	$data_result = $result->result_array();
    	$data[''] = 'Seleccione';
    	foreach ($data_result as $row){
    		$data[$row['id_cliente']] = $row['cliente_nom'];
    	}
    	return $data;
    }
    
    
    
  
    function delete_cliente($id_cliente){
    	$this->db->delete('tbl_cliente', array('id_cliente' => $id_cliente));
    	return $this->db->affected_rows();
    }
    
     
    
   
    function insert_cliente_local($data_form)
    {
    	$this->db->insert('tbl_cliente_local', $data_form);
    	return $this->db->insert_id();
    }    

    
    
    
    function delete_cliente_local_all($id_cliente){
    	$this->db->delete('tbl_cliente_local', array('id_cliente' => $id_cliente));
    	return $this->db->affected_rows();
    }
    
	function delete_cliente_local($id_cliente_local){
    	$this->db->delete('tbl_cliente_local', array('id_cliente_local' => $id_cliente_local));
    	return $this->db->affected_rows();
    }
    
    function delete_usuario_cliente($id_cliente){
    	$this->db->delete('tbl_usuario_cliente', array('id_cliente' => $id_cliente));
    	return $this->db->affected_rows();
    }
    
   
    
    function update_cliente_local($id_cliente_local, $data_form)
    {
    	$this->db->update('tbl_cliente_local', $data_form, array('id_cliente_local' => $id_cliente_local));
    	return $this->db->affected_rows();
    }


   
    
    function cliente_local_por_id($id_cliente_local)
    {
    	$sql="
            SELECT
                    tbl_cliente_local.*,
    				tbl_canal.*,
        			tbl_region.*,
        			tbl_ciudad.*,
    			 	CONCAT(tbl_region.nombre_region, ', ', tbl_ciudad.nombre_ciudad, ', ', tbl_cliente_local.direccion) AS direccion_total,
	    			tbl_cliente.id_cliente,
    	            IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos,' ',tbl_cliente.rut_doc), CONCAT(tbl_cliente.razon_social,' ',tbl_cliente.rut_doc)) AS cliente_nom
    
            FROM    tbl_cliente_local, tbl_cliente, tbl_region, tbl_ciudad, tbl_canal
            WHERE   tbl_cliente_local.id_cliente = tbl_cliente.id_cliente
    		AND		tbl_cliente_local.id_cliente_local = ".$this->db->escape($id_cliente_local)."
            AND		tbl_cliente_local.id_ciudad = tbl_ciudad.id_ciudad
           	AND		tbl_ciudad.id_region = tbl_region.id_region
            AND		tbl_cliente_local.id_canal = tbl_canal.id_canal";
    	$result = $this->db->query($sql);
    	return $result->row_array();
    }
    
     
    function list_cliente_local_por_id_cliente_all($id_cliente = 0){
        $sql="
            SELECT
                    	tbl_cliente_local.*,
    					tbl_ciudad.id_region, 
	                	tbl_ciudad.nombre_ciudad,
	                	tbl_region.nombre_region,
        				tbl_canal.nombre_canal
                    
            FROM    	tbl_cliente_local, tbl_region, tbl_ciudad, tbl_canal
            WHERE		tbl_cliente_local.id_cliente = ".$this->db->escape($id_cliente)."
            AND     	tbl_cliente_local.id_ciudad = tbl_ciudad.id_ciudad
            AND     	tbl_ciudad.id_region = tbl_region.id_region
            AND			tbl_cliente_local.id_canal = tbl_canal.id_canal
            ORDER BY    id_cliente_local ASC";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    /*
    function list_cliente_all($data_search)
    {
        $sql='
            SELECT
                    COUNT(1) AS total
            FROM    tbl_cliente, tbl_region, tbl_ciudad
            WHERE	tbl_cliente.id_ciudad = tbl_ciudad.id_ciudad
            AND     tbl_ciudad.id_region = tbl_region.id_region';
     	if ($data_search['nombre'] != ''){
            $sql=$sql."
                AND CONCAT(tbl_cliente.alias, ' ', tbl_cliente.rut_doc, ' ', tbl_cliente.razon_social, ' ', tbl_cliente.nombre, ' ', tbl_cliente.apellidos, ' ', tbl_cliente.giro, ' ', tbl_cliente.direccion, ' ', tbl_cliente.fonos, ' ', tbl_cliente.fax, ' ', tbl_cliente.celular, ' ', tbl_cliente.email) LIKE '%".$this->db->escape_like_str($data_search['nombre'])."%'";
        		 
        }
        if ($data_search['tipo_cliente'] != ''){
            $sql=$sql."
                AND tbl_cliente.tipo_cliente = ".$this->db->escape($data_search['tipo_cliente']);
        }
        if ($data_search['st_cliente'] != ''){
            $sql=$sql."
                AND tbl_cliente.st_cliente = ".$this->db->escape($data_search['st_cliente']);
        }
        if ($data_search['id_ciudad'] != ''){
            $sql=$sql."
                AND tbl_ciudad.id_ciudad = ".$this->db->escape($data_search['id_ciudad']);
        }
        if ($data_search['id_region'] != ''){
            $sql=$sql."
                AND tbl_region.id_region = ".$this->db->escape($data_search['id_region']);
        }
        $sql=$sql.'
            ORDER BY tbl_cliente.id_cliente ASC';
        $result = $this->db->query($sql);
        $row = $result->row_array();
        return $row['total'];
    }

    // get persons with paging
/*
    function list_cliente($data_search, $limit = 10, $offset = 0)
    {
        $sql="
            SELECT
                    tbl_cliente.*,
                    IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos), tbl_cliente.razon_social) AS cliente_nom,
                    DATE_FORMAT(tbl_cliente.fecha, '%d-%m-%Y') AS fecha_format,
                    CONCAT(tbl_region.nombre_region, ', ', tbl_ciudad.nombre_ciudad, ', ', tbl_cliente.direccion) AS direccion_total
                
          	FROM    tbl_cliente, tbl_region, tbl_ciudad
            WHERE	tbl_cliente.id_ciudad = tbl_ciudad.id_ciudad
            AND     tbl_ciudad.id_region = tbl_region.id_region";
     	if ($data_search['nombre'] != ''){
            $sql=$sql."
                AND CONCAT(tbl_cliente.alias, ' ', tbl_cliente.rut_doc, ' ', tbl_cliente.razon_social, ' ', tbl_cliente.nombre, ' ', tbl_cliente.apellidos, ' ', tbl_cliente.giro, ' ', tbl_cliente.direccion, ' ', tbl_cliente.fonos, ' ', tbl_cliente.fax, ' ', tbl_cliente.celular, ' ', tbl_cliente.email) LIKE '%".$this->db->escape_like_str($data_search['nombre'])."%'";
        		 
        }
        if ($data_search['tipo_cliente'] != ''){
            $sql=$sql."
                AND tbl_cliente.tipo_cliente = ".$this->db->escape($data_search['tipo_cliente']);
        }
        if ($data_search['st_cliente'] != ''){
            $sql=$sql."
                AND tbl_cliente.st_cliente = ".$this->db->escape($data_search['st_cliente']);
        }
        if ($data_search['id_ciudad'] != ''){
            $sql=$sql."
                AND tbl_ciudad.id_ciudad = ".$this->db->escape($data_search['id_ciudad']);
        }
        if ($data_search['id_region'] != ''){
            $sql=$sql."
                AND tbl_region.id_region = ".$this->db->escape($data_search['id_region']);
        }
        $sql=$sql.'
            ORDER BY 	tbl_cliente.id_cliente ASC
            LIMIT ' . $offset . ', ' . $limit;
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    */
    function list_cliente_local_all($data_search)
    {
    	$sql='
            SELECT
                    COUNT(1) AS total
            FROM    tbl_cliente_local, tbl_cliente, tbl_region, tbl_ciudad, tbl_canal
            WHERE	tbl_cliente_local.id_cliente = tbl_cliente.id_cliente
    		AND		tbl_cliente_local.id_ciudad = tbl_ciudad.id_ciudad
            AND     tbl_ciudad.id_region = tbl_region.id_region
    		AND		tbl_cliente_local.id_canal = tbl_canal.id_canal';
    	if ($data_search['id_cliente'] != ''){
    		$sql=$sql."
                AND tbl_cliente.id_cliente = ".$this->db->escape($data_search['id_cliente']);
    		 
    	}
    	if ($data_search['nombre'] != ''){
    		$sql=$sql."
                AND CONCAT(tbl_cliente_local.rut_local, ' ', tbl_cliente_local.razon_social, ' ', tbl_cliente_local.nombre_local, ' ', tbl_cliente_local.direccion, ' ', tbl_cliente_local.fonos) LIKE '%".$this->db->escape_like_str($data_search['nombre'])."%'";
    	}
    	if ($data_search['st_cliente_local'] != ''){
    		$sql=$sql."
                AND tbl_cliente_local.st_cliente_local = ".$this->db->escape($data_search['st_cliente_local']);
    	}
    	if ($data_search['id_canal'] != ''){
    		$sql=$sql."
                AND tbl_cliente_local.id_canal = ".$this->db->escape($data_search['id_canal']);
    	}
    	if ($data_search['id_ciudad'] != ''){
    		$sql=$sql."
                AND tbl_ciudad.id_ciudad = ".$this->db->escape($data_search['id_ciudad']);
    	}
    	if ($data_search['id_region'] != ''){
    		$sql=$sql."
                AND tbl_region.id_region = ".$this->db->escape($data_search['id_region']);
    	}
    	$sql=$sql.'
            ORDER BY 	tbl_cliente_local.nombre_local ASC';
    	$result = $this->db->query($sql);
    	$row = $result->row_array();
    	return $row['total'];
    }
    
    // get persons with paging
    
    function list_cliente_local($data_search, $limit = 10, $offset = 0)
    {
    	$sql="
            SELECT
    				tbl_cliente_local.*,
    				tbl_canal.*,
                    tbl_region.*, 
    				tbl_ciudad.*,
    			tbl_cliente.id_cliente,
                        IF (tbl_cliente.tipo_cliente = 'natural', CONCAT(tbl_cliente.nombre,' ',tbl_cliente.apellidos,' ',tbl_cliente.rut_doc), CONCAT(tbl_cliente.razon_social,' ',tbl_cliente.rut_doc)) AS cliente_nom
                    
    
          	FROM    tbl_cliente_local, tbl_cliente, tbl_region, tbl_ciudad, tbl_canal
            WHERE	tbl_cliente_local.id_cliente = tbl_cliente.id_cliente	
    		AND		tbl_cliente_local.id_ciudad = tbl_ciudad.id_ciudad
            AND     tbl_ciudad.id_region = tbl_region.id_region
    		AND		tbl_cliente_local.id_canal = tbl_canal.id_canal";
    	if ($data_search['id_cliente'] != ''){
    		$sql=$sql."
                AND tbl_cliente.id_cliente = ".$this->db->escape($data_search['id_cliente']);
    		 
    	}
    	if ($data_search['nombre'] != ''){
    		$sql=$sql."
                AND CONCAT(tbl_cliente_local.rut_local, ' ', tbl_cliente_local.razon_social, ' ', tbl_cliente_local.nombre_local, ' ', tbl_cliente_local.direccion, ' ', tbl_cliente_local.fonos) LIKE '%".$this->db->escape_like_str($data_search['nombre'])."%'";
    		 
    	}
    	if ($data_search['st_cliente_local'] != ''){
    		$sql=$sql."
                AND tbl_cliente_local.st_cliente_local = ".$this->db->escape($data_search['st_cliente_local']);
    	}
    	if ($data_search['id_canal'] != ''){
    		$sql=$sql."
                AND tbl_cliente_local.id_canal = ".$this->db->escape($data_search['id_canal']);
    	}
    	if ($data_search['id_ciudad'] != ''){
    		$sql=$sql."
                AND tbl_ciudad.id_ciudad = ".$this->db->escape($data_search['id_ciudad']);
    	}
    	if ($data_search['id_region'] != ''){
    		$sql=$sql."
                AND tbl_region.id_region = ".$this->db->escape($data_search['id_region']);
    	}
    	$sql=$sql.'
            ORDER BY 	cliente_nom ASC, tbl_cliente_local.nombre_local ASC 
            LIMIT ' . $offset . ', ' . $limit;
    	$result = $this->db->query($sql);
    	return $result->result_array();
    }
    
    
    
    
    
    function list_cliente_local_ruta_all($data_search)
    {
    	$sql="
            SELECT
                    COUNT(1) AS total
            FROM    tbl_cliente, tbl_cliente_local, tbl_region, tbl_ciudad, tbl_canal
            WHERE	tbl_cliente.id_cliente = tbl_cliente_local.id_cliente
    		AND		tbl_cliente_local.id_ciudad = tbl_ciudad.id_ciudad
            AND     tbl_ciudad.id_region = tbl_region.id_region
    		AND		tbl_cliente_local.id_canal = tbl_canal.id_canal
    		AND		tbl_cliente_local.st_cliente_local = 'activo'
    		AND		tbl_cliente_local.id_cliente_local NOT IN 
    		(
    		SELECT
    				tbl_ruta_cliente_local.id_cliente_local
			FROM	tbl_ruta_cliente_local
			WHERE	tbl_ruta_cliente_local.id_ruta = ".$this->db->escape($data_search['id_ruta'])."
    		)";
    	if ($data_search['id_cliente'] != ''){
    		$sql=$sql."
                AND tbl_cliente.id_cliente = ".$this->db->escape($data_search['id_cliente']);
    	}
    	 
    	if ($data_search['nombre_local'] != ''){
    		$sql=$sql."
                AND tbl_cliente_local.nombre_local LIKE '%".$this->db->escape_like_str($data_search['nombre_local'])."%'";
    	}
    	
    	if ($data_search['id_canal'] != ''){
    		$sql=$sql."
                AND tbl_cliente_local.id_canal = ".$this->db->escape($data_search['id_canal']);
    	}
    	if ($data_search['id_ciudad'] != ''){
    		$sql=$sql."
                AND tbl_ciudad.id_ciudad = ".$this->db->escape($data_search['id_ciudad']);
    	}
    	if ($data_search['id_region'] != ''){
    		$sql=$sql."
                AND tbl_region.id_region = ".$this->db->escape($data_search['id_region']);
    	}
    	$sql=$sql.'
            ORDER BY 	tbl_region.nombre_region ASC, tbl_ciudad.nombre_ciudad ASC, tbl_cliente_local.direccion  ASC';
    	$result = $this->db->query($sql);
    	$row = $result->row_array();
    	return $row['total'];
    }
    
    // get persons with paging
    
    function list_cliente_local_ruta($data_search, $limit = 10, $offset = 0)
    {
    	$sql="
            SELECT
    				tbl_cliente_local.*,
    				tbl_canal.*,
                    tbl_region.nombre_region,
    				tbl_ciudad.nombre_ciudad, 
    				tbl_cliente_local.direccion 
    
          	FROM    tbl_cliente, tbl_cliente_local, tbl_region, tbl_ciudad, tbl_canal
            WHERE	tbl_cliente.id_cliente = tbl_cliente_local.id_cliente	
    		AND		tbl_cliente_local.id_ciudad = tbl_ciudad.id_ciudad
            AND     tbl_ciudad.id_region = tbl_region.id_region
    		AND		tbl_cliente_local.id_canal = tbl_canal.id_canal
    		AND		tbl_cliente_local.st_cliente_local = 'activo'
    		AND		tbl_cliente_local.id_cliente_local NOT IN 
    		(
    		SELECT
    				tbl_ruta_cliente_local.id_cliente_local
			FROM	tbl_ruta_cliente_local
			WHERE	tbl_ruta_cliente_local.id_ruta = ".$this->db->escape($data_search['id_ruta'])."
    		)";
    	if ($data_search['nombre_local'] != ''){
    		$sql=$sql."
                AND tbl_cliente_local.nombre_local LIKE '%".$this->db->escape_like_str($data_search['nombre_local'])."%'";
    		
    	}
    	if ($data_search['id_cliente'] != ''){
    		$sql=$sql."
                AND tbl_cliente.id_cliente = ".$this->db->escape($data_search['id_cliente']);
    	}
    	if ($data_search['id_canal'] != ''){
    		$sql=$sql."
                AND tbl_cliente_local.id_canal = ".$this->db->escape($data_search['id_canal']);
    	}
    	if ($data_search['id_ciudad'] != ''){
    		$sql=$sql."
                AND tbl_ciudad.id_ciudad = ".$this->db->escape($data_search['id_ciudad']);
    	}
    	if ($data_search['id_region'] != ''){
    		$sql=$sql."
                AND tbl_region.id_region = ".$this->db->escape($data_search['id_region']);
    	}
    	$sql=$sql.'
            ORDER BY 	tbl_region.nombre_region ASC, tbl_ciudad.nombre_ciudad ASC, tbl_cliente_local.direccion  ASC
            LIMIT ' . $offset . ', ' . $limit;
    	$result = $this->db->query($sql);
    	return $result->result_array();
    }
    
    

	
    
    function opt_cliente_local_por_id_cliente_all()
    {
    
    	$sql="
            SELECT
                        tbl_cliente_local.id_cliente_local,
    					tbl_cliente_local.nombre_local
                        
            FROM        tbl_cliente_local
            WHERE       tbl_cliente_local.st_cliente_local = 'activo'
            ORDER BY    tbl_cliente_local.nombre_local ASC";
    
    	$result = $this->db->query($sql);
    	$data_result = $result->result_array();
    	$data[''] = 'Todos';
    	foreach ($data_result as $row){
    		$data[$row['id_cliente_local']] = $row['nombre_local'];
    	}
    	return $data;
    }
    		 
    function opt_cliente_local_por_id_cliente()
    {
    
    	$sql="
            SELECT
                        tbl_cliente_local.id_cliente_local,
    					tbl_cliente_local.nombre_local
                        
            FROM        tbl_cliente_local
            WHERE       tbl_cliente_local.st_cliente_local = 'activo'
            ORDER BY    tbl_cliente_local.nombre_local ASC";
    
    	$result = $this->db->query($sql);
    	$data_result = $result->result_array();
    	$data[''] = 'Seleccione';
    	foreach ($data_result as $row){
    		$data[$row['id_cliente_local']] = $row['nombre_local'];
    	}
    	return $data;
    }
}
?>