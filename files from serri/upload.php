<?php
	$message = "";
	// check to see of ok button was pressed
	if(isset($_POST["ok"])){
		$safeDir = _DIR_.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR;
		$filename = basename($_FILES['file_to_upload']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		//check to see if upload parameter specified
		if(($_FILES["file_to_upload"]["error"]==UPLOAD_ERR_OK) && ($ext == "jpg") && ($_FILES["file_to_upload"]["type"] == "image/jpeg") && ($_FILES["file_to_upload"]["size"] < 70000000)){
			//check to make sure file uploaded by upload process
			if(is_uploaded_file($_FILES["file_to_upload"]["tmp_name"])){
				// capture filename and strip out any directory path info
				$fn = basename($_FILES["file_to_upload"]["name"]);
				//Build now filename with safty measures in place
				$copyfile = $safeDir."safe_prefix_secure_info".strip_tags($fn);
				//copy file to safe directory 
				if(move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $copyfile)){
					$message .= "<br>Successfully uploaded file $copyfile\n";
					$img = "uploads/safe_prefix_secure_info".strip_tags($fn);
				} else {
					// trap upload file handle errors
					$message.="Unable to upload file ".$_FILES["file_to_upload"]["name"];
				}
			} else {
				$message .= "<br>File not uploaded";
			}
		}
	}

	$list = glob($safeDir . "*");
?>


<!DOCTYPE html>
<html>
<head>
	<title>upload</title>
</head>
<body>
	<h1>Protect file upload</h1>
	<form name="upload" method="POST" enctype="multipart/form-data">
		<input type="file" size="50" maxlength="255" name="file_to_upload" value="" />
		<input type="submit" name="ok" value="ok" />
	</form>
	<table cellspacing="4">
		<tr>
			<th>file name</th>
			<th>Last modified</th>
			<th>size</th>
		</tr>
		<?php 
		if(isset($list)){
			foreach ($list as $item) {
				echo "<tr><td>$item</td>";
				echo "<td>".date("F d Y:i:s*".filemtime($item))."</td>";
				echo "<td align=right>".filesize($item)."</td>";
				echo "</tr><br>";
			}
			}
			echo "</table><br>";
		?>
	
</body>
</html>