<?php
/*
   *   created by : Maaz Ansari
   *   Created On : 23-aug-2022
   *   Uses :  To display message on admin panel
*/
return [
    'UTF8_ENABLED'                       => true,
    'MAX_DAYS'                           => [
        "MAX_ENQ_REP_DAYS" => "365",
    ],
    'PLATFORM' => ['ios', 'android', 'web'],
    'enq_minus_3' => "Estimator Due Date",
    'mis_export_report_total_rows' => "76",
    'ABP_WEEKLY_INTERVAL_DAYS' => "15",
    'DEFAULT_CATEGORY_ID' => "1",
    'FORMAT_DATE_NEW' => 'd-mmm-yyyy',
    'TOTAL_RECORDS_FOR_OLD_MIPO_HISTORY' => "3",
    'ABP_WEEKLY_REPORT_PREVIOUS_ROW_LIMIT' => "5", #A Limit For Reviews In ABP Weekly Report
    'TRIGGER_CUSTOM_EMAIL' => FALSE,
    'TRIGGER_MIPO_EMAIL' => FALSE,
    // HR, CT , HR , EM product ids for abp variance product report
    'ABP_VARIANCE_REPORT_PRODUCT' => [1, 2, 3, 4],
];
