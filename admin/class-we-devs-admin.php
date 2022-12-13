<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpauthor.com
 * @since      1.0.0
 *
 * @package    We_Devs
 * @subpackage We_Devs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    We_Devs
 * @subpackage We_Devs/admin
 * @author     WP Author <wpauthor@email.com>
 */
class We_Devs_Admin {

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
		 * defined in We_Devs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The We_Devs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/styles.css', array(), $this->version, 'all' );

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
		 * defined in We_Devs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The We_Devs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/library.js', array(), $this->version, false );

	}

	public function wp_dashboards_setup() {
		wp_add_dashboard_widget(
		'applicant-submissions-dashboard-widget',
			esc_html__( 'Applicant Submissions', 'we-devs'),
			array($this,'applicant_submissions_dashboard_widget')
		); 
	}

	public function admin_menus() {
		add_menu_page(esc_html__('Applicant Submissions','we-devs'), esc_html__('Applicant Submissions','we-devs'),'edit_posts','applicant-submissions', array($this,'applicant_submissions'));

		add_menu_page(esc_html__('Applicant Submissions','we-devs'), esc_html__('Applicant Submissions 2','we-devs'),'edit_posts','applicant-submissions-client-side-data-table', array($this,'applicant_submissions2'));
				
	}

	

	public function applicant_submissions() {
		ob_start();
		require_once WE_DEVS_DIR.'admin/partials/applicant-submissions.php';
		echo ob_get_clean();
	}

	public function applicant_submissions2() {
		ob_start();
		require_once WE_DEVS_DIR.'admin/partials/applicant-submissions2.php';
		echo ob_get_clean();
	}	


	public function applicant_submissions_dashboard_widget() {
		ob_start();
		require_once WE_DEVS_DIR.'admin/partials/recent-applicant-submissions.php';
		echo ob_get_clean();
	}


	public function wd_admin_ajax() {
		require_once WE_DEVS_DIR.'includes/ajax.php';
		die();
	}



}
