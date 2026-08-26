<?php
class Controller_Base extends Controller{
    protected $require_login=true;
    protected $current_user=null;
    public function before(){
        parent::before();
        $this->current_user=\Session::get("user",null);
        if($this->require_login and $this->current_user==null){
            \Response::redirect("login");
        }
        \view::set_global("theme",\Service\Theme::resolve());
        \view::set_global("current_user",$this->current_user);
    }
}