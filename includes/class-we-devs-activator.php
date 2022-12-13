<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpauthor.com
 * @since      1.0.0
 *
 * @package    We_Devs
 * @subpackage We_Devs/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    We_Devs
 * @subpackage We_Devs/includes
 * @author     WP Author <wpauthor@email.com>
 */
class We_Devs_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::CreateApplicantSubmissionTable();
		!is_dir($d = WdApplicantCv('basedir')) && mkdir($d);    
	}

	private static function CreateApplicantSubmissionTable(){
		$charset_collate = D_B()->get_charset_collate();

	    $sql = "CREATE TABLE ".wd_table('applicant_submissions')." (
	      id INT NOT NULL AUTO_INCREMENT,
	      first_name varchar(100) NOT NULL,
	      last_name varchar(100) NOT NULL,
	      email varchar(100) NOT NULL,
	      mobile varchar(20) NOT NULL,
	      post varchar(50) NOT NULL,
	      address text NULL,
	      cv_name varchar(100),
	      active TINYINT(1) NOT NULL DEFAULT '1',
	      created_at TIMESTAMP NOT NULL,
	      updated_by int NULL,
	      updated_at DATETIME NULL,	      
	      PRIMARY KEY  (id)
	    ) $charset_collate;";

	    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	    dbDelta($sql);
	    
	    //return (bool)empty(D_B()->last_error);
	}

}
