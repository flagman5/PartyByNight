<? 
define('FONT_SIZE',14);
define('LINE_HEIGHT',1.22);
define('STAR_SIZE',20);
$ratings = array('crap.','not worth it.','not bad for a chill night','a night to remember','dude, where\'s my car');
define('NUM_RATINGS',count($ratings));
define('BASE_URL','http://pbn.thepollspace.com/pbn');
	
	function get_db_conn() {
	  $conn = mysql_connect($GLOBALS['db_ip'], $GLOBALS['db_user'], $GLOBALS['db_pass']);
	  mysql_select_db($GLOBALS['db_name'], $conn);
	  return $conn;
	}
	
	//get reviews and return to another function for display..
	function get_reviews($user) {
		
	  $conn = get_db_conn();
	  $res = mysql_query('SELECT `revnumber`, `name`, `city`, `address`,`cmt`,`rating` FROM reviews WHERE `user`=' . $user . ' ORDER BY `revnumber` DESC', $conn);
	  $prints = array();
	  while ($row = mysql_fetch_assoc($res)) {
		$prints[] = $row;
	  }
	  return $prints;
	}
	
	//display
	function render_reviews($reviews, $user) {
		if(empty($reviews)) {
			$fbml = "No Reviews";
		}
		else {
		  $fbml = '';
		  $i=0;
		  foreach ($reviews as $post) {
			$revnum = $post['revnumber'];
			$name = $post['name'];
			$city = $post['city'];
			$address = $post['address'];
			$cmt = $post['cmt'];
			$rating = $post['rating'];
			
			$fbml .= '<div class=\'tar\'>'
				  .  '<b class=title>'.$name.'</b> in ' .$city
				  .  '<fb:if-is-user uid='.$user.'>'
				  .  ' <div class=\'delete\'>'
				  .  '<a href="#" clicktoshow="delete_form'.$i.'">Delete Review</a>'
				  .	 '</div>'
				  .	 '<div id="delete_form'.$i.'" style="display:none;" class="delete_form">'
				  .  '<form method="POST" action="http://apps.facebook.com/partybynight/">'
				  .  '<input type="hidden" name="revnum" value='.$revnum.'>'
				  .  '<input type="hidden" name="action" value="delete">'
				  .  '<input type="submit" value="Delete this review" class="button">'
				  .  '<input type="reset" value="Cancel" class="button" clicktohide="delete_form'.$i.'">'
				  .  ' </form></div></fb:if-is-user>'
				  .  '<br/>'
				  .  $address
				  .  '<br/>'
				  .  '<fb:if-is-user uid='.$user.'>'
				  .  ' <div class=\'edit\'>'
				  .  '<a href="edit.php?edit='.$revnum.'">Edit Review</a>'
				  .	 '</div>'
				  .  '</fb:if-is-user>'
				  .  '<div class=\'rated star'.$rating.'\'>'
				  .  '</div>'
				  .  '<div class=\'commentary\'>'
				  .  $cmt
				  .  '<br/><br/>'
				  .  '<a href="#" clicktoshow="rec_form'.$i.'">Recommend this venue</a>'
				  .	 '<div id="rec_form'.$i.'" style="display:none;" class="rec_form">'
				  .  '<form method="POST" action="http://apps.facebook.com/partybynight/rec.php">'
				  .  '<input type="hidden" name="revnum" value='.$revnum.'>'
				  .  '<input type="hidden" name="action" value="rec">'
				  .  '<fb:multi-friend-input />'
				  .  '<input type="submit" value="Recommend" class="button">'
				  .  '<input type="reset" value="Cancel" class="button" clicktohide="rec_form'.$i.'">'
				  .  ' </form></div></div>'
				  .  '</div><br/>';
			$i++;
		  }
		}
	  return $fbml;
	}
	
	//function to render review for profile page
	function render_review_profile($reviews, $max, $user) {
	    $rank = rank($reviews);
		$fbml = '<style type="text/css">'
				. '	.profile {'
				. '	background-color:#EEEEFF;'
				. ' margin: 5px;'
				. '	}'
				. '.rated {'
				.	'background:url(http://pbn.thepollspace.com/pbn/images/star_bright.png) 0% 0% repeat-x;'
				.	'height:20px;'
				.	'clear:right;'
				.	'}'
				.   'div.star-1 {'
				.   '  display:none;'
				.   '  }'
				.  'div.star0 {'
				.   'width:20px;'
				. '}'
				.  'div.star1 {'
				.   'width:40px;'
				.' }'
				. ' div.star2 {'
				.  ' width:60px;'
				. '}'
				.  'div.star3 {'
				.  ' width:80px;'
				. '}'
				.  'div.star4 {'
				.  ' width:100px;'
				. '}'
				. '</style>'
				. '<div style="font-size: 15px; font-weight: bold">Party By Night <a href="http://apps.facebook.com/partybynight"><img src="http://pbn.thepollspace.com/pbn/images/owl25.jpg"></a></div><br/>'
				. '<center>My Partying experience is: '.$rank.'<br/></center><br/>'
				. '<div style="margin-top: 10px; font-size: 12px; font-weight: bold; border-bottom: 1px solid #dddddd">My latest party reviews: </div><br/>';
		
		if(empty($reviews)) {
			$fbml .= '<center><fb:name uid="'
				  .$user
				  .'"/> has not partied yet</center>';
		}
		else {
		  $i=0;
		  foreach ($reviews as $post) {
			$revnum = $post['revnumber'];
			$name = $post['name'];
			$city = $post['city'];
			$address = $post['address'];
			$cmt = $post['cmt'];
			$rating = $post['rating'];
			
			$fbml .= '<div class="profile">'
				  . '<b class=title>'.$name.'</b> in ' .$city
				  .  '<br/>'
				  .  $address
				  .  '<br/>'
				  .  '<div class=\'rated star'.$rating.'\'></div>'
				  .  '<div class=\'commentary\'>'
				  .  $cmt
				  .  '</div></div>';
	
			if (++$i == $max) break;
		   }
		}
			$fbml .= '<a href="http://apps.facebook.com/partybynight/friend.php?selected_friend='
				  .$user
				  .'">Click here to see all <fb:name uid="'
				  .$user
				  .'" possessive="true"/> reviews!</a>';
				  
		return $fbml;
	}
	
	//function to add a review
	function add_review($name, $city, $address, $review, $user, $rating) {
		$conn = get_db_conn();
		mysql_query("INSERT INTO reviews VALUES(NULL, '".$name."', '".$city."','".$address."','".$review."','".$user."','".$rating."', NOW())", $conn);
		//add into club names
		mysql_query("INSERT INTO clubs VALUES(NULL, '".$name."', '".$city."')", $conn);
	}
	
	//function to delete a review
	function delete_review($revnum) {
		$conn = get_db_conn();
		mysql_query("DELETE from reviews where revnumber='$revnum'", $conn);
	}
	
	//ranking utility
	function rank($reviews) {
		$exp = count($reviews);
		
		if($exp < 5 and $exp >= 0)
		{
			$rank= 'I don\'t party much';
		
		}
		if($exp < 10 and $exp >5)
		{
			$rank = 'I am an amateur partier';
		}
		if($exp < 15 and $exp >10)
		{
			$rank ='I only went out these few times';
		}
		if($exp < 20 and $exp >15)
		{
			$rank = 'I am a weekend warrior';
		}
		if($exp < 25 and $exp >20)
		{
			$rank = 'I like to party';
		}
		if($exp < 30 and $exp >25)
		{
			$rank = 'I live in bars/clubs';
		}
		if($exp > 30)
		{
			$rank = 'I am a F-ing Party Animal';
		}
		
		return $rank;
	}
	
	//function to get one review for edit
	function get_one_review($revnum) {
		  $conn = get_db_conn();
		  $res = mysql_query("SELECT name, city, address,cmt,rating FROM reviews WHERE revnumber='$revnum'", $conn);
	      $prints = mysql_fetch_assoc($res);
	      return $prints;
	}
	
	//function to edit
	function edit_review($name, $city, $address, $review, $rating, $revnum) {
		$conn = get_db_conn();
		$result = mysql_query("UPDATE reviews SET name='$name', city='$city', address='$address', cmt='$review', rating='$rating' WHERE revnumber='$revnum'", $conn);
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
	}
	
	//function to get everyones reviews
	function render_random($max) {
		$conn = get_db_conn();
		$result = mysql_query("SELECT * FROM reviews ORDER BY time DESC LIMIT 10", $conn);
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		$prints = array();
		while ($row = mysql_fetch_assoc($result)) {
			$prints[] = $row;
		}
		return $prints;
	}
	
	//display
	function render_random_reviews($reviews) {
		if(empty($reviews)) {
			$fbml = "No Reviews";
		}
		else {
		  $fbml = '';
		  $i=0;
		  foreach ($reviews as $post) {
			$revnum = $post['revnumber'];
			$name = $post['name'];
			$city = $post['city'];
			$address = $post['address'];
			$cmt = $post['cmt'];
			$rating = $post['rating'];
			$reviewer = $post['user'];
			
			if($rating == -1) { $stars_output = "<br/><br/>"; }
			else { $stars_output = '<div class=\'rated star'.$rating.'\'></div>'; }
			
			$fbml .= '<div class=\'tar\'><div class="mini"><fb:profile-pic uid='.$reviewer.' linked="yes" /><br/><fb:name uid='.$reviewer.' linked="false" firstnameonly ="true" /></div><div class=\'random\'>'
				  .  '<b class=title>'.$name.'</b> in ' .$city
				  .  '<br/>'
				  .  $address
				  .  '<br/>'
				  .  $stars_output
				  .  '<div class=\'commentary\'>'
				  .  $cmt
				  .  '<br/><br/>'
				  .  '<a href="#" clicktoshow="rec_form'.$i.'">Recommend this venue</a>'
				  .	 '<div id="rec_form'.$i.'" style="display:none;" class="rec_form">'
				  .  '<form method="POST" action="http://apps.facebook.com/partybynight/rec.php">'
				  .  '<input type="hidden" name="revnum" value='.$revnum.'>'
				  .  '<input type="hidden" name="action" value="rec">'
				  .  '<fb:multi-friend-input />'
				  .  '<input type="submit" value="Recommend" class="button">'
				  .  '<input type="reset" value="Cancel" class="button" clicktohide="rec_form'.$i.'">'
				  .  ' </form></div>'
				  .  '</div>'
				  .  '</div></div><br/>';
			$i++;
		  }
		}
	  return $fbml;
	}
	
	
?>