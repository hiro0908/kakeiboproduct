<?php
class Controller_Login extends Controller_Base{
    protected $require_login=false;
    public function get_index(){
        $this->template->title="ログイン";
        $this->template->content=\View::forge("login/index");
    }
    public function post_index(){
        $val=\Validation::forge();
        $val->add_field("username","ユーザー名","required");
        $val->add_field("password","パスワード","required");

        if (!$val->run()){
            $this->template->title="ログイン";
            $this->template->content=\View::forge("login/index",array(
                "errors"=>array("ユーザー名とパスワードを入力してください"),
                "username"=>\Input::post("username"),
            ));
            return;
        }

        $user=\Service\Auth::attempt(\Input::post("username"),\Input::post("password"));

        if ($user===null){
            $this->template->title="ログイン";
            $this->template->content=\View::forge("login/index",array(
                "errors"=>array("ユーザー名またはパスワードが正しくありません"),
                "username"=>\Input::post("username"),
            ));
            return;
        }
        \Service\Auth::login($user);
        \Response::redirect("home");
    }
    public function action_logout(){
        \Service\Auth::logout();
        \Session::set_flash("success","正常にログアウトしました");
        \Response::redirect("login");
    }
}