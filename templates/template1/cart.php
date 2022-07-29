<?php
global $woocommerce;
$items = $woocommerce->cart->get_cart();
$itemCount = count($items);
?>
<aside class="focawo-floating-cart" id="flying_cart">
    <div class="focawo-floating-cart-inner">
        <div class="focawo-floating-cart-header">
            <h3><?php echo (get_option('acl_focawo_cart_title')!=""?get_option('acl_focawo_cart_title'): __('Shopping Cart','acl-floating-cart')); ?> </h3>
        </div>
        <!--focawo-floating-cart-header-->
        <div class="focawo-floating-cart-item-wrapper">
            <div style="display:none" id="focawo-cart-loader"></div>
            <div class="focawo_cart_content"></div>
            <!--            focawo_cart_content-->
        </div>
        <!--focawo-floating-cart-item-wrapper-->
        <div class="focawo-floating-cart-footer">
            <ul>
                <li>
                    <a id="focawo-floating-checkout-btn"
                       href="<?php echo wc_get_checkout_url(); ?>"> <?php _e('Checkout', 'acl-floating-cart'); ?> </a>
                </li>
            </ul>

        </div>
        <!--focawo-floating-cart-footer-->
    </div>
    <!--focawo-floating-cart-inner-->
</aside>
<div class="focawo-floting-cart-trigger">
    <div class="focawo-floting-cart-trigger-inner">
        <div class="focawo-floting-trigger-item-count">
            <span id="focawo-floting-cart-item-qty"> <?php echo $itemCount; ?></span>
            <span>
            <?php
            $item_title = (get_option('acl_focawo_item_label') != "" ? ' ' . get_option('acl_focawo_item_label') :__('Items','acl-floating-cart'));
            echo $item_title;
            ?>
            </span>
        </div>
        <div class="focawo-floting-trigger-cart-total">
            <span id="focawo-floting-cart-sub-total">
                <?php echo $woocommerce->cart->get_cart_total(); ?>
            </span>
        </div>
    </div>
</div>
<!--focawo-floting-cart-trigger-->
<div id="animated-product-image-box"></div>