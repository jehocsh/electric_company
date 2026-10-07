<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerAccountModel extends Model
{
    protected $table            = 'customer_accounts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Fields matching the new database structure
    protected $allowedFields    = [
        'account_number', 
        'customer_name', 
        'address', 
        'phone', 
        'email', 
        'meter_number', 
        'connection_type', 
        'status'
    ];

    // Enable automatic timestamp updates for created_at and updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function searchAccounts($keyword, $perPage) {
        return $this->groupStart()
                    ->like('customer_name', $keyword)
                    ->orLike('account_number', $keyword)
                    ->orLike('email', $keyword)
                    ->orLike('phone', $keyword)
                    ->groupEnd()
                    ->paginate($perPage);
    }

    public function getAccountsByStatus($status, $perPage) {
        return $this->where('status', $status)->paginate($perPage);
    }

    public function getAccountsByType($type, $perPage) {
        return $this->where('connection_type', $type)->paginate($perPage);
    }

    public function getAccountsPaginated($perPage) {
        return $this->paginate($perPage);
    }

    public function getTotalAccounts() {
        return $this->countAllResults();
    }

    public function getCountByStatus($status) {
        return $this->where('status', $status)->countAllResults();
    }
}