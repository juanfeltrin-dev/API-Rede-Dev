<?php


namespace App\Http\Controllers;



use App\Services\Payment\Factory\TransactionFactory;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function pay(Request $request, TransactionFactory $transactionFactory)
    {
        try {
            $transaction = $transactionFactory->build($request->type);
            $transaction->pay($request);

            return redirect()->route('pay.form')->with('success', 'Pago!');
        } catch (\Exception $exception) {
            return redirect()->route('pay.form')->with('error', $exception->getMessage());
        }
    }
}
