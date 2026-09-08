<?php
class Controller_Home extends Controller_Base{
    public function action_index(){
        $year=(int)date("Y");
        $month=(int)date("n");
        $this->template->title="ホーム";
        $this->template->content=\View::forge("home/index",array(
            "summary"=>\Service\Budget::summary($this->current_user["id"],$year,$month),
        ));
    }
}