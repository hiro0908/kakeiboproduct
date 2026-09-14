<?php
class Controller_Budget extends Controller_Base{
    public function get_index(){
        $year   = (int) date("Y");
        $month  = (int) date("n");
        $budget = \Model_Budget::find_by_month($this->current_user["id"], $year, $month );
        $this -> template -> title   = "支出目標";
        $this -> template -> content = \View::forge( "budget/index", array(
            "budget" => $budget,
        ));
    }
    public function post_index(){
        $year  = (int) date("Y");
        $month = (int) date("n");
        $val   = \Validation::forge();
        $val   -> add_field("amount","上限金額","required|numeric_min[1]");

        if(!$val  -> run()){
            $this -> template -> title   = "支出目標";
            $this -> template -> content = \View::forge("budget/index", array(
                "budget" => \Model_Budget::find_by_month($this -> current_user["id"], $year, $month),
                "errors" => $val -> error_message(),
            ));
            return ;
        }

        \Model_Budget::set($this -> current_user["id"], $year, $month, \Input::post("amount"));
        \Response::redirect("budget");
    }
}