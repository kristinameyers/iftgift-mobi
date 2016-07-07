<!--<style>.ui-input-clear.ui-btn.ui-icon-delete.ui-btn-icon-notext.ui-corner-all{left:4% !important}</style>-->
<div role="main" class="ui-content jqm-content jqm-content-c prof_cond">
	<div id="pro_control" style="display:none">
			<h3>Profiles to consider</h3>
			<div class="ui-grid-b">
				<div class="ui-block-a"><div class="ui-bar <?php if($_GET['page'] == 'only') { ?> selected <?php } else { ?>ui-bar-a <?php } ?>" id="only"><span>[Insert Recipient Name] Only</span></div></div>
				<div class="ui-block-b"><div class="ui-bar <?php if($_GET['page'] == 'iftClique') { ?> selected <?php } else { ?>ui-bar-a <?php } ?>" id="iftclique"><span>[Insert Recipient Name] iftClique</span></div></div>
				<div class="ui-block-c"><div class="ui-bar <?php if($_GET['page'] == 'similar_persons') { ?> selected <?php } else { ?>ui-bar-a <?php } ?>" id="sperson"><span>Similar Persons</span></div></div>
			</div><!-- /grid-b -->
	</div>
			<div class="ui-field-contain keyword">
				<label for="search-1">Keyword Search</label>
				<form id="SearchForms">
				<div class="key_flied">
					<input name="search" id="search" value="" type="search">
					<input type="hidden" name="location" id="location" value="1" >
					<input type="button" id="SearchForm"/>
				</div>
				<a href="#" onclick="funresets()">Clear</a>
				</form>	
			</div>
		</div>
		<?php /*?><a href="<?php echo ru;?>step_2a" data-ajax="false"><img src="<?php echo ru_resource;?>images/backarrow.jpg" alt="Back Arrow" class="backarrow" /></a>
		<form id="SearchForm">
		<button class="ui-btn ui-corner-all clnc search" id="search_pro">Search</button>
		<div class="ui-field-contain search">
			<fieldset data-role="controlgroup" data-mini="true">
				<legend>Who is in control?</legend>
				<input name="control" id="radio-choice-v-5a" value="2" type="radio">
				<label for="radio-choice-v-5a">s'Jester</label>
				<input name="control" id="radio-choice-v-5b" value="1"<?php if($_SESSION['LOGINDATA']['USERID'] != '') echo 'checked="checked"'; ?> type="radio">
				<label for="radio-choice-v-5b">You</label>
			</fieldset>
		</div>
		<div class="ui-field-contain search_btm">
		
			<input name="search" id="search" value="" type="search">
			<label for="textinput-1" class="select_price">Select a price range</label>
			<input name="price_from" id="textinput-1" placeholder="$15" value="" type="text">
			<span>to</span>
			<input name="price_to" id="textinput-1" placeholder="$2,500" value="" type="text">
			
		</div>
		</form><?php */?>
		<div class="ui-grid-c price_filter">
			<label for="search-1">Price Filter</label>
			<form id="SearchForms2">
			<input type="hidden" name="location" id="location" value="1" >
			<div class="ui-block-a">
				<div class="ui-bar ui-bar-a">
					<div class="ui-field-contain">
						<input name="price_from" id="textinput-1" placeholder="$15" value="" type="text">
					</div>
				</div>
			</div>
			<div class="ui-block-b"><div class="ui-bar ui-bar-a"><span>to</span></div></div>
			<div class="ui-block-a">
				<div class="ui-bar ui-bar-a">
					<div class="ui-field-contain">
						<input name="price_to" id="textinput-1" placeholder="$500" value="" type="text">
					</div>
				</div>
			</div>
			<div class="ui-block-d"><div class="ui-bar ui-bar-a"><input type="button" value="GO" id="SearchForm2" /></div>
				<a href="#" onclick="funreset()">Clear</a>
			</div>
			</form>	
		</div>
	<div id="search_results"></div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#only').click(function () {
		$('#only').removeClass( "ui-bar-a" ).addClass('selected');
		$('#sperson').removeClass( "selected" );
		$('#iftclique').removeClass( "selected" );
		var url = '<?php echo ru;?>only/';
		$(location).attr('href',url);
		});
		
		$('#iftclique').click(function () {
		$('#iftclique').removeClass( "ui-bar-a" ).addClass('selected');
		$('#sperson').removeClass( "selected" );
		$('#only').removeClass( "selected" );
		var url = '<?php echo ru;?>iftClique/';
		$(location).attr('href',url);
		});
		
		$('#sperson').click(function () {
		var url = '<?php echo ru;?>similar_persons/';
		$(location).attr('href',url);
		});
	});
	</script>	
<script language="javascript">
function funresets()
{
	document.getElementById("SearchForms").reset();
}
$(document).ready(function(){
    $("#SearchForm").click(function(e){
       e.preventDefault();
 		dataString = $("#SearchForms").serialize();
     	$.ajax({
        type: "POST",
        url: "<?php echo ru;?>process/search.php",
        data: dataString,
        success: function(data) {
        	$('#search_results').html(data);
			$(".demo").customScrollbar();
        	$("#fixed-thumb-size-demo").customScrollbar({fixedThumbHeight: 50, fixedThumbWidth: 60});
        }
		 
        });          
    });
	
	
 $("#SearchForm2").click(function(e){
       e.preventDefault();
 		dataString = $("#SearchForms2").serialize();
     	$.ajax({
        type: "POST",
        url: "<?php echo ru;?>process/search.php",
        data: dataString,
        success: function(data) {
        	$('#search_results').html(data);
			$(".demo").customScrollbar();
        	$("#fixed-thumb-size-demo").customScrollbar({fixedThumbHeight: 50, fixedThumbWidth: 60});
        }
		 
        });          
    });	

});
function funreset()
{
	document.getElementById("SearchForms2").reset();
}	

	/*function SearchForms(){
		document.getElementById("SearchForm").submit()	
	}*/
</script>
<script type="text/javascript">
$(function()
{  
      $('input').focusin(function()
      {
        input = $(this);
        input.data('place-holder-text', input.attr('placeholder'))
        input.attr('placeholder', '');
      });

      $('input').focusout(function()
      {
          input = $(this);
          input.attr('placeholder', input.data('place-holder-text'));
      });
})

</script>	