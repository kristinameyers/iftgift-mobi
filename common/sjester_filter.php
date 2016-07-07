<div class="browse_cat">Modify s'Jester Search</div>
<div role="main" class="ui-content jqm-content jqm-content-c prof_cond" id="pro_control" <?php if($page == 'only' || $page == 'iftClique' || $page == 'similar_persons' || $page == 'search_result') { } else { ?> style="display:none" <?php } ?>>
			<h3>Profiles to consider</h3>
			<div class="ui-grid-b">
				<div class="ui-block-a"><div class="ui-bar <?php if($_GET['page'] == 'only') { ?> selected <?php } else { ?>ui-bar-a <?php } ?>" id="only"><span><?php echo ucfirst($view['first_name']);?> Only</span></div></div>
				<div class="ui-block-b"><div class="ui-bar <?php if($_GET['page'] == 'iftClique') { ?> selected <?php } else { ?>ui-bar-a <?php } ?>" id="iftclique"><span><?php echo ucfirst($view['first_name']);?> iftClique</span></div></div>
				<div class="ui-block-c"><div class="ui-bar <?php if($_GET['page'] == 'similar_persons') { ?> selected <?php } else { ?>ui-bar-a <?php } ?>" id="sperson"><span>Similar Persons</span></div></div>
			</div><!-- /grid-b -->
			<div class="ui-field-contain keyword">
				<label for="search-1">Keyword Search</label>
				<form id="Searchforms" method="post" action="<?php echo ru;?>process/process_sjestersearch.php" data-ajax="false">
				<div class="key_flied">
					<input name="keyword" id="keyword" value="" type="search">
					<input type="submit" id="SearchForm"/>
				</div>
				<a href="#" onclick="funresets()">Clear</a>
				</form>
			</div>
		</div>
		<div class="ui-grid-c price_filter">
			<label for="search-1">Price Filter</label>
			<form id="Searchforms2" method="post" action="<?php echo ru;?>process/process_sjestersearch.php" data-ajax="false">
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
			<div class="ui-block-d"><div class="ui-bar ui-bar-a"><input type="submit" value="GO" /></div>
				<a href="#" onclick="funreset()">Clear</a>
			</div>
			</form>
		</div>
<script type="text/javascript">
function funresets()
{
	document.getElementById("Searchforms").reset();
}
function funreset()
{
	document.getElementById("Searchforms2").reset();
}
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