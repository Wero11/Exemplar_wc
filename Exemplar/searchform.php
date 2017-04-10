<?php
$top_navs = wp_get_nav_menu_items("Top");

//do_action('icl_language_selector'); 
?>
<form class="search" action="<?php echo home_url(); ?>/" method="get">
	<fieldset>
		<span class="text">
			<input name="s" id="s" type="text" value="" placeholder="<?php echo __('Search ...', 'Exemplar'); ?>" />
			<input type="submit" value="" class="search-btn" />
		</span>
	</fieldset>
</form>
<div id="language_switcher">
<?php 
	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Language Switcher')): 
		//dynamic_sidebar('Language Switcher');
	endif;
?>
</div>
<div class="top-navs">
	<ul>
	<?php
	foreach($top_navs as $top_nav){
		echo "<li><a href='".$top_nav->url."'>".$top_nav->title."</a></li>";
	}
	?>
	</ul>
</div>