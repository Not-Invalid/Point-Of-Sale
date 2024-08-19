<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Tanda Terima</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .items-table{
            margin-top: 1.5rem;
        }
        .header-table, .details, .items-table, .footer-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }
        .items-table th, .items-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        .footer-table td {
            margin-top: 1rem;
            border: none;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 60%;">
                <h2>PT. Semarak Indonesia</h2>
                <p>Tangerang, Banten, Indonesia</p>
                <p>Tel.: +62-812-3456-7890, Fax.: +62-809-8765-4321</p>
            </td>
            <td style="text-align: right;">
                <h3>BUKTI TANDA TERIMA</h3>
            </td>
        </tr>
    </table>

    <table class="details">
        @foreach($receivingNotes as $note)
        <tr>
            <td>Date: {{ $note->input_date }}</td>
            <td>TO: {{ $note->receiver }}</td>
        </tr>
        @endforeach
    </table>

    <p>Dengan ini kami menyatakan bahwa kami telah menerima sejumlah barang dalam kondisi baik dengan jumlah dan deskripsi sebagai berikut:</p>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item No</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Description</th>
                <th>Remarks/References</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($receivingNotes as $index => $note)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $note->product->product_name }}</td>
                <td>{{ $note->quantity }}</td>
                <td>{{ $note->description }}</td>
                <td>{{ $note->references }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td style="width: 50%;">
                <p>DIKIRIM OLEH / INITIATED BY:</p>
                <p>Name: __________________________</p>
                <p>COP, Signature & Date: __________________________</p>
            </td>
            <td style="width: 50%;">
                <p>DITERIMA OLEH / RECEIVED BY:</p>
                <p>Name: __________________________</p>
                <p>COP, Signature & Date: __________________________</p>
            </td>
        </tr>
    </table>
</body>
</html>
