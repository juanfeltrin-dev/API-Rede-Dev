<?php


namespace App\Services\Payment\Gateway\Rede;


use App\Services\Payment\Client\Response\Json;
use App\Services\Payment\Client\Request\Request as ClientRequest;
use App\Services\Payment\Gateway\Interfaces\TransactionInterface;
use Exception;
use Illuminate\Http\Request;

class Transaction implements TransactionInterface
{
    const BASE_URI_REQUEST_SANDBOX      = 'https://api.userede.com.br/desenvolvedores/v1/';
    const BASE_URI_REQUEST_PRODUCTION   = 'https://api.userede.com.br/erede/v1/';

    const SERVICE_TRANSACTION = 'transactions';

    /**
     * @var ClientRequest
     */
    private $_request;

    /**
     * @var Json
     */
    private $_response;

    /**
     * @var array
     */
    private $_header;

    public function __construct(ClientRequest $request, Json $response)
    {
        $this->_request     = $request;
        $this->_header      = [
            'Authorization' => 'Basic ' . base64_encode(env('REDE_PV') . ':' . env('REDE_TOKEN')),
            'content-type'  => 'application/json'
        ];

        $this->_request->setResponse($response);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function pay(Request $request)
    {
        try {
            $this->_request->setBaseUrl(self::BASE_URI_REQUEST_SANDBOX);
            $this->_request->setMethod($this->_request::METHOD_POST);
            $this->_request->setService(self::SERVICE_TRANSACTION);
            $this->_request->setOptions([
                "headers"   => $this->_header,
                "json"      => [
                    "reference" => rand(1000, 9999),
                    "amount" => 2099,
                    "cardholderName" => "John Snow",
                    "cardNumber" => "5448280000000007",
                    "expirationMonth" => 12,
                    "expirationYear" => 2021,
                    "securityCode" => "235"
                ]
            ]);

            return $this->_request->build();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
