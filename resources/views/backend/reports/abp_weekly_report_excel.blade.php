<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Abp Weekly Report</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td colspan="{{($abp_weekly_data['total_reviews'] * 2) + 6}}" style="text-align: center;"> APB Weekly Report: {{ date('Y-m-d') }}</td>
            </tr>
            <tr>
                <td style="width: 50px;border:1px solid black; background-color:#ffff00;">Sr. No</td>
                <td style="width: 150px;border:1px solid black; background-color: #ffff00;">Client</td>
                <td style="width: 50px;border:1px solid black; background-color:#ffff00;">CI</td>
                <td style="width: 150px;border:1px solid black; background-color: #ffff00;">Order Value</td>
                <td style="width: 150px;border:1px solid black; background-color:#ffff00;">Product</td>
                <td style="width: 150px;border:1px solid black; background-color:#ffff00;">Probability</td>

                @for($i = 0; $i < $abp_weekly_data['total_reviews']; $i++)
                    <td style="width: 150px;border: 1px solid black; background-color:#ffff00;">Remarks</td>
                    <td style="width: 150px;border: 1px solid black; background-color:#ffff00;">{{ $abp_weekly_data['ceo_details']['nick_name'] ?? 'CEO' }} Remark</td>
                @endfor
            </tr>
        </thead>
        <tbody>
            @php
                $sr_no = 1;
            @endphp
            @foreach($abp_weekly_data['report_data'] as $key => $value)
                <tr>
                    <td style="border:0px solid black;">{{ $sr_no }}</td>
                    <td style="border:0px solid black;">{{ $value['client_name'] }}</td>
                    <td style="border:0px solid black;">{{ $value['case_incharge']['nick_name'] }}</td>
                    <td style="border:0px solid black;">{{ $value['order_value_budget']}}</td>
                    <td style="border:0px solid black;">{{ $value['product']['product_name'] }}</td>
                    <td style="border:0px solid black;">{{ $value['latest_record']['probability'] ?? '' }}</td>

                    @for($i = 0; $i < $abp_weekly_data['total_reviews']; $i++)
                        @if(isset($value['case_history'][$i]['remark_time_expected']))
                            <td style="border:0px solid black;"> Remark On {{ date('Y-m-d', strtotime($value['case_history'][$i]['created_at'])) }}:
                                <br>{{ ($value['case_history'][$i]['remark_time_expected']) ?? '-' }}
                            </td>
                        @else
                            <td style="border:0px solid black;">-</td>
                        @endif
                        @if(isset($value['case_history'][$i]['ceo_reviewal_remark']))
                            <td style="border:0px solid black;"> Remark On {{ $value['case_history'][$i]['ceo_reviewal_date'] }}:
                                <br>{{ ($value['case_history'][$i]['ceo_reviewal_remark']) ?? '-' }}
                            </td>
                        @else
                            <td style="border:0px solid black;">-</td>
                        @endif
                    @endfor
                    @php
                        $sr_no++;
                    @endphp
                </tr>
            @endforeach
            @php
            @endphp
        </tbody>
    </table>
</body>
</html>
