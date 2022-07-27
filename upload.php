<?php

if(isset($_FILES['file']['name'])){

	/* Getting file name */
	$filename = $_FILES['file']['name'];

	/* Location */
	$uploads = wp_upload_dir();
	// print_r($uploads);
	// $location = $uploads['path'].'/'.$filename;
	$location = $uploads['basedir'] . $uploads['subdir'] .'/'. $filename;
	$location_v = site_url().'/wp-content/uploads' . $uploads['subdir'] .'/'. $filename;
	$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
	$imageFileType = strtolower($imageFileType);

	/* Valid extensions */
	$valid_extensions = array("jpg","jpeg","png");

	$response = 0;
	/* Check file extension */
	if(in_array(strtolower($imageFileType), $valid_extensions)) {
	   	/* Upload file */
	   	if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
			// $the_id = 55;   
			$response = $location;//.'?the_id='.$the_id;
	   	}
	}

	  echo $location_v;
	exit;
}