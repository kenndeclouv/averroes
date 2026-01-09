<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <h2>School Inventory Report</h2>
        <p>Generated on: {{ date('d M Y H:i') }}</p>
    </div>

    <button class="no-print" onclick="window.print()"
        style="padding: 10px 20px; cursor: pointer; margin-bottom: 20px;">Print Report</button>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Code</th>
                <th>Name</th>
                <th>Room</th>
                <th>Condition</th>
                <th>Quantity</th>
                <th>Location Detail</th>
                <th>Purchase Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventories as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->room->name ?? '-' }}</td>
                    <td>{{ $item->condition }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->location ?? '-' }}</td>
                    <td>{{ $item->purchase_date->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
