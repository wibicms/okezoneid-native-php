<html>
	<head>
	<title> OkezoneID PHP Native </title>
	</head>

	
	<body>
		<?php
		
		include('okezone_sdk/okezone_id.php');

		$okezone_id = new Okezone_Id();

		$okezone_user = json_decode($okezone_id->get_user_detail());

		if($okezone_user->statusCode==200){
			print_r($okezone_user);
			
			echo '<a href="'.$okezone_id->get_logout_url().'">Logout</a>'; 
		}else{
			?>
			<a href="#" onclick="javascript:window.open('<?php echo $okezone_id->get_login_url(); ?>', 'popupwindow', 'width=450,height=750,menu=0,status=0');" class="news">Sign In</a>
			<?php
		}
		?>
	</body>
</html>


