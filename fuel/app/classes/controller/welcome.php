<?php
/**
 * アプリの404ページ用コントローラ。
 * routes.php の _404_ ルートから呼ばれる。
 */
class Controller_Welcome extends Controller
{
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}
