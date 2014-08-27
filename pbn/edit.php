<?
	// the facebook client library
	include_once '../client/facebook.php';
	
	// this defines some of your basic setup
	include_once 'config.php';
	
	// the lib functions for 
	include_once 'library.php';
	
	$facebook = new Facebook($api_key, $secret);
	$facebook->require_frame();
	$user = $facebook->require_add();
	
	//get the review
	$revnum = $_REQUEST['edit'];
	$data = array();
	$data = get_one_review($revnum);
	$realstars = $data['rating'];
	$realstars++;
	//process the edited review, if there is any
	if (isset($_POST['name'])) {
		
		$name = $_POST['name'];
		$city = $_POST['city'];
		$address = $_POST['address'];
		$review = $_POST['review'];
		if(!isset($_POST['rate2'])) {
		  $rating = $data['rating'];
		} else {
		  $rating = (int)$_POST['rate2'];
		}
		
	
		edit_review($name, $city, $address, $review ,$rating, $revnum);
		
	    // publish the feed....
		$name_profile = stripslashes($name);
		$feed_title = "edited $name_profile on <a href=\"http://apps.facebook.com/partybynight/\">Party By Night</a>";
		$feed_body =  "";
		$feed_pic = 'http://pbn.thepollspace.com/pbn/images/owl.jpg';
		$feed_pic_url = 'http://apps.facebook.com/partybynight/';
		$facebook->api_client->feed_publishActionOfUser($feed_title, $feed_body, $feed_pic, $feed_pic_url);
		
		//return
		$url = "http://apps.facebook.com/partybynight";
		$facebook->redirect($url);
		exit;
	}
	
?>
<? include_once('css/general.php'); ?>
	<div style="padding: 10px;">
	<h1>Party by Night application</h1><center><img src="http://pbn.thepollspace.com/pbn/images/owl.jpg"></center>
 	
	<fb:tabs>
	<fb:tab-item href='http://apps.facebook.com/partybynight' title='Main Menu' selected='true'/>
	<fb:tab-item href='http://apps.facebook.com/partybynight/invite.php' title='Invite friends!'  />
	<fb:tab-item href='http://apps.facebook.com/partybynight/find_friends.php' title="Friend's reviews" />
	<fb:tab-item href='http://apps.facebook.com/partybynight/others.php' title='Random Reviews'  />
	</fb:tabs>
  <h1>Edit your review</h1>
  <hr/>
	<form method="POST" action="http://apps.facebook.com/partybynight/edit.php">
	  Venue Name:<br/><input type="text" name="name" size="20" value="<? echo stripslashes($data['name'])?>"> <br/>
	  City: <br/><input type="text" name="city" size="20" value="<? echo stripslashes($data['city'])?>"><br/>
	  Exact Address (optional):<br/> <input type="text" name="address" size="30" value="<? echo stripslashes($data['address'])?>"><br/>
	  Your current rating is: <? echo $realstars?> stars <br/>
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
			 <input type=radio name=rate2 value=<?=$j?> />
			<span>
			   <?=$ratings[$j]?>
			 </span>
		   </a>
		 <?}?>
	   </span>
	</span>
	<br/><br/>
	<br/><br/>
	How was the night? <br/><textarea rows="3" cols="40" name="review" id="review" wrap=hard><? echo stripslashes($data['cmt'])?></textarea><br/>
	 <input type="hidden" value="<?echo $revnum ?>" name="edit">
	 <input value="Edit Review" type="submit" class="inputbutton" />
	</form>
	<form action="http://apps.facebook.com/partybynight">
	<input value="Cancel" type="submit" class="inputbutton" />
	</form>
	</div>