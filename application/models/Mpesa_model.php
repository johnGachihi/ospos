<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mpesa_model extends CI_Model
{
    public function savePayment(array $payment)
    {
        $this->db->insert('mpesa_payments', $payment);
    }

    public function search_payments(SearchParam $search_param, string $search_query): array
    {
        $column = $this->getDatabaseColumn($search_param);
        $this->db->where($column, $search_query);
        $this->db->where('status', 'pending');
        $this->db->where('created_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
        $query = $this->db->get('mpesa_payments');
        return $query->result();
    }

    private function getDatabaseColumn(SearchParam $param): string {
        switch (true) {
            case $param instanceof AMOUNT:
                return 'amount';
            case $param instanceof TRANSACTION_ID:
                return 'transaction_id';
            case $param instanceof PHONE_NUMBER:
                return 'payer_phone_number';
            default:
                throw new InvalidArgumentException('Invalid SearchParam provided');
        }
    }
}




class SearchParam {}
class AMOUNT extends SearchParam {}
class TRANSACTION_ID extends SearchParam {}
class PHONE_NUMBER extends SearchParam {}