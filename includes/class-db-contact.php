<?php

class DBContact {

	public static function StoreApplicantSubmission(){
		$post = $_POST;

		if(is_array($post) && wp_verify_nonce( $post['nnc_applicant_submission']??'', 'applicant_submission_nonce_action' ) ){
			$fn = sanitize_text_field($post['first_name']);
			$ln = sanitize_text_field($post['last_name']);
			$mail = sanitize_email($post['email']);
			if(D_B()->insert(
				wd_table('applicant_submissions'),
				array(
					'first_name'=>$fn,
					'last_name'=>$ln,
					'email'=>$mail,
					'mobile'=>$post['mobile'],
					'post'=>sanitize_text_field($post['post']),
					'address'=>sanitize_textarea_field($post['address']),
					'cv_name'=>self::UploadApplicantCV($post['pre_file_name']??'')
				)
			)){
				return WdSendMail([
					'subject'=>'Submission Confirmation',
					'message'=>"Hi $fn $ln, <br/> <b>Thanks</b> for apply!",
					'to'=>[$mail,$fn.' '.$ln]
				]);
			}
		}
		return false;
	}

	public static function ChangeApplicantData(){
		$post = $_POST;

		if(is_array($post) && wp_verify_nonce( $post['nnc_applicant_submission']??'', 'applicant_submission_nonce_action' ) ){
			$fn = sanitize_text_field($post['first_name']);
			$ln = sanitize_text_field($post['last_name']);
			$mail = sanitize_email($post['email']);
			return (bool) D_B()->update(
				wd_table('applicant_submissions'),
				array(
					'first_name'=>$fn,
					'last_name'=>$ln,
					'email'=>$mail,
					'mobile'=>$post['mobile'],
					'post'=>sanitize_text_field($post['post']),
					'address'=>sanitize_textarea_field($post['address']),
					'cv_name'=>self::UploadApplicantCV($post['pre_file_name']??'')
				),
				array('id'=>$post['id'])
			);
		}
		return false;
	}
	public static function RecentApplicantData($c=5){
		return D_B()->get_results("select * from ".wd_table('applicant_submissions'). " where active=1 order by id desc limit $c offset 0");
		 
	}	

	private static function UploadApplicantCV($fileName=''){
		if(empty($_FILES['aplicant_cv']['name'])) return $fileName;

		function custom_upload_dir($d_i){ 
		    return array_merge($d_i,CvDirUrl($d_i));
		}
		add_filter( 'upload_dir','custom_upload_dir');
		$fileName = floor(microtime(true) * 1000).'.'.pathinfo($_FILES['aplicant_cv']['name'], PATHINFO_EXTENSION);

		wp_upload_bits(
			$fileName, 
			null, 
			file_get_contents($_FILES['aplicant_cv']['tmp_name'])
		);
		remove_filter( 'upload_dir', 'custom_upload_dir' );
		return $fileName;
	}
}


