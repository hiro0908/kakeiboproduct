<?php

class Model_Budget{
    public static function find_by_month($user_id,$year,$month){
        return \DB::select("id","amount")
        ->from("budget")
        ->where("user_id","=",$user_id)
        ->where("year","=",$year)
        ->where("month","=",$month)
        ->execute()
        ->current()?:null;
    }

    public static function set($user_id,$year,$month,$amount){
        $existing=static::find_by_month($user_id,$year,$month);
        if($existing === null){
            list($id,)=\DB::insert("budget")
                ->set(array(
                    "user_id"=>$user_id,
                    "year"=>$year,
                    "month"=>$month,
                    "amount"=>$amount,
                    "created_at"=>\Date::forge()->format("mysql"),
                    "updated_at"=>\Date::forge()->format("mysql"),
                ))
                ->execute();
            return $id;
        }

        \DB::update("budget")
            ->set(array(
                "amount"=>$amount,
                "updated_at"=>\Date::forge()->format("mysql")
            ))
            ->where("id","=",$existing["id"])
            ->execute();
        return $existing["id"];
    }
    public static function delete_by_user($user_id){
        return \DB::delete("budget")
            -> where("user_id","=",$user_id)
            -> execute();
    }
}