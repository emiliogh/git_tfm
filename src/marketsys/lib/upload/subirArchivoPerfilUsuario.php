<?php
   SESSION_START();
	if(is_array($_FILES)) {
		if(is_uploaded_file($_FILES['file']['tmp_name'])) {
			$sourcePath = $_FILES['file']['tmp_name'];
			$directory = '../images/avatar/';
			$files = glob($directory . '*.*');
				if ( $files !== false )
					{ $filecount = count( $files );}
				else{$filecount = 0;}
			$sz = str_replace('application/','',str_replace('image/','',$_FILES['file']['type']));
			$targetPath = "../images/avatar/".str_pad($filecount,8, "0", STR_PAD_LEFT).".".$sz;
			
				if(move_uploaded_file($sourcePath,$targetPath)) {
					//$_SESSION["avatar"] = str_pad($_GET['nb'],8, "0", STR_PAD_LEFT).".".$sz;
					echo json_encode(str_pad($filecount,8, "0", STR_PAD_LEFT).".".$sz);
				}
			}	
	}
?>