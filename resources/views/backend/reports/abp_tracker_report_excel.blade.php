<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$fileName}}</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th style="width: 130px;height: 50px;border: 2px solid black"></th>
        <th colspan="4"
            style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ $headingName ?? '' }}</th>
    </tr>
    <tr>
        <th style="width: 100px;border: 2px solid black"></th>
        <th style="width: 100px;border: 2px solid black"><b>Sales</b></th>
        <th style="width: 100px;border: 2px solid black"><b>NM</b></th>
        <th style="width: 100px;border: 2px solid black"><b>Margin Rs.</b></th>
        <th style="width: 100px;border: 2px solid black"><b>Credit Days</b></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="background-color: #E0E0E0;border: 2px solid black">{{ $regionName }} Region</td>
        <td style="border: 2px solid black"></td>
        <td style="border: 2px solid black"></td>
        <td style="border: 2px solid black"></td>
        <td style="border: 2px solid black"></td>
    </tr>

    @foreach($trackerData as $budgetType => $abpData)
        @if($budgetType == 'expected')
            {{--Expected budget data --}}
            <tr>
                <td style="border: 2px solid black"><b>Expected</b></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
            </tr>
            @foreach($abpData as $data)
                <tr>
                    <td style="border: 2px solid black">{{ $data->product_name ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->sales_sum ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->net_margin_sum ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->calculated_margin_rs ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->total_credit_days_sum }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="border: 2px solid black"><b>Total Expected</b></td>
                <td style="border: 2px solid black"><b>{{  $trackerData[$budgetType]->sum('sales_sum') }}</b></td>
                <td style="border: 2px solid black"><b>{{ $trackerData[$budgetType]->sum('net_margin_sum')}}</b></td>
                <td style="border: 2px solid black"><b>{{ $trackerData[$budgetType]->sum('calculated_margin_rs')}}</b>
                </td>
                <td style="border: 2px solid black"><b>{{ $trackerData[$budgetType]->sum('total_credit_days_sum')}}</b>
                </td>
            </tr>
            <tr>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
            </tr>
        @endif

        @if($budgetType == 'miscellaneous')
            {{--MISC budget data --}}
            <tr>
                <td style="border: 2px solid black"><b>Misc</b></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
            </tr>
            @foreach($abpData as $data)
                <tr>
                    <td style="border: 2px solid black">{{ $data->product_name ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->sales_sum ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->net_margin_sum ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->calculated_margin_rs ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->total_credit_days_sum }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="border: 2px solid black"><b>Total Misc</b></td>
                <td style="border: 2px solid black"><b>{{  $trackerData[$budgetType]->sum('sales_sum') }}</b></td>
                <td style="border: 2px solid black"><b>{{ $trackerData[$budgetType]->sum('net_margin_sum')}}</b></td>
                <td style="border: 2px solid black">
                    <b>{{ $trackerData[$budgetType]->sum('calculated_margin_rs')}}</b>
                </td>
                <td style="border: 2px solid black"><b>{{ $trackerData[$budgetType]->sum('total_credit_days_sum')}}</b>
                </td>
            </tr>
            <tr>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
            </tr>
        @endif

        @if($budgetType == 'new')
            {{--New budget data --}}
            <tr>
                <td style="border: 2px solid black"><b>New</b></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
            </tr>
            @foreach($abpData as $data)
                <tr>
                    <td style="border: 2px solid black">{{ $data->product_name ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->sales_sum ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->net_margin_sum ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->calculated_margin_rs ?? '-' }}</td>
                    <td style="border: 2px solid black">{{ $data->total_credit_days_sum }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="border: 2px solid black"><b>Total New</b></td>
                <td style="border: 2px solid black"><b>{{  $trackerData[$budgetType]->sum('sales_sum') }}</b></td>
                <td style="border: 2px solid black"><b>{{ $trackerData[$budgetType]->sum('net_margin_sum')}}</b></td>
                <td style="border: 2px solid black">
                    <b>{{ $trackerData[$budgetType]->sum('calculated_margin_rs')}}
                    </b>
                </td>
                <td style="border: 2px solid black"><b>{{ $trackerData[$budgetType]->sum('total_credit_days_sum')}}</b>
                </td>
            </tr>
            <tr>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
            </tr>
        @endif

        @if($loop->last)
            <tr>
                <td style="border: 2px solid black"><b>Total {{ $regionName }}</b></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
            </tr>
            @php
                $endTotalData =  calculateAbpTrackerData($trackerData);
            @endphp
            @foreach($endTotalData as $data)
                <tr>
                    <td style="background-color:#ffff00;border: 2px solid black">{{ $data['product_name'] ?? '-' }}</td>
                    <td style="background-color:#ffff00;border: 2px solid black">{{ $data['sales_sum'] ?? '-' }}</td>
                    <td style="background-color:#ffff00;border: 2px solid black">{{ $data['net_margin_sum'] ?? '-' }}</td>
                    <td style="background-color:#ffff00;border: 2px solid black">{{ $data['calculated_margin_rs'] ?? '-' }}</td>
                    <td style="background-color:#ffff00;border: 2px solid black">{{ $data['total_credit_days_sum'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="border: 2px solid black"><b>Total {{ $regionName }}</b></td>
                <td style="border: 2px solid black"><b>{{  $endTotalData->sum('sales_sum') }}</b>
                </td>
                <td style="border: 2px solid black"><b>{{ $endTotalData->sum('net_margin_sum')}}</b>
                </td>
                <td style="border: 2px solid black"><b>{{ $endTotalData->sum('calculated_margin_rs')}}</b></td>
                <td style="border: 2px solid black">
                    <b>{{ $endTotalData->sum('total_credit_days_sum')}}</b>
                </td>
            </tr>
            <tr>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
            </tr>
        @endif
    @endforeach

    @if($ciBudgetData->count())
        @foreach($ciBudgetData as $ciName => $allBudgetData)
            <tr>
                <td style="background-color: #E0E0E0;border: 2px solid black">{{ $ciName ?? '' }}</td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
                <td style="border: 2px solid black"></td>
            </tr>
            @foreach($allBudgetData as $budgetName => $budgetData)
                {{--Expected budget data --}}
                @if($budgetName == 'expected')
                    <tr>
                        <td style="border: 2px solid black"><b>Expected</b></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                    </tr>
                    @foreach(checkProductIsExist($budgetData,$budgetName ,$ciName) as $data)
                        <tr>
                            <td style="border: 2px solid black">{{ $data['product_name'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['sales_sum'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['net_margin_sum'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['calculated_margin_rs'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['total_credit_days_sum'] }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="border: 2px solid black"><b>Total Expected</b></td>
                        <td style="border: 2px solid black"><b>{{  $allBudgetData[$budgetName]->sum('sales_sum') }}</b>
                        </td>
                        <td style="border: 2px solid black">
                            <b>{{ $allBudgetData[$budgetName]->sum('net_margin_sum')}}</b>
                        </td>
                        <td style="border: 2px solid black">
                            <b>{{ $allBudgetData[$budgetName]->sum('calculated_margin_rs')}}</b></td>
                        <td style="border: 2px solid black">
                            <b>{{ $allBudgetData[$budgetName]->sum('total_credit_days_sum')}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                    </tr>
                @endif

                {{--MISC budget data --}}
                @if($budgetName == 'miscellaneous')
                    <tr>
                        <td style="border: 2px solid black"><b>Misc</b></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                    </tr>
                    @foreach(checkProductIsExist($budgetData,$budgetName ,$ciName) as $data)
                        <tr>
                            <td style="border: 2px solid black">{{ $data['product_name'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['sales_sum'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['net_margin_sum'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['calculated_margin_rs'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['total_credit_days_sum'] }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="border: 2px solid black"><b>Total Misc</b></td>
                        <td style="border: 2px solid black"><b>{{  $allBudgetData[$budgetName]->sum('sales_sum') }}</b>
                        </td>
                        <td style="border: 2px solid black">
                            <b>{{ $allBudgetData[$budgetName]->sum('net_margin_sum')}}</b>
                        </td>
                        <td style="border: 2px solid black">
                            <b>{{ $allBudgetData[$budgetName]->sum('calculated_margin_rs')}}</b></td>
                        <td style="border: 2px solid black">
                            <b>{{ $allBudgetData[$budgetName]->sum('total_credit_days_sum')}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                    </tr>
                @endif

                {{--new budget data --}}
                @if($budgetName == 'new')
                    <tr>
                        <td style="border: 2px solid black"><b>New</b></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                    </tr>
                    @foreach(checkProductIsExist($budgetData,$budgetName ,$ciName) as $data)
                        <tr>
                            <td style="border: 2px solid black">{{ $data['product_name'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['sales_sum'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['net_margin_sum'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['calculated_margin_rs'] ?? '-' }}</td>
                            <td style="border: 2px solid black">{{ $data['total_credit_days_sum'] }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="border: 2px solid black"><b>Total New</b></td>
                        <td style="border: 2px solid black"><b>{{  $allBudgetData[$budgetName]->sum('sales_sum') }}</b>
                        </td>
                        <td style="border: 2px solid black">
                            <b>{{ $allBudgetData[$budgetName]->sum('net_margin_sum')}}</b>
                        </td>
                        <td style="border: 2px solid black">
                            <b>{{ $allBudgetData[$budgetName]->sum('calculated_margin_rs')}}</b></td>
                        <td style="border: 2px solid black">
                            <b>{{ $allBudgetData[$budgetName]->sum('total_credit_days_sum')}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                    </tr>
                @endif

                {{--new budget data --}}
                @if($loop->last)
                    <tr>
                        <td style="border: 2px solid black"><b>Total {{ $ciName  }}</b></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                    </tr>
                    @php
                        $endTotalData =  calculateAbpTrackerData($allBudgetData,$ciName);
                    @endphp
                    @foreach($endTotalData as $data)
                        <tr>
                            <td style="background-color:#ffff00;border: 2px solid black">{{ $data['product_name'] ?? '-' }}</td>
                            <td style="background-color:#ffff00;border: 2px solid black">{{ $data['sales_sum'] ?? '-' }}</td>
                            <td style="background-color:#ffff00;border: 2px solid black">{{ $data['net_margin_sum'] ?? '-' }}</td>
                            <td style="background-color:#ffff00;border: 2px solid black">{{ $data['calculated_margin_rs'] ?? '-' }}</td>
                            <td style="background-color:#ffff00;border: 2px solid black">{{ $data['total_credit_days_sum'] }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="border: 2px solid black"><b>Total {{ $ciName }}</b></td>
                        <td style="border: 2px solid black"><b>{{  $endTotalData->sum('sales_sum') }}</b>
                        </td>
                        <td style="border: 2px solid black"><b>{{ $endTotalData->sum('net_margin_sum')}}</b>
                        </td>
                        <td style="border: 2px solid black"><b>{{ $endTotalData->sum('calculated_margin_rs')}}</b></td>
                        <td style="border: 2px solid black">
                            <b>{{ $endTotalData->sum('total_credit_days_sum')}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                        <td style="border: 2px solid black"></td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    @endif
    </tbody>
</table>

</body>
</html>
