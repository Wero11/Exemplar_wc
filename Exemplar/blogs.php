<?php
get_header(); ?>
	<?php
	$selected_sidebar_replacement = get_post_meta($post->ID, 'sbg_selected_sidebar_replacement', true);
	if(get_post_meta($post->ID, 'pyre_full_width', true) == 'yes') {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
		$sidebar_right_css = 'display:none';
	}
	else
	{
		$content_css = "";
		if( !$selected_sidebar_replacement[0] == 0 || get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left' ){
			$sidebar_css = "float:left";
		}
		else{
			$sidebar_css = "display:none";
		}

		if( !$selected_sidebar_replacement[1] == 0 || get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right' ){
			$sidebar_right_css = "float:right";
		}
		else{
			$sidebar_right_css = "display:none";
		}
		
		if( (!$selected_sidebar_replacement[0] == 0 || get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') && $selected_sidebar_replacement[1] == 0 )
			$content_css = "float:right";
		else
			$content_css = "float:left";

		if( (!$selected_sidebar_replacement[1] == 0 && !$selected_sidebar_replacement[0] == 0) || (!$selected_sidebar_replacement[0] == 0 && get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') || (!$selected_sidebar_replacement[1] == 0 && get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') )
		{
			$sidebar_css = "float:left; width:21.4042553%";
			$sidebar_right_css = "float:right; width:21.4042553%";
			$content_css = "float:left; width:53.1914894%; padding-left:2%; padding-right:2%";
		}
	}
	?>
	<div style="<?php echo $sidebar_css; ?>" class="sidebar">
		<?php if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left'){ ?>
		<ul class="side-nav">
			<?php wp_reset_query(); ?>
			<?php
			$args = array( "post_type"=>"blog", "posts_per_page"=>-1, "post_status"=>"pubish" );
			query_posts( $args );
			if(have_posts() ){
				while ( have_posts() ) : the_post();
					$post_id = get_the_ID();
					?>
					<li><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></li>
					<?php
				endwhile;
				wp_reset_query();
			}
			?>
		</ul>
		<?php } ?>
		<?php
		if(!$selected_sidebar_replacement[0] == 0) {
			generated_dynamic_sidebar($selected_sidebar_replacement[0]);
		}
		?>
	</div>
	<div id="content" style="<?php echo $content_css; ?>">
		<?php while(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php global $data; if($data['featured_images'] && has_post_thumbnail()): ?>
			<div class="image">
				<?php the_post_thumbnail('blog-large'); ?>
			</div>
			<?php endif; ?>
			<div class="post-content">
				<?php the_content(); ?>
			</div>
			<?php if($data['comments_pages']): ?>
				<?php wp_reset_query(); ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
	</div>
	<div style="<?php echo $sidebar_right_css?>" class="sidebar">
		<?php if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right'){ ?>
		<ul class="side-nav">
			<?php wp_reset_query(); ?>
			<?php
			$post_ancestors = get_post_ancestors($post->ID);
			$post_parent = end($post_ancestors);
			?>
			<?php if(is_page($post_parent)): ?><?php endif; ?>
			<li <?php if(is_page($post_parent)): ?>class="current_page_item"<?php endif; ?>><a href="<?php echo get_permalink($post_parent); ?>" title="Back to Parent Page"><?php echo get_the_title($post_parent); ?></a></li>
			<?php
			if($post_parent)
			$children = wp_list_pages("title_li=&child_of=".$post_parent."&echo=0");
			else
			$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
			if ($children) {
			?>
			<?php echo $children; ?>
			<?php } ?>

			<?php
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if (!is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
					$querystr = "SELECT postmeta.post_id FROM $wpdb->postmeta AS postmeta WHERE meta_key = 'pyre_sidebar_navigation_parent_page' AND meta_value = '". $post->ID ."' ";
				}
				else
					$querystr = "SELECT postmeta.post_id FROM $wpdb->postmeta AS postmeta LEFT JOIN ".$wpdb->prefix."icl_translations iclt ON (iclt.element_id=postmeta.post_id) WHERE meta_key = 'pyre_sidebar_navigation_parent_page' AND meta_value LIKE '%". $post->ID ."%' AND iclt.language_code='".ICL_LANGUAGE_CODE."'" ;

				//$external_pageid = $wpdb->get_var($wpdb->prepare($querystr));
				$external_pageid = $wpdb->get_var($querystr);

				if($external_pageid):
					$page_data = get_post($external_pageid);
				?>
				<li><a href="<?php echo get_permalink($external_pageid); ?>"><?php echo $page_data->post_title; ?></a></li>
				<?php
				endif;
			?>
		</ul>
		<?php } ?>
		<?php
		if(!$selected_sidebar_replacement[1] == 0) {
			generated_dynamic_sidebar($selected_sidebar_replacement[1]);
		}
		?>
	</div>
<?php get_footer(); ?>