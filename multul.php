<?php

/*
Plugin Name: multul
Plugin URI: https://github.com/TIgorr/Multul-Wordpress-Module
Description: Multul Wordpress Module
Author: Alter
Version: 0.1
Author URI:
 */

if (is_admin ()) {
	include_once ABSPATH . 'wp-content/plugins/multul/admin.php';
	$multul_adm = new multul_adm();
	register_activation_hook(__FILE__, array($multul_adm, 'multul_install'));
	register_deactivation_hook(__FILE__, array($multul_adm, 'multul_uninstall'));
}

function multul_get_link($author) {
	global $current_user;
	$comment		= get_comment($comment_ID);
	$user_id		= $comment->user_id;
	$current_id		= $current_user->id;
	$capabilities	= $current_user->wp_capabilities;

	if (!empty($capabilities) && $current_id != $user_id && get_option('multul_ucp_status')) {
		echo $author . '<a href="javascript:;" onclick="multul.im.openContact(' . $user_id . ',\'' . $author . '\')"><img src="http://multul.ru/media/images/messenger/chats.gif" alt="" /></a><br>';
	} else {
		echo $author;
	}
}

add_filter('get_comment_author', 'multul_get_link');

function multul_init() {
	global $current_user;
	require ABSPATH . 'wp-content/plugins/multul/multul_lib.php';

	$capabilities	= $current_user->wp_capabilities;
	$user_id		= $current_user->id;
	$user_name		= $current_user->user_login;
	$multul_id		= get_option('multul_id');
	$multul_key		= get_option('multul_key');

	if (!empty($capabilities) && $multul_id && $multul_key) {
		$config = array(
			'app_id'		=> $multul_id,
			'secret_key'	=> $multul_key,
			'uid'			=> $user_id,
			'name'			=> $user_name,
		);

		$multul = Multul::factory($config)->render();
		return $multul;
	}
}

function remove_footer() {
    if (get_option('multul_ucp_status')){
	echo multul_init();
    }
}

add_filter('wp_footer', 'remove_footer');

function remove_adm_footer(){
    if (get_option('multul_acp_status')){
        echo multul_init();
    }
}

add_filter('admin_footer','remove_adm_footer');