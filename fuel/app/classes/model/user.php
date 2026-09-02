<?php
class Model_User{
    public static function find_by_username($username){
        return \DB::select("id","username","password")
        ->from("user")
        ->where("username","=",$username)
        ->execute()
        ->current()?:null;
    }

    //既に使用された名前の場合の処理
    public static function username_exists($username){
        return static::find_by_username($username)!==null;
    }

    public static function create($username,$password){
        list($id,)=\DB::insert("user")
            ->Set(array(
                "username"=>$username,
                "password"=>password_hash("$password",PASSWORD_DEFAULT),
                "created_at"=>\Date::forge()->format("mysql"),
                "updated_at"=>\Date::forge()->format("mysql")
            ))

            ->execute();
            return $id;
    }
}