<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://raihan.website
 * @since      1.0.0
 *
 * @package    Book_Management
 * @subpackage Book_Management/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Book_Management
 * @subpackage Book_Management/admin
 * @author     Raihan Islam <raihanislam.cse@gmail.com>
 */
class Book_Management_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	private $table_activator;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		require_once BOOKS_MANAGEMENT_TOOL_PLUGIN_PATH . 'includes/class-book-management-activator.php';
	    $activator = new Book_Management_Activator();
		$this->table_activator = $activator;

	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Book_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Book_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$valid_pages = array(
			"book-management-tool",
			"book-management-create-book-shelf",
			"book-management-list-book-shelf",
			"book-management-create-book",
			"book-management-list-book"
		);
		 $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';

		 if(in_array($page,$valid_pages)){
			wp_enqueue_style( 
				'book-bootstrap', 
				BOOK_MANAGEMENT_PLUGIN_URL . '/assets/css/bootstrap.min.css', 
				array(), $this->version, 'all' 
			);
			wp_enqueue_style( 
				'book-datatable', 
				BOOK_MANAGEMENT_PLUGIN_URL . '/assets/css/jquery.dataTables.min.css', 
				array(), $this->version, 'all' 
			);
			wp_enqueue_style( 
				'book-sweetalert', 
				BOOK_MANAGEMENT_PLUGIN_URL . '/assets/css/sweetalert.css', 
				array(), $this->version, 'all' 
			);

		 }
		// wp_enqueue_style( 
		// $this->plugin_name, 
		// plugin_dir_url( __FILE__ ) . 'css/book-management-admin.css', 
		// array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Book_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Book_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$valid_pages = array(
			"book-management-tool",
			"book-management-create-book-shelf",
			"book-management-list-book-shelf",
			"book-management-create-book",
			"book-management-list-book"
		);
		 $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
		 if(in_array($page,$valid_pages)){

			wp_enqueue_script("jquery");
			
			wp_enqueue_script( 
				'book-bootstrapjs', 
				BOOK_MANAGEMENT_PLUGIN_URL . '/assets/js/bootstrap.min.js',  
				array( 'jquery' ), $this->version, false 
			);
			wp_enqueue_script( 
				'book-dataTablesjs', 
				BOOK_MANAGEMENT_PLUGIN_URL . '/assets/js/jquery.dataTables.min.js',  
				array( 'jquery' ), $this->version, false 
			);
			wp_enqueue_script( 
				'book-validatejs', 
				BOOK_MANAGEMENT_PLUGIN_URL . '/assets/js/jquery.validate.min.js',  
				array( 'jquery' ), $this->version, false 
			);
			wp_enqueue_script( 
				'book-sweetalertjs', 
				BOOK_MANAGEMENT_PLUGIN_URL . '/assets/js/sweetalert.min.js',  
				array( 'jquery' ), $this->version, false 
			);

			wp_enqueue_script( 
				$this->plugin_name, 
				plugin_dir_url( __FILE__ ) . 'js/book-management-admin.js', 
				array( 'jquery' ), $this->version, false );

				wp_localize_script($this->plugin_name, "smc_book",array(
					"name" => "Smart Coder",
					"author" => "Raihan Islam",
					"ajaxurl" => admin_url("admin-ajax.php")
				));

		 }
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/book-management-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function book_management_menu(){
		add_menu_page("Book Management", "Book Management", "manage_options", 
		"book-management-tool", array($this, "book_management_plugin"));

    // create plugin submenus
		add_submenu_page("book-management-tool","Dashboard", "Dashboard", 
		"manage_options", "book-management-tool", 
		array($this, "book_management_plugin"));

		add_submenu_page("book-management-tool","Create Book Shelf", 
		"Create Book Shelf", "manage_options", "book-management-create-book-shelf", 
		array($this, "book_management_create_book_shelf"));

		add_submenu_page("book-management-tool","List Book Shelf", "List Book Shelf", 
		"manage_options", "book-management-list-book-shelf", 
		array($this, "book_management_list_book_shelf"));

		add_submenu_page("book-management-tool","Create Book", "Create Book", 
		"manage_options", "book-management-create-book", 
		array($this, "book_management_create_book"));

		add_submenu_page("book-management-tool","List Book", "List Book", 
		"manage_options", "book-management-list-book", 
		array($this, "book_management_list_book"));
	}


	public function book_management_create_book_shelf(){
		ob_start();
		
		include_once(BOOKS_MANAGEMENT_TOOL_PLUGIN_PATH."admin/partials/temp-create-book-shelf.php");

		$template = ob_get_contents();

		ob_end_clean();

		echo $template;
	}

	public function book_management_list_book_shelf(){

		global $wpdb;

		$book_shelf = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM " .$this->table_activator->wp_smc_tbl_book_shelf(),"" 
			)
			);
		//echo "ashdbhasdbasd";
		ob_start();
		
		include_once(BOOKS_MANAGEMENT_TOOL_PLUGIN_PATH."admin/partials/temp-list-book-shelf.php");

		$template = ob_get_contents();

		ob_end_clean();

		echo $template;
	}

	public function book_management_create_book(){
		
	}

	public function book_management_list_book(){
		echo "list Book Page";
	}

	public function  book_management_plugin(){
      global $wpdb;
	//   $user_email = $wpdb->get_var( "SELECT user_email from wp_users WHERE ID = 1" );
	//   echo $user_email;

	//   $user_data = $wpdb->get_row("SELECT * from wp_users WHERE ID = 1",ARRAY_A);
	//   echo "<pre>";
	//   print_r($user_data);

	//   $user_data = $wpdb->get_col("SELECT post_title from wp_posts");
	//   echo "<pre>";
	//   print_r($user_data);

	//   $user_data = $wpdb->get_results("SELECT * from wp_posts",ARRAY_A);
	//   echo "<pre>";
	//   print_r($user_data);

	//   $user_data = $wpdb->get_row(
	// 	$wpdb->prepare("SELECT * from wp_posts where ID = %d",1)
	// 	);
	//   echo "<pre>";
	//   print_r($user_data);
	
	}


	public function handle_ajax_requests_admin(){
		global $wpdb;
		$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';
		if(!empty($param )) {
			if($param == "first_simple_ajax"){
				echo json_encode(array(
					"status" => 1,
					"message" => "first ajax request",
					"data" => array(
						"name" => "Smart Coder",
						"author" => "raihan"
					)
				));
			}elseif($param == "create_book_shelf"){

				// get all data from form
				$name = isset($_REQUEST['txt_name']) ? $_REQUEST['txt_name'] : "";
				$capacity = isset($_REQUEST['txt_capacity']) ? $_REQUEST['txt_capacity'] : "";
				$location = isset($_REQUEST['txt_location']) ? $_REQUEST['txt_location'] : "";
				$status = isset($_REQUEST['dd_status']) ? $_REQUEST['dd_status'] : "";

				$wpdb->insert($this->table_activator->wp_smc_tbl_book_shelf(), array(
					"shelf_name" => $name,
					"capacity" => $capacity,
					"shelf_location" => $location,
					"status" => $status
				));

				if($wpdb->insert_id > 0){

					echo json_encode(array(
						"status" => 1,
						"message" => "Book Shelf created successfully"
					));
				}else{

					echo json_encode(array(
						"status" => 0,
						"message" => "Failed to create book shelf"
					));
				}

			}
		}

	}

}