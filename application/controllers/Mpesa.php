<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Mpesa extends Secure_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mpesaService');
    }

    public function test() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'mpesa_test_phone_number',
            'Mpesa phone number for test',
            'regex_match[/^0([0-9]){9}$/]'
        );

        if ($this->form_validation->run() === false) {
            echo json_encode([
                'success' => false,
                'message' => $this->form_validation->error('mpesa_test_phone_number')
            ]);
        }

        $this->mpesaService->simulateC2BPayment(
            $this->input->post('mpesa_test_phone_number'));
    }
}