<?php


namespace App\Services\Payment\Gateway\Interfaces;


use Illuminate\Http\Request;

interface TransactionInterface
{
    public function pay(Request $request);
}
