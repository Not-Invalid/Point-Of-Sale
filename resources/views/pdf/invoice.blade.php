<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .header {
            color: black;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
    </div>
    <p>Invoice Id: {{ $invoiceData['invoiceId'] }}</p>
    <p>Transaction date: {{ $invoiceData['transactionDate'] }}</p>

    <table style="width:100%">
        <tr>
            <th>Product Name</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <tr>
            <td>{{ $invoiceData['productName'] }}</td>
            <td>{{ $invoiceData['id_brand'] }}</td>
            <td>{{ $invoiceData['id_category'] }}</td>
            <td>{{ $invoiceData['quantity'] }}</td>
            <td>{{ formatCurrency($invoiceData['unitPrice'], session('selectedCurrency', 'IDR')) }}</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center; font-weight:600">Total</td>
            <td>{{ formatCurrency($invoiceData['total'], session('selectedCurrency', 'IDR')) }}</td>
        </tr>
    </table>
</body>
</html>
