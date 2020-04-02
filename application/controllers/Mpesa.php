<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Mpesa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mpesaService');
    }

    public function payment()
    {
        error_log(json_encode($this->input->raw_input_stream));
    }

    public function test()
    {
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
        } else {
            $phoneNumber = $this->input->post('mpesa_test_phone_number');
            $formattedPhoneNumber = '254' . substr($phoneNumber, 1);
            $this->mpesaService->simulateC2BPayment($formattedPhoneNumber);
        }

    }
}