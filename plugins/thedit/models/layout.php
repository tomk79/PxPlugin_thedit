<?php

/**
 * PX Plugin "thedit"
 */
class pxplugin_thedit_models_layout{

	private $layout_id;
	private $theme_obj;
	private $plugin_obj;

	/**
	 * コンストラクタ
	 * @param $command = PXコマンド配列
	 * @param $px = PxFWコアオブジェクト
	 */
	public function __construct( $px, $layout_id, $plugin_obj, $theme_obj ){
		$this->px = $px;
		$this->layout_id = $layout_id;
		$this->theme_obj = $theme_obj;
		$this->plugin_obj = $plugin_obj;
	}

	/**
	 * レイアウトIDを取得
	 */
	public function get_layout_id(){
		return $this->layout_id;
	}

	/**
	 * テーマIDを取得
	 */
	public function get_theme_id(){
		return $this->theme_obj->get_theme_id();
	}

}

?>
