<!DOCTYPE html>
<html>
<head>
    <title>Income Report</title>
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
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Date: {{ $date }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Transaction Number</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->transaction_number }}</td>
                    <td>{{ $transaction->product_name }}</td>
                    <td>{{ $transaction->qty }}</td>
                    <td>{{ formatRupiah($transaction->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: center;"><strong>Total Pemasukan</strong></td>
                <td><strong>{{ formatRupiah($totalIncome) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
