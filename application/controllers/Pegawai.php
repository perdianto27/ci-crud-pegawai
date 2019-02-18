<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pegawai_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $pegawai = $this->Pegawai_model->get_all();

        $data = array(
            'pegawai_data' => $pegawai
        );

        $this->template->load('template','pegawai_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Pegawai_model->get_by_id($id);
        if ($row) {
            $data = array(
		'NIK' => $row->NIK,
		'nama' => $row->nama,
		'alamat' => $row->alamat,
		'telp' => $row->telp,
	    );
            $this->template->load('template','pegawai_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pegawai'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('pegawai/create_action'),
	    'NIK' => set_value('NIK'),
	    'nama' => set_value('nama'),
	    'alamat' => set_value('alamat'),
	    'telp' => set_value('telp'),
	);
        $this->template->load('template','pegawai_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'telp' => $this->input->post('telp',TRUE),
	    );

            $this->Pegawai_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pegawai'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Pegawai_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pegawai/update_action'),
		'NIK' => set_value('NIK', $row->NIK),
		'nama' => set_value('nama', $row->nama),
		'alamat' => set_value('alamat', $row->alamat),
		'telp' => set_value('telp', $row->telp),
	    );
            $this->template->load('template','pegawai_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pegawai'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('NIK', TRUE));
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'telp' => $this->input->post('telp',TRUE),
	    );

            $this->Pegawai_model->update($this->input->post('NIK', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pegawai'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Pegawai_model->get_by_id($id);

        if ($row) {
            $this->Pegawai_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pegawai'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pegawai'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');

	$this->form_validation->set_rules('NIK', 'NIK', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "pegawai.xls";
        $judul = "pegawai";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
	xlsWriteLabel($tablehead, $kolomhead++, "Telp");

	foreach ($this->Pegawai_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->telp);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pegawai.doc");

        $data = array(
            'pegawai_data' => $this->Pegawai_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('pegawai_doc',$data);
    }

}
