<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th, td {
            text-align: center;
        }

        th{
            font-size: 14px;
        }

        td {
            font-size: 13px
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Date: {{ $date }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Transaction Date</th>
                <th>Transaction Number</th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                    <td>{{ $transaction->transaction_number }}</td>
                    <td>{{ $transaction->product_name }}</td>
                    <td>{{ $transaction->brand->brand_name }}</td>
                    <td>{{ $transaction->category->category_name }}</td>
                    <td>{{ $transaction->qty }}</td>
                    <td>{{ formatCurrency($transaction->total, session('selectedCurrency', 'IDR')) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7" style="text-align: center; font-weight:600">Total Sales</td>
                <td><strong>{{ formatCurrency($totalIncome, session('selectedCurrency', 'IDR')) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
