
<table id="data_table">
	<thead>
		<th>Name</th>
		<th>Email</th>
		<th>Phone</th>		
	</thead>
	<tbody>
		<?php 
			if(!empty($data=DBContact::RecentApplicantData(5))){
				foreach($data as $r){
					echo "<tr>
						<td>$r->first_name $r->last_name</td>
						<td>$r->email</td>
						<td>$r->mobile</td>					
					</tr>";
				}
			}else{
				echo "<tr>
					<td colspan='3' style='text-align:center'>No Recent Data</td>		
				</tr>";
			}
		?>
	</tbody>
</table>