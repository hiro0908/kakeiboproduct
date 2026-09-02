<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010-2026 Fuel Development Team
 * @link       https://fuelphp.com
 */

return array(
	/**
	 * -------------------------------------------------------------------------
	 *  Default route
	 * -------------------------------------------------------------------------
	 *
	 */

	'_root_' => 'welcome/index',

	/**
	 * -------------------------------------------------------------------------
	 *  Page not found
	 * -------------------------------------------------------------------------
	 *
	 */

	"_400_"=>function(){
		return Response::forge(View::forge("400"),400);
	},
	"_403_" => function(){
		return Response::forge(View::forge("403"),403);
	},
	'_404_' => 'welcome/404',
	"_500_"=>function(){
		return Response::forge(View::forge("500"),500);
	},

	/**
	 * -------------------------------------------------------------------------
	 *  Example for Presenter
	 * -------------------------------------------------------------------------
	 *
	 *  A route for showing page using Presenter
	 *
	 */

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
	'home' => 'home/index',
	"register"=>"register/index",
	"login"=>"login/index",
	"logout"=>"login/logout"
);
