<?php
class MySQL {
	public function __construct() {}

	/* Set Consortium */
	
	// Get user firstname and lastname
	public function get_username($userid) {
		return "SELECT user_firstname, user_lastname FROM redcap_user_information WHERE username='$userid'";
	}
	
	public function get_user_profile($userid) {
		return "SELECT username, user_email, user_lastname, user_firstname, super_user, user_lastlogin FROM redcap_user_information WHERE username='$userid'";
	}
	
	// Total projects
	public function conso_total_project() {
		return "SELECT count(*) as total_count FROM redcap_projects WHERE app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%'";
	}
	
	// Total users
	/*
	public function conso_total_user() {
		return "SELECT count(*) as total_count FROM redcap_user_rights";
	}
	*/
	
	// Total centres
	public function conso_total_centre() {
		return "SELECT count(*) as total_count FROM redcap_data_access_groups";
	}
	
    /*
	// Total record
	public function conso_total_record() {
		return "SELECT count(*) as total_count FROM redcap_data WHERE field_name='study_id'";
	} */
    
	
	// Total DB size
	public function conso_db_size() {
		return "SELECT db_size FROM (SELECT table_schema as 'db_name', SUM( data_length + index_length ) /1024 /1024 'db_size' FROM information_schema.TABLES GROUP BY table_schema) AS T WHERE db_name='redcap_5.9.3'";
	}
	
	// Number of production in consortium
	public function conso_num_production() {
		return "SELECT status FROM redcap_projects WHERE status='1' AND purpose !=  'NULL' AND app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%'";
	}
	
	// Number of development in consortium
	public function conso_num_development() {
		return "SELECT status FROM redcap_projects WHERE status='0' AND purpose !=  'NULL' AND app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%'";	
	}
	
	// Number of inactive in consortium
	public function conso_num_inactive() {
		return "SELECT status FROM redcap_projects WHERE status='2' AND purpose !=  'NULL' AND app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%'";	
	}
	
	// Number of archive in consortium
	public function conso_num_archive() {
		return "SELECT status FROM redcap_projects WHERE status='3' AND purpose !=  'NULL' AND app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%'";	
	}
	
	// Get Production information
	public function conso_prod_info() {
		return "SELECT project_id, app_title, creation_time, project_pi_firstname, project_pi_lastname, project_pi_email FROM redcap_projects WHERE status='1' AND purpose !=  'NULL' AND app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%' ORDER BY creation_time DESC";
	}
	
	// Get Development information
	public function conso_dev_info() {
		return "SELECT project_id, app_title, creation_time, project_pi_firstname, project_pi_lastname, project_pi_email FROM redcap_projects WHERE status='0' AND purpose !=  'NULL' AND app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%' ORDER BY creation_time DESC";
	}
	
	// Get Inactive information
	public function conso_inact_info() {
		return "SELECT project_id, app_title, creation_time, project_pi_firstname, project_pi_lastname, project_pi_email FROM redcap_projects WHERE status='2' AND purpose !=  'NULL' AND app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%' ORDER BY creation_time DESC";
	}
	
	// Get Archive information
	public function conso_arch_info() {
		return "SELECT project_id, app_title, creation_time, project_pi_firstname, project_pi_lastname, project_pi_email FROM redcap_projects WHERE status='3' AND purpose !=  'NULL' AND app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%' ORDER BY creation_time DESC";
	}
	
	// Get projects in last 10 days
	public function conso_last_10days() {
		return "SELECT DATE_FORMAT(creation_time, '%Y-%m-%d') FROM redcap_projects WHERE creation_time BETWEEN NOW() - INTERVAL 10 DAY AND NOW()";
	}
	
	// Get projects in last 30 days
	public function conso_last_30days() {
		return "SELECT DATE_FORMAT(creation_time, '%Y-%m-%d') FROM redcap_projects WHERE creation_time BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
	}
	
	// Get projects in last 90 days
	public function conso_last_90days() {
		return "SELECT DATE_FORMAT(creation_time, '%Y-%m-%d') FROM redcap_projects WHERE creation_time BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
	}

	// Get total users
	public function conso_total_user() {
		return "SELECT username, user_firstname, user_lastname, user_email FROM redcap_user_information";
	}
	
