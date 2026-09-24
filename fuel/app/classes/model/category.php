<?php

class Model_Category{
    public static function all_by_user($user_id){
        return \DB::select("id", "name", "created_at")
            -> from("category")
            -> where("user_id", "=", $user_id)
            -> order_by("name", "asc")
            -> execute()
            -> as_array();
    }
    public static function find($id, $user_id){
        return \DB::select("id","user_id","name")
            -> from("category")
            -> where("id", "=", $id)
            -> where("user_id", "=", $user_id)
            -> execute()
            -> current() ? : null;
    }

    public static function name_exists($user_id, $name, $exclude_id = null){
        $query = \DB::select("id")
            -> from("category")
            -> where("user_id","=",$user_id)
            -> where("name","=",$name);
        if ($exclude_id !== null){
            $query -> where("id", "!=", $exclude_id);
        }
        return $query -> execute() -> count() > 0;
    }
    public static function create($user_id, $name){
        list($id,)=\DB::insert("category")
            -> set(array(
                "user_id"    => $user_id,
                "name"       => $name,
                "created_at" => \Date::forge()->format("mysql"),
                "updated_at" => \Date::forge()->format("mysql"),
            ))
            -> execute();
        return $id;
    }

    public static function update($id, $user_id, $name){
        return \DB::update("category")
            -> set(array(
                "name"       => $name,
                "updated_at" => \Date::forge() -> format("mysql"),
            ))
            -> where("id","=",$id)
            -> where("user_id","=",$user_id)
            -> execute();
    }
    public static function delete($id, $user_id){
        return \DB::delete("category")
            -> where("id", "=", $id)
            -> where("user_id", "=", $user_id)
            -> execute();
    } 
    public static function delete_by_user($user_id){
        return \DB::delete("category")
            -> where("user_id", "=", $user_id)
            -> execute();
    }
}