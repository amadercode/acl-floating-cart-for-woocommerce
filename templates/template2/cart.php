<?php
global $woocommerce;
$items = $woocommerce->cart->get_cart();
$itemCount = count($items);
$main_icon_url = get_option('acl_focawo_main_icon') != "" ? get_option('acl_focawo_main_icon') : ACL_FOCAWO_IMG_URL . 'cart-icon.png';
$close_icon_url = get_option('acl_focawo_close_icon') != "" ? get_option('acl_focawo_close_icon') : ACL_FOCAWO_IMG_URL . 'close-icon.png';
?>
<div class="focawo-floating-cart-wrapper">
    <aside class="focawo-floating-cart" id="flying_cart">
        <div class="focawo-floating-cart-inner">
            <div class="focawo-floating-cart-header">
                <h3><?php echo (get_option('acl_focawo_cart_title')!=""?get_option('acl_focawo_cart_title'): __('Shopping Cart','acl-floating-cart')); ?> </h3>
            </div>
            <!--focawo-floating-cart-header-->
            <div class="focawo-floating-cart-item-wrapper">
                <div style="display:none" id="focawo-cart-loader"></div>
                <div class="focawo_cart_content">

                </div>
                <!--            focawo_cart_content-->
            </div>
            <!--focawo-floating-cart-item-wrapper-->
            <div class="focawo-floating-cart-footer">
                <div class="focawo-floting-cart-total">
                    <?php echo get_option('acl_focawo_sub_total_label'); ?>
                    <span id="focawo-floting-cart-sub-total">
                            <?php echo $woocommerce->cart->get_cart_total(); ?>
                        </span>
                </div>
                <!-- focawo-floting-trigger-cart-total-->
                <div class="focawo-floting-cart-shipping-message">
                    <?php echo (get_option('acl_focawo_shipping_notice_label')!=""?get_option('acl_focawo_shipping_notice_label'): __('Shipping charge will be added at checkout page.','acl-floating-cart')); ?>
                </div>
            </div>
            <!--focawo-floating-cart-footer-->

        </div>
        <!--focawo-floating-cart-inner-->
    </aside>
    <div class="focawo-floting-cart-trigger">
        <div class="focawo-floting-cart-trigger-inner">
            <div>
                <a id="focawo-floating-checkout-btn"
                   href="<?php echo wc_get_checkout_url(); ?>"> <?php _e('Checkout', 'acl-floating-cart'); ?> </a>
            </div>
        </div>
        <!-- focawo-floting-cart-trigger-inner-->
        <div class="focawo-floting-cart-trigger-icon">
            <div id="focawo-floting-cart-item-qty"
                 class="focawo-floting-cart-item-qty focawo-floting-trigger-item-count"><?php echo $itemCount; ?></div>
            <img class="focawo-floting-cart-main-icon" src="<?php echo $main_icon_url; ?>" alt="<?php _e('Cart Icon', 'acl-floating-cart'); ?>">
            <img class="focawo-floting-cart-close-icon" src="<?php echo $close_icon_url; ?>" alt="<?php _e('Cart Icon', 'acl-floating-cart'); ?>">

        </div>
        <!--focawo-floting-cart-trigger-icon-->
    </div>
</div>
<!--focawo-floating-cart-wrapper-->
<div id="animated-product-image-box"></div>
<div id="focawo-floating-cart-overly"></div>