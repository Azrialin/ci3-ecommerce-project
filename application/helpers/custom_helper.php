<?php

function setFlashData($class,$message,$url)
{
    $CI = get_instance();// 獲取 CodeIgniter 框架的實例並將其賦值給 $CI 變量
    $CI->load->library('session');
    $CI->session->set_flashdata('class', $class);
    $CI->session->set_flashdata('message', $message);
    redirect($url);
}

function adminLoggedIn()
{
    $CI = get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('aId')) {
        return true;
    } else {
        return false;
    }
}

function getAdminId()
{
    $CI = get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('aId')) {
        return $CI->session->userdata('aId');
    } else {
        return false;
    }
}


// $this->session->userdata('aId')