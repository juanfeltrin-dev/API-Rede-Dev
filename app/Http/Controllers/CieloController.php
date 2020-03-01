<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CieloController extends Controller
{
    const BASE_URI = 'https://apisandbox.cieloecommerce.cielo.com.br';
    private $merchantId;
    private $merchantKey;

    public function __construct()
    {
        $this->merchantId = '6a3bc4d2-8839-45fb-866f-0a279bb4a67f';
        $this->merchantKey = 'BIXZTYYMIVKSHIMBHLJLFXEEMNKICEESGCBONJRS';
    }

    public function getHeader()
    {
        return [
            'MerchantId' => $this->merchantId,
            'MerchantKey' => $this->merchantKey,
            'content-type'     => 'application/json'
        ];
    }

    public function getBody()
    {
        return json_encode([
           "MerchantOrderId" => rand(1000, 9999),
           "Customer" => [
                "Name" => "Comprador crédito simples"
           ],
           "Payment" => [
             "Type" => "CreditCard",
             "Amount" => 15700,
             "Installments" => 1,
             "SoftDescriptor" => "123456789ABCD",
             "CreditCard" => [
                 "CardNumber" => "1234123412341231",
                 "Holder" => "Teste Holder",
                 "ExpirationDate" => "12/2030",
                 "SecurityCode" => "123",
                 "Brand" => "Visa",
                 "CardOnFile" => [
                    "Usage" =>  "Used",
                    "Reason" => "Unscheduled"
                 ]
             ]
           ]
        ]);

    }

    public function index()
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        $res = $client->request('POST', '/1/sales/', [
            'headers' => $this->getHeader(),
            'body' => $this->getBody()
        ]);

        $data = [
            'payment' => json_decode($res->getBody()->getContents())
        ];

        dd($data['payment']);

        return view('index', $data);
    }
}
