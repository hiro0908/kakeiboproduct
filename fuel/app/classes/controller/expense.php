<?php

class Controller_Expense extends Controller_Base{
    public function action_index(){
        $this->template->title="支出一覧";
        $this->template->content=\View::forge("expense/index",array(
            "expenses"=>\Model_Expense::all_by_user($this->current_user["id"])
        ));
    }

    public function action_new(){
        if (\Input::method()=="POST"){
            return $this->handle_create();
        }
        $this->template->title="支出の新規作成";
        $this->template->content=\View::forge("expense/new",array(
            "categories"=>\Model_Category::all_by_user($this->current_user["id"]),
        ));
    }
    protected function handle_create(){
        $categories=\Model_Category::all_by_user($this->current_user["id"]);
        $max_amount=\Config::get("kakeibo.max_expense_amount",1000000);

        $val=\Validation::forge();
        $val->add_field("title","タイトル","required|max_length[100]");
        $val->add_field("amount","金額","required|numeric_min[1]|numeric_max[{$max_amount}]");
        $val->add_field("expense_date","支出日","required|valid_date");
        $val->add_field("category_id","カテゴリ","required");
        $val->add_field("memo","メモ","max_length[255]");

        if (!$val->run()){
            $this->template->title="支出の新規登録";
            $this->template->content=\View::forge("expense/new",array(
                "categories"=>$categories,
                "errors"=>$val->error_message(),
            ));
            return;
        }

        $category_id=\Input::post("category_id");

        if (\Model_Category::find($category_id,$this->current_user["id"])===null){
            $this->template->title="支出の新規登録";
            $this->template->content=\View::forge("expense/new",array(
                "categories"=>$categories,
                "errors"=>array("選択したカテゴリが不正です"),
            ));
            return;
        }
        \Model_Expense::create(
            $this->current_user["id"],
            $category_id,
            \Input::post("title"),
            \Input::post("amount"),
            \Input::post("expense_date"),
            \Input::post("memo")?:null
        );
        \Response::redirect("expense");
    }

    public function action_edit($id){
        $expense=\Model_Expense::find($id,$this->current_user["id"]);

        if($expense===null){
            throw new \HttpNotFoundException();
        }
        if (\Input::method()==="POST"){
            return $this->handle_update($id,$expense);
        }
        $this->template->title="支出の編集";
        $this->template->content=\View::forge("expense/edit",array(
            "expense"=>$expense,
            "categories"=>\Model_Category::all_by_user($this->current_user["id"]),
        ));
    }

    protected function handle_update($id,$expense){
        $categories=\Model_Category::all_by_user($this->current_user["id"]);
        $max_amount=\Config::get("kakeibo.max_expense_amount",1000000);

        $val=\Validation::forge();
        $val->add_field("title","タイトル","required|max_length[100]");
        $val->add_field("amount","金額","required|numeric_min[1]|numeric_max[{$max_amount}]");
        $val->add_field("expense_date","支出日","required|valid_date");
        $val->add_field("category_id","カテゴリ","required");
        $val->add_field("memo","メモ","max_length[255]");

        if(!$val->run()){
            $this->template->title="支出の編集";
            $this->template->content=\View::forge("expense/edit",array(
                "expense"=>$expense,
                "categories"=>$categories,
                "errors"=>$val->error_message(),
            ));
            return;
        }

        $category_id=\Input::post("category_id");

        if(\Model_Category::find($category_id,$this->current_user["id"])===null){
            $this->template->title="支出の編集";
            $this->template->content=\View::forge("expense/edit",array(
                "expense"=>$expense,
                "categories"=>$categories,
                "errors"=>array("選択したカテゴリが不正です"),
            ));
            return;
        }
        \Model_Expense::update(
            $id,
            $this->current_user["id"],
            $category_id,
            \Input::post("title"),
            \Input::post("amount"),
            \Input::post("expense_date"),
            \Input::post("memo")?:null
        );

        \Response::redirect("expense");
    }
        public function action_delete($id){
            if (\Input::method()!=="POST"){
                throw new \HttpNotFoundException();
            }

            \Model_Expense::delete($id,$this->current_user["id"]);
            \Response::redirect("expense");
        }
}