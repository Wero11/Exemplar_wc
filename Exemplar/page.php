<?php get_header(); ?>
	<?php
	global $post;
	$c_pageID = $post->ID;
	
	$selected_sidebar_replacement = get_post_meta($post->ID, 'sbg_selected_sidebar_replacement', true);
	if($c_pageID == -9999 )
	{
		$sidebar_css = "display:none";
		$content_css = "float:left";
		$selected_sidebar_replacement[0] = "";
		$selected_sidebar_replacement[1] = "Event Calendar";
	}
	elseif(get_post_meta($post->ID, 'pyre_full_width', true) == 'yes') {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
	}
/*	elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
	}*/
	else{
		if( !$selected_sidebar_replacement[0] == 0 ){
			$sidebar_css = "float:left";
			$content_css = "float:left";
		}
		else{
			$sidebar_css = "display:none";
			$content_css = "float:left";
		}

		if( !$selected_sidebar_replacement[1] == 0 ){
			$sidebar_right_css = "float:right";
			$content_css = "float:left";
		}
		else{
			$sidebar_right_css = "display:none";
			$content_css = "float:left";
		}

		if( !$selected_sidebar_replacement[0] == 0 && !$selected_sidebar_replacement[1] == 0 )
		{
			$sidebar_css = "float:left; width:21.4042553%";
			$sidebar_right_css = "float:right; width:21.4042553%";
			$content_css = "float:left; width:53.1914894%; padding-left:2%; padding-right:2%";
		}
	}
	?>
	<div class="sidebar" style="<?php echo $sidebar_css; ?>">
		<?php 
		if(!$selected_sidebar_replacement[0] == 0) {
			generated_dynamic_sidebar($selected_sidebar_replacement[0]);
		}
		?>
	</div>
	<div id="content" style="<?php echo $content_css; ?>">
		<?php if(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php global $data; if($data['featured_images'] && has_post_thumbnail()): ?>
			<div class="image">
				<?php the_post_thumbnail('blog-large'); ?>
			</div>
			<?php endif; ?>
			<div class="page-title">
				<h1></h1>
			</div>
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
			<?php if($data['comments_pages']): ?>
				<?php wp_reset_query(); ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	<div class="sidebar" style="<?php echo $sidebar_right_css; ?>">
		<?php 
		if(!$selected_sidebar_replacement[1] == 0) {
			generated_dynamic_sidebar($selected_sidebar_replacement[1]);
		}
		?>
	</div>
<?php get_footer(); ?>