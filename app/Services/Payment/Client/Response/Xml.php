<?php


namespace App\Services\Payment\Client\Response;


use App\Services\Payment\Client\Response\Interfaces\ResponseInterface;

class Xml implements ResponseInterface
{
    public function build($response)
    {
        return json_decode(simplexml_load_string($response->getBody()->getContents()));
    }
}
