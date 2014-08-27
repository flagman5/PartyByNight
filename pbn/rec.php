<?

		// the facebook client library
		include_once '../client/facebook.php';
		
		// this defines some of your basic setup
		include_once 'config.php';
		
		$facebook = new Facebook($api_key, $secret);
		$facebook->require_frame();
		$fb = $facebook->api_client;
		$current_user = $facebook->require_login();

		$url = $fb->notifications_send(implode(',',$_POST['ids']),
		  'recommended you to read a party review at <a href="http://apps.facebook.com/partybynight/friend.php?selected_friend='
		  .$current_user
		  .'">Party by Night</a>');
		  
		 
		  if(is_string($url)) {
				echo '<fb:redirect url="'.$url.'" />';
			  }
?>
	
	