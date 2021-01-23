<?php


namespace App\Services\Payment\Gateway\Cielo;


use App\Services\Payment\Client\Response\Json;
use App\Services\Payment\Client\Request\Request as ClientRequest;
use App\Services\Payment\Gateway\Interfaces\TransactionInterface;
use Exception;
use Illuminate\Http\Request;

class Transaction implements TransactionInterface
{
    const BASE_URI_REQUEST_SANDBOX      = 'https://apisandbox.cieloecommerce.cielo.com.br/1/';
    const BASE_URI_REQUEST_PRODUCTION   = 'https://api.cieloecommerce.cielo.com.br/1/';

    const BASE_URI_QUERY_SANDBOX        = 'https://apiquerysandbox.cieloecommerce.cielo.com.br/1/';
    const BASE_URI_QUERY_PRODUCTION     = 'https://apiquery.cieloecommerce.cielo.com.br/1/';

    const SERVICE_TRANSACTION = 'sales';

    /**
     * @var ClientRequest
     */
    private $_request;

    /**
     * @var array
     */
    private $_header;

    public function __construct(ClientRequest $request, Json $response)
    {
        $this->_request     = $request;
        $this->_header      = [
            'MerchantId'    => env('CIELO_MERCHANT_ID'),
            'MerchantKey'   => env('CIELO_MERCHANT_KEY'),
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
                ]
            ]);

            return $this->_request->build();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
