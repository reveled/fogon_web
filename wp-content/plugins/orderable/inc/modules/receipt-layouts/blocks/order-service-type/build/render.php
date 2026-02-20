<?php
/**
 * Render Order Service Types block.
 *
 * @package orderable
 */

// phpcs:ignore WordPress.WP.GlobalVariablesOverride
$order = Orderable_Receipt_Layouts::get_order();

if ( ! $order ) {
	return;
}

$service_type = $order->get_meta( '_orderable_service_type' );

if ( empty( $service_type ) ) {
	return;
}

$label          = $attributes['label'] ?? __( 'Order Type:', 'orderable' );
$delivery_label = empty( $attributes['deliveryLabel'] ) ? Orderable_Services::get_service_label( 'delivery' ) : $attributes['deliveryLabel'];
$pickup_label   = empty( $attributes['pickupLabel'] ) ? Orderable_Services::get_service_label( 'pickup' ) : $attributes['pickupLabel'];

switch ( $service_type ) {
	case 'pickup':
		$service_label = $pickup_label;
		break;

	default:
		$service_label = $delivery_label;
		break;
}
?>

<div <?php echo wp_kses_data( Orderable_Receipt_Layouts::get_receipt_block_wrapper_attributes() ); ?>>
	<?php printf( '<span class="wp-block-orderable-receipt-layouts__label">%s</span>%s', esc_html( $label ), esc_html( $service_label ) ); ?>
</div>
