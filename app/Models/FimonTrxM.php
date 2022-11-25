<?php 

namespace App\Models;

use CodeIgniter\Model;


class FimonTrxM extends Model{
    protected $table = 'transactions';
    protected $allowedFields = ['trxid', 'trx_name', 'trx_type', 'nominal', 'description', 'trx_date', 'trx_time'];
    
    public function post_data_trx($data){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        $this->insert($data);
    }

    public function get_data_trx(){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        return $this->findAll();
    }
    
    public function get_data_trx_by($field, $filter){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        $this->where($field, $filter);
        return $this->find();
    }

    public function put_data_trx($trxid, $newData){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        $keys = array_keys($newData);
        for($i = 0; $i < count($keys); $i++) {
            $this->set($keys[$i], $newData[$keys[$i]] );
        }
        $this->where('trxid', $trxid);
        $this->update();
    }

    public function delete_data_trx($trxid){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        $this->where('trxid', $trxid);
        $this->delete();
    }

}

