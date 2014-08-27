<?php

// Get these from http://developers.facebook.com
$api_key = '740beeaa89384591f957dc167280e9ce';
$secret  = 'a9516efe1c5736b92d4965d330774609';
/* While you're there, you'll also want to set up your callback url to the url
 * of the directory that contains Footprints' index.php, and you can set the
 * framed page URL to whatever you want.  You should also swap the references
 * in the code from http://apps.facebook.com/footprints/ to your framed page URL. */

// The IP address of your database
$db_ip = 'internal-db.s15902.gridserver.com';           

$db_user = 'db15902';
$db_pass = 'Mtxvu6SJ';

// the name of the database that you create for footprints.
$db_name = 'db15902_fb';

//invite.php constants
$appname = 'Party by Night!';
$apppage = 'http://www.facebook.com/apps/application.php?id=7945625766';
$appurl = 'http://apps.facebook.com/partybynight';
$serverurl = 'http://pbn.thepollspace.com/pbn/';

/* create this table on the database:
CREATE TABLE `footprints` (
  `from` int(11) NOT NULL default '0',
  `to` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  KEY `from` (`from`),
  KEY `to` (`to`)
)
*/
