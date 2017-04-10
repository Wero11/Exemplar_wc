<?php
add_action('widgets_init', 'news_filter_load_widgets');

function news_filter_load_widgets()
{
	register_widget('News_Filter_Widget');
}

class News_Filter_Widget extends WP_Widget {
	
	function News_Filter_Widget()
	{
		$widget_ops = array('classname' => 'news_filter', 'description' => 'News Filter.');

		$control_ops = array('id_base' => 'news_filter-widget');

		$this->WP_Widget('news_filter-widget', 'JadeCreative: News Filter', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		
		echo $before_widget;

		if($title) {
			echo $before_title . $title . $after_title;
		}
		?>
		<div class="news-filter-items clearfix">
			<form method="post" action="<?php echo get_bloginfo("url")?>/news" class="news-filter-form">
			<?php
				$current_year = date("Y");
				$current_month = date("m");
				$start_year = $current_year - 4;
				
				$selected_news_filter_date = "";
				$selected_news_filter_category = "";

				if( isset($_POST["news-filter-date"]) )
					$selected_news_filter_date = $_POST["news-filter-date"];

				if( isset($_POST["news-filter-category"]) )
					$selected_news_filter_category = $_POST["news-filter-category"];
				?>
				<ul class="side-nav news-filter-nav">
					<li>
						<a href="javascript:void(0)">
						<div class="filter-item">
								<label for="news-filter-date">By Date Range</label>
								<select name="news-filter-date" id="news-filter-date">
									<option value="" <?php if($selected_news_filter_date == "") echo "selected"; ?>>All Time</option>
								<?php
								for($i=$current_year;$i>=$start_year;$i--){
									echo "<optgroup label='".$i."'>";
									if( $i==$current_year ){
										for($j=$current_month;$j>=1;$j--){
											$cur_item = $i."-".str_pad($j,2,"0",STR_PAD_LEFT);
											if($selected_news_filter_date == $cur_item) 
												$select_class = "selected"; 
											else
												$select_class = ""; 

											echo "<option value='".$i."-".str_pad($j,2,"0",STR_PAD_LEFT)."' ".$select_class.">".date("M", strtotime($i."-".str_pad($j,2,"0",STR_PAD_LEFT)))."</option>";
										}
									}
									else
									{
										for($j=12;$j>=1;$j--){
											$cur_item = $i."-".str_pad($j,2,"0",STR_PAD_LEFT);
											if($selected_news_filter_date == $cur_item) 
												$select_class = "selected"; 
											else
												$select_class = ""; 

											echo "<option value='".$i."-".str_pad($j,2,"0",STR_PAD_LEFT)."' ".$select_class.">".date("F", strtotime($i."-".str_pad($j,2,"0",STR_PAD_LEFT)))."</option>";
										}
									}
									echo "</optgroup>";
								}
								?>
								</select>
							</div>
						</a>
					</li>
					<li>
						<a href="javascript:void(0)">
							<div class="filter-item">
								<label for="news-filter-category">By Category</label>
								<select name="news-filter-category" id="news-filter-category">
									<option value="">All</option>
								<?php
								$terms = get_terms( 'news_category', 'hide_empty=0' );

								foreach( $terms as $term )
								{
									if($selected_news_filter_category == $term->slug) 
										$select_class = "selected"; 
									else
										$select_class = ""; 
									echo "<option value='".$term->slug."' ".$select_class.">".$term->name."</option>";
								}
							?>
								</select>
							</div>
						</a>
					</li>
				</ul>
			</form>
		</div>

		<?php echo $after_widget;
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#news-filter-date, #news-filter-category").change(function(){
					jQuery(".news-filter-form").submit();
				})
			})
		</script>
		<?php
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'News Filter');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	<?php
	}
}
?>