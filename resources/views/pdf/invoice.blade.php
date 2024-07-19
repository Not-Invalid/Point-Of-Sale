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
            <th>No</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <tr>
            <td>1</td>
            <td>{{ $invoiceData['productName'] }}</td>
            <td>{{ $invoiceData['quantity'] }}</td>
            <td>{{ formatRupiah($invoiceData['unitPrice']) }}</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;">Total</td>
            <td>{{ formatRupiah( $invoiceData['total'] )}}</td>
        </tr>
    </table>
</body>
</html>
