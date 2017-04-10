<?php get_header(); ?>
	<?php
	if($data['blog_full_width']) {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
	} elseif($data['news_sidebar_position'] == 'Left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
	} elseif($data['news_sidebar_position'] == 'Right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
	}
	?>
	<div id="content" style="<?php echo $content_css; ?>" class="news-list-container">
		<?php
		$news_filter_date = "";
		$news_filter_category = "";
		if( isset($_POST["news-filter-date"]) )
			$news_filter_date = $_POST["news-filter-date"];
		if( isset($_POST["news-filter-category"]) )
			$news_filter_category = $_POST["news-filter-category"];
		
		if( $news_filter_date != "" && $news_filter_category != "" )
		{
			$selected_date = explode("-", $_POST["news-filter-date"]);
			$selected_year = $selected_date[0];
			$selected_month = $selected_date[1];
			$args = array( "post_type"=>"avada_news", "tax_query"=>array( array("taxonomy"=> "news_category", "field"=>"slug", "terms"=>$_POST["news-filter-category"]) ), "posts_per_page"=>-1, "year"=>$selected_year, "monthnum"=>$selected_month, "post_status"=>"publish" );
			query_posts($args);
		}
		elseif( $news_filter_date != "" && $news_filter_category == "" ){
			$selected_date = explode("-", $_POST["news-filter-date"]);
			$selected_year = $selected_date[0];
			$selected_month = $selected_date[1];
			$args = array( "post_type"=>"avada_news", "posts_per_page"=>-1, "year"=>$selected_year, "monthnum"=>$selected_month, "post_status"=>"publish" );
			query_posts($args);
		}
		elseif( $news_filter_date =="" && $news_filter_category != "" ){
			$args = array( "post_type"=>"avada_news", "tax_query"=>array( array("taxonomy"=> "news_category", "field"=>"slug", "terms"=>$_POST["news-filter-category"]) ), "posts_per_page"=>-1, "post_status"=>"publish" );
			query_posts($args);
		}
		?>
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
			$post_content = get_post($post->ID);
			?>
			<div class="content-column">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="single-post-date"><?php echo date("d M Y", strtotime($post_content->post_date)); ?></div>
				<?php
				$selected_terms = get_the_terms( $post->ID, 'news_category' );
				$selected_terms_list = array();
				foreach($selected_terms as $sterm){
					$selected_terms_list[] = $sterm->name;
				}
				?>
				<div class="single-post-category"><?php echo "Categories: ".implode(", ", $selected_terms_list) ?></div>
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
		</div>
		<?php endwhile; ?>
		<?php themefusion_pagination($pages = '', $range = 2); ?>
		<?php else: ?>
		<h2><?php echo __("There isn't any news for the selected filter items", "Exemplar"); ?></h2>
		<?php endif; ?>
	</div>
	<div class="sidebar" style="<?php echo $sidebar_css; ?>">
		<?php
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('News Filter')): 
		endif;
		?>
	</div>
<?php get_footer(); ?>