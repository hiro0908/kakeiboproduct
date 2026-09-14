<?php
class Controller_Settings extends Controller_Base{
    public function get_index(){
        $this -> template -> title   = "設定";
        $this -> template -> content = \View::forge("settings/index", array(
            "theme" => \Service\Theme::resolve(),
        ));
    }
    public function post_index(){
        \Service\Theme::set(\Input::post("theme"));
        \Response::redirect("settings");
    }
}