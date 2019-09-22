<?php


namespace App\Services;


use Stripe\Customer;
use Stripe\Stripe;

class MerchantService
{

    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    public function createCustomer($source,$email)
    {
        $company = Customer::create([
            'source'=>$source,
            'email'=>$email
        ]);
    }

    public function deleteCustomer(){}
    public function updateCustomer(){}
    public function findCustomer(){}
    public function listAllCustomer(){}

    public function createCard(){}
    public function deleteCard(){}
    public function updateCard(){}
    public function findCard(){}
    public function listAllCard(){}

    public function createCharge(){}
    public function captureCharge(){}
    public function updateCharge(){}
    public function findCharge(){}
    public function listAllCharge(){}
}
