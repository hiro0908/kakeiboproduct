<?php
abstract class Controller_Base extends Controller_Template{
    public $template  ="layout";

    protected $require_login = true;
    protected $current_user = null;
    public function before(){
        parent::before();
        $this->current_user=\Session::get("user",null);
        if ($this->require_login and $this->current_user===null){
            \Response::redirect("login");
        }
        $this->template->theme=\Service\Theme::resolve();
        $this->template->current_user=$this->current_user;
        \View::set_global("current_user",$this->current_user);
    }
}