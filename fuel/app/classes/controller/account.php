<?php

class Controller_Account extends Controller_Base{
    public function action_index(){
        if (\Input::method()==="POST"){
            return $this->handle_delete();
        }
        $this->template->title="アカウント削除";
        $this->template->content=\View::forge("account/index");
    }
    protected function handle_delete(){
        \Service\Account::withdraw($this->current_user["id"]);
        \Service\Auth::logout();
        \Response::redirect("login");
    }
}