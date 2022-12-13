<?php 

if(isset($_POST['purpose'])){
	$p = $_POST;

	if($p['purpose']=='gasd'){

		$cols = array("id","first_name","last_name","email","mobile","post","address","cv_name","created_at");

		$args = json_decode(stripslashes($p['args']),true);
        $perPage = $args['pp'];
        $offset = ($args['pn']-1)*$args['pp'];
        $orderBy = $cols[$args['scn']];
        $order = $args['so'];
        $searchedVal = $args['sfv'];
        $where = ["where active='1'"];
        if($args['sfv']){
        	$where[] = " (LOWER(REPLACE(CONCAT(id,first_name,last_name,email,mobile,post,address,cv_name,created_at),' ','')) ) like '%$args[sfv]%' ";
        }

        $where = implode(" and ", $where);

		$data = D_B()->get_results("select * from ".wd_table('applicant_submissions'). " $where order by $orderBy $order limit $perPage offset $offset");

		$totalRow = D_B()->get_var("select count(*) as total_row from ".wd_table('applicant_submissions')." $where");

		echo json_encode([
			'cols'=>$cols,
			'data'=>$data,
			'total_row' => $totalRow
		]);
	} else if($p['purpose']=='dasd'){
		$success = D_B()->query("update ".wd_table('applicant_submissions')." set active=0 where id=$p[d_id]");
		echo (int)$success;
	} else if($p['purpose']=='gaasd'){
		$cols = array("id","first_name","last_name","email","mobile","post","address","cv_name","created_at");
		$data = D_B()->get_results("select * from ".wd_table('applicant_submissions'). " where active='1' order by id asc");
		echo json_encode([
			'cols'=>$cols,
			'data'=>$data
		]);
	}
}

?>