<?php

class Admin extends CI_Controller
{
    public function index()
    {
        $this->load->view('admin/header/header');
        $this->load->view('admin/header/css');
        $this->load->view('admin/header/navtop');
        $this->load->view('admin/header/navleft');
        $this->load->view('admin/home/index');
        $this->load->view('admin/header/footer');
        $this->load->view('admin/header/htmlclose');

    }
}