<?php

class Controller_Account extends Controller_Base{
    public function get_index(){
        $this -> template -> title   = "アカウント削除";
        $this -> template -> content = \View::forge("account/index");
    }
    public function post_index(){
        \Service\Account::withdraw($this -> current_user["id"]);
        \Service\Auth::logout();
        \Response::redirect("login");
    }
}