@php
$top_loop_count = 3;
$estimator_count = count($misReportData['admin']);
@endphp
@if($estimator_count > $top_loop_count)
@php
$top_loop_count = $estimator_count;
@endphp

@endif
<table>
    <tbody>
        <tr>
            <td style="border:1px solid black;"></td>

            @for($i=1; $i<=$top_loop_count; $i++ )
            <td style="border:1px solid black; width: 100px;"></td>
            @endfor
            
            <td style="border:1px solid black; width: 100px; font-weight:bold;">Total</td>
        </tr>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">Report of : {{$misReportData['mis_date_to_display']}}</td>
             @for($i=1; $i<=$top_loop_count; $i++ )
             @if($i == 2 )
            <td style="border:1px solid black; font-weight:bold; font-style:italic;">Explanations</td>
            @else
            <td style="border:1px solid black;"></td>
             @endif
            @endfor
            <td style="border:1px solid black;"></td>

        </tr>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">Total:</td>
               @for($i=1; $i<=$top_loop_count; $i++ )
            <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black; font-weight:bold;">{{$misReportData['total']}}</td>

        </tr>
        
        <tr>
            <td style="border:1px solid black; width: 300px;"> Pending for categorization from case incharge</td>
            @for($i=1; $i<=$top_loop_count; $i++ )
                @if($i == 2 )
                    <td style="border:1px solid black; font-style:italic;">New inquiry of {{date('jS',strtotime($misReportData['mis_date']))}} and awaiting categorization</td>
                @else
                    <td style="border:1px solid black;"></td>
                @endif
            @endfor
            <td style="border:1px solid black;">{{$misReportData['pending_for_categorization_from_case_incharge']}} </td>

        </tr>
        
        <tr>
            <td style="border:1px solid black;">Regretted (GHI) - RGT count</td>
            @for($i=1; $i<=$top_loop_count; $i++ )
                @if($i == 2 )
                    <td style="border:1px solid black; font-style:italic;">New inquiry received on {{date('jS',strtotime($misReportData['mis_date']))}} and regretted on {{date('jS',strtotime($misReportData['mis_date']))}} itself</td>
                @else
                    <td style="border:1px solid black;"></td>
                @endif
            @endfor
            <td style="border:1px solid black;">{{$misReportData['regretted_ghi']}}</td>

        </tr>
        
        <tr>
            <td style="border:1px solid black;">Allocated to estimators on the day itself</td>
            @for($i=1; $i<=$top_loop_count; $i++ )
                @if($i == 2 )
                    <td style="border:1px solid black; font-style:italic;">New inquiry received on {{date('jS',strtotime($misReportData['mis_date']))}} and handed over to estimator on {{date('jS',strtotime($misReportData['mis_date']))}} itself</td>
                @else
                    <td style="border:1px solid black;"></td>
                @endif
            @endfor
            <td style="border:1px solid black;">{{$misReportData['allocated_to_estimators_on_the_day_itself']}}</td>

        </tr>
        
        <tr>
            <td style="border:1px solid black;">Awaiting allocation to estimators (after categorization)</td>
            @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['awaiting_allocation_to_estimators_after_categorization']}}</td>

        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">Previous day backlog pending for Allocation</td>
            @for($i=1; $i<=$top_loop_count; $i++ )
                @if($i == 2 )
                    <td style="border:1px solid black; font-style:italic;">Inquiries not allocated till end of {{date('jS',strtotime($misReportData['mis_date_minus_one']))}} this includes items not categorized yet</td>
                @else
                    <td style="border:1px solid black;"></td>
                @endif
            @endfor
            <td style="border:1px solid black; font-weight:bold;">{{$misReportData['previous_day_backlog_pending_for_allocation']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Categorization pending</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black; font-weight:bold;">{{ $misReportData['categorization_pending_from_fy']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Regretted (GHI)</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['regretted_ghi_from_fy']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Dropped</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['dropped_from_fy']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Allocated from previous day backlog</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['allocated_from_previous_day_backlog']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Not yet allocated</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['not_yet_allocated']}}</td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">Totals</td>
             @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;"></td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Not categorized</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['not_categorized_total']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Directly regretted</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['directly_regretted_total']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Dropped</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['dropped_total']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Pending for estimation (fresh load)</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['pending_for_estimation_total']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Not allocated (total unallocated)</td>
              @for($i=1; $i<=$top_loop_count; $i++ )
                    <td style="border:1px solid black;"></td>
            @endfor
            <td style="border:1px solid black;">{{$misReportData['not_allocated_total']}}</td>
        </tr>
        <tr></tr>
        @if($estimator_count > 0)

        <tr>
            <td colspan="{{$estimator_count+1}}" style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
        </tr>
        <tr>
            <td colspan="{{$estimator_count+1}}" align="right" style="border:1px solid black; font-weight:bold;">New Allocations (previous pending + inquiries received)</td>
            <td style="border:1px solid black; font-weight:bold;">76</td>
        </tr>
        <tr>
             <td colspan="{{$estimator_count+1}}" style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
        </tr>
        @endif
    </tbody>
</table>

@if($estimator_count > 0)
<table>
    <tbody>
        <tr>
            <td style="border:1px solid black; font-weight:bold; background-color: yellow;">Estimators Review</td>
            
            @foreach($misReportData['admin'] as $key=>$value)
            <td style="border:1px solid black; font-weight:bold;">{{$key}}</td>
            
            @endforeach
            <td style="border:1px solid black; font-weight:bold;">Total</td>

        </tr>
        <tr>
            <td style="border:1px solid black;">Previous day inquiry pending for estimation</td>
            @php
            $previous_day_inquiry_pending_for_estimation_total = 0;
            @endphp
            @foreach($misReportData['previous_day_inquiry_pending_for_estimation'] as $value)
            <td style="border:1px solid black; font-weight:bold;">{{-- @$value --}}</td>
             @php
            $previous_day_inquiry_pending_for_estimation_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black; font-weight:bold;">{{-- @$previous_day_inquiry_pending_for_estimation_total --}}</td>
        </tr>
        <tr>
            <td>Allocation</td>
            @php
            $allocation_total = 0;
            @endphp
            @foreach($misReportData['allocation'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $allocation_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$allocation_total}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Transfer from other estimator (taken over)</td>
            @php
            $transfer_from_the_estimator_total = 0;
            @endphp
            @foreach($misReportData['transfer_from_the_estimator'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $transfer_from_the_estimator_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$transfer_from_the_estimator_total}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Transfer to other estimator (handed out)</td>
              @php
            $transfer_to_the_estimator_total = 0;
            @endphp
            @foreach($misReportData['transfer_to_the_estimator'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $transfer_to_the_estimator_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$transfer_to_the_estimator_total}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">Total Pending With Estimators</td>
              @foreach($misReportData['transfer_to_the_estimator'] as $value)
            <td style="border:1px solid black; font-weight:bold;"></td>
            @endforeach
            <td style="border:1px solid black; font-weight:bold;"></td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">{{'Estimated & sent to typist'}}</td>
            @php
                $estimated_and_sent_to_typist_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_and_sent_to_typist_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black; font-weight:bold;">{{$estimated_and_sent_to_typist_total}}</td>
        </tr>
        <tr>
            <td align="right">CT</td>
            @php
                $estimated_product1_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist_p1'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_product1_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black;">{{$estimated_product1_total}}</td>
        </tr>
        <tr>
            <td align="right">EM</td>
            @php
                $estimated_product2_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist_p2'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_product2_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black;">{{$estimated_product2_total}}</td>
        </tr>
        <tr>
            <td align="right">GR</td>
            @php
                $estimated_product3_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist_p3'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_product3_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black;">{{$estimated_product3_total}}</td>
        </tr>
        <tr>
            <td align="right">HR</td>
            @php
                $estimated_product4_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist_p4'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_product4_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black;">{{$estimated_product4_total}}</td>
        </tr>
        <tr>
            <td align="right">SS</td>
            @php
                $estimated_product5_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist_p5'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_product5_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black;">{{$estimated_product5_total}}</td>
        </tr>
        <tr>
            <td align="right">FRPCT</td>
            @php
                $estimated_product6_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist_p6'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_product6_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black;">{{$estimated_product6_total}}</td>
        </tr>
        <tr>
            <td align="right">FRPGR</td>
            @php
                $estimated_product7_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist_p7'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_product7_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black;">{{$estimated_product7_total}}</td>
        </tr>
        <tr>
            <td align="right">WMCT</td>
            @php
                $estimated_product8_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist_p8'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_product8_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black;">{{$estimated_product8_total}}</td>
        </tr>
        <tr>
            <td align="right">OTHERS</td>
            @php
                $estimated_product9_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist_p9'] as $value)
                <td style="border:1px solid black;">{{$value}}</td>
                @php
                    $estimated_product9_total += $value;
                @endphp
            @endforeach
            <td style="border:1px solid black;">{{$estimated_product9_total}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Dropped</td>
              @php
            $dropped_total = 0;
            @endphp
            @foreach($misReportData['dropped'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $dropped_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$dropped_total}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Regretted</td>
             @php
            $regretted_total = 0;
            @endphp
            @foreach($misReportData['regretted'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $regretted_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$regretted_total}}</td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">Revisions</td>
           @foreach($misReportData['new_additions_into_revision_pool'] as $value)
            <td style="border:1px solid black;"></td>
            @endforeach
            <td style="border:1px solid black;"></td>
        </tr>
        <tr>
            <td style="border:1px solid black;">New additions into revision pool</td>
             @php
            $new_additions_into_revision_pool_total = 0;
            @endphp
            @foreach($misReportData['new_additions_into_revision_pool'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $new_additions_into_revision_pool_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$new_additions_into_revision_pool_total}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">{{'Revised & Sent to typist'}}</td>
            @php
            $revised_and_sent_to_typist_total = 0;
            @endphp
            @foreach($misReportData['revised_and_sent_to_typist'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $revised_and_sent_to_typist_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$revised_and_sent_to_typist_total}}</td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">Day Output to typists (new + rev)</td>
           
            @foreach($misReportData['new_additions_into_revision_pool'] as $value)
            <td style="border:1px solid black; font-weight:bold;"></td>
            
            @endforeach
            <td style="border:1px solid black; font-weight:bold;"></td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">Closing load with estimators</td>
           @foreach($misReportData['new_additions_into_revision_pool'] as $value)
            <td style="border:1px solid black; font-weight:bold;"></td>
            
            @endforeach
            <td style="border:1px solid black; font-weight:bold;"></td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
    <tr>
        <td style="border:1px solid black;">Pending - not started yet</td>
        @php
            $pending_not_started_yet_total = 0;
            @endphp
            @foreach($misReportData['pending_not_started_yet'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $pending_not_started_yet_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$pending_not_started_yet_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - work started but not complete</td>
            @php
            $pending_work_started_but_not_complete_total = 0;
            @endphp
            @foreach($misReportData['pending_work_started_but_not_complete'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $pending_work_started_but_not_complete_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$pending_work_started_but_not_complete_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - IG Breakup</td>
         @php
            $ig_brk_total = 0;
            @endphp
            @foreach($misReportData['ig_brk'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $ig_brk_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$ig_brk_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - Revision</td>
        @php
            $rev_total = 0;
            @endphp
            @foreach($misReportData['rev'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $rev_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$rev_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - VOA</td>
        @php
            $voa = 0;
        @endphp
        @foreach($misReportData['voa'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
            @php
                $voa += $value;
            @endphp
        @endforeach
        <td style="border:1px solid black;">{{$voa}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - HOLD</td>
        @php
            $hold = 0;
        @endphp
        @foreach($misReportData['hold'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
            @php
                $hold += $value;
            @endphp
        @endforeach
        <td style="border:1px solid black;">{{$hold}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - not clear</td>
         @php
            $unc_total = 0;
            @endphp
            @foreach($misReportData['unc'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $unc_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$unc_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - not clear, earliest</td>
         @php
            @endphp
            @foreach($misReportData['oldest_register_date'] as $value)
            <td style="border:1px solid black;">{{$value ? date('d/m/Y',strtotime($value)) : ''}}</td>
            @endforeach
            <td style="border:1px solid black;"></td>
    </tr>
    {{-- <tr>
        <td style="border:1px solid black;">Pending - po_cost</td>
         @php
            $po_cost_total = 0;
            @endphp
            @foreach($misReportData['po_cost'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $po_cost_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$po_cost_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - rgt</td>
         @php
            $rgt_total = 0;
            @endphp
            @foreach($misReportData['rgt'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $rgt_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$rgt_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - drp</td>
         @php
            $drp_total = 0;
            @endphp
            @foreach($misReportData['drp'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $drp_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$drp_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - qtd</td>
         @php
            $qtd_total = 0;
            @endphp
            @foreach($misReportData['qtd'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $qtd_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$qtd_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - rev_qtd</td>
         @php
            $rev_qtd_total = 0;
            @endphp
            @foreach($misReportData['rev_qtd'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $rev_qtd_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$rev_qtd_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - tq</td>
         @php
            $tq_total = 0;
            @endphp
            @foreach($misReportData['tq'] as $value)
            <td>{{$value}}</td>
             @php
            $tq_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$tq_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">Pending - wrk</td>
         @php
            $wrk_total = 0;
            @endphp
            @foreach($misReportData['wrk'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $wrk_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$wrk_total}}</td>
    </tr> --}}
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td style="border:1px solid black; font-weight:bold; background-color: yellow;">Typists Review</td>
            @foreach($misReportData['previous_day_estimates_pending_for_typing'] as $value)
            <td style="border:1px solid black;"></td>
            @endforeach
            <td style="border:1px solid black;"></td>
        </tr>
        <tr>
            <td style="border:1px solid black;">Previous day estimates pending for typing</td>
            @php
            $previous_day_estimates_pending_for_typing_total = 0;
            @endphp
            @foreach($misReportData['previous_day_estimates_pending_for_typing'] as $value)
            <td style="border:1px solid black;">{{-- @$value --}}</td>
             @php
            $previous_day_estimates_pending_for_typing_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black; font-weight:bold;">{{-- @$previous_day_estimates_pending_for_typing_total --}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;">{{'Estimated & sent to typist'}}</td>
             @php
            $estimated_and_sent_to_typist_total = 0;
            @endphp
            @foreach($misReportData['estimated_and_sent_to_typist'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $estimated_and_sent_to_typist_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black; font-weight:bold;">{{$estimated_and_sent_to_typist_total}}</td>
        </tr>
        <tr>
            <td align='right' style="border:1px solid black; font-weight:bold;">Total</td>
            @foreach($misReportData['estimated_and_sent_to_typist'] as $value)
            <td style="border:1px solid black; font-weight:bold;"></td>
           
            @endforeach
            <td style="border:1px solid black; font-weight:bold;"></td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td style="border:1px solid black;">Sent to Client</td>
            @php
            $sent_to_client_total = 0;
            @endphp
            @foreach($misReportData['sent_to_client'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $sent_to_client_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$sent_to_client_total}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black; font-weight:bold;">Closing load with typists</td>
            @foreach($misReportData['sent_to_client'] as $value)
            <td style="border:1px solid black; font-weight:bold;"></td>
            @endforeach
            <td style="border:1px solid black; font-weight:bold;"></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
        <td style="border:1px solid black;">TQ</td>
         @php
            $tq_total = 0;
            @endphp
            @foreach($misReportData['tq'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $tq_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$tq_total}}</td>
    </tr>
        <tr>
             <td style="border:1px solid black;">MIPO</td>
            @foreach($misReportData['admin'] as $key=>$value)
            <td style="border:1px solid black;">0</td>
            @endforeach
            <td style="border:1px solid black;">0</td>
        </tr>
    <tr>
        <td style="border:1px solid black;">PO-COST</td>
         @php
            $po_cost_total = 0;
            @endphp
            @foreach($misReportData['po_cost'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $po_cost_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$po_cost_total}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">TDS</td>
         @php
            $tds_total = 0;
            @endphp
            @foreach($misReportData['tds'] as $value)
            <td style="border:1px solid black;">{{$value}}</td>
             @php
            $tds_total += $value;
            @endphp
            @endforeach
            <td style="border:1px solid black;">{{$tds_total}}</td>
    </tr>
    </tbody>
</table>
@endif
@if(!empty($misReportData['enquiry_remark']))
    <table>
        <tbody>
            <tr>
                <td style="border:1px solid black; font-weight:bold;">Engineers Remark</td>
            </tr>
            @foreach($misReportData['enquiry_remark'] as $nick_name => $enquiry_remark)
            <tr>
                <td style="border:1px solid black;">{{ $nick_name }}</td>
                <td>{{ !is_numeric($enquiry_remark) ? $enquiry_remark : '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
