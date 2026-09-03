<?php

class Model_Expense{
    public static function all_by_user($user_id){
        return \DB::select("expense.id","expense.title","expense.amount","expense.expense_date","expense.memo","category.name as category_name")
            ->from("expense")
            ->join("category")
            ->on("category.id","=","expense.category_id")
            ->where("expense.user_id","=",$user_id)
            ->order_by("expense.expense_date","desc")
            ->execute()
            ->as_array();
    }

    public static function find($id,$user_id){
        return \DB::select("id","user_id","category_id","title","amount","expense_date","memo")
        ->from("expense")
        ->where("id","=",$id)
        ->where("user_id","=",$user_id)
        ->execute()
        ->current()?:null;
    }

    public static function create($user_id,$category_id,$title,$amount,$expense_date,$memo){
        list($id,)=\DB::insert("expense")
            ->set(array(
                "user_id"=>$user_id,
                "category_id"=>$category_id,
                "title"=>$title,
                "amount"=>$amount,
                "expense_date"=>$expense_date,
                "memo"=>$memo,
                "created_at"=>\Date::forge()->format("mysql"),
                "updated_at"=>\Date::forge()->format("mysql"),
            ))
            ->execute();
            return $id;
    }

    public static function update($id,$user_id,$category_id,$title,$amount,$expense_date,$memo){
        return \DB::update("expense")
            ->set(array(
                "category_id"=>$category_id,
                "title"=>$title,
                "amount"=>$amount,
                "expense_date"=>$expense_date,
                "memo"=>$memo,
                "updated_at"=>\Date::forge()->format("mysql"),
            ))
            ->where("id","=",$id)
            ->where("user_id","=",$user_id)
            ->execute();
    }

    public static function delete($id,$user_id){
        return \DB::delete("expense")
        ->where("id","=",$id)
        ->where("user_id","=",$user_id)
        ->execute();
    }
}