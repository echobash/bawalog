<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nith extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        // Your own constructor code
    }

    public function index()
    {
        try {
            $user_id = $this->input->get('user_id') ? $this->input->get('user_id') : 1;
            $this->load->model('user_model');
            $this->load->model('birthday_wishes_model');
            $data['user'] = $this->user_model->getUserData($user_id);
            $data['inboxWishes'] = $this->birthday_wishes_model->getBirthdaysWishes($user_id, "inbox");
            $data['outboxWishes'] = $this->birthday_wishes_model->getBirthdaysWishes($user_id, "outbox");
            //echo "<pre>";print_r($data);die;
            $data['user_id']=$user_id;
            $this->load->view('nith/index', $data);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function saveData()
    {
        try {
            $user_id = $this->input->post('user_id');
            $about = $this->input->post('about');
            $this->load->model('user_model');
            if ($user_id && $about) {
                $data = array('about' => $about);
                $result = $this->user_model->saveData($data, $user_id);
                if ($result) {
                    $resp['status'] = "success";
                } else {
                    $resp['status'] = "fail";
                }
                echo json_encode($resp);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function sendMessage()
    {
        try {
            $user_id = $this->input->post('user_id');
            $wisher_id = $this->input->post('wisher_id');
            $message = $this->input->post('message');
            $to = $this->input->post('email');
            $this->load->model('birthday_wishes_model');
            // echo "<pre>";print_r($_POST);die;
            if ($user_id && $message && $wisher_id) {
                $data = array('user_id' => $user_id, 'wisher_id' => $wisher_id, 'message' => $message);
                // $result = $this->birthday_wishes_model->saveMessage($data);
                $this->email->from('greenywish@gmail.com');
                $this->email->to("anwarali377@gmail.com");
                $this->email->subject('very crucial email');
                $this->email->message('writing a crucial mail that you must receive');
                $this->email->set_header('get it fast', 'ok i will');
                $email_status =$this->email->send();
                $this->email->print_debugger();
                echo "<pre>";var_dump($email_status);die;
                if ($result) {
                    $resp['status'] = "success";
                    echo "<pre>";print_r($email_status);die;
                } else {
                    $resp['status'] = "fail";
                }
                echo json_encode($resp);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function friendList()
    {
        try {
            $data['title'] = "Friend List";
            $data['user_id'] = $this->input->get('user_id');
            $this->load->model('user_model');
            $data['user'] = $this->user_model->getFriendList($data['user_id']);
            $this->load->view('nith/friendList', $data);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
