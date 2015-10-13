<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parametro{

	public function __construct()
    {
       $this->CI =& get_instance();
    }
    
	function set_value()
	{

		$this->CI->estado = array('activo'=>'Activo', 'inactivo'=>'Inactivo');
		$this->CI->tipo_persona = array('natural'=>'Natural', 'juridico'=>'Jur&iacute;dico', 'extranjero'=>'Extranjero');
		$this->CI->tipo_documento = array('rut'=>'Rut','otro'=>'Otro');
		$this->CI->arr_nombre_modulos_nuevos = array('bancos'=>'Bancos', 'giros'=>'Giros', 'tipo_producto'=>'Tipo Productos', 'descuento_tipo'=>'% Desc. x Tipo', 'lista_precio'=>'Listas de Precios', 'correlativos'=>'Correlativos', 'bancos'=>'Bancos');
		
		$this->CI->si_no = array(''=>'Seleccione', 'si'=>'Si','no'=>'No');
		$this->CI->si_no_all = array(''=>'Todos', 'si'=>'Si','no'=>'No');
		$this->CI->si_no_movil = array(''=>'-', 'si'=>'Si','no'=>'No');
		$this->CI->font_color = array('negro'=>'#000000', 'verde'=>'#007700', 'rojo'=>'#990000','azul'=>'#3A01DF');
	}
}
/* End of file parametro.php */
/* Location: ./application/hooks/parametro.php */