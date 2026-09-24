<?php
namespace Service;

class Auth{
    public static function attempt($username, $password){
        $user = \Model_User::find_by_username($username);
        if($user === null){
            return null;
        }
        if(!password_verify($password, $user["password"])){
            return null;
        }
        return $user;
    }
    public static function login($user){
        \Session::Set("user", array(
            "id"       => $user["id"],
            "username" => $user["username"],
        ));
        \Session::instance() -> rotate();
    }
    public static function logout(){
        \Session::delete("user");
    }
}