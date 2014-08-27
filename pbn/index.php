<?
define('IS_IE',preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT']));
define('IS_IE7',preg_match('/MSIE\s+7/',$_SERVER['HTTP_USER_AGENT']));

	// the facebook client library
	include_once '../client/facebook.php';
	
	// this defines some of your basic setup
	include_once 'config.php';
	
	// the lib functions for 
	include_once 'library.php';
	
	$facebook = new Facebook($api_key, $secret);
	$facebook->require_frame();
	$user = $facebook->require_add();
	
	//process the added review, if there is any
	if (isset($_POST['name'])) {
		
		$name = $_POST['name'];
		$city = $_POST['city'];
		$address = $_POST['address'];
		$review = $_POST['review'];
		if(!isset($_POST['rate'])) {
		  $rating = -1;
		} else {
		  $rating = (int)$_POST['rate'];
		}
		
		
		add_review($name, $city, $address, $review, $user ,$rating);
		
		// publish the feed....
		$name_profile = stripslashes($name);
		$feed_title = "reviewed $name_profile on <a href=\"http://apps.facebook.com/partybynight/\">Party By Night</a>";
		$feed_body =  "";
		$feed_pic = 'http://pbn.thepollspace.com/pbn/images/owl.jpg';
		$feed_pic_url = 'http://apps.facebook.com/partybynight/';
		$facebook->api_client->feed_publishActionOfUser($feed_title, $feed_body, $feed_pic, $feed_pic_url);
	}
	
	//process a deletion
	if (isset($_POST['action'])) {
		$func = $_POST['action'];
		if($func == 'delete') {
			$revnum = $_POST['revnum'];
			
			delete_review($revnum);
		}
	}
	
	//get the reviews
	$reviews = get_reviews($user);
	
	
	//put the update to the person's profile...easy enough...
	$profile_fbml = render_review_profile($reviews, 3, $user);
	$facebook->api_client->profile_setFBML($profile_fbml);
	
	//get rank
	$rank = rank($reviews);
?>
<? include_once('css/general.php'); ?>
	<div style="padding: 10px;">
	<h1>Party by Night application</h1><center><img src="http://pbn.thepollspace.com/pbn/images/owl.jpg"></center>
	<fb:tabs>
	<fb:tab-item href='http://apps.facebook.com/partybynight' title='Main Menu' selected='true'/>
	<fb:tab-item href='http://apps.facebook.com/partybynight/invite.php' title='Invite friends!' />
	<fb:tab-item href='http://apps.facebook.com/partybynight/find_friends.php' title="Friend's reviews" />
	<fb:tab-item href='http://apps.facebook.com/partybynight/others.php' title='Random Reviews' />
	</fb:tabs>
  <h2>Hi <fb:name firstnameonly="true" uid="<?=$user?>" useyou="false"/>!  </h2><br/>
  <h2><center>Your Current Partying Experience is: <?echo $rank?></center></h2>
  <br/>
  <h1>So, Where did you party?</h1>
  <hr/>
	<form method="POST" action="http://apps.facebook.com/partybynight/">
	  Venue Name:<br/><input type="text" name="name" size="20"> <br/>
	  City: <br/><input type="text" name="city" size="20"><br/>
	  Exact Address (optional):<br/> <input type="text" name="address" size="30"><br/>
	  <span class='rating'>
	   <span class="preamble">Rate</span>
	   <span class='galaxy'>
		 <?
		 $hide_ids = array();
		 for($j=0;$j<NUM_RATINGS;$j++) {
		   $hide_ids[] = 'x'.$j;
		 }
		 for($j=NUM_RATINGS-1;$j>=0;$j--) {
		   ?>
		   <div class="starry_night star<?=$j?>" id="star<?=$hide_ids[$j]?>" style="display:none;"></div>
		   
		   <a href=# class="star rating<?=$j?>" clickthrough="true" clicktohide='star<?=implode(',star',$hide_ids)?>' clicktoshow='star<?=$hide_ids[$j]?>' >
			 <input type=radio name=rate value=<?=$j?> />
			<span>
			   <?=$ratings[$j]?>
			 </span>
		   </a>
		 <?}?>
	   </span>
	</span>
	<br/><br/> <br/><br/>
	How was the night? <br/><textarea rows="3" cols="40" name="review" id="review" wrap=hard></textarea><br/>
	 <input value="Post Review" type="submit" class="inputbutton" />
	</form>
	
	<hr/>

	<div class="reviews_frame">

	<h1>
	Reviews:
	</h1>
	
	<? echo render_reviews($reviews, $user)?>
	</div>
	
	
</div>