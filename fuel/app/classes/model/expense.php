<?php

class Model_Expense{
    public static function all_by_user($user_id,$filters=array()){
        $query= \DB::select("expense.id", "expense.title", "expense.amount", "expense.expense_date", "expense.memo", "expense.category_id", array("category.name", "category_name"))
            -> from("expense")
            -> join("category")
            -> on("category.id", "=", "expense.category_id")
            -> where("expense.user_id","=",$user_id);
        if (!empty($filters["year"]) and !empty($filters["month"])){
            $start  = sprintf("%04d-%02d-01", $filters["year"], $filters["month"]);
            $end    = date("Y-m-t",strtotime($start));
            $query  -> where("expense.expense_date", ">=", $start)
                    -> where("expense.expense_date", "<=", $end);
        }

        if (!empty($filters["category_id"])){
            $query -> where("expense.category_id", "=", $filters["category_id"]);
        }

        if (!empty($filters["limit"])){
            $query -> limit((int) $filters["limit"]);
        }

        $sort_by  = !empty($filters["sort_by"])?$filters["sort_by"]:"expense_date";
        $sort_dir = !empty($filters["sort_dir"])?$filters["sort_dir"]:"desc";

        return $query -> order_by("expense." . $sort_by,$sort_dir)
            -> execute()
            -> as_array();
    }

    public static function find($id,$user_id){
        return \DB::select("id","user_id","category_id","title","amount","expense_date","memo")
        -> from("expense")
        -> where("id", "=", $id)
        -> where("user_id", "=", $user_id)
        -> execute()
        -> current() ? : null;
    }

    public static function create($user_id, $category_id, $title, $amount, $expense_date, $memo){
        list($id,) = \DB::insert("expense")
            -> set(array(
                "user_id"      => $user_id,
                "category_id"  => $category_id,
                "title"        => $title,
                "amount"       => $amount,
                "expense_date" => $expense_date,
                "memo"         => $memo,
                "created_at"   => \Date::forge() -> format("mysql"),
                "updated_at"   => \Date::forge() -> format("mysql"),
            ))
            -> execute();
            return $id;
    }

    public static function update($id,$user_id, $category_id, $title, $amount, $expense_date, $memo){
        return \DB::update("expense")
            -> set(array(
                "category_id"  => $category_id,
                "title"        => $title,
                "amount"       => $amount,
                "expense_date" => $expense_date,
                "memo"         => $memo,
                "updated_at"   => \Date::forge()->format("mysql"),
            ))
            -> where("id", "=", $id)
            -> where("user_id", "=", $user_id)
            -> execute();
    }

    public static function delete($id, $user_id){
        return \DB::delete("expense")
        -> where("id", "=", $id)
        -> where("user_id", "=", $user_id)
        -> execute();
    }

    public static function delete_by_user($user_id){
        return \DB::delete("expense")
        -> where ("user_id", "=", $user_id)
        -> execute();
    }

    public static function total_by_month($user_id, $year, $month){
        $start  = sprintf("%04d-%02d-01", $year, $month);
        $end    = date("Y-m-t",strtotime($start));
        $result = \DB::select(array(\DB::expr("SUM(amount)"), "total"))
            -> from("expense")
            -> where("user_id", "=", $user_id)
            -> where("expense_date", ">=", $start)
            -> where("expense_date", "<=", $end)
            -> execute()
            -> get("total");
        return (int) $result;
    }

    public static function total_by_category($user_id, $year, $month){
        $start = sprintf("%04d-%02d-01", $year, $month);
        $end   = date("Y-m-t", strtotime($start));

        return \DB::select("category.name", array(\DB::expr("SUM(expense.amount)"), "total"))
            -> from("expense")
            -> join("category")
            -> on("category.id", "=", "expense.category_id")
            -> where("expense.user_id", "=", $user_id)
            -> where("expense.expense_date" ,">=", $start)
            -> where("expense.expense_date", "<=", $end)
            -> group_by("category.id")
            -> execute()
            -> as_array();
    }

    public static function monthly_totals($user_id, $months = 6){
        $result = array();
        $now    = new \Datetime();
        for($i = $months-1; $i >= 0; $i--){
            $date     =  clone $now;
            $date     -> modify("-{$i} months");
            $year     =  (int) $date->format("Y");
            $month    =  (int) $date->format("n");
            $result[] =  array(
                "label" => $date -> format("Y/m"),
                "total" => static::total_by_month($user_id, $year, $month),
            );
        }
        return $result;
    }
}