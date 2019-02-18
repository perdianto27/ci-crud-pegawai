<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lokasi extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('Lokasi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $lokasi = $this->Lokasi_model->get_all();

        $data = array(
            'lokasi_data' => $lokasi
        );

        $this->template->load('template','lokasi_list', $data);
    }

    public function read($kd_lokasi) 
    {
        $row = $this->Lokasi_model->get_by_kd_lokasi($kd_lokasi);
        if ($row) {
            $data = array(
		'kd_lokasi' => $row->kd_lokasi,
		'nm_lokasi' => $row->nm_lokasi,
	    );
            $this->template->load('template','lokasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('lokasi/create_action'),
	    'kd_lokasi' => set_value('kd_lokasi'),
	    'nm_lokasi' => set_value('nm_lokasi'),
	);
        $this->template->load('template','lokasi_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        'kd_lokasi' => $this->input->post('kd_lokasi',TRUE),        
		'nm_lokasi' => $this->input->post('nm_lokasi',TRUE),
	    );

            $this->Lokasi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('lokasi'));
        }
    }
    
    public function update($kd_lokasi) 
    {
        $row = $this->Lokasi_model->get_by_kd_lokasi($kd_lokasi);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('lokasi/update_action'),
		'kd_lokasi' => set_value('kd_lokasi', $row->kd_lokasi),
		'nm_lokasi' => set_value('nm_lokasi', $row->nm_lokasi),
	    );
            $this->template->load('template','lokasi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kd_lokasi', TRUE));
        } else {
            $data = array(
		'nm_lokasi' => $this->input->post('nm_lokasi',TRUE),
	    );

            $this->Lokasi_model->update($this->input->post('kd_lokasi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('lokasi'));
        }
    }
    
    public function delete($kd_lokasi) 
    {
        $row = $this->Lokasi_model->get_by_kd_lokasi($kd_lokasi);

        if ($row) {
            $this->Lokasi_model->delete($kd_lokasi);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('lokasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nm_lokasi', 'nm lokasi', 'trim|required');

	$this->form_validation->set_rules('kd_lokasi', 'kd_lokasi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "lokasi.xls";
        $judul = "lokasi";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Kode lokasi");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Lokasi");

	foreach ($this->Lokasi_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
        xlsWriteLabel($tablebody, $kolombody++, $data->kd_lokasi);    
	    xlsWriteLabel($tablebody, $kolombody++, $data->nm_lokasi);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=lokasi.doc");

        $data = array(
            'lokasi_data' => $this->Lokasi_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('lokasi_doc',$data);
    }

}

