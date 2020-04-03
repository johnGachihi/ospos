<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mpesa_model extends CI_Model
{
    public function savePayment(array $payment)
    {
        $this->db->insert('mpesa_payments', $payment);
    }
}