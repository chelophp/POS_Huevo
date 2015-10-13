<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_lista_precio extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('canal_model','',TRUE);
        $this->load->model('cliente_model','',TRUE);
 
    }
 

    public function index($accion = '', $offset = 0, $csv = '')
    {
    	//$this->sesion_usuario->logged_in();
        //recibir y guardar en sesion datos de busqueda
        $data_search = $this->input->post('data_search') ? $this->input->post('data_search') : $_SESSION['data_search'];
        $_SESSION['data_search'] = $data_search;

           //recibir y guardar en sesion valor de $limit para el paginador
        $limit = $this->input->post('limit') ? $this->input->post('limit') : $_SESSION['limit'];
        $_SESSION['limit'] = $limit;

        //offset
        $uri_segment = 4;
        $offset = $this->uri->segment($uri_segment) ? $this->uri->segment($uri_segment) : 0;
        $_SESSION['offset'] = $offset;

        $data['pagination'] = '';
        $data['table']      = '';
        $data['num_registros_totales']  = 0;
        $data['num_registros_pagina']   = 0;

        // load data
       // if ($accion == 'listar'){
            $data_db = $this->canal_model->list_canal($data_search, $limit, $offset);
            $data['num_registros_pagina'] = count($data_db);

            // generate pagination
            $this->load->library('pagination');
            $config['base_url']             = site_url('admin_canal/index/listar/');
            $config['total_rows']           = $this->canal_model->list_canal_all($data_search);
            $data['num_registros_totales']  = $config['total_rows'];
            $config['per_page']             = $limit;
            $config['uri_segment']          = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination']             = $this->pagination->create_links();
                      
            // generate table data
            $arr_data[0] = array('Cliente','Nombre', 'Estado', 'Acciones');
            if ($csv == 'export'){
                array_pop($arr_data[0]);
            }
            foreach ($data_db as $row){
                $arr_color[$row['id_canal']] = $this->font_color['negro'];
                if ($row['st_canal'] == 'inactivo'){
                    $arr_color[$row['id_canal']] = $this->font_color['rojo'];
                }
                $edit = '<a href="javascript:void(0)" onclick="colorbox('."'".site_url('admin_canal/edit_canal/'.$row['id_canal'])."'".',900,600)" class="update">Actualizar</a>';
                $ver  = '<a href="javascript:void(0)" onclick="colorbox('."'".site_url('admin_canal/view_canal/'.$row['id_canal'])."'".',900,600)" class="view">Ver</a>';
                $arr_data[$row['id_canal']] = array($row['cliente_nom'], $row['nombre_canal'], $row['st_canal'], $ver.' '.$edit);
                if ($csv == 'export'){
                    array_pop($arr_data[$row['id_canal']]);
                }
            }
            unset($data_db);
            if ($csv == 'export'){
                $this->load->helper('xls');
                echo array_to_xls((array)$arr_data, 'listado_canal_'.date('d-m-Y H:i').'.xls');
                exit;
            }
        //}

        $data['arr_data']           = $arr_data;
        $data['arr_color']          = $arr_color;
           
        $data['url_nuevo']          = site_url('admin_canal/add_canal');
        $data['url_csv']            = anchor('admin_canal/index/listar/'.$_SESSION['offset'].'/export','XLS',array('class'=>'xls'));
        $data['url_accion']         = site_url('admin_canal/index/listar');

        $data['opt_st_canal']      	= array_merge(array(''=>'Todos'), (array)$this->estado);
        $data['opt_cliente']		= $this->cliente_model->opt_cliente_all();

        $data['data_search']        = $data_search;
        $data['limit']              = $limit;

        // load view

        $this->load->view('admin_head');
        $this->load->view('admin_canal_list', $data);
        $this->load->view('admin_foot');

    }

    public function add_canal(){
    	$this->sesion_usuario->logged_in();
        $data['data_form']          = $this->session->flashdata('data_form');
        $data['insertar_otro']      = $this->session->flashdata('insertar_otro');
        $data['url_accion']         = site_url('admin_canal/insert_canal');
        $data['opt_cliente']		= $this->cliente_model->opt_cliente();
        $this->load->view('admin_head_pop');
        $this->load->view('admin_canal_insert', $data);
        $this->load->view('admin_foot_pop');
    }

    public function insert_canal(){
    	$this->sesion_usuario->logged_in();
        $insertar_otro      = $this->input->post('insertar_otro');
        $msg = '';
        $this->form_validation->set_rules('data_form[id_cliente]', 'Cliente', 'trim|required|xss_clean');
        $this->form_validation->set_rules('data_form[nombre_canal]', 'Nombre', 'trim|required|min_length[1]|xss_clean|callback_canal_check');
       
        // run validation
        if ($this->form_validation->run() == FALSE){
        	$data_form          = $this->input->post('data_form');
            $msg['error'] = 'No se pudo ingresar el canal, intentelo nuevamente.<br />'.validation_errors();
            $this->session->set_flashdata('msg', $msg);
            $this->session->set_flashdata('data_form', $data_form);
            $this->session->set_flashdata('insertar_otro', $insertar_otro);
            redirect('admin_canal/add_canal','refresh');
        }else{
        	$data_form          = $this->input->post('data_form');
            $id_canal = $this->canal_model->insert_canal($data_form);
            $msg['ok'] = 'El canal ha sido ingresado.';
            if ($insertar_otro == 'on'){
            	$this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('insertar_otro', $insertar_otro);
                redirect('admin_canal/add_canal','refresh');
            }else{
	            $row = $this->canal_model->canal_por_id($id_canal);
	            $edit = '<a href="javascript:void(0)" onclick=colorbox("'.site_url('admin_canal/edit_canal/'.$row['id_canal']).'",900,600) class="update">Actualizar</a>';
	            $ver  = '<a href="javascript:void(0)" onclick=colorbox("'.site_url('admin_canal/view_canal/'.$row['id_canal']).'",900,600) class="view">Ver</a>';
                $fila = "<tr class=fila id=$id_canal><td>".$row['cliente_nom']."</td><td>".$row['nombre_canal']."</td><td>".$row['st_canal']."</td><td>".$ver." ".$edit."</td></tr>";
                echo "<script>alert('".$msg['ok']."');</script>";
            	echo "<script>parent.$('$fila').prependTo('#html_table_body').addClass('fila');</script>";
                echo "<script>parent.$.fn.colorbox.close();</script>";
            }
        }
    }

    public function view_canal($id_canal, $imprimir = ''){
    	$this->sesion_usuario->logged_in();
		$this->sesion_usuario->logged_in();
        $data['data_form']      = $this->canal_model->canal_por_id($id_canal);
        $data['url_pdf']        = anchor('admin_canal/view_canal/'.$id_canal.'/imprimir','PDF',array('class'=>'pdf'));

        $pdf = false;
        if ($imprimir == 'imprimir'){
            $pdf = true;
        }
        $data['pdf'] = $pdf;

        $html = $this->load->view('head_pdf', '', $pdf);
        $html .= $this->load->view('admin_canal_view', $data, $pdf);
        $html .= $this->load->view('foot_pdf', '', $pdf);
        if ($imprimir == 'imprimir'){
           $this->load->helper('to_pdf');
           pdf_create($html, 'vista_canal_'.date('d-m-Y H:i'));
        }
    }
    
    public function edit_canal($id_canal){
    	$this->sesion_usuario->logged_in();
        if ($this->session->flashdata('data_form')){
            $data['data_form']          = $this->session->flashdata('data_form');
        }else{
            $data['data_form']          = $this->canal_model->canal_por_id($id_canal);
        }
        
        $data['opt_st_canal']     =  $this->estado;
        $data['id_canal']         = $id_canal;
        $data['url_accion']         = site_url('admin_canal/update_canal/'.$id_canal);
        $data['opt_cliente']		= $this->cliente_model->opt_cliente();
        // load view

        $this->load->view('admin_head_pop');
        $this->load->view('admin_canal_edit', $data);
        $this->load->view('admin_foot_pop');
    }

    public function update_canal($id_canal){
    	$this->sesion_usuario->logged_in();
        $_SESSION['id_canal'] = $id_canal;
        
        
        $msg = '';
        $this->form_validation->set_rules('data_form[id_cliente]', 'Cliente', 'trim|required|xss_clean');
        $this->form_validation->set_rules('data_form[nombre_canal]', 'Nombre', 'trim|required|min_length[1]|xss_clean|callback_canal_check');
        $this->form_validation->set_rules('data_form[st_canal]', 'Estado', 'trim|required|xss_clean');
        
        // run validation
        if ($this->form_validation->run() == FALSE){
        	$data_form      = $this->input->post('data_form');
            $msg['error'] = 'No se pudo actualizar el canal, intentelo nuevamente.<br />'.validation_errors();
            $this->session->set_flashdata('msg', $msg);
            $this->session->set_flashdata('data_form', $data_form);
            redirect('admin_canal/edit_canal/'.$id_canal,'refresh');
        }else{
        	$data_form      = $this->input->post('data_form');
            $num_filas_afectadas = $this->canal_model->update_canal($id_canal, $data_form);
            $msg['ok'] = 'El canal ha sido actualizado.';
            $row = $this->canal_model->canal_por_id($id_canal);
            $color = $this->font_color['negro'];
            if ($row['st_canal'] == 'inactivo'){
            	$color = $this->font_color['rojo'];
            }
            $edit = '<a href="javascript:void(0)" onclick=colorbox("'.site_url('admin_canal/edit_canal/'.$row['id_canal']).'",900,600) class="update">Actualizar</a>';
            $ver  = '<a href="javascript:void(0)" onclick=colorbox("'.site_url('admin_canal/view_canal/'.$row['id_canal']).'",900,600) class="view">Ver</a>';
            $fila = "<td><font color=$color>".$row['cliente_nom']."</font></td><td><font color=$color>".$row['nombre_canal']."</font></td><td><font color=$color>".$row['st_canal']."</font></td><td><font color=$color>".$ver." ".$edit."</font></td>";
            echo "<script>alert('".$msg['ok']."');</script>";
            echo "<script>parent.$('#$id_canal').html('$fila').addClass('fila');</script>";
            echo "<script>parent.$.fn.colorbox.close();</script>";
        }
    }
    
   
    
    public function canal_check($canal){
		$this->sesion_usuario->logged_in();
        $id_canal = $_SESSION['id_canal'];
        unset($_SESSION['id_canal']);
        $row = $this->canal_model->check_canal_por_nombre($canal, $id_canal);
        if ($row)
        {
            $this->form_validation->set_message('canal_check', 'El %s ya existe');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function combo_canal_all(){
    	$id_cliente = $this->input->post('id_cliente');
    	$data = $this->canal_model->opt_canal_por_cliente_all($id_cliente);
    	$opt_select = '';
    	foreach((array)$data as $id_canal => $nombre_canal){
    		$opt_select = $opt_select . '<option value="'.$id_canal.'">'.$nombre_canal.'</option>';
    	}
    	echo $opt_select;
    }
    
    public function combo_canal(){
    	$id_cliente = $this->input->post('id_cliente');
    	$data = $this->canal_model->opt_canal_por_cliente($id_cliente);
    	$opt_select = '';
    	foreach((array)$data as $id_canal => $nombre_canal){
    		$opt_select = $opt_select . '<option value="'.$id_canal.'">'.$nombre_canal.'</option>';
    	}
    	echo $opt_select;
    }

    
}
/* End of file admin_lista_precio.php */
/* Location: ./application/controllers/admin_lista_precio.php */