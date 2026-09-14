<?php
class Controller_Home extends Controller_Base{
    public function action_index(){
        $year           = (int)date("Y");
        $month          = (int)date("n");
        $monthly_totals = \Model_Expense::monthly_totals($this -> current_user["id"]);
        $max            = max(array_column($monthly_totals,"total"))?: 1;
        foreach($monthly_totals as &$m){
            $m["height"] = $m["total"] > 0 ? max(4, round($m["total"]/$max*150)) : 0;
        }
        unset($m);
        $this -> template -> title   = "ホーム";
        $this -> template -> content = \View::forge("home/index", array(
            "summary"        => \Service\Budget::summary($this->current_user["id"],$year,$month),
            "monthly_totals" => $monthly_totals,
        ));
    }
}