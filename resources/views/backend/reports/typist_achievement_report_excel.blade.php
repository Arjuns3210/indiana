<table>
    <tbody>
        <tr>
            <td colspan="2" style="border: 1px solid black; background-color:#dcf1ff;width:100px; font-weight:bold" align="center"> TYPIST Achievement</td>
        </tr>
        <tr>
            <td style="border: 1px solid black; background-color:#dcf1ff; width:200px;">Date</td>
            <td style="border: 1px solid black; background-color:#dcf1ff; width:200px;">{{$TypistAchievementReportData['start_date_to_display'] }} to {{$TypistAchievementReportData['end_date_to_display'] }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid black; background-color:#dcf1ff; width:200px;">Name</td>
            <td style="border: 1px solid black; background-color:#dcf1ff; width:200px;">
                @foreach($TypistAchievementReportData['typist_name'] as $key => $typist)
                    {{$typist}}
                    @if($key !== array_key_last($TypistAchievementReportData['typist_name']))
                    {{','}}
                    @endif
                @endforeach
        </tr>
        <tr>
            <td style="border: 1px solid black; background-color:#dcf1ff;">Category</td>
            <td style="border: 1px solid black; background-color:#dcf1ff; word-wrap: break-word">
            @foreach($TypistAchievementReportData['category_name'] as $key => $category)
            {{$category}}
                    @if($key !== array_key_last($TypistAchievementReportData['category_name']))
                    {{','}}
                    @endif
            @endforeach
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black; background-color:#dcf1ff;">Status</td>
            <td style="border: 1px solid black; background-color:#dcf1ff; word-wrap: break-word">
            @foreach($TypistAchievementReportData['typist_status_name'] as $key => $status)
            {{$status}}
                    @if($key !== array_key_last($TypistAchievementReportData['typist_status_name']))
                    {{','}}
                    @endif
            @endforeach
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid black; background-color:#dcf1ff; font-weight:bold;">Count of Enq No.</td>
            <td style="border: 1px solid black; background-color:#dcf1ff;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid black; background-color:#dcf1ff; font-weight:bold;">ACTIONS</td>
            <td style="border: 1px solid black; background-color:#dcf1ff; font-weight:bold;">TOTAL</td>
        </tr>
        <tr>
            <td style="border: 1px solid black;">Delayed</td>
            <td style="border: 1px solid black;">{{ $TypistAchievementReportData['delayed'] }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid black;">Acted in time</td>
            <td style="border: 1px solid black;">{{ $TypistAchievementReportData['acted_on_time'] }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid black;">Blank</td>
            <td style="border: 1px solid black;">{{ $TypistAchievementReportData['blank_count'] }}</td>
        </tr>
        
        <tr>
            <td style="border: 1px solid black; background-color:#dcf1ff; font-weight:bold;">Grand Total</td>
            <td style="border: 1px solid black; background-color:#dcf1ff; font-weight:bold;">{{$TypistAchievementReportData['grand_total']}}</td>
        </tr>
        <tr>
           <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid black;">{{'Achievement %'}}</td>
            <td style="border: 1px solid black;">{{$TypistAchievementReportData['achievement_percent']}}%</td>
        </tr>
    </tbody>
</table>
<table>
    <tr></tr>
    <tr>
        <td style="border: 1px solid black; background-color:#dcf1ff; font-weight:bold;">STATUS</td>
        <td style="border: 1px solid black; background-color:#dcf1ff; font-weight:bold;">COUNT</td>
    </tr>
        <tr>
            <td style="border-right: 1px hair black;">Blank</td>
            <td style="border-right: 1px solid black;">{{ $TypistAchievementReportData['blank_count'] }}</td>
        </tr>
    @php
        $total = $TypistAchievementReportData['blank_count'];
    @endphp
    @foreach ( $TypistAchievementReportData['status_count'] as $key => $val)
    <tr>
        <td style="border-right: 1px hair black; ">{{$key}}</td>
        <td style="border-right: 1px solid black; ">{{$val}}</td>
    </tr>
     @php
        $total += $val;
    @endphp
    @endforeach
    <tr>
        <td style="border: 1px solid black; background-color:#dcf1ff; font-weight:bold;">TOTAL</td>
        <td style="border: 1px solid black; background-color:#dcf1ff; font-weight:bold;">{{$total}}</td>
    </tr>
</table>