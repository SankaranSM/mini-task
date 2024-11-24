<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <h3>Billing Receipt - Thanks for purchasing</h3>
        <p><strong>Customer Email:</strong> {{ $email }}</p>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Purchase Price</th>
                    <th>Tax %</th>
                    <th>Tax Payable</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($billDetails as $item)
                    <tr>
                        <td>{{ $item['product_id'] }}</td>
                        <td>₹{{ $item['unit_price'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>₹{{ $item['purchase_price'] }}</td>
                        <td>{{ $item['tax_rate'] }}%</td>
                        <td>₹{{ $item['tax_payable'] }}</td>
                        <td>₹{{ $item['total_price'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Total Without Tax:</strong> ₹{{ $totalWithoutTax }}</p>
        <p><strong>Total Tax Payable:</strong> ₹{{ $totalTaxPayable }}</p>
        <p><strong>Net Total:</strong> ₹{{ $netTotal }}</p>
        <p><strong>Rounded Total:</strong> ₹{{ $roundedNetTotal }}</p>
        <p><strong>Balance:</strong> ₹{{ $balance }}</p>
        <hr>
        <h4>Balance Denomination:</h4>
        <ul>
            @foreach ($denominationBreakdown as $denomination => $count)
                <li>₹{{ $denomination }}: {{ $count }}</li>
            @endforeach
        </ul>
    </body>
</html>