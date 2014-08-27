<?

	$friendID = $_REQUEST['selected_friend'];
	
	// the lib functions for 
	include_once 'library.php';	
	
	// this defines some of your basic setup
	include_once 'config.php';
	
	include_once('css/others_css.php');
	
?>
	<div style="padding: 10px;">
	<h1>Party by Night application</h1><center><img src="http://pbn.thepollspace.com/pbn/images/owl.jpg"></center>
	<fb:tabs>
	<fb:tab-item href='http://apps.facebook.com/partybynight' title='Main Menu'/>
	<fb:tab-item href='http://apps.facebook.com/partybynight/invite.php' title='Invite friends!' />
	<fb:tab-item href='http://apps.facebook.com/partybynight/find_friends.php' title="Friend's reviews" selected='true' />
	<fb:tab-item href='http://apps.facebook.com/partybynight/others.php' title='Random Reviews' />
	</fb:tabs>
	<fb:if-is-app-user uid="<?=$friendID?>">
		<?//get the reviews
		$reviews = get_reviews($friendID);
		
			//get rank
			$rank = rank($reviews);
		?>
		<div class="reviews_frame">
		<h1>
		<fb:name uid="<?=$friendID?>" possessive="true"/> Reviews:
		</h1>
		<br/>
		<center><h2><fb:name uid="<?=$friendID?>" possessive="true" linked="false"/> partying experience is: <?echo $rank?></h2></center>
		<hr>
		<? echo render_reviews($reviews, $friendID)?>
		</div>
	  <fb:else>
	  <fb:success message="Your Friend has not installed this application!" />
	  <br/>
	  <fb:name uid="<?=$friendID?>" /> has not installed Party By Night application
	  <br/>
	  <a href="http://apps.facebook.com/partybynight/send.php?uid=<?=$friendID?>">Click here to tell them to install the application</a>
	  
	  </fb:else>
	  
	</fb:if-is-app-user>
</div>
	
	
