<?php


namespace App\Services\Payment\Client\Response\Interfaces;


use Psr\Http\Message\ResponseInterface as PrResponseInterface;

interface ResponseInterface
{
    public function build(PrResponseInterface $response);
}
