<table class="table table-responsive" id="transactions-table">
    <thead>
        <tr>
        <th>Qrcode</th>
        <th>Buyer</th>
        <th>Method</th>
        <th>Amount</th>
        <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            
            <td>
             <a href="{!! route('transactions.show', [$transaction->id]) !!}">
                {!! $transaction->qrcode['product_name'] !!}
             </a>
            </td>
            <td>{!! $transaction->user['name'] !!}</td>
            <td>{!! $transaction->payment_method !!}</td>
            <td>${!! $transaction->amount !!}</td>
            <td>{!! $transaction->status !!}</td>
            
        </tr>
    @endforeach
    </tbody>
</table>