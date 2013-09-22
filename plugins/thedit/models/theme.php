<?php

/**
 * PX Plugin "thedit"
 */
class pxplugin_thedit_models_theme{

	private $px;
	private $theme_id;
	private $plugin_obj;

	/**
	 * コンストラクタ
	 * @param $command = PXコマンド配列
	 * @param $px = PxFWコアオブジェクト
	 */
	public function __construct( $px, $theme_id, $plugin_obj ){
		$this->px = $px;
		$this->theme_id = $theme_id;
		$this->plugin_obj = $plugin_obj;
	}

	/**
	 * factory: レイアウトモデル
	 */
	public function factory_model_layout( $layout_id ){
		$class_name = $this->px->load_px_plugin_class('/thedit/models/layout.php');
		$obj = new $class_name( $this->px, $layout_id, $this->plugin_obj, $this );
		return $obj;
	}

	/**
	 * テーマのパスを取得する
	 */
	public function get_path_dir(){
		$path_theme_dir = $this->plugin_obj->get_path_theme_dir().$this->get_theme_id().'/';
		return $path_theme_dir;
	}

	/**
	 * テーマIDを取得
	 */
	public function get_theme_id(){
		return $this->theme_id;
	}

	/**
	 * レイアウトの一覧を取得
	 */
	public function get_layout_list(){
		$path_theme_dir = $this->get_path_dir();
		$items = $this->px->dbh()->ls( $path_theme_dir );
		$rtn = array();
		foreach( $items as $basename ){
			if( !is_file( $path_theme_dir.$basename ) ){
				continue;
			}
			if( !preg_match( '/\.html$/s', $basename ) ){
				continue;
			}
			array_push( $rtn, preg_replace( '/\.html$/s', '', $basename ) );
		}
		return $rtn;
	}// get_layout_list()

	/**
	 * テーマが存在しているか確認する
	 */
	public function is_theme_exists(){
		if( !strlen( $this->get_theme_id() ) ){
			return false;
		}
		if( !preg_match( '/^[a-zA-Z0-9\_]+$/', $this->get_theme_id() ) ){
			return false;
		}
		$path_theme_dir = $this->plugin_obj->get_path_theme_dir().$this->get_theme_id();
		if( !is_dir($path_theme_dir) ){
			return false;
		}
		return true;
	}

}

?>
