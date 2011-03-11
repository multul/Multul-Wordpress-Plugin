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
                add_option('multul_acp_status',true);
                add_option('multul_ucp_status',true);
	}

	public function multul_uninstall(){
		delete_option('multul_id');
		delete_option('multul_key');
                delete_option('multul_acp_status');
                delete_option('multul_ucp_status');
	}

	public function multul_options(){
                get_option('multul_acp_status') ? $multul_acp_status = 'On' : $multul_acp_status = 'Off';
                get_option('multul_ucp_status') ? $multul_ucp_status = 'On' : $multul_ucp_status = 'Off';

                if ($_POST){
			update_option('multul_id',trim($_POST['multul_id']));
			update_option('multul_key',trim($_POST['multul_key']));
                        $_POST['acp_active'] == 'On' ? update_option('multul_acp_status',true) : update_option('multul_acp_status',false);
                        $_POST['ucp_active'] == 'On' ? update_option('multul_ucp_status',true) : update_option('multul_ucp_status',false);
		}
                include ABSPATH.'wp-content/plugins/multul/multul.html';
        }
}
