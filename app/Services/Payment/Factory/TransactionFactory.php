<?php


namespace App\Services\Payment\Factory;


use App\Services\Payment\Gateway\Cielo\Transaction as CieloTransaction;
use App\Services\Payment\Gateway\Interfaces\TransactionInterface;
use App\Services\Payment\Gateway\Rede\Transaction as RedeTransaction;
use Exception;

class TransactionFactory
{
    /**
     * @var CieloTransaction
     */
    private $_cieloTransaction;

    /**
     * @var RedeTransaction
     */
    private $_redeTransaction;

    public function __construct(
        CieloTransaction $cieloTransaction,
        RedeTransaction $redeTransaction
    )
    {
        $this->_cieloTransaction    = $cieloTransaction;
        $this->_redeTransaction     = $redeTransaction;
    }

    /**
     * @param string $type
     * @return TransactionInterface
     * @throws Exception
     */
    public function build(string $type)
    {
        switch ($type) {
            case 'cielo':
                return $this->_cieloTransaction;
                break;
            case 'rede':
                return $this->_redeTransaction;
                break;
            default:
                throw new Exception("payment method not supported");
                break;
        }
    }
}
