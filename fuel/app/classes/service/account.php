<?php

namespace Service;

class Account{
    public static function withdraw($user_id){
        \DB::start_transaction();
        try{
            \DB::delete("expense")->where("user_id","=",$user_id)->execute();
            \DB::delete("budget")->where("user_id","=",$user_id)->execute();
            \DB::delete("category")->where("user_id","=",$user_id)->execute();
            \Model_User::delete($user_id);
            \DB::commit_transaction();
        }catch (\Exception $e){
            \DB::rollback_transaction();
            throw $e;
        }
    }
}