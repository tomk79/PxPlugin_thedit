<?php

/**
 * PX Plugin "thedit"
 */
class pxplugin_thedit_editor_main{

	private $px;
	private $plugin_obj;
	private $theme_obj;
	private $layout_obj;

	/**
	 * コンストラクタ
	 * @param $command = PXコマンド配列
	 * @param $px = PxFWコアオブジェクト
	 */
	public function __construct( $px, $plugin_obj, $theme_obj, $layout_obj ){
		$this->px = $px;
		$this->plugin_obj = $plugin_obj;
		$this->theme_obj = $theme_obj;
		$this->layout_obj = $layout_obj;
	}

	/**
	 * 編集画面を出力
	 */
	public function execute(){
		return $this->page_home();
	}

	/**
	 * ホーム画面
	 */
	private function page_home(){
		header('Content-type: text/html');
		$src = '';
		$src .= '<html>'."\n";
		$src .= '<head>'."\n";
		$src .= '<title>thedit - Pickles Framework</title>'."\n";
		$src .= '</head>'."\n";
		$src .= '<body>'."\n";
		$src .= '<p>開発中です。</p>'."\n";
		$src .= '<p><a href="'.t::h($this->plugin_obj->href( ':property.'.$this->theme_obj->get_theme_id() )).'">キャンセル</a></p>'."\n";
		$src .= '</body>'."\n";
		$src .= '</html>'."\n";
		print $src;
		exit;
	}



}

?>
