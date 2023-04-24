<?php

class Admin extends CI_Controller
{
    public function index()
    {

        if ($this->session->userdata('aId')){

            $this->load->view('admin/header/header');
            $this->load->view('admin/header/css');
            $this->load->view('admin/header/navtop');
            $this->load->view('admin/header/navleft');
            $this->load->view('admin/home/index');
            $this->load->view('admin/header/footer');
            $this->load->view('admin/header/htmlclose');
        } else {
            setFlashData('alert-danger','Please log in 1st to access ur admin panel','admin/login');
        }

    }

    public function login()
    {
        $this->load->view('admin/login');
    }

    public function checkAdmin()
    {
        $data['aEmail'] = $this->input->post('email',true);
        $data['aPassword'] = $this->input->post('password',true);

        if (!empty ($data['aEmail']) && !empty ($data['aPassword'])) {
            $admindata = $this->ModAdmin->checkAdmin($data);
            if (count($admindata) == 1){
                $forSession = array(
                    'aId'=>$admindata[0]['aId'],
                    'aName'=>$admindata[0]['aName'],
                    'aEmail'=>$admindata[0]['aEmail'],
                );
                $this->session->set_userdata($forSession);
                if ($this->session->userdata('aId')){
                    redirect('admin');
                } else {
                    echo "session not created";
                };
                var_dump($admindata);
            } else {
            setFlashData('alert-warning','Please check your email or password','admin/login');
            }
        } else {
            setFlashData('alert-warning','Please Check the required fields~~','admin/login');
        }
    }

    public function logOut()
    {
        if ($this->session->userdata('aId')){
            $this->session->set_userdata('aId','');
            setFlashData('alert-danger','You have successfully logged out','admin/login');
        } else {
            setFlashData('alert-danger','Please log in login now~','admin/login');
        }
    }
}