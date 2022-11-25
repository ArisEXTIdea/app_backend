<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \App\Models\FimonUserM;
use \App\Models\FimonTrxM;
use CodeIgniter\RESTful\ResourceController;

class FimonC extends BaseController
{
    use ResponseTrait;
    protected $FimonUserM;
    protected $FimonTrxM;

    public function __construct()
    {
        $this->FimonUserM = new FimonUserM();
        $this->FimonTrxM = new FimonTrxM();
        helper(['auth', 'link']);
    }

    // =============================================================================== //
    //                              -- Users API --                                    //
    // =============================================================================== //

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
    
            if(!$this->FimonUserM->post_data_user($userData)){
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
            if($this->FimonUserM->get_data_users()){
                $respond = [
                    'message' => 'Success',
                    'data' => $this->FimonUserM->get_data_users()
                ];

                return $this->respond($respond, 200);
            }
            else {
                return $this->failNotFound();
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
            if($this->FimonUserM->get_data_user_by($field, $filter)){
                $respond = [
                    'message' => 'Success',
                    'data' => $this->FimonUserM->get_data_user_by($field, $filter)
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
            if($this->FimonUserM->get_data_user_by('uid', $uid)){
                $newData = $this->request->getRawInput();

                if(!$this->FimonUserM->put_data_user($uid, $newData)){
                    $respond = [
                        'message'=> 'Success',
                        'data'=> $this->FimonUserM->get_data_user_by('uid', $uid)
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
            if($this->FimonUserM->get_data_user_by('uid', $uid)){
                if(!$this->FimonUserM->delete_data_user($uid)){
                    return $this->respond('Deleting Success');
                } else{
                    return $this->fail('Failed', 500);
                }
            }
            else {
                return $this->failNotFound();
            }
        } else {
            return $this->failForbidden('Access Denied', 403);
        }
    }

    
    // =============================================================================== //
    //                              -- TRANSACTIONS API --                             //
    // =============================================================================== //

    public function post_data_trx(){
        $apiKey = $this->request->header('key')->getValue();

        if(checkKey($apiKey)){
            $trxData = [
                'trxid' => 'trx-' . uniqid(),
                'trx_name' => $this->request->getPost('trx_name'),
                'trx_type' => $this->request->getPost('trx_type'),
                'nominal' => $this->request->getPost('nominal'),
                'description' => $this->request->getPost('description'),
                'trx_date' => $this->request->getPost('trx_date'),
                'trx_time' => $this->request->getPost('trx_time'),
            ];
    
            if(!$this->FimonTrxM->post_data_trx($trxData)){
                $respond = [
                    'message' => 'Success - Transaction Created',
                    'data' => $trxData
                ];
                return $this->respondCreated($respond, 201);
            } else {
                return $this->fail('Request Failed', 400);
            }
        } else {
            return $this->failForbidden('Access Denied', 403);
        }

    }

    public function get_data_trx(){
        $apiKey = $this->request->header('key')->getValue();
        
        if(checkKey($apiKey)){
            if($this->FimonTrxM->get_data_trx()){
                $respond = [
                    'message' => 'Success',
                    'data' => $this->FimonTrxM->get_data_trx()
                ];

                return $this->respond($respond, 200);
            }
            else {
                return $this->failNotFound();
            }
        } else {
            return $this->failForbidden('Access Denied', 403);
        }
    }

    public function get_data_trx_by(){
        $apiKey = $this->request->header('key')->getValue();
        $url = urlToArrayReverse();
        $field = $url[1];
        $filter = $url[0];

        if(checkKey($apiKey)){
            if($this->FimonTrxM->get_data_trx_by($field, $filter)){
                $respond = [
                    'message' => 'Success',
                    'data' => $this->FimonTrxM->get_data_trx_by($field, $filter)
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

    public function put_data_trx() {
        $apiKey = $this->request->header('key')->getValue();
        $url = urlToArrayReverse();
        $trxid = $url[0];

        if(checkKey($apiKey)){
            if($this->FimonTrxM->get_data_trx_by('trxid', $trxid)){
                $newData = $this->request->getRawInput();

                if(!$this->FimonTrxM->put_data_trx($trxid, $newData)){
                    $respond = [
                        'message'=> 'Success',
                        'data'=> $this->FimonTrxM->get_data_trx_by('trxid', $trxid)
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

    public function delete_data_trx(){
        $apiKey = $this->request->header('key')->getValue();
        $url = urlToArrayReverse();
        $trxid = $url[0];

        if(checkKey($apiKey)){
            if($this->FimonTrxM->get_data_trx_by('trxid', $trxid)){
                if(!$this->FimonTrxM->delete_data_trx($trxid)){
                    return $this->respond('Deleting Success');
                } else{
                    return $this->fail('Failed', 500);
                }
            }
            else {
                return $this->failNotFound();
            }
        } else {
            return $this->failForbidden('Access Denied', 403);
        }
    }
}
