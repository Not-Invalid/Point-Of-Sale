<!DOCTYPE html>
<html>
<head>
    <title>Product Report</title>
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
                <th>Product</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->product_name }}</td>
                    <td>{{ $transaction->brand->brand_name }}</td>
                    <td>{{ $transaction->category->category_name }}</td>
                    <td>{{ $transaction->qty }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: center;"><strong>Total Barang Terjual</strong></td>
                <td><strong>{{ $totalQty }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
