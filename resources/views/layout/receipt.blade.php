<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bill</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .bill-section {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #f1f1f1;
        }
        ul{
            list-style-type: none;
        }
        .button {
            background-color: Crimson;  
            border-radius: 5px;
            color: white;
            padding: .5em;
            text-decoration: none;
        }

        .button:focus,
        .button:hover {
            background-color: FireBrick;
            color: White;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="bill-header text-center">
            <h3>Billing Page</h3>
        </div>
        <a href="{{url('/')}}" class="button">Back</a>
        <div class="bill-section mt-4">
            <p><strong>Customer Email:</strong> {{ $email }}</p>
            
            <table class="table table-bordered">
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
        </div>

        <div class="mt-4 text-end text">
            <p><strong>Total Price without Tax:</strong> ₹{{ $totalWithoutTax }}</p>
            <p><strong>Total Tax Payable:</strong> ₹{{ $totalTaxPayable }}</p>
            <p><strong>Net Price of Purchased Items:</strong> ₹{{ $netTotal }}</p>
            <p><strong>Rounded Down Value of Net Price:</strong> ₹{{ $roundedNetTotal }}</p>
            <p><strong>Balance Payable to the Customer:</strong> ₹{{ $balance }}</p>
        </div>
        <hr>
        <div class="mt-4 text-end">
            <h6><strong>Balance Denomination:</strong></h6>
            <ul>
                @foreach ($denominationBreakdown as $denomination => $count)
                    <li><strong>₹{{ $denomination }}:</strong> {{ $count }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>
