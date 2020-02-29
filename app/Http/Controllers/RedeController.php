<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RedeController extends Controller
{
    const BASE_URI = 'https://api.userede.com.br/desenvolvedores/v1/';
    private $authorization;

    public function __construct()
    {
        $this->authorization = 'Basic ' . base64_encode('10005285:e0ed0a851e7c436d8dbe4f5e2ab6ccdf');
    }

    public function getHeader()
    {
        return [
            'Authorization' => $this->authorization,
            'content-type'     => 'application/json'
        ];
    }

    public function getBody()
    {
        return json_encode([
            "reference" => rand(1000, 9999),
            "amount" => 2099,
            "cardholderName" => "John Snow",
            "cardNumber" => "5448280000000007",
            "expirationMonth" => 12,
            "expirationYear" => 2020,
            "securityCode" => "235"
        ]);

    }

    public function index()
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        $res = $client->request('POST', 'transactions', [
            'headers' => $this->getHeader(),
            'body' => $this->getBody()
        ]);

        $data = [
            'payment' => json_decode($res->getBody()->getContents())
        ];

        return view('index', $data);
    }
}
