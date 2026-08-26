<?php

namespace Service;
class Theme
{
    const LIGHT = "light";
    const DARK="dark";
    public static function resolve(){
        $cookie_name=\Config::get("kakeibo.theme_cookie_name","kakeibo_theme");
        $default=\Config::get("kakeibo.default_theme",static::LIGHT);
        $theme = \Cookie::get($cookie_name,$default);

        return in_array($theme,array(static::LIGHT,static::DARK),true)?$theme:$default;
    }
}