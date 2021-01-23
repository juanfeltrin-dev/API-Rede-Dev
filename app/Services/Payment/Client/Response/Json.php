<?php


namespace App\Services\Payment\Client\Response;


use App\Services\Payment\Client\Response\Interfaces\ResponseInterface;

class Json implements ResponseInterface
{
    public function build($response)
    {
        return json_decode($response->getBody()->getContents());
    }
}
