<?php

namespace Service;

class Budget{
    public static function summary($user_id,$year,$month){
        $budget=\Model_Budget::find_by_month($user_id,$year,$month);
        $total=\Model_Expense::total_by_month($user_id,$year,$month);
        $limit=$budget !== null ? (int) $budget["amount"]:null;

        $percentage = ($limit!== null and $limit > 0)?round($total/$limit*100):null;
        $threshold = \Config::get("kakeibo.budget_alert_threshold",80);

        return array(
            "total"      => $total,
            "limit"      => $limit,
            "percentage" => $percentage,
            "is_warning" => $percentage !== null and $percentage >= $threshold,
            "is_over"    => $percentage !== null and $percentage >= 100,
        );
    }
}