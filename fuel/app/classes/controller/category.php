<?php

class Controller_Category extends Controller_Base{
    protected function find_category_or_404($id){
        $category = \Model_Category::find($id, $this -> current_user["id"]);
        if ($category === null){
            throw new \HttpNotFoundException();
        }
        return $category;
    }
    public function get_index(){
        $this -> template -> title   = "カテゴリ管理";
        $this -> template -> content = \View::forge("category/index", array(
            "categories" => \Model_Category::all_by_user($this -> current_user["id"]),
        ));
    }

    public function post_index(){
        $val = Validation::forge();
        $val -> add_field("name", "カテゴリ名", "required|max_length[50]");
        $categories = \Model_Category::all_by_user($this -> current_user["id"]);
        if (!$val->run()){
            $this -> template -> title   ="カテゴリ管理";
            $this -> template -> content = \View::forge("category/index", array(
                "categories" => $categories,
                "errors" => $val -> error_message(),
            ));
            return;
        }

        $name = \Input::post("name");

        if (\Model_Category::name_exists($this -> current_user["id"], $name)){
            $this->template -> title   = "カテゴリ管理";
            $this->template -> content = \View::forge("category/index", array(
                "categories" => $categories,
                "errors"     => array("同じカテゴリが既にあります"),
            ));
            return;
        }
        
        \Model_Category::create($this -> current_user["id"], $name);
        \Response::redirect("category");
    }

    public function get_edit($id){
        $category = $this -> find_category_or_404($id);
        $this -> template -> title   = "カテゴリ編集";
        $this -> template -> content = View::forge("category/edit",array(
            "category" => $category,
        ));
    }
    public function post_edit($id){
        $category = $this -> find_category_or_404($id);
        $val      = \Validation::forge();
        $val -> add_field("name", "カテゴリ名", "required|max_length[50]");
        if (!$val -> run()){
            $this -> template -> title = "カテゴリ編集";
            $this -> template -> content=\View::forge("category/edit", array(
                "category" => $category,
                "errors"   => $val -> error_messege(),
            ));
            return;
        }

        $name = \Input::post("name");

        if(\Model_Category::name_exists($this -> current_user["id"], $name, $id)){
            $this -> template -> title   = "カテゴリ編集";
            $this -> template -> content = \View::forge("category/edit", array(
                "category" => $category,
                "errors"   => array("同じ名前のカテゴリが既にあります"),
            ));
            return;
        }
        \Model_Category::update($id, $this -> current_user["id"], $name);
        \Response::redirect("category");

    }
    public function post_delete($id){
        $ok = \Service\Category::delete($id, $this -> current_user["id"]);

        if (!$ok){
            \Session::set_flash("error", "このカテゴリは支出で使われているため削除できません");
        }
        \Response::redirect("category");
    }
}