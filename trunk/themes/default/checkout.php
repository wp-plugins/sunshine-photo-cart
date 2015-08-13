<?php load_template(SUNSHINE_PATH.'themes/default/header.php'); ?>

<h1><?php _e('Checkout', 'sunshine'); ?></h1>

<?php echo apply_filters('the_content', $post->post_content); ?>

<form method="post" action="<?php sunshine_url('checkout'); ?>" id="sunshine-checkout" class="sunshine-form">
<?php do_action('sunshine_checkout_start_form'); ?>
<input type="hidden" name="sunshine_checkout" value="1" />
<?php if (sunshine_cart_items()) { ?>

	<ol id="sunshine-checkout-steps">
		<li id="sunshine-checkout-step-contact">
			<?php sunshine_checkout_contact_fields(); ?>
		</li>
		<li id="sunshine-checkout-step-billing">
			<?php sunshine_checkout_billing_fields(); ?>
		</li>
		<li id="sunshine-checkout-step-shipping">
			<?php sunshine_checkout_shipping_fields(); ?>
		</li>
		<li id="sunshine-checkout-step-shipping-methods">
			<?php sunshine_checkout_shipping_methods(); ?>
		</li>
		<li id="sunshine-checkout-order-review">
			<?php sunshine_checkout_order_review(); ?>
		</li>
		<li id="sunshine-checkout-step-payment-methods">
			<?php sunshine_checkout_payment_methods(); ?>
		</li>
	</ol>

	<div class="sunshine-checkout-buttons">
		<input type="submit" value="<?php _e('Complete my purchase', 'sunshine'); ?>" class="sunshine-button" /></a>
	</div>

<?php } else { ?>
	<p><?php _e('You do not have anything in your cart yet', 'sunshine'); ?></p>
<?php } ?>

	<?php do_action('sunshine_checkout_end_form'); ?>
</form>

<?php load_template(SUNSHINE_PATH.'themes/default/footer.php'); ?>