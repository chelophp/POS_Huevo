<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_localidad extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('localidad','',TRUE);
 
    }

    public function combo_ciudad_all(){
        $id_region = $this->input->post('id_region');
        $data = $this->localidad->opt_ciudad_por_region_all($id_region);
        $opt_select = '';
        foreach((array)$data as $id_ciudad => $nombre_ciudad){
            $opt_select = $opt_select . '<option value="'.$id_ciudad.'">'.$nombre_ciudad.'</option>';
        }
        echo $opt_select;
    }

    public function combo_ciudad(){
        $id_region = $this->input->post('id_region');
        $data = $this->localidad->opt_ciudad_por_region($id_region);
        $opt_select = '';
        foreach((array)$data as $id_ciudad => $nombre_ciudad){
            $opt_select = $opt_select . '<option value="'.$id_ciudad.'">'.$nombre_ciudad.'</option>';
        }
        echo $opt_select;
    }
}
/* End of file admin_localidad.php */
/* Location: ./application/controllers/admin_localidad.php */