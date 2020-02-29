<p>Situação: {{$payment->returnMessage}}</p>
<p>Cartão: {{$payment->cardBin}} ****** {{$payment->last4}}</p>
<p>Data da Transação: {{date("d/m/Y H:i:s", strtotime($payment->dateTime))}}</p>
