<?php
/**
 * 404ページ用プレゼンター。
 */
class Presenter_Welcome_404 extends Presenter
{
	public function view()
	{
		$this->title = 'ページが見つかりません';
	}
}
