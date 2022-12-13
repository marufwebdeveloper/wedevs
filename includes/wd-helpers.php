<?php


function p($d){
	echo "<pre>";
	print_r($d);
	echo "</pre>";
}
if(!function_exists('D_B')){
	function D_B(){
		global $wpdb;
		return $wpdb;
	}
}
if(!function_exists('wd_table')){
	function wd_table($table){
		return D_B()->prefix.$table;
	}
}
if(!function_exists('wd_request')){
	function wd_request($method='get'){
		return strtolower($_SERVER['REQUEST_METHOD']) === $method;		
	}
}
if(!function_exists('clean_form_resubmission')){
	function clean_form_resubmission(){
		add_action('wp_footer',function(){
			echo "<script>(window.history.replaceState)&&window.history.replaceState(null,null,window.location.href);</script>";
		});		
	}
}
if(!function_exists('wd_alert')){
	function wd_alert($t,$m){
		add_action('wp_footer',function() use ($t,$m){
			echo "<script>WD_Alert('$t','$m');</script>";
		});		
	}
}
if(!function_exists('wd_admin_alert')){
	function wd_admin_alert($t,$m){
		add_action('admin_footer',function() use ($t,$m){
			echo "<script>WD_Alert('$t','$m');</script>";
		});		
	}
}
if(!function_exists('FeedBack')){
	function FeedBack($k,$r,$a=''){
		$m = [
			'applicant_submission0' => [0,'Something Wrong! Please Try Again.'],
			'applicant_submission1' => [1,'Data Received Successfully'],
			'applicant_submission2' => [1,'Data Updated Successfully'],
		];	
		$f = $m[$k.$r]??['',''];	
		if($a=='admin'){			
			wd_admin_alert($f[0]?'success':'error',$f[1]);
		}else if($a=='user'){
			wd_alert($f[0]?'success':'error',$f[1]);
		}
		return true;
	}
}
function WdApplicantCVDir(){
	return 'wd_aplicant_cvs';
}
if(!function_exists('WdApplicantCv')){
	function WdApplicantCv($need){
		$wpud = CvDirUrl(wp_upload_dir());
		return $wpud[$need]??'';
	}
}
if(!function_exists('CvDirUrl')){
	function CvDirUrl($wpud){
		$subdir = WdApplicantCVDir();
		$wpud['path'] = str_replace($wpud['subdir'], '', $wpud['path']).'/'.$subdir;
		$wpud['url'] = str_replace($wpud['subdir'], '', $wpud['url']).'/'.$subdir;
		$wpud['subdir'] = $subdir;
		$wpud['basedir'] = $wpud['basedir'].'/'.$subdir;
		$wpud['baseurl'] = $wpud['baseurl'].'/'.$subdir;

		return $wpud;
	}
}
if(!function_exists('AdminRedirect')){
	function WdRedirect($url){
		echo "<script>window.location.href='$url';</script>";
	}
}
if(!function_exists('WdSendMail')){
	function WdSendMail(array $args){
	    require_once(ABSPATH.'wp-includes/PHPMailer/PHPMailer.php');
		require_once(ABSPATH.'wp-includes/PHPMailer/Exception.php');
		require_once(ABSPATH.'wp-includes/PHPMailer/SMTP.php');

		try{

			$mail = new PHPMailer\PHPMailer\PHPMailer(true);

		    $mail->SMTPDebug = 0;
		    $mail->isSMTP();   
		    $mail->Host = 'smtp.gmail.com';
		    $mail->SMTPAuth = true;     
		    $mail->Username = 'generalmailmaruf@gmail.com';
		    $mail->Password = 'xwavmurlrysnjjon';  
		    $mail->SMTPSecure = 'tls'; 
		    $mail->Port = 587;  

		    $mail->setFrom('generalmailmaruf@gmail.com', 'Submission Confirmation');
		    $mail->addAddress($args['to'][0]??'',$args['to'][1]??'');
		    $mail->addReplyTo('generalmailmaruf@gmail.com');

		    $mail->isHTML(true); 
		    $mail->Subject = $args['subject']??'-';
		    $mail->Body    = $args['message']??'-';

		    $mail->send();

		    return true;
		}catch(Exception $e){}

		return false;

		/*
		//Did not work. 

	    add_filter('wp_mail_content_type','wd_set_mail_content_type');
	    add_action('phpmailer_init', 'wd_mail_smtp_configure');

	    $d = wp_mail( $to, $subject, $message );	    

	    remove_filter('wp_mail_content_type','wd_set_mail_content_type');
	    remove_action('phpmailer_init', 'wd_mail_smtp_configure');
	    */
	}
}
function wd_admin_page_url(string $menu_slug, $query=null) : string{
    $url = menu_page_url($menu_slug, false);
    if($query) {
        $url .= '&' . (is_array($query) ? http_build_query($query) : (string) $query);
    }
    return $url;
}
function RemoveCurrentUrlParam(array $p=[]){
    add_action('admin_footer',function() use ($p){
		echo "<script>
			window.history.replaceState(null, null,
				wd_remove_url_param(['".implode(',', $p)."'],window.location.href)
			);
		</script>";
	});
}
function wd_mail_smtp_configure( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.google.com';
    $phpmailer->Port       = '587';
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->SMTPAuth   = false;
    $phpmailer->Username   = 'generalmailmaruf@gmail.com';
    $phpmailer->Password   = 'xwavmurlrysnjjon';
    $phpmailer->From       = 'generalmailmaruf@gmail.com';
    $phpmailer->FromName   = 'From Name';
    $phpmailer->addReplyTo('generalmailmaruf@gmail.com', 'Information');
}
function wd_set_mail_content_type() {
    return "text/html";
}
?>