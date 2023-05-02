<?php

class Admin extends CI_Controller
{
    public function index()
    {

        if ($this->session->userdata('aId')) {

            $this->load->view('admin/header/header');
            $this->load->view('admin/header/css');
            $this->load->view('admin/header/navtop');
            $this->load->view('admin/header/navleft');
            $this->load->view('admin/home/index');
            $this->load->view('admin/header/footer');
            $this->load->view('admin/header/htmlclose');
        } else {
            setFlashData('alert-danger', 'Please log in 1st to access ur admin panel', 'admin/login');
        }
    }

    public function login()
    {
        $this->load->view('admin/login');
    }

    public function checkAdmin()
    {
        $data['aEmail'] = $this->input->post('email', true);
        $data['aPassword'] = $this->input->post('password', true);

        if (!empty($data['aEmail']) && !empty($data['aPassword'])) {
            $admindata = $this->ModAdmin->checkAdmin($data);
            if (count($admindata) == 1) {
                $forSession = array(
                    'aId' => $admindata[0]['aId'],
                    'aName' => $admindata[0]['aName'],
                    'aEmail' => $admindata[0]['aEmail'],
                );
                $this->session->set_userdata($forSession);
                if ($this->session->userdata('aId')) {
                    redirect('admin');
                } else {
                    echo "session not created";
                };
                var_dump($admindata);
            } else {
                setFlashData('alert-warning', 'Please check your email or password', 'admin/login');
            }
        } else {
            setFlashData('alert-warning', 'Please Check the required fields~~', 'admin/login');
        }
    }

    public function logOut()
    {
        if ($this->session->userdata('aId')) {
            $this->session->set_userdata('aId', '');
            setFlashData('alert-danger', 'You have successfully logged out', 'admin/login');
        } else {
            setFlashData('alert-danger', 'Please log in login now~', 'admin/login');
        }
    }

    public function newCategory()
    {
        if (adminLoggedIn()) {
            $this->load->view('admin/header/header');
            $this->load->view('admin/header/css');
            $this->load->view('admin/header/navtop');
            $this->load->view('admin/header/navleft');
            $this->load->view('admin/home/newCategory');
            $this->load->view('admin/header/footer');
            $this->load->view('admin/header/htmlclose');
        } else {
            setFlashData('alert-danger', 'Please log in first to add your category.', 'admin/login');
        }
    }

    public function addCategory()
    {
        if (adminLoggedIn()) {
            $data['cName'] = $this->input->post('categoryName', true);
            if (!empty($data['cName'])) {
                $path = realpath(APPPATH . '../assets/images/categories/');
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|png|jpg|jpeg';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('catDp')) {
                    $error = $this->upload->display_errors();
                    setFlashData('alert-danger', $error, 'admin/newCategory');
                } else {
                    $fileName = $this->upload->data();
                    $data['cDp'] = $fileName['file_name'];
                    $data['cDate'] = date('Y-m-d h:i:s');
                    $data['adminId'] = getAdminId();
                }
                $addData = $this->ModAdmin->checkCategory($data);
                
                if ($addData->num_rows() > 0) {
                    setFlashData('alert-danger', 'The category already exist.', 'admin/newCategory');
                } else {
                    $addData = $this->ModAdmin->addCategory($data);
                    if ($addData) {
                        setFlashData('alert-success', 'You have successfully added you category.', 'admin/newCategory');
                    } else {
                        setFlashData('alert-danger', 'You can not add your category right now .', 'admin/newCategory');
                    }
                }
            } else {
                setFlashData('alert-danger', 'Category Nmae is required.', 'admin/newCategory');
            }
        } else {
            setFlashData('alert-danger', 'Please log in first to add your category.', 'admin/login');
        }
    }
}
