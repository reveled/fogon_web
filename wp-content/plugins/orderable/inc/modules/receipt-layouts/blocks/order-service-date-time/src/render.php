<?php
/**
 * Render Order Service Date Time block.
 *
 * @package orderable
 */

// phpcs:ignore WordPress.WP.GlobalVariablesOverride
$order = Orderable_Receipt_Layouts::get_order();

if ( ! $order ) {
	return;
}

$service_type = $order->get_meta( '_orderable_service_type' );

$delivery_label = Orderable_Services::get_service_label( 'delivery' );
// translators: %s - Delivery label
$default_delivery_date_label = sprintf( __( '%s Date:', 'orderable' ), $delivery_label );
// translators: %s - Pickup label
$default_delivery_time_label = sprintf( __( '%s Time:', 'orderable' ), $delivery_label );

$delivery_date_label = empty( $attributes['deliveryDateLabel'] ) ? $default_delivery_date_label : $attributes['deliveryDateLabel'];
$delivery_time_label = empty( $attributes['deliveryTimeLabel'] ) ? $default_delivery_time_label : $attributes['deliveryTimeLabel'];

$pickup_label = Orderable_Services::get_service_label( 'pickup' );
// translators: %s - Delivery label
$default_pickup_date_label = sprintf( __( '%s Date:', 'orderable' ), $pickup_label );
// translators: %s - Pickup label
$default_pickup_time_label = sprintf( __( '%s Time:', 'orderable' ), $pickup_label );

$pickup_date_label = empty( $attributes['pickupDateLabel'] ) ? $default_pickup_date_label : $attributes['pickupDateLabel'];
$pickup_time_label = empty( $attributes['pickupTimeLabel'] ) ? $default_pickup_time_label : $attributes['pickupTimeLabel'];

switch ( $service_type ) {
	case 'pickup':
		$service_date_label = $pickup_date_label;
		$service_time_label = $pickup_time_label;
		break;

	default:
		$service_date_label = $delivery_date_label;
		$service_time_label = $delivery_time_label;
		break;
}

$order_service_date = $order->get_meta( 'orderable_order_date' );

if ( empty( $order_service_date ) ) {
	return;
}

$order_service_time = false;
if ( class_exists( 'Orderable_Timings_Pro_Checkout' ) ) {
	$order_service_time = $order->get_meta( 'orderable_order_time' );
}

?>

<?php if ( $attributes['showDate'] ?? true ) : ?>
	<div <?php echo wp_kses_data( Orderable_Receipt_Layouts::get_receipt_block_wrapper_attributes() ); ?>>
		<?php
			// translators: %1$s - date.
			printf( __( '<span class="wp-block-orderable-receipt-layouts__label">%1$s</span> %2$s', 'orderable' ), esc_html( $service_date_label ), esc_html( $order_service_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div>
<?php endif; ?>

<?php if ( $order_service_time && ( $attributes['showTime'] ?? true ) ) : ?>
	<div <?php echo wp_kses_data( Orderable_Receipt_Layouts::get_receipt_block_wrapper_attributes() ); ?>>
		<?php
			// translators: %1$s - time
			printf( __( '<span class="wp-block-orderable-receipt-layouts__label">%1$s</span> %2$s', 'orderable' ), esc_html( $service_time_label ), esc_html( $order_service_time ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div>
<?php endif; ?>