	// Get users in last 6 months
	public function conso_last6month_user() {
		return "SELECT username, user_firstname, user_lastname, user_email, DATE_FORMAT(user_lastlogin, '%Y-%m-%d') FROM redcap_user_information WHERE user_lastlogin BETWEEN NOW() - INTERVAL 6 MONTH AND NOW()";
	}

	// Redcap Version
	public function conso_redcap_version() {
		return "SELECT value FROM redcap_config WHERE field_name='redcap_version'";
	}
	
	// Get users in last 10 days
	public function conso_user_last_10days() {
		return "SELECT DATE_FORMAT(user_creation, '%Y-%m-%d') FROM redcap_user_information WHERE user_creation BETWEEN NOW() - INTERVAL 10 DAY AND NOW()";
	}
	
	// Get users in last 30 days
	public function conso_user_last_30days() {
		return "SELECT DATE_FORMAT(user_creation, '%Y-%m-%d') FROM redcap_user_information WHERE user_creation BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
	}
	
	// Get users in last 90 days
	public function conso_user_last_90days() {
		return "SELECT DATE_FORMAT(user_creation, '%Y-%m-%d') FROM redcap_user_information WHERE user_creation BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
	}
	
	// Get list of Suspended users account in database
	
	public function suspended_users() {
	
	return "select username,user_firstname,user_lastname,user_email from redcap_user_information where user_suspended_time != 'NULL'";
	}
	
     // Get list of API users account in database
    
    public function api_users()
    {
     return  
     "SELECT userrights.project_id, userinfo.username,userinfo.user_firstname, userinfo.user_lastname, userinfo.user_email
     FROM redcap_user_information userinfo
     INNER JOIN redcap_user_rights userrights ON userinfo.username = userrights.username
     AND userrights.api_token !=  'NULL' ORDER BY userrights.project_id DESC";  
    }
    
    
    
	/* Set CRSU */
	
	// Number of Production
	public function crsu_num_production() {
		return "351";
	}
	
	// Number of Development
	public function crsu_num_development() {
		return "139";
	}
	
	// Number of Inactive
	public function crsu_num_inactive() {
		return "4";
	}
	
	// Number of Archive
	public function crsu_num_archive() {
		return "57";
	}
	
	// Total users
	public function crsu_total_user() {
		return "731";
	}
	
	// Total centre
	public function crsu_total_centre() {
		return "614";
	}

	// Total record
	public function crsu_total_record() {
		return "97300";
	}
	
	// Total DB size
	public function crsu_db_size() {
		return "4403";
	}
	
	// Version
	public function crsu_version() {
		return "4.12";
	}
	
	/* Set IHDI */
	
	// Number of Production
	public function ihdi_num_production() {
		return "1";
	}
	
	// Number of Development
	public function ihdi_num_development() {
		return "0";
	}
	
	// Number of Inactive
	public function ihdi_num_inactive() {
		return "0";
	}
	
	// Number of Archive
	public function ihdi_num_archive() {
		return "0";
	}
	// Number of users
	public function ihdi_total_user() {
		return "43";
	}
	
	// Number of centre
	public function ihdi_total_centre() {
		return "9";
	}
	
	// Number of record
	public function ihdi_total_record() {
		return "544";
	}
	
	
	/* Set CTU */
	
	// Number of Production
	public function ctu_num_production() {
		return "7";
	}
	
	// Number of Development
	public function ctu_num_development() {
		return "5";
	}
	
	// Number of Inactive
	public function ctu_num_inactive() {
		return "0";
	}
	
	// Number of Archive
	public function ctu_num_archive() {
		return "4";
	}
	
	// Number of users
	public function ctu_total_user() {
		return "28";
	}
	
	// Number of centres
	public function ctu_total_centre() {
		return "116";
	}
	
	// Number of record
	public function ctu_total_record() {
		return "408";
	}
	
	/* Set vec */
	
	// Number of Production
	public function vec_num_production() {
		return "0";
	}
	
	// Number of Development
	public function vec_num_development() {
		return "0";
	}
	
	// Number of Inactive
	public function vec_num_inactive() {
		return "0";
	}
	
	// Number of Archive
	public function vec_num_archive() {
		return "0";
	}
	
	// Number of users
	public function vec_total_user() {
		return "0";
	}
	
	// Number of centres
	public function vec_total_centre() {
		return "0";
	}
	
	// Number of record
	public function vec_total_record() {
		return "0";
	}
	
	
	
}
?>