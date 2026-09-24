<?php

namespace Service;
class Theme{
    const LIGHT = "light";
    const DARK  = "dark";
    public static function resolve(){
        $cookie_name = \Config::get("kakeibo.theme_cookie_name", "kakeibo_theme");
        $default     = \Config::get("kakeibo.default_theme", static::LIGHT);
        $theme       = \Cookie::get($cookie_name, $default);

        return in_array($theme, array(static::LIGHT,static::DARK), true) ? $theme : $default;
    }
    public static function set($theme){
        if(!in_array($theme, array(static::LIGHT,static::DARK), true)){
            $theme = \Config::get("kakeibo.default_theme", static::LIGHT);
        }

        $cookie_name = \Config::get("kakeibo.theme_cookie_name", "kakeibo_theme");
        $expiry      = \Config::get("kakeibo.theme_cookie_expiry", 60*60*24*365);
        \Cookie::set($cookie_name, $theme, $expiry);
    }
}