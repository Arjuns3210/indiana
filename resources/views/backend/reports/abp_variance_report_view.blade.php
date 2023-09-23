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
{{--Table A--}}
<table>
    <thead>
    <tr>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0">Same Date</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="7"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">ABP</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">ACT</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">VARIANCE</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
    </tr>
    <tr>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">A</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 400px">CLIENT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 200px">PROJECT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CI</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">ZONE</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 200px">CLIENT CATEGORY
        </th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CUSTOMER</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">INDUSTRY</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">APPLICATION</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black; width: 150px">STATUS</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black; width: 200px">REASON FOR
            VARIANCE
        </th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ; width: 100px">PROBABILITY</th>
    </tr>
    </thead>
    <tbody>
    @php
        $number = 1;
        $abpEndTotal = 0;
        $abpGRTotal = 0;
        $abpCTTotal = 0;
        $abpHRTotal = 0;
        $abpEMTotal = 0;
        $actEndTotal = 0;
        $actGRTotal = 0;
        $actCTTotal = 0;
        $actHRTotal = 0;
        $actEMTotal = 0;
        $varianceEndTotal = 0;
        $varianceGRTotal = 0;
        $varianceCTTotal = 0;
        $varianceHRTotal = 0;
        $varianceEMTotal = 0;
    @endphp
    @if($abpVarianceTypeA->count())
        @foreach($abpVarianceTypeA as $productName => $abpData)
            @foreach($abpData as $data)
                <tr>
                    <td style="text-align:center;border: 2px solid black">{{ $number++ }}</td>
                    <td style="text-align:center;border: 2px solid black">{{$data->client_name}}</td>
                    <td style="border: 2px solid black">{{ $data->enquiry->project_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->caseIncharge->nick_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->region->region_name ?? $data->enquiry->region->region_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->enquiry->category->category_name ?? ''  }}</td>
                    <td style="border: 2px solid black ">{{ $data->enquiry->client_name ?? '' }}</td>
                    <td style="border: 2px solid black ">{{  $data->enquiry->industry->industry_code ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black "></td>
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'GR'){
                          $abpGRTotal +=  $data->order_value_budget;   
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'CT'){
                            $abpCTTotal +=  $data->order_value_budget;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'HR'){
                            $abpHRTotal +=  $data->order_value_budget;  
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'EM'){
                           $abpEMTotal +=  $data->order_value_budget; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $data->order_value_budget }}</td>
                    @php
                        $abpEndTotal += $data->order_value_budget ?? 0;
                    @endphp

                    @php
                        $orderValueExpected = $data->abpReviewLatestOneHistory->order_value_expected ?? '';
                         $orderValueExpectedCalculation = empty($orderValueExpected) ? 0 : $orderValueExpected;
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'GR'){
                          $actGRTotal += $orderValueExpectedCalculation;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'CT'){
                            $actCTTotal +=  $orderValueExpectedCalculation;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'HR'){
                            $actHRTotal +=  $orderValueExpectedCalculation;  
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'EM'){
                           $actEMTotal +=  $orderValueExpectedCalculation; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $orderValueExpected }}</td>
                    @php
                        $actEndTotal += $orderValueExpectedCalculation ?? 0;
                    @endphp


                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'GR'){
                           $varianceGRTotal +=  ($data->order_value_budget - $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'CT'){
                           $varianceCTTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'HR'){
                           $varianceHRTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'EM'){
                            $varianceEMTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ ($data->order_value_budget 
 - $orderValueExpectedCalculation)  ?? '-'}}</td>
                    @php
                        if ($productName == 'EM'){
                            $varianceEndTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp

                    <td style="text-align:center;border: 2px solid black"></td>
                    <td style="text-align:center;border: 2px solid black">{{ $data->abpReviewLatestOneHistory->remark_time_expected ?? '-' }}</td>
                    <td style="text-align:center;border: 2px solid black">{{$data->abpReviewLatestOneHistory->probability ?? '-'}}</td>
                </tr>
            @endforeach
        @endforeach
    @else
        <tr></tr>
    @endif
    <tr>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ">{{$abpGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ $abpEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actGRTotal == 0) ? "" : $actGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actCTTotal == 0) ? '' : $actCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actHRTotal == 0) ? '' : $actHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actEMTotal == 0) ? '' : $actEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ ($actEndTotal == 0) ? '' : $actEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ $varianceEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
    </tr>
    <tr></tr>
    <tr></tr>
    </tbody>
</table>

{{--Table B--}}
<table>
    <thead>
    <tr>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0">Delay Data</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="7"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">ABP</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">ACT</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">VARIANCE</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
    </tr>
    <tr>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">B</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 400px">CLIENT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 200px">PROJECT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CI</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">ZONE</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 200px">CLIENT CATEGORY
        </th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CUSTOMER</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">INDUSTRY</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">APPLICATION</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black; width: 150px">STATUS</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black; width: 200px">REASON FOR
            VARIANCE
        </th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ; width: 100px">PROBABILITY</th>
    </tr>
    </thead>
    <tbody>
    @php
        $number = 1;
        $abpEndTotal = 0;
        $abpGRTotal = 0;
        $abpCTTotal = 0;
        $abpHRTotal = 0;
        $abpEMTotal = 0;
        $actEndTotal = 0;
        $actGRTotal = 0;
        $actCTTotal = 0;
        $actHRTotal = 0;
        $actEMTotal = 0;
        $varianceEndTotal = 0;
        $varianceGRTotal = 0;
        $varianceCTTotal = 0;
        $varianceHRTotal = 0;
        $varianceEMTotal = 0;
    @endphp
    @if($abpVarianceTypeB->count())
        @foreach($abpVarianceTypeB as $productName => $abpData)
            @foreach($abpData as $data)
                <tr>
                    <td style="text-align:center;border: 2px solid black">{{ $number++ }}</td>
                    <td style="text-align:center;border: 2px solid black">{{$data->client_name}}</td>
                    <td style="border: 2px solid black">{{ $data->enquiry->project_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->caseIncharge->nick_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->region->region_name ?? $data->enquiry->region->region_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->enquiry->category->category_name ?? ''  }}</td>
                    <td style="border: 2px solid black ">{{ $data->enquiry->client_name ?? '' }}</td>
                    <td style="border: 2px solid black ">{{  $data->enquiry->industry->industry_code ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black "></td>
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'GR'){
                          $abpGRTotal +=  $data->order_value_budget;   
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'CT'){
                            $abpCTTotal +=  $data->order_value_budget;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'HR'){
                            $abpHRTotal +=  $data->order_value_budget;  
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'EM'){
                           $abpEMTotal +=  $data->order_value_budget; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $data->order_value_budget }}</td>
                    @php
                        $abpEndTotal += $data->order_value_budget ?? 0;
                    @endphp

                    @php
                        $orderValueExpected = $data->abpReviewLatestOneHistory->order_value_expected ?? '';
                         $orderValueExpectedCalculation = empty($orderValueExpected) ? 0 : $orderValueExpected;
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'GR'){
                          $actGRTotal += $orderValueExpectedCalculation;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'CT'){
                            $actCTTotal +=  $orderValueExpectedCalculation;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'HR'){
                            $actHRTotal +=  $orderValueExpectedCalculation;  
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'EM'){
                           $actEMTotal +=  $orderValueExpectedCalculation; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $orderValueExpected }}</td>
                    @php
                        $actEndTotal += $orderValueExpectedCalculation ?? 0;
                    @endphp


                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'GR'){
                           $varianceGRTotal +=  ($data->order_value_budget - $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'CT'){
                           $varianceCTTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'HR'){
                           $varianceHRTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'EM'){
                            $varianceEMTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ ($data->order_value_budget 
 - $orderValueExpectedCalculation)  ?? '-'}}</td>
                    @php
                        if ($productName == 'EM'){
                            $varianceEndTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp

                    <td style="text-align:center;border: 2px solid black"></td>
                    <td style="text-align:center;border: 2px solid black">{{ $data->abpReviewLatestOneHistory->remark_time_expected ?? '-' }}</td>
                    <td style="text-align:center;border: 2px solid black">{{$data->abpReviewLatestOneHistory->probability ?? '-'}}</td>
                </tr>
            @endforeach
        @endforeach
    @else
        <tr></tr>
    @endif
    <tr>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ">{{$abpGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ $abpEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actGRTotal == 0) ? "" : $actGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actCTTotal == 0) ? '' : $actCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actHRTotal == 0) ? '' : $actHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actEMTotal == 0) ? '' : $actEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ ($actEndTotal == 0) ? '' : $actEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ $varianceEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
    </tr>
    <tr></tr>
    <tr></tr>
    </tbody>
</table>

{{--Table C--}}
<table>
    <thead>
    <tr>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0">Early Data</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="7"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">ABP</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">ACT</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">VARIANCE</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
    </tr>
    <tr>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">C</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 400px">CLIENT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 200px">PROJECT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CI</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">ZONE</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 200px">CLIENT CATEGORY
        </th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CUSTOMER</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">INDUSTRY</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">APPLICATION</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black; width: 150px">STATUS</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black; width: 200px">REASON FOR
            VARIANCE
        </th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ; width: 100px">PROBABILITY</th>
    </tr>
    </thead>
    <tbody>
    @php
        $number = 1;
        $abpEndTotal = 0;
        $abpGRTotal = 0;
        $abpCTTotal = 0;
        $abpHRTotal = 0;
        $abpEMTotal = 0;
        $actEndTotal = 0;
        $actGRTotal = 0;
        $actCTTotal = 0;
        $actHRTotal = 0;
        $actEMTotal = 0;
        $varianceEndTotal = 0;
        $varianceGRTotal = 0;
        $varianceCTTotal = 0;
        $varianceHRTotal = 0;
        $varianceEMTotal = 0;
    @endphp
    @if($abpVarianceTypeC->count())
        @foreach($abpVarianceTypeC as $productName => $abpData)
            @foreach($abpData as $data)
                <tr>
                    <td style="text-align:center;border: 2px solid black">{{ $number++ }}</td>
                    <td style="text-align:center;border: 2px solid black">{{$data->client_name}}</td>
                    <td style="border: 2px solid black">{{ $data->enquiry->project_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->caseIncharge->nick_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->region->region_name ?? $data->enquiry->region->region_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->enquiry->category->category_name ?? ''  }}</td>
                    <td style="border: 2px solid black ">{{ $data->enquiry->client_name ?? '' }}</td>
                    <td style="border: 2px solid black ">{{  $data->enquiry->industry->industry_code ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black "></td>
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'GR'){
                          $abpGRTotal +=  $data->order_value_budget;   
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'CT'){
                            $abpCTTotal +=  $data->order_value_budget;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'HR'){
                            $abpHRTotal +=  $data->order_value_budget;  
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'EM'){
                           $abpEMTotal +=  $data->order_value_budget; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $data->order_value_budget }}</td>
                    @php
                        $abpEndTotal += $data->order_value_budget ?? 0;
                    @endphp

                    @php
                        $orderValueExpected = $data->abpReviewLatestOneHistory->order_value_expected ?? '';
                         $orderValueExpectedCalculation = empty($orderValueExpected) ? 0 : $orderValueExpected;
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'GR'){
                          $actGRTotal += $orderValueExpectedCalculation;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'CT'){
                            $actCTTotal +=  $orderValueExpectedCalculation;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'HR'){
                            $actHRTotal +=  $orderValueExpectedCalculation;  
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'EM'){
                           $actEMTotal +=  $orderValueExpectedCalculation; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $orderValueExpected }}</td>
                    @php
                        $actEndTotal += $orderValueExpectedCalculation ?? 0;
                    @endphp


                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'GR'){
                           $varianceGRTotal +=  ($data->order_value_budget - $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'CT'){
                           $varianceCTTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'HR'){
                           $varianceHRTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'EM'){
                            $varianceEMTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ ($data->order_value_budget 
 - $orderValueExpectedCalculation)  ?? '-'}}</td>
                    @php
                        if ($productName == 'EM'){
                            $varianceEndTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp

                    <td style="text-align:center;border: 2px solid black"></td>
                    <td style="text-align:center;border: 2px solid black">{{ $data->abpReviewLatestOneHistory->remark_time_expected ?? '-' }}</td>
                    <td style="text-align:center;border: 2px solid black">{{$data->abpReviewLatestOneHistory->probability ?? '-'}}</td>
                </tr>
            @endforeach
        @endforeach
    @else
        <tr></tr>
    @endif
    <tr>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ">{{$abpGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ $abpEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actGRTotal == 0) ? "" : $actGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actCTTotal == 0) ? '' : $actCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actHRTotal == 0) ? '' : $actHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actEMTotal == 0) ? '' : $actEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ ($actEndTotal == 0) ? '' : $actEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ $varianceEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
    </tr>
    <tr></tr>
    <tr></tr>
    </tbody>
</table>

{{--Table D--}}
<table>
    <thead>
    <tr>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0">MISC Data</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="7"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">ABP</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">ACT</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0" colspan="5">VARIANCE</th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
        <th style="border: 2px solid black; text-align: center; background-color: #E0E0E0"></th>
    </tr>
    <tr>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">D</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 400px">CLIENT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 200px">PROJECT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CI</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">ZONE</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 200px">CLIENT CATEGORY
        </th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CUSTOMER</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">INDUSTRY</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">APPLICATION</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">GR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">CT</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">HR</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">EM</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ;width: 100px">TOTAL</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black; width: 150px">STATUS</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black; width: 200px">REASON FOR
            VARIANCE
        </th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ; width: 100px">PROBABILITY</th>
    </tr>
    </thead>
    <tbody>
    @php
        $number = 1;
        $abpEndTotal = 0;
        $abpGRTotal = 0;
        $abpCTTotal = 0;
        $abpHRTotal = 0;
        $abpEMTotal = 0;
        $actEndTotal = 0;
        $actGRTotal = 0;
        $actCTTotal = 0;
        $actHRTotal = 0;
        $actEMTotal = 0;
        $varianceEndTotal = 0;
        $varianceGRTotal = 0;
        $varianceCTTotal = 0;
        $varianceHRTotal = 0;
        $varianceEMTotal = 0;
    @endphp
    @if($abpVarianceTypeD->count())
        @foreach($abpVarianceTypeD as $productName => $abpData)
            @foreach($abpData as $data)
                <tr>
                    <td style="text-align:center;border: 2px solid black">{{ $number++ }}</td>
                    <td style="text-align:center;border: 2px solid black">{{$data->client_name}}</td>
                    <td style="border: 2px solid black">{{ $data->enquiry->project_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->caseIncharge->nick_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->region->region_name ??  $data->enquiry->region->region_name ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black ">{{ $data->enquiry->category->category_name ?? ''  }}</td>
                    <td style="border: 2px solid black ">{{ $data->enquiry->client_name ?? '' }}</td>
                    <td style="border: 2px solid black ">{{  $data->enquiry->industry->industry_code ?? '' }}</td>
                    <td style="text-align:center;border: 2px solid black "></td>
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'GR'){
                          $abpGRTotal +=  $data->order_value_budget;   
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'CT'){
                            $abpCTTotal +=  $data->order_value_budget;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'HR'){
                            $abpHRTotal +=  $data->order_value_budget;  
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? $data->order_value_budget : '' }}</td>
                    @php
                        if ($productName == 'EM'){
                           $abpEMTotal +=  $data->order_value_budget; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $data->order_value_budget }}</td>
                    @php
                        $abpEndTotal += $data->order_value_budget ?? 0;
                    @endphp

                    @php
                        $orderValueExpected = $data->abpReviewLatestOneHistory->order_value_expected ?? '';
                         $orderValueExpectedCalculation = empty($orderValueExpected) ? 0 : $orderValueExpected;
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'GR'){
                          $actGRTotal += $orderValueExpectedCalculation;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'CT'){
                            $actCTTotal +=  $orderValueExpectedCalculation;     
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'HR'){
                            $actHRTotal +=  $orderValueExpectedCalculation;  
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? $orderValueExpected : '' }}</td>
                    @php
                        if ($productName == 'EM'){
                           $actEMTotal +=  $orderValueExpectedCalculation; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $orderValueExpected }}</td>
                    @php
                        $actEndTotal += $orderValueExpectedCalculation ?? 0;
                    @endphp


                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'GR' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'GR'){
                           $varianceGRTotal +=  ($data->order_value_budget - $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'CT' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'CT'){
                           $varianceCTTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'HR' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'HR'){
                           $varianceHRTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ $productName == 'EM' ? ($data->order_value_budget 
 - (empty($orderValueExpected) ? 0 : $orderValueExpected)) : ''}}</td>
                    @php
                        if ($productName == 'EM'){
                            $varianceEMTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp
                    <td style="text-align:center;border: 2px solid black ">{{ ($data->order_value_budget 
 - $orderValueExpectedCalculation)  ?? '-'}}</td>
                    @php
                        if ($productName == 'EM'){
                            $varianceEndTotal +=  ($data->order_value_budget -
                            $orderValueExpectedCalculation) ?? 0; 
                        }
                    @endphp

                    <td style="text-align:center;border: 2px solid black"></td>
                    <td style="text-align:center;border: 2px solid black">{{ $data->abpReviewLatestOneHistory->remark_time_expected ?? '-' }}</td>
                    <td style="text-align:center;border: 2px solid black">{{$data->abpReviewLatestOneHistory->probability ?? '-'}}</td>
                </tr>
            @endforeach
        @endforeach
    @else
        <tr></tr>
    @endif
    <tr>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black ">{{$abpGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$abpEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ $abpEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actGRTotal == 0) ? "" : $actGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actCTTotal == 0) ? '' : $actCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actHRTotal == 0) ? '' : $actHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{($actEMTotal == 0) ? '' : $actEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ ($actEndTotal == 0) ? '' : $actEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceGRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceCTTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceHRTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{$varianceEMTotal}}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black">{{ $varianceEndTotal }}</th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black"></th>
        <th style="background-color: #E0E0E0;text-align:center;border: 2px solid black "></th>
    </tr>
    <tr></tr>
    <tr></tr>
    </tbody>
</table>
</body>
</html>
