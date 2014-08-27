<?
	// the facebook client library
	include_once '../client/facebook.php';
	
	// this defines some of your basic setup
	include_once 'config.php';
	
	// the lib functions for 
	include_once 'library.php';
?>

<? include_once('css/others_css.php'); ?>
	<div style="padding: 10px;">
	<h1>Party by Night application</h1><center><img src="http://pbn.thepollspace.com/pbn/images/owl.jpg"></center>
	<fb:tabs>
	<fb:tab-item href='http://apps.facebook.com/partybynight' title='Main Menu'/>
	<fb:tab-item href='http://apps.facebook.com/partybynight/invite.php' title='Invite friends!' />
	<fb:tab-item href='http://apps.facebook.com/partybynight/find_friends.php' title="Friend's reviews" selected='true' />
	<fb:tab-item href='http://apps.facebook.com/partybynight/others.php' title='Random Reviews' />
	</fb:tabs>
	<center>
	<br/>
	<h2>Find out where your friends partied!</h2>
	<br/>
	<form method="POST" action="http://apps.facebook.com/partybynight/friend.php">
	<fb:friend-selector uid="<?=$user?>" name="uid" idname="selected_friend" />
	<input type="submit" value="View" class="button">
	</form>
	</center>
	</div>