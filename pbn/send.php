<?
		// the facebook client library
		include_once '../client/facebook.php';
		
		// this defines some of your basic setup
		include_once 'config.php';
		
		$facebook = new Facebook($api_key, $secret);
		$facebook->require_frame();
		$fb = $facebook->api_client;
		$current_user = $facebook->require_login();
		
		$friendID = $_GET['uid'];
		
		// title of request/invitation, will say "1 [$title] invitation/request
		$title = "Party by Night!";
		
		// content of the message. Also include the accept button.
		$content = "<fb:req-choice url=\"http://apps.facebook.com/partybynight/\" label=\"Accept\" />Install Party by Night, and start sharing your nights! ";
		
		// type of notification - either 'invitation' or 'request'
		$request = "request";
		
		
		// image to be displayed on the left side of your invitation, will be resized to 100x100, so shoot for this size
		$image = "http://pbn.thepollspace.com/pbn/images/owl.jpg";
		
		
		// generate the message and return confirmation page
		$confirmURL = $fb->notifications_sendRequest($friendID, $title, $content, $image, $request);


		  if(is_string($confirmURL)) {
				echo '<fb:redirect url="'.$confirmURL.'" />';
			  }
		  else
			{
			  echo '<fb:error><fb:message>You have reached the maximum number of invitations today.  Please try again tomorrow.</fb:message></fb:error>';
			}
	
?>