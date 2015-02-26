<html>
	<head>
	<title> OkezoneID PHP Native </title>
	</head>

	
	<body>
		<?php
		
		include('okezone_sdk/okezone_id.php');

		$okezone_id = new Okezone_Id();

		$params = array( 'request_url' => 'okezone.com',
						   'log_type'	 => 'READ', // or anything
						   'refferer'	 => '', //email or anything
						   'author'		 => 'adi sukma',
						   'editor'		 => 'wibawa',
						   'published'	 => date('Y-m-d')
						   );
		$activity = $okezone_id->post_activity($params);
		echo $activity;
		
		?>
	</body>
</html>


