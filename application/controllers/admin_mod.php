<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");
class Admin_mod extends Secure_area {

	public function __construct()
	{
		parent::__construct('admin_mod');
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
	}

	public function index(){
		
	}
	
	public function bancos(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Bancos');
		$crud->set_theme('datatables');
		$crud->set_table($this->db->dbprefix('banco'));
		$crud->unset_delete();
		$crud->unset_texteditor('nombre_banco','full_text');
		$output = $crud->render();
		$this->_admin_mod_output($output);
	}
	
	public function giros(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Giros');
		$crud->set_theme('datatables');
		$crud->set_table($this->db->dbprefix('giro'));
		$crud->unset_delete();
		$crud->unset_texteditor('nombre_giro','full_text');
		$output = $crud->render();
		$this->_admin_mod_output($output);
	}
	
	public function tipo_producto(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Tipos de Productos');
		$crud->set_theme('datatables');
		$crud->set_table($this->db->dbprefix('items_tipo'));
		$crud->unset_delete();
		$output = $crud->render();
		$this->_admin_mod_output($output);
	}
	
	public function descuento_tipo(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Tipos de Productos');
		$crud->set_theme('datatables');
		$crud->display_as('id_items_tipo','Tipo Producto');
		$crud->set_relation('id_items_tipo','items_tipo','nombre_items_tipo');
		$crud->set_table($this->db->dbprefix('items_descuento_por_tipo'));
		$crud->unset_delete();
		$output = $crud->render();
		$this->_admin_mod_output($output);
	}
	
	public function lista_precio(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Listas de Precio');
		$crud->set_theme('datatables');
		$crud->set_table($this->db->dbprefix('lista_precio'));
		$crud->unset_delete();
		$output = $crud->render();
		$this->_admin_mod_output($output);
	}
	
	public function correlativos(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Correlativos');
		$crud->set_theme('datatables');
		$crud->display_as('location_id','Tienda');
		$crud->set_relation('location_id','locations','name');
		$crud->set_table($this->db->dbprefix('correlativo'));
		$crud->unset_delete();
		$output = $crud->render();
		$this->_admin_mod_output($output);
	}
	/*
	public function equipos(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Equipos');
		$crud->set_theme('flexigrid');
		$crud->set_table('tbl_equipo');
		$crud->set_relation('id_grupo','tbl_grupo','nombre_grupo');
		$output = $crud->render();
		$this->_copaamerica_output($output);
	}
	public function estadios(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Estadios');
		$crud->set_theme('flexigrid');
		$crud->set_table('tbl_estadio');
		$output = $crud->render();
		$this->_copaamerica_output($output);
	}
	public function estadisticas(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Estad�sticas');
		$crud->set_theme('flexigrid');
		$crud->set_table('tbl_estadistica');
		$output = $crud->render();
		$this->_copaamerica_output($output);
	}
	public function fase2(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Fase 2');
		$crud->set_theme('flexigrid');
		$crud->set_table('tbl_fase2');
		$output = $crud->render();
		$this->_copaamerica_output($output);
	}
	
	public function goleadores(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Goleadores');
		$crud->set_theme('flexigrid');
		$crud->set_table('tbl_goleadores');
		$output = $crud->render();
		$this->_copaamerica_output($output);
	}
	public function grupos(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Grupos');
		$crud->set_theme('flexigrid');
		$crud->set_table('tbl_grupo');
		$output = $crud->render();
		$this->_copaamerica_output($output);
	}
	public function jugadores(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Jugadores');
		$crud->set_theme('flexigrid');
		$crud->set_table('tbl_jugador');
		$output = $crud->render();
		$this->_copaamerica_output($output);
	}
	
	public function partidos(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Partidos');
		$crud->set_theme('flexigrid');
		$crud->set_table('tbl_partido');
		$crud->set_relation('id_estadio','tbl_estadio','nombre_estadio');
		$crud->set_relation('id_equipo1','tbl_equipo','nombre_equipo');
		$crud->set_relation('id_equipo2','tbl_equipo','nombre_equipo');
		$crud->set_relation('id_ganador','tbl_equipo','nombre_equipo');
		
		$output = $crud->render();
		$this->_copaamerica_output($output);
	}
	*/
	
	public function _admin_mod_output($output = null)
	{
		$this->load->view('admin_mod',$output);
	}

	

}