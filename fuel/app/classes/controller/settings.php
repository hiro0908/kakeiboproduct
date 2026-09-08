<?php
class Controller_Settings extends Controller_Base{
    public function action_index(){
        if(\Input::method()==="POST"){
            return $this->handle_submit();
        }
        $this->template->title="設定";
        $this->template->content=\View::forge("settings/index",array(
            "theme"=>\Service\Theme::resolve(),
        ));
    }
    protected function handle_submit(){
        \Service\Theme::set(\Input::post("theme"));
        \Response::redirect("settings");
    }
}