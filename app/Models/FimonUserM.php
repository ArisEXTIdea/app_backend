<?php 

namespace App\Models;

use CodeIgniter\Model;


class FimonUserM extends Model{
    protected $table = 'users';
    protected $allowedFields = ['uid', 'name', 'email', 'photo', 'user_level', 'account_type'];
    
    
    public function post_data_user($data){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        $this->insert($data);
    }

    public function get_data_users(){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        return $this->findAll();
    }
    
    public function get_data_user_by($field, $filter){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        $this->where($field, $filter);
        return $this->find();
    }

    public function put_data_user($uid, $newData){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        $keys = array_keys($newData);
        for($i = 0; $i < count($keys); $i++) {
            $this->set($keys[$i], $newData[$keys[$i]] );
        }
        $this->where('uid', $uid);
        $this->update();
    }

    public function delete_data_user($uid){
        $this->setDatabase(getenv('FIMON_DATABASE'));
        $this->where('uid', $uid);
        $this->delete();
    }

}

