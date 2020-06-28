<?php
/**
 * View: Events Bar Views List
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/components/events-bar/views/list.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @version 5.0.0
 *
 * @var array $public_views Array of data of the public views, with the slug as the key.
 */
?>
<div
	class="tribe-events-c-view-selector__content"
	id="tribe-events-view-selector-content"
	data-js="tribe-events-view-selector-list-container"
>
	<ul class="tribe-events-c-view-selector__list">
		<?php foreach ( $public_views as $public_view_slug => $public_view_data ) : ?>
			<?php $this->template(
				'components/events-bar/views/list/item',
				[ 'public_view_slug' => $public_view_slug, 'public_view_data' => $public_view_data ]
			); ?>
		<?php endforeach; ?>
	</ul>
</div>
<?php foreach ( $public_views as $public_view_slug => $public_view_data ) :

$list_item_classes = [ 'tribe-events-c-view-selector__list-item', "tribe-events-c-view-selector__list-item--$public_view_slug" ];
	$active = ($view_slug === $public_view_slug )?'active' : '';
?>
	<a
		href="<?php echo esc_url( $public_view_data->view_url ); ?>"
		class="tribe-events-c-view-selector__list-item-link <?php echo $active; ?>"
		data-js="tribe-events-view-link"
	>
		<span class="tribe-events-c-view-selector__list-item-icon tribe-common-svgicon tribe-common-svgicon--<?php echo esc_attr( $public_view_slug ); ?>"></span>
		<span class="tribe-events-c-view-selector__list-item-text">
			<?php echo ($public_view_data->view_label  == 'Month')? 'Calendar' :  esc_html( $public_view_data->view_label ); ?>
		</span>
	</a>

<?php endforeach; ?>
