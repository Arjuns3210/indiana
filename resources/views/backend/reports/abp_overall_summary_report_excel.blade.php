<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>APB Overall Summary Report</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td colspan="5" style="text-align: center;"> APB Overall Summary Report: </td>
            </tr>
            <tr>
                <td style="width: 50px;border:1px solid black; background-color:#ffff00;">Sr. No</td>
                <td style="width: 150px;border:1px solid black; background-color: #ffff00;">Client Name</td>
                <td style="width: 100px;border:1px solid black; background-color:#ffff00;">Case incharge</td>
                <td style="width: 150px;border:1px solid black; background-color: #ffff00;">NM</td>
                <td style="width: 150px;border:1px solid black; background-color:#ffff00;">Product</td>
            </tr>
        </thead>
        <tbody>
            @foreach($overall_summary_data as $key => $value)
            <tr>
                <td style="border:1px solid black;">{{$key+1}}</td>
                <td style="border:1px solid black;">{{$value->client_name}}</td>
                <td style="border:1px solid black;">{{$value->case_incharge['admin_name'] ?? ''}}</td>
                <td style="border:1px solid black;">{{$value->net_margin_budget}}</td>
                <td style="border:1px solid black;">{{$value->product->product_name}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
