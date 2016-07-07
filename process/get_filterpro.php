<?php
include_once("../connect/connect.php");
include_once("../config/config.php");
function get_images($image)
{
	$img =  preg_replace("/<a[^>]+\>/i", "", $image);
	preg_match("/src=([^>\\']+)/", $img, $result);
	$view_image = array_pop($result);
	return $view_image;
}
 $recption_id = $_SESSION['recipit_id']['New'];
 $query = "select recipit_id,cash_gift,gender,age,ocassion,email from ".tbl_recipient." where recipit_id = '".$recption_id."'";
 $get_info = $db->get_row($query,ARRAY_A);
 $cash = $get_info['cash_gift'];
 $gender = $get_info['gender'];
 $age = $get_info['age'];
 $ocassion = $get_info['ocassion'];
 $get_price = get_price($cash);
 $get_data = get_category($gender,$age);
 $get_occassion_data = get_ocassion($ocassion);
 
 
 $filter = $_POST['filter'];
 if($filter == 'only')
	{
		$get_user = mysql_fetch_array(mysql_query("select userId from ".tbl_user." where email = '".$get_info['email']."'"));
 		$ruserId = $get_user['userId'];
		
	 	$query = "select p.*,l.* from ".tbl_product." p, ".tbl_love." l where (p.status = 1 or p.status = 0) $get_data $get_price $get_occassion_data AND p.proid = l.proid AND l.userId = '".$ruserId."'";
		$view_pro = $db->get_row($query,ARRAY_A);
		$get_pro = $db->get_results($query,ARRAY_A);
		
		/***********************GET NEXT PRODUCT********************************/
		$sql = "SELECT p.*,l.* FROM gift_product p, gift_love_it l WHERE p.proid>{$view_pro['proid']} $get_data $get_price $get_occassion_data and (p.status = 1 or p.status = 0) and p.proid = l.proid AND l.userId = '".$ruserId."' ORDER BY p.proid LIMIT 1";
		$result = mysql_query($sql);
		if (@mysql_num_rows($result)>0) {
		$nextid = mysql_result($result,0);
		}
		/***********************GET NEXT PRODUCT********************************/
		
		/***********************GET PREVIOUS PRODUCT********************************/
		$sqls = "SELECT p.*,l.* FROM gift_product p, gift_love_it l WHERE p.proid<{$view_pro['proid']} $get_data $get_price $get_occassion_data and (p.status = 1 or p.status = 0) and p.proid = l.proid AND l.userId = '".$ruserId."' ORDER BY p.proid DESC LIMIT 1";
		$results = mysql_query($sqls);
		if (@mysql_num_rows($results)>0) {
		$previd = mysql_result($results,0);
		}	
		/***********************GET PREVIOUS PRODUCT********************************/	
		
	} else if($filter == 'iftclique') {
		$query = "select p.*,l.* from ".tbl_product." p, ".tbl_love." l where (p.status = 1 or p.status = 0) $get_data $get_price $get_occassion_data AND p.proid = l.proid AND l.userId = '".$_SESSION['LOGINDATA']['USERID']."'";
		$query2 = "select p.*,o.* from ".tbl_product." p, ".tbl_own." o where (p.status = 1 or p.status = 0) $get_data $get_price $get_occassion_data AND p.proid = o.proid AND o.userId = '".$_SESSION['LOGINDATA']['USERID']."'";
		
		$select_btemp =  $query." ".UNION." ".$query2;
		$view_pro = $db->get_row($select_btemp,ARRAY_A);
		$get_pro = $db->get_results($select_btemp,ARRAY_A);
		
		/***********************GET NEXT PRODUCT********************************/
		$nxt_sql = "SELECT p.*,l.* FROM gift_product p, gift_love_it l WHERE p.proid>{$view_pro['proid']} $get_data $get_price $get_occassion_data and (p.status = 1 or p.status = 0) and p.proid = l.proid AND l.userId = '".$_SESSION['LOGINDATA']['USERID']."'";
		
		$nxt_sqls = "SELECT p.*,o.* FROM gift_product p, gift_own_it o WHERE p.proid>{$view_pro['proid']} $get_data $get_price $get_occassion_data and (p.status = 1 or p.status = 0) and p.proid = o.proid AND o.userId = '".$_SESSION['LOGINDATA']['USERID']."'";
		
		$select_nxtbtemps =  $nxt_sql." ".UNION." ".$nxt_sqls;
		
		$result = mysql_query($select_nxtbtemps);
		if (@mysql_num_rows($result)>0) {
		$nextid = mysql_result($result,0);
		}
		/***********************GET NEXT PRODUCT********************************/
		
		/***********************GET PREVIOUS PRODUCT********************************/
		$prev_sql = "SELECT p.*,l.* FROM gift_product p, gift_love_it l WHERE p.proid<{$view_pro['proid']} $get_data $get_price $get_occassion_data and (p.status = 1 or p.status = 0) and p.proid = l.proid AND l.userId = '".$_SESSION['LOGINDATA']['USERID']."'";
		
		$prev_sqls = "SELECT p.*,o.* FROM gift_product p, gift_own_it o WHERE p.proid<{$view_pro['proid']} $get_data $get_price $get_occassion_data and (p.status = 1 or p.status = 0) and p.proid = o.proid AND o.userId = '".$_SESSION['LOGINDATA']['USERID']."'";
		
		$select_revbtemps =  $prev_sql." ".UNION." ".$prev_sqls;
		
		$results = mysql_query($select_revbtemps);
		if (@mysql_num_rows($results)>0) {
		$previd = mysql_result($results,0);
		}	
		/***********************GET PREVIOUS PRODUCT********************************/	
	} 
	$suggest = count($_SESSION["products"]) + 1; 
	if($filter == 'only' || $filter == 'iftclique') {
	?> 
	<div class="browse_cat sugg">Item #<?php echo $suggest ;?></div>
  	<div role="main" class="ui-content jqm-content jqm-content-c" id="filtered_picture">
		<h3 class="item_name"><?php  echo substr($view_pro['pro_name'],0,50);?></h3>
		<p class="item_type"><strong>Vendor:</strong> <?php  echo $view_pro['vendor'];?>, <strong>Category:</strong> <?php  echo ucfirst($view_pro['category']).' , '.ucfirst($view_pro['sub_category']);?></p>
		<h3 class="item_name item_price">$<?php  echo $view_pro['price'];?></h3>
		<?php if($previd != '') { ?>
		<a href="#" id="getPicButton_<?php echo $previd;?>" class="prod_arrow_left"></a>
		<?php } ?>
		<img src="<?php  get_image($view_pro['image_code']);?>" width="220" height="220" alt="<?php  echo substr($view_pro['pro_name'],0,50);?>" class="prod_img" />
		<?php if($nextid != '') { ?>
		<a href="#" id="getPicButton_<?php echo $nextid;?>" class="prod_arrow_left prod_arrow_right"></a>
		<?php } ?>
		<!--<h3>Product Description Display Here</h3>-->
		<form method="post" action="<?php echo ru;?>process/process_cart.php" data-ajax="false">
			<input type="hidden" name="proId" id="proId" value="<?php echo $view_pro['proid'];?>" />
			<input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['LOGINDATA']['USERID'];?>" />
			<input type="hidden" name="type" id="type" value="add" />
			<input type="hidden" name="qty" id="qty" value="1" />
			<button class="ui-btn ui-corner-all" id="suggest_test">Suggest</button>
		</form>
		<div class="user_love_it" style="display:none;">
			<img src="<?php echo ru_resource;?>images/user_love_it.jpg" alt="User Love It" /> <span>[ Test ] Loves it !</span>
		</div>
		<div class="ui-grid-b item-likes-type">
		<!---------------------OWN_IT------------------------------->
		<?php
			$get_own = mysql_num_rows(mysql_query("select userId from ".tbl_own." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
			$get_q = "SELECT count( own_it ) AS cnt FROM ".tbl_own." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( own_it )";
			$view_q = $db->get_row($get_q,ARRAY_A);
			?>
			<div id="own_it2" class="ui-block-a <?php if($get_own > 0) {?>active<?php } ?>" <?php if($get_own == 0) { ?>onclick="own_it('<?php echo $view_pro['proid'];?>','<?php echo $_SESSION['LOGINDATA']['USERID'];?>','own')" <?php } ?>><div class="ui-bar ui-bar-a">Own it<div class="own_it"></div><span><?php echo $view_q{'cnt'}; ?> People Own it</span></div></div>
			<div id="own_itbtm2"></div>
			
			<!-----------------------LOVE_IT----------------------------->
			<?php
			$get_love = mysql_num_rows(mysql_query("select userId from ".tbl_love." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
			$get_l = "SELECT count( love_it ) AS cnt FROM ".tbl_love." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( love_it )";
			$view_l = $db->get_row($get_l,ARRAY_A);
			?>
			<div id="love_it2" class="ui-block-b <?php if($get_love > 0) {?>active<?php } ?>" <?php if($get_love == 0) { ?>onclick="love_it('<?php echo $view_pro['proid'];?>','<?php echo $_SESSION['LOGINDATA']['USERID'];?>','love')" <?php } ?>><div class="ui-bar ui-bar-a">Love it<div class="own_it love_it"></div><span><?php echo $view_l{'cnt'}; ?> People Love it</span></div></div>
			<div id="love_itbtm2"></div>
			
			<!-----------------------HIDE_IT----------------------------->
			<?php
			$get_hide = mysql_num_rows(mysql_query("select userId from ".tbl_hide." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
			$get_h = "SELECT count( hide_it ) AS cnt FROM ".tbl_hide." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( hide_it )";
			$view_h = $db->get_row($get_h,ARRAY_A);
			?>
			<div id="hide_it2" class="ui-block-c <?php if($get_hide > 0) {?>active<?php } ?>" <?php if($get_hide == 0) { ?>onclick="hide_it('<?php echo $view_pro['proid'];?>','<?php echo $_SESSION['LOGINDATA']['USERID'];?>','hide')" <?php } ?>><div class="ui-bar ui-bar-a">Hide it<div class="own_it hide_it"></div><span><?php echo $view_h{'cnt'}; ?> People Hide it</span></div></div>
			<div id="hide_itbtm2"></div>
		</div><!-- /grid-b -->
		
		<?php /*?><a href="<?php echo ru;?>step_2a" data-ajax="false" class="back_arrow"><img src="<?php echo ru_resource;?>images/backarrow.jpg" alt="Back Arrow" class="backarrow" /> <span>Back to list</span></a><?php */?>
	</div><!-- /content -->
	<div id="product_test3"></div>
		<div class="browse_cat">Gifts S'Jester is Suggesting For [Insert Recipient Name]:</div>
		<div id="myCanvasContainer">
 			<canvas width="250" height="250" id="myCanvas">
  				<p>will be replaced by something else</p>
  		</canvas>
 	 </div>
			<div id="tags">
    	<ul>
		<?php	 
		if($get_pro)
		{
		   foreach($get_pro as $product)
		   {
		?>
 				 <li><a style="font-size: 16pt"><?php echo substr($product['pro_name'],0,20);?></a></li>
		<?php  } 
			 } 
		?>
  		</ul>
 </div>
<?php	
	}
	
	 if($filter == 'sperson') {
			$suggest = count($_SESSION["products"]) + 1; 
			$get_sperson = match_user($age,$gender);
			foreach($get_sperson as $person)
			{
				$email = $person['email'];
				$ocassionids = $person['ocassion'];
				$new_ocss = str_replace("AND (","OR ",get_ocassion($ocassionids));
				if($new_ocss == '') {
				$demo_ocss = $get_occassion_data;
				} else {
				$demo_ocss = str_replace(")","",$get_occassion_data);
				}
				$cash_amount = $view_sperson['cash_gift'];
				$get_user = mysql_fetch_array(mysql_query("select userId from ".tbl_user." where email = '".$email."'"));
				$suserid = $get_user['userId'];
				
				$query = "select distinct p.*,l.* from ".tbl_product." p, ".tbl_love." l where (p.status = 1 or p.status = 0) $get_data $get_price $demo_ocss $new_ocss AND p.proid = l.proid AND l.userId = '".$suserid."'";
				$get_pro[] = $db->get_results($query,ARRAY_A);
			}
			 foreach($get_pro as $products)
		   {
		   	foreach($products as $product)
			   {
		   			echo $product['proid'].'<br />';
			}
		   }
			exit;
			while($view_sperson = mysql_fetch_array($get_sperson)){
				$email = $view_sperson['email'];
				$ocassionids = $view_sperson['ocassion'];
				$new_ocss = str_replace("AND (","OR ",get_ocassion($ocassionids));
				if($new_ocss == '') {
				$demo_ocss = $get_occassion_data;
				} else {
				$demo_ocss = str_replace(")","",$get_occassion_data);
				}
				$cash_amount = $view_sperson['cash_gift'];
				$get_user = mysql_fetch_array(mysql_query("select userId from ".tbl_user." where email = '".$email."'"));
				$suserid = $get_user['userId'];
				
				$query = "select p.*,l.* from ".tbl_product." p, ".tbl_love." l where (p.status = 1 or p.status = 0) $get_data $get_price $demo_ocss $new_ocss AND p.proid = l.proid AND l.userId = '".$suserid."'";	
				$get_pro[] = $db->get_results($query,ARRAY_A);
				$view_pro = $db->get_row($query,ARRAY_A);
				
				/***********************GET NEXT PRODUCT********************************/
				
				$nxt_sql = "SELECT p.*,l.* FROM gift_product p, gift_love_it l WHERE p.proid>{$view_pro['proid']} $get_data $get_price $demo_ocss $new_ocss AND p.proid = l.proid AND l.userId = '".$suserid."' ORDER BY p.proid LIMIT 1";
		
				$result = mysql_query($nxt_sql);
				if (@mysql_num_rows($result)>0) {
				$nextid = mysql_result($result,0);
				}
				
				/***********************GET NEXT PRODUCT********************************/
		
			   /********************GET PREVIOUS PRODUCT********************************/
				$prev_sql = "SELECT p.*,l.* FROM gift_product p, gift_love_it l WHERE p.proid<{$view_pro['proid']} $get_data $get_price $demo_ocss $new_ocss AND p.proid = l.proid AND l.userId = '".$suserid."' ORDER BY p.proid LIMIT 1";
		
				$results = mysql_query($prev_sql);
				if (@mysql_num_rows($results)>0) {
				$previd = mysql_result($results,0);
				}	
		/***********************GET PREVIOUS PRODUCT********************************/	
				
				if($view_pro != '') {
				
				$product='
		<div class="browse_cat sugg">Item # '.$suggest.'</div>
		<div role="main" class="ui-content jqm-content jqm-content-c" id="filtered_picture">
		<h3 class="item_name">'.substr($view_pro['pro_name'],0,50).'</h3>
		<p class="item_type"><strong>Vendor:</strong>'.$view_pro['vendor'].', <strong>Category:</strong>'.ucfirst($view_pro['category']).' , '.ucfirst($view_pro['sub_category']).'</p>
		<h3 class="item_name item_price">$ '.$view_pro['price'].'</h3>';
		if($previd != '') {
		$product.='<a href="#" id="getPicButton_'.$previd.'" class="prod_arrow_left"></a>';
		}
		$product.='<img src="'.get_images($view_pro['image_code']).'" width="220" height="220" alt="'.substr($view_pro['pro_name'],0,50).'" class="prod_img" />';
		if($nextid != '') {
		$product.='<a href="#" id="getPicButton_'.$nextid.'" class="prod_arrow_left prod_arrow_right"></a>';
		}
		$product.='<form method="post" action="'.ru.'process/process_cart.php" data-ajax="false">
			<input type="hidden" name="proId" id="proId" value="'.$view_pro['proid'].'" />
			<input type="hidden" name="userId" id="userId" value="'.$_SESSION['LOGINDATA']['USERID'].'" />
			<input type="hidden" name="type" id="type" value="add" />
			<input type="hidden" name="qty" id="qty" value="1" />
			<button class="ui-btn ui-corner-all" id="suggest_test">Suggest</button>
		</form>
		<div class="user_love_it" style="display:none;">
			<img src="'.ru_resource.'images/user_love_it.jpg" alt="User Love It" /> <span>[ Test ] Loves it !</span>
		</div>
		<div class="ui-grid-b item-likes-type">';
		$get_own = mysql_num_rows(mysql_query("select userId from ".tbl_own." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
		$get_q = "SELECT count( own_it ) AS cnt FROM ".tbl_own." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( own_it )";
		$view_q = $db->get_row($get_q,ARRAY_A);
		$product.='<div id="own_it2" class="ui-block-a'; if($get_own > 0) { $product.='active';}$product.='"'; if($get_own == 0) {  $product.='onclick="own_it('.$view_pro['proid'].','.$_SESSION['LOGINDATA']['USERID'].','.own.')"'; } $product.='>';
		$product.='<div class="ui-bar ui-bar-a">Own it<div class="own_it"></div><span>'.$view_q{'cnt'}.' People Own it</span></div></div>
			<div id="own_itbtm2"></div>';
		$get_love = mysql_num_rows(mysql_query("select userId from ".tbl_love." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
		$get_l = "SELECT count( love_it ) AS cnt FROM ".tbl_love." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( love_it )";
		$view_l = $db->get_row($get_l,ARRAY_A);
			
		$product.='<div id="love_it2" class="ui-block-b'; if($get_love > 0) { $product.='active';}$product.='"'; if($get_love == 0) {  $product.='onclick="love_it('.$view_pro['proid'].','.$_SESSION['LOGINDATA']['USERID'].','.love.')"'; } $product.='>';
		$product.='<div class="ui-bar ui-bar-a">Love it<div class="own_it love_it"></div><span>'.$view_l{'cnt'}.' People Love it</span></div></div>
			<div id="love_itbtm2"></div>';	
		$get_hide = mysql_num_rows(mysql_query("select userId from ".tbl_hide." where userId = '".$_SESSION['LOGINDATA']['USERID']."' and proid = '".$view_pro['proid']."'"));
		$get_h = "SELECT count( hide_it ) AS cnt FROM ".tbl_hide." WHERE proid = '".$view_pro['proid']."' GROUP BY proid HAVING Count( hide_it )";
		$view_h = $db->get_row($get_h,ARRAY_A);
		$product.='<div id="hide_it2" class="ui-block-c'; if($get_hide > 0) { $product.='active';}$product.='"'; if($get_hide == 0) {  $product.='onclick="hide_it('.$view_pro['proid'].','.$_SESSION['LOGINDATA']['USERID'].','.hide.')"'; } $product.='>';
		$product.='<div class="ui-bar ui-bar-a">Hide it<div class="own_it hide_it"></div><span>'.$view_h{'cnt'}.' People Hide it</span></div></div>
			<div id="hide_itbtm2"></div>	
			
		</div>
		</div>';?>
  		
	<?php }
	
	 } 
	 echo $product;
	 ?>
	<div id="product_test3"></div>
		<div class="browse_cat">Gifts S'Jester is Suggesting For [Similar Persons]:</div>
		<div id="myCanvasContainer">
 			<canvas width="250" height="250" id="myCanvas">
  				<p>will be replaced by something else</p>
  		</canvas>
 	 </div>
			<div id="tags">
    	<ul>
		<?php	 
		if($get_pro)
		{
		   foreach($get_pro as $products)
		   {
			 if($products)
			 {
			   foreach($products as $product)
			   {
		?>
 				 <li><a style="font-size: 16pt"><?php echo substr($product['pro_name'],0,20);?></a></li>
		<?php  } 
			 } 
		   }
		 } 
		?>
  		</ul>
 </div>
<?php } ?> 
 <script type="text/javascript">
      window.onload = function() {
        try {
          TagCanvas.Start('myCanvas','tags',{
            textColour: '#000000',
            outlineColour: '#ff00ff',
			outlineMethod: 'none',
            reverse: true,
            maxSpeed: 0.05,
			depth: 0.99,
  			weight: true,
  			weightMode: "size",
  			weightFrom: null,
			activeCursor: 'auto',
			initial : [0.1,-0.1],
			decel : 0.98,
			maxSpeed : 0.04,
			minBrightness : 0.2,
			depth : 0.92,
			pulsateTo : 0.6
          });
        } catch(e) {
          // something went wrong, hide the canvas container
          document.getElementById('myCanvasContainer').style.display = 'none';
        }
      };
    </script>

<?php if($filter == 'only') { ?>	
<script type="text/javascript">
function getPicture(myPicId)
{
var myData = 'picID='+myPicId;
jQuery.ajax({
    url: "<?php echo ru;?>process/get_filterdonly.php",
	type: "GET",
    dataType:'html',
	data:myData,
    success:function(response)
    {
        $('#product_test3').html(response);
		$('#filtered_picture').hide();
    }
    });
}
</script>
<?php } else if($filter == 'iftclique') {?>
<script type="text/javascript">
function getPicture(myPicId)
{
var myData = 'picID='+myPicId;
jQuery.ajax({
    url: "<?php echo ru;?>process/get_filterdiftclique.php",
	type: "GET",
    dataType:'html',
	data:myData,
    success:function(response)
    {
        $('#product_test3').html(response);
		$('#filtered_picture').hide();
    }
    });
}
</script>
<?php } else if($filter == 'sperson') {?>
<script type="text/javascript">
function getPicture(myPicId)
{
var myData = 'picID='+myPicId;
jQuery.ajax({
    url: "<?php echo ru;?>process/get_filterdsperson.php",
	type: "GET",
    dataType:'html',
	data:myData,
    success:function(response)
    {
        $('#product_test3').html(response);
		$('#filtered_picture').hide();
    }
    });
}
</script>
<?php } ?>
<script type="text/javascript">
function own_it(proid,uid,type)
{
	var proId = proid;
	var userId = uid;
	var type = type;
	$.ajax({
	url: '<?php echo ru;?>process/process_product.php?proid='+proId+'&userId='+userId+'&type='+type,
	type: 'get', 
	success: function(output) {
	$('#own_it2').hide();
	$('#own_itbtm2').html(output);
	}
	});
}

function love_it(proid,uid,type)
{
	var proId = proid;
	var userId = uid;
	var type = type;
	$.ajax({
	url: '<?php echo ru;?>process/process_product.php?proid='+proId+'&userId='+userId+'&type='+type,
	type: 'get', 
	success: function(output) {
	$('#love_it2').hide();
	$('#love_itbtm2').html(output);
	}
	});
}

function hide_it(proid,uid,type)
{
	var proId = proid;
	var userId = uid;
	var type = type;
	$.ajax({
	url: '<?php echo ru;?>process/process_product.php?proid='+proId+'&userId='+userId+'&type='+type,
	type: 'get', 
	success: function(output) {
	$('#hide_it2').hide();
	$('#hide_itbtm2').html(output);
	}
	});
}
</script>	
			