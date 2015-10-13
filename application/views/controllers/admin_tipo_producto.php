<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_tipo_producto extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('rechazo_model','',TRUE);
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
            $data_db = $this->rechazo_model->list_rechazo($data_search, $limit, $offset);
            $data['num_registros_pagina'] = count($data_db);

            // generate pagination
            $this->load->library('pagination');
            $config['base_url']             = site_url('admin_rechazo/index/listar/');
            $config['total_rows']           = $this->rechazo_model->list_rechazo_all($data_search);
            $data['num_registros_totales']  = $config['total_rows'];
            $config['per_page']             = $limit;
            $config['uri_segment']          = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination']             = $this->pagination->create_links();
                      
            // generate table data
            $arr_data[0] = array('Cliente','Nombre', 'Tipo', 'Estado', 'Acciones');
            if ($csv == 'export'){
                array_pop($arr_data[0]);
            }
            foreach ($data_db as $row){
                $arr_color[$row['id_rechazo']] = $this->font_color['negro'];
                if ($row['st_rechazo'] == 'inactivo'){
                    $arr_color[$row['id_rechazo']] = $this->font_color['rojo'];
                }
                $edit = '<a href="javascript:void(0)" onclick="colorbox('."'".site_url('admin_rechazo/edit_rechazo/'.$row['id_rechazo'])."'".',900,600)" class="update">Actualizar</a>';
                $ver  = '<a href="javascript:void(0)" onclick="colorbox('."'".site_url('admin_rechazo/view_rechazo/'.$row['id_rechazo'])."'".',900,600)" class="view">Ver</a>';
                $arr_data[$row['id_rechazo']] = array($row['cliente_nom'], $row['nombre_rechazo'], $row['tipo_rechazo'], $row['st_rechazo'], $ver.' '.$edit);
                if ($csv == 'export'){
                    array_pop($arr_data[$row['id_rechazo']]);
                }
            }
            unset($data_db);
            if ($csv == 'export'){
                $this->load->helper('xls');
                echo array_to_xls((array)$arr_data, 'listado_rechazo_'.date('d-m-Y H:i').'.xls');
                exit;
            }
        //}

        $data['arr_data']           = $arr_data;
        $data['arr_color']          = $arr_color;
           
        $data['url_nuevo']          = site_url('admin_rechazo/add_rechazo');
        $data['url_csv']            = anchor('admin_rechazo/index/listar/'.$_SESSION['offset'].'/export','XLS',array('class'=>'xls'));
        $data['url_accion']         = site_url('admin_rechazo/index/listar');

        $data['opt_st_rechazo']      = array_merge(array(''=>'Todos'), (array)$this->estado);
        $data['opt_tipo_rechazo']      = array_merge(array(''=>'Todos'), (array)$this->tipo_rechazo);
        $data['opt_cliente']		= $this->cliente_model->opt_cliente_all();
        $data['data_search']        = $data_search;
        $data['limit']              = $limit;

        // load view

        $this->load->view('partial/header');
        $this->load->view('temporal/admin_rechazo_list', $data);
        $this->load->view('partial/footer');

    }

    public function add_rechazo(){
    	$this->sesion_usuario->logged_in();
        $data['data_form']          = $this->session->flashdata('data_form');
        $data['insertar_otro']      = $this->session->flashdata('insertar_otro');
        $data['url_accion']         = site_url('admin_rechazo/insert_rechazo');
        $data['opt_tipo_rechazo']      = array_merge(array(''=>'Seleccione'), (array)$this->tipo_rechazo);
        $data['opt_cliente']		= $this->cliente_model->opt_cliente();
        $this->load->view('admin_head_pop');
        $this->load->view('admin_rechazo_insert', $data);
        $this->load->view('admin_foot_pop');
    }

    public function insert_rechazo(){
    	$this->sesion_usuario->logged_in();
        $insertar_otro      = $this->input->post('insertar_otro');
        $msg = '';
        $this->form_validation->set_rules('data_form[id_cliente]', 'Cliente', 'trim|required|xss_clean');
        $this->form_validation->set_rules('data_form[nombre_rechazo]', 'Nombre', 'trim|required|min_length[1]|xss_clean|callback_rechazo_check');
        $this->form_validation->set_rules('data_form[tipo_rechazo]', 'Tipo', 'trim|required|xss_clean');
       
        // run validation
        if ($this->form_validation->run() == FALSE){
        	$data_form          = $this->input->post('data_form');
            $msg['error'] = 'No se pudo ingresar el rechazo, intentelo nuevamente.<br />'.validation_errors();
            $this->session->set_flashdata('msg', $msg);
            $this->session->set_flashdata('data_form', $data_form);
            $this->session->set_flashdata('insertar_otro', $insertar_otro);
            redirect('admin_rechazo/add_rechazo','refresh');
        }else{
        	$data_form          = $this->input->post('data_form');
            $id_rechazo = $this->rechazo_model->insert_rechazo($data_form);
            $msg['ok'] = 'El rechazo ha sido ingresado.';
            if ($insertar_otro == 'on'){
            	$this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('insertar_otro', $insertar_otro);
                redirect('admin_rechazo/add_rechazo','refresh');
            }else{
	            $row = $this->rechazo_model->rechazo_por_id($id_rechazo);
	            $edit = '<a href="javascript:void(0)" onclick=colorbox("'.site_url('admin_rechazo/edit_rechazo/'.$row['id_rechazo']).'",900,600) class="update">Actualizar</a>';
	            $ver  = '<a href="javascript:void(0)" onclick=colorbox("'.site_url('admin_rechazo/view_rechazo/'.$row['id_rechazo']).'",900,600) class="view">Ver</a>';
                $fila = "<tr class=fila id=$id_rechazo><td>".$row['cliente_nom']."</td><td>".$row['nombre_rechazo']."</td><td>".$row['tipo_rechazo']."</td><td>".$row['st_rechazo']."</td><td>".$ver." ".$edit."</td></tr>";
                echo "<script>alert('".$msg['ok']."');</script>";
            	echo "<script>parent.$('$fila').prependTo('#html_table_body').addClass('fila');</script>";
                echo "<script>parent.$.fn.colorbox.close();</script>";
            }
        }
    }

    public function view_rechazo($id_rechazo, $imprimir = ''){
    	$this->sesion_usuario->logged_in();
		$this->sesion_usuario->logged_in();
        $data['data_form']      = $this->rechazo_model->rechazo_por_id($id_rechazo);
        $data['url_pdf']        = anchor('admin_rechazo/view_rechazo/'.$id_rechazo.'/imprimir','PDF',array('class'=>'pdf'));

        $pdf = false;
        if ($imprimir == 'imprimir'){
            $pdf = true;
        }
        $data['pdf'] = $pdf;

        $html = $this->load->view('head_pdf', '', $pdf);
        $html .= $this->load->view('admin_rechazo_view', $data, $pdf);
        $html .= $this->load->view('foot_pdf', '', $pdf);
        if ($imprimir == 'imprimir'){
           $this->load->helper('to_pdf');
           pdf_create($html, 'vista_rechazo_'.date('d-m-Y H:i'));
        }
    }
    
    public function edit_rechazo($id_rechazo){
    	$this->sesion_usuario->logged_in();
        if ($this->session->flashdata('data_form')){
            $data['data_form']          = $this->session->flashdata('data_form');
        }else{
            $data['data_form']          = $this->rechazo_model->rechazo_por_id($id_rechazo);
        }
        $data['opt_cliente']		= $this->cliente_model->opt_cliente();
        $data['opt_tipo_rechazo']      = $this->tipo_rechazo;
        $data['opt_st_rechazo']     =  $this->estado;
        $data['id_rechazo']         = $id_rechazo;
        $data['url_accion']         = site_url('admin_rechazo/update_rechazo/'.$id_rechazo);
        // load view

        $this->load->view('admin_head_pop');
        $this->load->view('admin_rechazo_edit', $data);
        $this->load->view('admin_foot_pop');
    }

    public function update_rechazo($id_rechazo){
    	$this->sesion_usuario->logged_in();
        $_SESSION['id_rechazo'] = $id_rechazo;
        
        
        $msg = '';
        $this->form_validation->set_rules('data_form[id_cliente]', 'Cliente', 'trim|required|xss_clean');
        $this->form_validation->set_rules('data_form[nombre_rechazo]', 'Nombre', 'trim|required|min_length[1]|xss_clean|callback_rechazo_check');
        $this->form_validation->set_rules('data_form[tipo_rechazo]', 'Tipo', 'trim|required|xss_clean');
        $this->form_validation->set_rules('data_form[st_rechazo]', 'Estado', 'trim|required|xss_clean');
        
        // run validation
        if ($this->form_validation->run() == FALSE){
        	$data_form      = $this->input->post('data_form');
            $msg['error'] = 'No se pudo actualizar el rechazo, intentelo nuevamente.<br />'.validation_errors();
            $this->session->set_flashdata('msg', $msg);
            $this->session->set_flashdata('data_form', $data_form);
            redirect('admin_rechazo/edit_rechazo/'.$id_rechazo,'refresh');
        }else{
        	$data_form      = $this->input->post('data_form');
            $num_filas_afectadas = $this->rechazo_model->update_rechazo($id_rechazo, $data_form);
            $msg['ok'] = 'El rechazo ha sido actualizado.';
            $row = $this->rechazo_model->rechazo_por_id($id_rechazo);
            $color = $this->font_color['negro'];
            if ($row['st_rechazo'] == 'inactivo'){
            	$color = $this->font_color['rojo'];
            }
            $edit = '<a href="javascript:void(0)" onclick=colorbox("'.site_url('admin_rechazo/edit_rechazo/'.$row['id_rechazo']).'",900,600) class="update">Actualizar</a>';
            $ver  = '<a href="javascript:void(0)" onclick=colorbox("'.site_url('admin_rechazo/view_rechazo/'.$row['id_rechazo']).'",900,600) class="view">Ver</a>';
            $fila = "<td><font color=$color>".$row['cliente_nom']."</font></td><td><font color=$color>".$row['nombre_rechazo']."</font></td><td><font color=$color>".$row['tipo_rechazo']."</font></td><td><font color=$color>".$row['st_rechazo']."</font></td><td><font color=$color>".$ver." ".$edit."</font></td>";
            echo "<script>alert('".$msg['ok']."');</script>";
            echo "<script>parent.$('#$id_rechazo').html('$fila').addClass('fila');</script>";
            echo "<script>parent.$.fn.colorbox.close();</script>";
        }
    }
    
   
    
    public function rechazo_check($rechazo){
		$this->sesion_usuario->logged_in();
        $id_rechazo = $_SESSION['id_rechazo'];
        unset($_SESSION['id_rechazo']);
        $row = $this->rechazo_model->check_rechazo_por_nombre($rechazo, $id_rechazo);
        if ($row)
        {
            $this->form_validation->set_message('rechazo_check', 'El %s ya existe');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    
}
/* End of file admin_rechazo.php */
/* Location: ./application/controllers/admin_rechazo.php */