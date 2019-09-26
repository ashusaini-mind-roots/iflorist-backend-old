<?php


namespace App\Services;


use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class MerchantService
{

    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    public function createCustomer(
        $email, $company_name, $source, $address
    )
    {
        $company = Customer::create([
            'email' => $email,
            'source' => $source,
            'name' => $company_name,
            'address' => $address
        ]);
        return $company;
    }

    public function deleteCustomer($customerID)
    {
        $Customer = Customer::retrieve($customerID);
        $result = $Customer->delete();
        return $result->isDeleted();
    }

    public function updateCustomer()
    {
    }

    public function findCustomer()
    {
    }

    public function listAllCustomer()
    {
    }


    public function createCard(
        $token, $billing_details, $type = 'card'
    )
    {
        $PaymentMethod = PaymentMethod::create([
            'card' => ['token' => $token],
            'billing_details' => $billing_details,
            'type' => $type,
        ]);
    }

    public function deleteCard()
    {
    }

    public function updateCard()
    {
    }

    public function findCard()
    {
    }

    public function listAllCard()
    {
    }

    public function createCharge()
    {
    }

    public function captureCharge()
    {
    }

    public function updateCharge()
    {
    }

    public function findCharge()
    {
    }

    public function listAllCharge()
    {
    }
}
