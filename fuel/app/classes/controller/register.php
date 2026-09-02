<?php

class Controller_Register extends Controller_Base{
    protected $require_login=false;

    public function action_index(){
        if (\Input::method()==="POST"){
            return $this->handle_submit();
        }
        $this->template->title="新規登録";
        $this->template->content=\View::forge("register/index");
    }

    protected function handle_submit(){
        $val=\Validation::forge();
        $val->add_field("username","ユーザー名","required|max_length[50]");
        $val->add_field("password","パスワード","required|min_length[8]");
        $val->add_field("password_confirm","パスワード確認","required|match_field[password]");

        if (!$val->run()){
            $this->template->title="新規登録";
            $this->template->content=\View::forge("register/index", array(
                "errors"=>$val->error_message(),
                "username"=>\Input::post("username"),
            ));
            return;
        }

        $username=\Input::post("username");
        if (\Model_User::username_exists($username)){
            $this->template->title="新規登録";
            $this->template->content=\View::forge("register/index", array(
                "errors"=>array("このユーザー名は既に使われています"),
                "username"=>$username,
            ));
            return;
        }

        $id=\Model_User::create($username, \Input::post("password"));
        \Service\Auth::login(array("id"=>$id, "username"=>$username));
        \Response::redirect("home");
    }
}