<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \App\Models\FimonM;
use CodeIgniter\RESTful\ResourceController;

class FimonC extends BaseController
{
    use ResponseTrait;
    protected $FimonM;

    public function __construct()
    {
        $this->FimonM = new FimonM();
        helper(['auth', 'link']);
    }

    public function post_data_user(){
        $apiKey = $this->request->header('key')->getValue();

        if(checkKey($apiKey)){
            $userData = [
                'uid' => uniqid(),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'photo' => $this->request->getPost('photo'),
                'user_level' => 0,
                'account_type' => 0,
            ];
    
            if(!$this->FimonM->post_data_user($userData)){
                $respond = [
                    'message' => 'Success - User Created',
                    'data' => $userData
                ];
                return $this->respondCreated($respond, 201);
            } else {
                return $this->fail('Request Failed', 400);
            }
        } else {
            return $this->failForbidden('Access Denied', 403);
        }

    }

    public function get_data_users(){
        $apiKey = $this->request->header('key')->getValue();
        

        if(checkKey($apiKey)){
            if($this->FimonM->get_data_users()){
                $respond = [
                    'message' => 'Success',
                    'data' => $this->FimonM->get_data_users()
                ];

                return $this->respond($respond, 200);
            }
        } else {
            return $this->failForbidden('Access Denied', 403);
        }
    }

    public function get_data_user_by(){
        $apiKey = $this->request->header('key')->getValue();
        $url = urlToArrayReverse();
        $field = $url[1];
        $filter = $url[0];

        if(checkKey($apiKey)){
            if($this->FimonM->get_data_user_by($field, $filter)){
                $respond = [
                    'message' => 'Success',
                    'data' => $this->FimonM->get_data_user_by($field, $filter)
                ];

                return $this->respond($respond, 200);
            }
            else{
                return $this->failNotFound();
            }
        } else {
            return $this->failForbidden('Access Denied', 403);
        }
    }

    public function put_data_user() {
        $apiKey = $this->request->header('key')->getValue();
        $url = urlToArrayReverse();
        $uid = $url[0];

        if(checkKey($apiKey)){
            if($this->FimonM->get_data_user_by('uid', $uid)){
                $newData = $this->request->getRawInput();

                if(!$this->FimonM->put_data_user($uid, $newData)){
                    $respond = [
                        'message'=> 'Success',
                        'data'=> $this->FimonM->get_data_user_by('uid', $uid)
                    ];
                    return $this->respondUpdated($respond, 200);
                } else {
                    return $this->fail('Failed', 500);
                }

            }
            else{
                return $this->failNotFound();
            }
        } else {
            return $this->failForbidden('Access Denied', 403);
        }
    }

    public function delete_data_user(){
        $apiKey = $this->request->header('key')->getValue();
        $url = urlToArrayReverse();
        $uid = $url[0];

        if(checkKey($apiKey)){
            if($this->FimonM->get_data_user_by('uid', $uid)){
                if(!$this->FimonM->delete_data_user($uid)){
                    return $this->respond('Deleting Success');
                } else{
                    return $this->fail('Failed', 500);
                }
            }
        } else {
            return $this->failForbidden('Access Denied', 403);
        }
    }
}
