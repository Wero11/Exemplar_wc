<?php 
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php 

// Setup an array of venue details for use later in the template
$venue_details = array();

if ($venue_name = tribe_get_meta( 'tribe_event_venue_name' ) ) {
	$venue_details[] = $venue_name;	
}

if ($venue_address = tribe_get_meta( 'tribe_event_venue_address' ) ) {
	$venue_details[] = $venue_address;	
}
// Venue microformats
$has_venue = ( $venue_details ) ? ' vcard': '';
$has_venue_address = ( $venue_address ) ? ' location': '';

global $post;
$event = $post;
?>

<!-- Event Cost -->
<!-- <?php if ( tribe_get_cost() ) : ?> 
	<div class="tribe-events-event-cost">
		<span><?php echo tribe_get_cost( null, true ); ?></span>
	</div>
<?php endif; ?> -->

<td class="event-date-td">
	<div class="date">
		<?php if ( tribe_event_is_multiday( $event ) ) {  // multi-date event ?>
			<?php if ( tribe_event_is_all_day( $event ) ) { ?>
				<span class="event-date-weekday"><?php echo tribe_get_start_date( $event, true, "D" ) ?></span>
				<span class="event-date-day"><?php echo tribe_get_start_date( $event, true, "j" ) ?></span>
				<span class="event-date-month"><?php echo tribe_get_start_date( $event, true, "M" ) ?></span>
			<?php } else { ?>
				<span class="event-date-weekday"><?php echo tribe_get_start_date( $event, false, "D" ) ?></span>
				<span class="event-date-day"><?php echo tribe_get_start_date( $event, false, "j" ) ?></span>
				<span class="event-date-month"><?php echo tribe_get_start_date( $event, false, "M" ) ?></span>
			<?php }?>
		<?php } elseif ( tribe_event_is_all_day( $event ) ) { // all day event ?>
			<span class="event-date-weekday"><?php echo tribe_get_start_date( $event, true, "D" ) ?></span>
			<span class="event-date-day"><?php echo tribe_get_start_date( $event, true, "j" ) ?></span>
			<span class="event-date-month"><?php echo tribe_get_start_date( $event, true, "M" ) ?></span>
		<?php } else { // single day event ?>
			<span class="event-date-weekday"><?php echo tribe_get_start_date( $event, false, "D" ) ?></span>
			<span class="event-date-day"><?php echo tribe_get_start_date( $event, false, "j" ) ?></span>
			<span class="event-date-month"><?php echo tribe_get_start_date( $event, false, "M" ) ?></span>
		<?php } ?>
	</div>
</td>

<td class="event-description-td">
	<!-- Event Title -->
	<?php do_action( 'tribe_events_before_the_event_title' ) ?>
	<!-- <h2 class="tribe-events-list-event-title summary"> -->
		<span class="event-title">
			<a class="url" href="<?php echo tribe_get_event_link() ?>" rel="bookmark">
				<?php the_title() ?>
			</a>
		</span>
	<!--</h2>-->
	<?php do_action( 'tribe_events_after_the_event_title' ) ?>

	<!-- Event Meta -->
	<?php do_action( 'tribe_events_before_the_meta' ) ?>
	<div class="tribe-events-event-meta <?php echo $has_venue . $has_venue_address; ?>">

		<!-- Schedule & Recurrence Details -->
		<div class="updated published time-details">
			<?php //echo tribe_events_event_schedule_details() ?>
			<?php //echo tribe_events_event_recurring_info_tooltip() ?>
		</div>
		
		<?php if ( $venue_details ) : ?>
			<!-- Venue Display Info -->
			<div class="tribe-events-venue-details">
				<?php echo implode( ', ', $venue_details) ; ?>
			</div> <!-- .tribe-events-venue-details -->
		<?php endif; ?>

	</div><!-- .tribe-events-event-meta -->
	<?php do_action( 'tribe_events_after_the_meta' ) ?>

	<!-- Event Image -->
	<?php echo tribe_event_featured_image( null, 'medium' ) ?>

	<!-- Event Content -->
	<?php do_action( 'tribe_events_before_the_content' ) ?>
	<div class="tribe-events-list-event-description tribe-events-content description entry-summary">
		<?php //the_excerpt() ?>
		<!-- <a href="<?php echo tribe_get_event_link() ?>" class="tribe-events-read-more" rel="bookmark"><?php _e( 'Find out more', 'tribe-events-calendar' ) ?> &raquo;</a>-->
	</div><!-- .tribe-events-list-event-description -->
	<?php do_action( 'tribe_events_after_the_content' ) ?>
</td>

<td class="event-start-time-td">
	<span><?php echo __("Start Time", "Exemplar") ?></span><br/>
	
	<?php if ( tribe_event_is_multiday( $event ) ) {  // multi-date event ?>
		<?php if ( tribe_event_is_all_day( $event ) ) { ?>
			<?php echo __("All day event", "Exemplar") ?>
		<?php } else { ?>
			<?php echo tribe_get_start_date( $event, false, "H:i A" ) ?>
		<?php }?>
	<?php } elseif ( tribe_event_is_all_day( $event ) ) { // all day event ?>
		<?php echo __("All day event" , "Exemplar") ?>
	<?php } else { // single day event ?>
		<?php echo tribe_get_start_date( $event, false, "H:i A" ) ?>
	<?php } ?>
</td>

<!--
<td class="event-enquiry-td">
	<input type="button" class="small button green" value="Enquire">
</td>
-->