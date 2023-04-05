<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://raihan.website
 * @since      1.0.0
 *
 * @package    Book_Management
 * @subpackage Book_Management/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Book_Management
 * @subpackage Book_Management/includes
 * @author     Raihan Islam <raihanislam.cse@gmail.com>
 */
class Book_Management_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	private $table_activator;

	public function __construct($activator){
		$this->table_activator = $activator;
	}

	public function deactivate() {
		global $wpdb;
		//$wpdb->query("DROP TABLE IF EXISTS {$this->Book_table_prefix()}");
		$wpdb->query("DROP TABLE IF EXISTS ".$this->table_activator->Book_table_prefix());
		$wpdb->query("DROP TABLE IF EXISTS ". $this->table_activator->wp_smc_tbl_book_shelf());


		$get_data = $wpdb->get_row(
				$wpdb->prepare(
					"SELECT ID from " . $wpdb->prefix . "posts WHERE Post_name = %s",'book_tool'
				)
		);

		$page_id = $get_data->ID;
		if($page_id > 0){
			wp_delete_post($page_id ,true);
		}
	}

	// public function Book_table_prefix(){
	// 	global $wpdb;
	// 	return $wpdb->prefix . "book_table";
	// }

}