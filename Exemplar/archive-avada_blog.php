<?php get_header(); ?>
	<?php
	if($data['blog_full_width']) {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
	} elseif($data['blog_sidebar_position'] == 'Left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
	} elseif($data['blog_sidebar_position'] == 'Right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
	}

	$terms = get_terms( 'blog_category', 'hide_empty=0' );
		
	$selected_blog_category = "";
	
	if( isset($_REQUEST["cat"]) )
		$selected_blog_category = $_REQUEST["cat"];
	else
		$selected_blog_category = $terms[0]->slug;

	$args = array( "post_type"=>"avada_blog", "tax_query"=>array( array("taxonomy"=> "blog_category", "field"=>"slug", "terms"=>$selected_blog_category) ), "posts_per_page"=>-1, "post_status"=>"publish" );
	query_posts($args);
	
	?>
	<div id="content" style="<?php echo $content_css; ?>">
		<?php if (have_posts()) : ?>
		<?php while(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
			<?php
			if($data['featured_images']):
			if($data['legacy_posts_slideshow']) {
				include('legacy-slideshow.php');
			} else {
				include('new-slideshow.php');
			}
			endif;
			?>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<span class="single-post-date"><?php the_date("d M Y"); ?></span>
			<div class="post-content">
				<?php
				if($data['content_length'] == 'Excerpt') {
					$stripped_content = tf_content( $data['excerpt_length_blog'], $data['strip_html_excerpt'] );
					echo $stripped_content; 
				} else {
					the_content('');
				}
				?>
			</div>
			<div style="clear:both;"></div>
			<?php if($data['post_meta']): ?>
			<div class="meta-info">
				<div class="alignleft">
					<?php echo __('By', 'Exemplar'); ?> <?php the_author_posts_link(); ?><span class="sep">|</span><?php the_time($data['date_format']); ?><span class="sep">|</span><?php the_category(', '); ?><span class="sep">|</span><?php comments_popup_link(__('0 Comments', 'Exemplar'), __('1 Comment', 'Exemplar'), '% '.__('Comments', 'Exemplar')); ?>
				</div>
				<div class="alignright">
					<a href="<?php the_permalink(); ?>" class="read-more"><?php echo __('Read More', 'Exemplar'); ?></a>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
		<?php themefusion_pagination($pages = '', $range = 2); ?>
		<?php else: ?>
		<?php endif; ?>
	</div>
	<div class="sidebar" style="<?php echo $sidebar_css; ?>">
		<ul class="side-nav">
		<?php
		//if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog Sidebar')): 
		//endif;
		
		$i = 0;
		foreach( $terms as $term )
		{
			if($selected_blog_category == $term->slug) 
				$select_class = "current_page_item"; 
			else
				$select_class = ""; 
			echo "<li class='".$select_class."'><a href='".get_bloginfo("url")."/blogs?cat=".$term->slug."'>".$term->name."</a></li>";
			$i++;
		}
		?>
		</ul>
	</div>
<?php get_footer(); ?>