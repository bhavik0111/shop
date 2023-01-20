<?php
function get_catname($cat_id='',$conn){
	$returndata='';
	if($cat_id!=''){
		$query =  "select cat_name from category_master where cat_id='".$cat_id."'";
		$data = mysqli_query($conn, $query);
		$result = mysqli_fetch_assoc($data);
		$returndata=$result['cat_name'];
	}
	return $returndata;
}

?>