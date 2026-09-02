<?php

namespace Service;

class Category{
    public static function is_in_use($category_id){
        return \DB::select("id")
            ->from("expense")
            ->where("category_id","=",$category_id)
            ->execute()
            ->count()>0;
    }

    public static function delete($id,$user_id){
        if (static::is_in_use($id)){
            return false;#使用中なので削除できない
        }
        \Model_Category::delete($id,$user_id);
        return true;
    }
}