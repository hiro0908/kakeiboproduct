<?php

namespace Service;

class Account{
    public static function withdraw($user_id){
        \DB::start_transaction();
        try{
            \Model_Expense::delete_by_user($user_id);
            \Model_Budget::delete_by_user($user_id);
            \Model_Category::delete_by_user($user_id);
            \Model_User::delete($user_id);
            \DB::commit_transaction();
        }catch (\Exception $e){
            \DB::rollback_transaction();
            throw $e;
        }
    }
}