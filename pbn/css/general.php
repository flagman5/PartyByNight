<style type="text/css">
 a.star {
	background:url(<?=BASE_URL?>/images/t.gif) 0% 0% repeat;
	position:absolute;
   height:<?=STAR_SIZE?>px;
   padding:0px;
   overflow:hidden;
   z-index:2;
 }   

 </style>
 <style type="text/css">
 a.star:hover {
   background:url(<?=BASE_URL?>/images/star_bright.png) 0% 0% repeat-x;
   overflow:visible;
 }   
  a.star span {
   display:block;
   position:absolute;
   top:0px;
   margin-top:<?=STAR_SIZE?>px;
   white-space:nowrap;
 }
 a.star input {
   margin:0px;
   height:<?=STAR_SIZE?>px;
   width:<?=STAR_SIZE?>px;
   cursor:pointer;
   float:right;
   opacity:0;
 }
 input.rating, input.submit {
  z-index:2;
  float:right;
}
 </style>
<style type="text/css">
 span.galaxy {
   position:relative;
   float:left;
   width:<?=STAR_SIZE*NUM_RATINGS?>px;
   height:<?=STAR_SIZE?>px;
   background:url(<?=BASE_URL?>/images/star_dim.png) 0% 0% repeat-x;
 }
 </style><style type="text/css">
 span.galaxy div.starry_night {
   position:absolute;
   top:0px;
   height:<?=STAR_SIZE?>px;
   background:url(<?=BASE_URL?>/images/star_bright.png) 0% 0% repeat-x;
   margin:0px;
   padding:0px;
   z-index:0;
 }
 span.rating {
  display:block;
  float:left;
  clear:both;
  margin-bottom:<?=FONT_SIZE*LINE_HEIGHT + 2?>px;
  overflow:visible;
}
 span.rating span.preamble {
  position:relative;
  top:3px;
  float:left;
  margin-right:8px;
}
 <? for($j=0;$j<NUM_RATINGS;$j++) { ?>
 div.star<?=$j?> {
   width:<?=STAR_SIZE*($j+1)?>px;
 }
 a.rating<?=$j?> {
   width:<?=STAR_SIZE*($j+1)?>px;
 }
 <? } ?>
 div.star-1 {
  display:none;
}
 span.galaxy:hover div.starry_night {
   z-index:-1;
 }

div.delete_form {
  position:relative;
  top:<?=FONT_SIZE*LINE_HEIGHT?>px;
  left:<?=FONT_SIZE*10?>px;
  padding:1em;
  background-color:white;
  border:1px outset black;
  width:200px;
  z-index:3;
}
div.edit_form {
  position:relative;
  padding:1em;
  background-color:white;
  border:1px outset black;
  z-index:3;
}
div.search_friends {
  position:relative;
  top:<?=FONT_SIZE*LINE_HEIGHT?>px;
  
  padding:1em;
  background-color:white;
  border:1px outset black;
  width:200px;
  z-index:3;
}
div.rec_form{
  position:relative;
  top:<?=FONT_SIZE*LINE_HEIGHT?>px;
  
  padding:1em;
  background-color:white;
  border:1px outset black;
  width:400px;
  z-index:3;
}
 </style>
<style type="text/css">

.rated {
background:url(<?=BASE_URL?>/images/star_bright.png) 0% 0% repeat-x;
height:<?=STAR_SIZE?>px;
clear:right;
}
.delete {
  float:right;
  cursor:pointer;
}
.edit {
  position:relative;
  float:right;
  cursor:pointer;
}
</style>
  <style type="text/css">
.reviews_frame {
  border-bottom:1px solid #CCCCCC;
}
.tar {
	background-color:#EEEEFF;
}
.mini {
  float:left;
}
.random {
	margin-left:100px;
}
</style>