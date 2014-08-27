<?
	// the facebook client library
	include_once '../client/facebook.php';
	
	// this defines some of your basic setup
	include_once 'config.php';
	
	// the lib functions for 
	include_once 'library.php';
	
	//basic
	$facebook = new Facebook($api_key, $secret);
	$facebook->require_frame();
	$user = $facebook->require_add();
	//get latest 15 reviews
	$reviews = render_random(10);
	
?>

<? include_once('css/others_css.php'); ?>
	<div style="padding: 10px;">
	<h1>Party by Night application</h1><center><img src="http://pbn.thepollspace.com/pbn/images/owl.jpg"></center>
	
	<fb:tabs>
	<fb:tab-item href='http://apps.facebook.com/partybynight' title='Main Menu'/>
	<fb:tab-item href='http://apps.facebook.com/partybynight/invite.php' title='Invite friends!'  />
	<fb:tab-item href='http://apps.facebook.com/partybynight/find_friends.php' title="Friend's reviews" />
	<fb:tab-item href='http://apps.facebook.com/partybynight/others.php' title='Random Reviews' selected='true' />
	</fb:tabs>
	
		<div class="reviews_frame">
	
		<h1>
		Reviews:
		</h1>
		
		<? echo render_random_reviews($reviews)?>
		</div>
	
	</div>