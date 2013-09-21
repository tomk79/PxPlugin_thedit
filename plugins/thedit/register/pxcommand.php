<?php
$this->load_px_class('/bases/pxcommand.php');

/**
 * PX Plugin "thedit"
 */
class pxplugin_thedit_register_pxcommand extends px_bases_pxcommand{

	private $command;

	private $path_data_dir;

	/**
	 * コンストラクタ
	 * @param $command = PXコマンド配列
	 * @param $px = PxFWコアオブジェクト
	 */
	public function __construct( $command , $px ){
		parent::__construct( $command , $px );
		$this->command = $this->get_command();
		$this->path_data_dir = $this->px->get_conf('paths.px_dir').'_sys/ramdata/plugins/thedit/';
		$this->start();
	}


	/**
	 * コンテンツ内へのリンク先を調整する。
	 */
	private function href( $linkto = null ){
		if(is_null($linkto)){
			return '?PX='.implode('.',$this->command);
		}
		if($linkto == ':'){
			return '?PX=plugins.thedit';
		}
		$rtn = preg_replace('/^\:/','?PX=plugins.thedit.',$linkto);

		$rtn = $this->px->theme()->href( $rtn );
		return $rtn;
	}

	/**
	 * コンテンツ内へのリンクを生成する。
	 */
	private function mk_link( $linkto , $options = array() ){
		if( !strlen($options['label']) ){
			if( $this->local_sitemap[$linkto] ){
				$options['label'] = $this->local_sitemap[$linkto]['title'];
			}
		}
		$rtn = $this->href($linkto);

		$rtn = $this->px->theme()->mk_link( $rtn , $options );
		return $rtn;
	}

	// ------------------------------------------------------------------------------------------------------------------

	/**
	 * 処理の開始
	 */
	private function start(){
		return $this->page_homepage();
	}

	/**
	 * ホームページを表示する。
	 */
	private function page_homepage(){

		$src = '';
		$src .= '<p>テーマを編集するプラグインです。</p>'."\n";
		$src .= ''."\n";

		$current_theme_id = $this->px->theme()->get_theme_id();

		$path_theme_dir = $this->px->get_conf('paths.px_dir').'themes/';
		$theme_id_list = $this->px->dbh()->ls( $this->px->get_conf('paths.px_dir').'themes' );
		foreach( $theme_id_list as $key=>$val ){
			if( !is_dir( $path_theme_dir.$val ) ){ unset( $theme_id_list[$key] ); }//ディレクトリじゃない場合は除外
			if( preg_match( '/^\./', $val ) ){ unset( $theme_id_list[$key] ); }//ドットで始まる場合は除外
		}

		if( !count($theme_id_list) ){
			$src .= '<p>テーマは登録されていません。</p>'."\n";
		}else{
			$src .= '<div class="unit">'."\n";
			$src .= '<table class="def" style="width:100%;">'."\n";
			$src .= '	<thead>'."\n";
			$src .= '	<tr>'."\n";
			$src .= '		<th>テーマID</th>'."\n";
			$src .= '		<th>テーマが定義しているアウトライン名</th>'."\n";
			$src .= '		<th>---</th>'."\n";
			$src .= '	</tr>'."\n";
			$src .= '	</thead>'."\n";
			foreach( $theme_id_list as $theme_id ){
				$src .= '	<tr>'."\n";
				$src .= '		<th style="word-break:break-all;"><span'.($current_theme_id==$theme_id?' class="current"':'').'>'.t::h($theme_id).'</span></th>'."\n";
				$src .= '		<td style="word-break:break-all;">'."\n";
				$outline_list = $this->px->dbh()->ls( $this->px->get_conf('paths.px_dir').'themes/'.$theme_id.'/' );
				foreach( $outline_list as $number=>$filename ){
					if( $this->px->dbh()->get_extension($filename) != 'html' ){
						unset($outline_list[$number]);
					}else{
						$outline_list[$number] = $this->px->dbh()->trim_extension( $outline_list[$number] );
					}
				}
				if( !count($outline_list) ){
					$src .= '		<div class="center">---</div>'."\n";
				}else{
					$src .= '		<div>'.implode(', ', $outline_list).'</div>'."\n";
				}
				$src .= '		</td>'."\n";
				$src .= '		<td class="center">'.($current_theme_id==$theme_id?'---':'<a href="?THEME='.t::h($theme_id).'">このテーマを適用する</a>').'</td>'."\n";
				$src .= '	</tr>'."\n";
			}
			$src .= '</table>'."\n";
			$src .= '</div>'."\n";
		}

		print $this->html_template($src);
		exit;
	}

}

?>
