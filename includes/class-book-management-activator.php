<?php

/**
 * Fired during plugin activation
 *
 * @link       https://raihan.website
 * @since      1.0.0
 *
 * @package    Book_Management
 * @subpackage Book_Management/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Book_Management
 * @subpackage Book_Management/includes
 * @author     Raihan Islam <raihanislam.cse@gmail.com>
 */
class Book_Management_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

		$book_create = "CREATE TABLE `".$this->Book_table_prefix()."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(200) NOT NULL,
			`amount` int(11) NOT NULL,
			`description` text NOT NULL,
			`book_image` varchar(250) NOT NULL,
			`language` varchar(200) NOT NULL,
			`status` int(11) NOT NULL DEFAULT 1,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			PRIMARY KEY (`id`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

			require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
		   dbDelta( $book_create );


		   $shelf_table = "CREATE TABLE `".$this->wp_smc_tbl_book_shelf()."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`shelf_name` varchar(150) NOT NULL,
			`capacity` int(11) NOT NULL,
			`shelf_location` varchar(200) NOT NULL,
			`status` int(11) NOT NULL DEFAULT '1',
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

			require_once (ABSPATH.'wp-admin/includes/upgrade.php');
			dbDelta($shelf_table);

			$insert_query = "INSERT into ".$this->wp_smc_tbl_book_shelf()." (shelf_name, capacity, shelf_location, status) VALUES 
				('Shelf 1', 230, 'Left Cornor', 1), 
				('Shelf 2', 300, 'Right Cornor', 1), 
				('Shelf 3', 100, 'Center Top', 1)";

			$wpdb->query($insert_query);


			$post_array_data = array(
					'post_title' => "Book Tool",
					'post_name' => "book_tool",
					'post_status'  => 'publish',
					'post_author' => 1,
					'post_content' => "Simple Book Tool",
					'post_type' => "page"
			);

			wp_insert_post($post_array_data);
	}

	public function Book_table_prefix(){
		global $wpdb;
		return $wpdb->prefix . "book_table";
	}

	public function wp_smc_tbl_book_shelf(){

		global $wpdb;
		return $wpdb->prefix."smc_tbl_book_shelf";
	}

	

}