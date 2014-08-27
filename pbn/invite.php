<?php
// the facebook client library
include_once '../client/facebook.php';

// this defines some of your basic setup
include_once 'config.php';

//basic stuff
$facebook = new Facebook($api_key, $secret);
$facebook->require_frame();
$user = $facebook->require_login();

//  Get list of friends who have this app installed...
$rs = $facebook->api_client->fql_query("SELECT uid FROM user WHERE has_added_app=1 and uid IN (SELECT uid2 FROM friend WHERE uid1 = $user)");
$arFriends = "";

//  Build an delimited list of users...
if ($rs)
{
	for ( $i = 0; $i < count($rs); $i++ )
	{
		if ( $arFriends != "" )
			$arFriends .= ",";
	
		$arFriends .= $rs[$i]["uid"];
	}
}

//  Construct a next url for referrals
$sNextUrl = urlencode("&refuid=".$user);

//  Build your invite text
$invfbml = <<<FBML
You've been invited to Party by Night!
<fb:name uid="$user" firstnameonly="true" shownetwork="false"/> wants you to add Party by Night so that you can start sharing your nights!
<fb:req-choice url="http://apps.facebook.com/partybynight" label="Let's Party" />
FBML;

?>
	<div style="padding: 10px;">
	<h1>Party by Night application</h1><center><img src="http://pbn.thepollspace.com/pbn/images/owl.jpg"></center>
	<fb:tabs>
	<fb:tab-item href='http://apps.facebook.com/partybynight' title='Main Menu'/>
	<fb:tab-item href='http://apps.facebook.com/partybynight/invite.php' title='Invite friends!' selected='true' />
	<fb:tab-item href='http://apps.facebook.com/partybynight/find_friends.php' title="Friend's reviews" />
	<fb:tab-item href='http://apps.facebook.com/partybynight/others.php' title='Random Reviews' />
	</fb:tabs>
	</div>
<fb:request-form type="PartyByNight" action="index.php" content="<?=htmlentities($invfbml)?>" invite="true">
	<fb:multi-friend-selector max="20" actiontext="Find out where your friends are partying! These are all the friends that have no yet installed Party by Night. Invite your friends here" showborder="true" rows="5" exclude_ids="<?=$arFriends?>" />
</fb:request-form>