<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Mpesa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mpesaService');
        $this->load->model('mpesa_model');
    }

    public function payment()
    {
        error_log(json_encode($this->input->raw_input_stream));
        if (! $this->checkPaymentRequestValid($this->input->raw_input_stream)) {
            echo json_encode([
                "ResponseCode" => "1",
                "ResponseDesc" => "Invalid Request Body"
            ]);
            return;
        }

        echo json_encode([
            "ResponseCode" => "0",
            "ResponseDesc" => "success"
        ]);

        $response = json_decode($this->input->raw_input_stream);

        $this->mpesa_model->savePayment([
            'transaction_id' => $response->TransID,
            'amount' => $response->TransAmount,
            'payer_phone_number' => $response->MSISDN,
            'payer_first_name' => $response->FirstName,
            'payer_middle_name' => $response->MiddleName,
            'payer_last_name' => $response->LastName
        ]);
    }

    private function checkPaymentRequestValid($responseBody)
    {
        if (! $jsonResponseBody = json_decode($responseBody))
            return false;

//        show_error($jsonResponseBody->TransId);

        return isset($jsonResponseBody->TransID) &&
            isset($jsonResponseBody->TransAmount) &&
            isset($jsonResponseBody->MSISDN) &&
            isset($jsonResponseBody->FirstName) &&
            isset($jsonResponseBody->MiddleName) &&
            isset($jsonResponseBody->LastName);
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