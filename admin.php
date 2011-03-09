<?php

class multul_adm{

	function __construct(){
		add_action('admin_menu', array('multul_adm', 'add_admin_page'));
	}

	public function add_admin_page(){
		add_menu_page('Multul','Multul','10','Multul',array('multul_adm','multul_options'));
	}

	public function multul_install(){
		add_option('multul_id','id');
		add_option('multul_key','key');
	}

	public function multul_uninstall(){
		delete_option('multul_id');
		delete_option('multul_key');
	}

	public function multul_options(){
		if ($_POST){
			update_option('multul_id',$_POST['multul_id']);
			update_option('multul_key',$_POST['multul_key']);
		}
		include ABSPATH.'wp-content/plugins/multul/multul.html';
	}
}
