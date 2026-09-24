<?php

class Controller_Expense extends Controller_Base{
    protected function find_expense_or_404($id){
        $expense = \Model_Expense::find($id, $this -> current_user["id"]);
        if ($expense === null){
            throw new \HttpNotFoundException();
        }
        return $expense;
    }
    public function action_index(){
        $allowed_sort = array(
            "date"    => "expense_date",
            "amount"  => "amount",
            "title"   => "title",
        );

        $allowed_dir = array("asc", "desc");
        $year        = \Input::get("year")  ? : (int) date("Y");
        $month       = \Input::get("month") ? : (int) date("n");
        $category_id = \Input::get("category_id" ? : null);
        $sort_key    = \Input::get("sort","date");
        $dir         = \Input::get("dir","desc");
        $sort_column = array_key_exists($sort_key, $allowed_sort) ? $allowed_sort[$sort_key] : "expense_date";
        $sort_dir    = in_array($dir, $allowed_dir, true) ? $dir : "desc";
        $per_page    = (int) \Input::get("per_page", \Config::get("kakeibo.list_per_page", 10));
        $allowed_per_page  = array(10, 50, 100);
        $date_toggle_dir   = ($sort_key === "date"   and $sort_dir === "asc") ? "desc" : "asc";
        $amount_toggle_dir = ($sort_key === "amount" and $sort_dir === "asc") ? "desc" : "asc";
        if(!in_array($per_page, $allowed_per_page, true)){
            $per_page = \Config::get("kakeibo.list_per_page", 10);
        }
        $this -> template -> title   = "支出一覧";
        $this -> template -> content = \View::forge("expense/index", array(
            "expenses"  => \Model_Expense::all_by_user($this -> current_user["id"], array(
                "year"        => $year,
                "month"       => $month,
                "category_id" => $category_id,
                "sort_by"     => $sort_column,
                "sort_dir"    => $sort_dir,
                "limit"       => $per_page,
            )),
            "categories"         => \Model_Category::all_by_user($this -> current_user["id"]),
            "category_totals"    => \Model_Expense::total_by_category($this -> current_user["id"],$year,$month),
            "filter_year"        => $year,
            "filter_month"       => $month,
            "filter_category_id" => $category_id,
            "sort_key"           => $sort_key,
            "sort_dir"           => $sort_dir,
            "filter_per_page"    => $per_page,
            "date_toggle_dir"    => $date_toggle_dir,
            "amount_toggle_dir"  => $amount_toggle_dir,

        ));


    }

    protected function json($date,$status=200){
        return \Response::forge(json_encode($date), $status, array("Content-Type" => "application/json"));
    }

    public function get_new(){
        $this -> template -> title   = "支出の新規作成";
        $this -> template -> content = \View::forge("expense/new", array(
            "categories" => \Model_Category::all_by_user($this -> current_user["id"]),
        ));
    }
    public function post_new(){
        $categories = \Model_Category::all_by_user($this -> current_user["id"]);
        $max_amount = \Config::get("kakeibo.max_expense_amount", 1000000);

        $val = \Validation::forge();
        $val -> add_field("title", "タイトル", "required|max_length[100]");
        $val -> add_field("amount", "金額", "required|numeric_min[1]|numeric_max[{$max_amount}]");
        $val -> add_field("expense_date", "支出日", "required|valid_date");
        $val -> add_field("category_id", "カテゴリ", "required");
        $val -> add_field("memo", "メモ", "max_length[255]");

        if (!$val -> run()){
            if (\Input::is_ajax()){
                return $this  -> json(array(
                    "success" => false,
                    "errors"  => array_values($val -> error_message())
                    ));
            }
            $this -> template -> title   = "支出の新規登録";
            $this -> template -> content = \View::forge("expense/new", array(
                "categories" => $categories,
                "errors"     => $val -> error_message(),
            ));
            return;
        }

        $category_id = \Input::post("category_id");
        $category    = \Model_Category::find($category_id, $this -> current_user["id"]);

        if ($category === null){
            $this -> template -> title   = "支出の新規登録";
            $this -> template -> content = \View::forge("expense/new", array(
                "categories"  => $categories,
                "errors"      => array("選択したカテゴリが不正です"),
            ));
            return;
        }
        $id = \Model_Expense::create(
            $this -> current_user["id"],
            $category_id,
            \Input::post("title"),
            \Input::post("amount"),
            \Input::post("expense_date"),
            \Input::post("memo") ? : null
        );

        if(\Input::is_ajax()){
            $expense = \Model_Expense::find($id,$this->current_user["id"]);
            $expense["category_name"] = $category["name"];
            return $this -> json(array("success"=>true,"expense"=>$expense));
        }
        \Response::redirect("expense");
    }

    public function get_edit($id){
        $expense = $this  -> find_expense_or_404($id);
        $this -> template -> title   = "支出の編集";
        $this -> template -> content = \View::forge("expense/edit",array(
            "expense"    => $expense,
            "categories" => \Model_Category::all_by_user($this->current_user["id"]),
        ));
    }

    public function post_edit($id){
        $expense    = \Model_Expense::find($id,$this -> current_user["id"]);
        $categories = \Model_Category::all_by_user($this -> current_user["id"]);
        $max_amount = \Config::get("kakeibo.max_expense_amount",1000000);

        $val = \Validation::forge();
        $val -> add_field("title", "タイトル", "required|max_length[100]");
        $val -> add_field("amount", "金額", "required|numeric_min[1]|numeric_max[{$max_amount}]");
        $val -> add_field("expense_date", "支出日","required|valid_date");
        $val -> add_field("category_id", "カテゴリ","required");
        $val -> add_field("memo", "メモ", "max_length[255]");

        if(!$val  -> run()){
            $this -> template -> title   = "支出の編集";
            $this -> template -> content = \View::forge("expense/edit", array(
                "expense"     => $expense,
                "categories"  => $categories,
                "errors"      => array_values($val -> error_message()),
            ));
            return;
        }

        $category_id = \Input::post("category_id");
        $category    = \Model_Category::find($category_id,$this->current_user["id"]);

        if($category === null){
            if(\Input::is_ajax()){
                return $this -> json(array("success" => false, "errors" => array("選択したカテゴリーが不正です")));
            }
            $this -> template -> title   = "支出の編集";
            $this -> template -> content = \View::forge("expense/edit", array(
                "expense"    => $expense,
                "categories" => $categories,
                "errors"     => array("選択したカテゴリが不正です"),
            ));
            return;
        }
        \Model_Expense::update(
            $id,
            $this -> current_user["id"],
            $category_id,
            \Input::post("title"),
            \Input::post("amount"),
            \Input::post("expense_date"),
            \Input::post("memo") ? : null
        );

        if (\Input::is_ajax()){
            $updated = Model_Expense::find($id, $this -> current_user["id"]);
            $updated["category_name"] = $category["name"];
            return $this -> json(array("success" => true,"expense" => $updated));
        }

        \Response::redirect("expense");
    }
    public function post_delete($id){
        \Model_Expense::delete($id, $this -> current_user["id"]);
        if (\Input::is_ajax()){
            return $this -> json(array("success" => true));
        }
        \Response::redirect("expense");
    }
}