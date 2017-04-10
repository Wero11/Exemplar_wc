<?php 
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/loop.php
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php 
global $more;
$more = false;
?>

<div class="tribe-events-loop hfeed vcalendar">
	
	<table class="events-table" width="100%" cellpadding="0" cellspacing="0">
	<?php $prev_event_date = ""; ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php do_action( 'tribe_events_inside_before_loop' ); ?>

		<!-- Month / Year Headers -->
		<?php //tribe_events_list_the_date_headers(); ?>

		<!-- Event  -->
		<!-- <div id="post-<?php the_ID() ?>" class="<?php tribe_events_event_classes() ?>"> -->
		<?php
			global $post;
			$event = $post;

			if ( tribe_event_is_multiday( $event ) ) 
			{  // multi-date event 
				if ( tribe_event_is_all_day( $event ) ) { 
					$current_event_date = tribe_get_start_date( $event, true, "F j" ) ;
				} else { 
					$current_event_date = tribe_get_start_date( $event, false, "F j" ) ;
				}
			} elseif ( tribe_event_is_all_day( $event ) ) { // all day event 
				$current_event_date = tribe_get_start_date( $event, true, "F j" ) ;
			} else { // single day event 
				$current_event_date = tribe_get_start_date( $event, false, "F j" ) ;
			} 
			
			if ( $prev_event_date == "" )
				$prev_event_date = $current_event_date;

			if( $prev_event_date == $current_event_date ){
				$class = "";
			}
			else{
				$class = "last-event";
				$prev_event_date = $current_event_date;
			}
		?>
		<tr class="<?php echo $class?>" >
			<?php tribe_get_template_part( 'list/single', 'event' ) ?>
		</tr>
		<!-- </div> --><!-- .hentry .vevent -->


		<?php do_action( 'tribe_events_inside_after_loop' ); ?>
	<?php endwhile; ?>
	</table>

</div><!-- .tribe-events-loop -->
