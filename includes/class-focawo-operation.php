<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class ACL_FOCAWO_Operation {

    /**
     * Constructor function.
     * @access  public
     * @since   1.1.0
     * @return  void
     */
    public function __construct () {
        add_action('wp_ajax_focawo_show_cart', array($this,'show_cart'));
        add_action('wp_ajax_nopriv_focawo_show_cart', array($this,'show_cart'));

        add_action('wp_ajax_focawo_cart_item_remove', array($this,'cart_item_remove'));
        add_action('wp_ajax_nopriv_focawo_cart_item_remove', array($this,'cart_item_remove'));

        add_action('wp_ajax_focawo_update_cart_item_number', array($this,'update_cart_item_number'));
        add_action('wp_ajax_nopriv_focawo_update_cart_item_number', array($this,'update_cart_item_number'));

        add_action('wp_footer', array($this,'floating_fly_cart'));
        add_action('wp_head', array($this,'custom_style'));
    }

    public function floating_fly_cart(){
        $plugin_path=ACL_FOCAWO_PATH;
        $template=get_option('acl_focawo_templates')!=""?get_option('acl_focawo_templates'):'2';
        //ob_start();
        if(file_exists($plugin_path.'templates/template'.$template.'/cart.php')) {
            //Loading the product loop template
            wc_get_template(
                'template' . $template . '/cart.php',
                array(),
                null,
                $plugin_path.'templates/'
            );
        }else{
            echo "<p class='focawo-template-not-found'>".__($plugin_path.'templates/template'.$template.'/cart.php'.' Cart template does not exist!','acl-floating-cart')."</p>";
        }
        //$content = ob_get_clean();
        //return $content;
        ?>
        <?php
    }

    public function show_cart(){
        $html = '';
        global $woocommerce;
        $items = $woocommerce->cart->get_cart();
        $itemCount = count($items);
        if ($itemCount >= 1) {
            $html .= '<div class ="focawo-cart-table">';
            foreach ($items as $item => $values) {
                $_product = apply_filters('woocommerce_cart_item_product', $values['data'], $values, $item);
                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $values ) : '', $values, $item );

                $html .= '<div class="focawo-cart-row">';
                $html .='<div class="focawo-cart-cell focawo-cart-thumb-cell"> <span data-cart-item="'.$item.'" class="focawo-remove-cart-item"><button>'.__('X','acl-floating-cart').'</button></span>';
                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $values, $item );
                if ( ! $product_permalink ) {
                    $html .=$thumbnail; // PHPCS: XSS ok.
                } else {
                    $html .=sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                }
                $html.='</div>';
                $html .='<div class="focawo-cart-cell focawo-cart-title-cell">';

                if ( ! $product_permalink ) {
                    $html.= wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $values, $item ) . '&nbsp;' );
                } else {
                    $html.= wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $values, $item ) );
                }

                do_action( 'woocommerce_after_cart_item_name', $values, $item );

                // Meta data.
                $html.= wc_get_formatted_cart_item_data( $values ); // PHPCS: XSS ok.

                // Backorder notification.
                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $values['quantity'] ) ) {
                    $html.= wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $values['product_id'] ) );
                }
                $html .= '<div class="focawo-cart-item-quantity-oparation">';
                $html .= '<div class="focawo-cart-item-decreament">-</div>';
                $html .= '<div class="focawo-cart-item-qnty-number"><input class="focawo-cart-item-qnty" data-cart-item="' . $item . '" type="number" min="1" value="' . $values['quantity'] . '"></div>';
                $html .= '<div class="focawo-cart-item-increament">+</div>';
                $html .= '</div>';
                $html.='</div>';

                $html .= '<div class="focawo-cart-cell focawo-cart-price-cell"><span>' . apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $values, $item) . '</span></div> </div>';
            }
        } else {
            // focawo_cart_lang_cart_total
            if(isset($focawo_cart_lang_no_products) && $focawo_cart_lang_no_products != '' ){
                $html .= '<div class="focawo_no_cartprods">'.$focawo_cart_lang_no_products.'</div>';
            }else{
                $html .= '<div class="focawo_no_cartprods">'.__('No products in the cart','acl-floating-cart').'</div>';
            }
        }
        $response=array('html'=>$html,'items'=>$itemCount, 'cart_total'=>$woocommerce->cart->get_cart_total());
        echo wp_send_json($response);
        wp_die();
    }

    public function cart_item_remove(){
        //getting cart items n
        global $woocommerce;
        $cart_item_key  = wc_clean($_POST['cart_item']);
        $result         = $woocommerce->cart->remove_cart_item($cart_item_key);
        echo wp_send_json($result);
        wp_die();
    }
    public function update_cart_item_number(){
        //getting cart items
        $cart_item_key  = wc_clean($_POST['cart_item_key']);
        $qnty = empty( $_POST['qnty'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', wc_clean($_POST['qnty']));
        global $woocommerce;
        $result         = $woocommerce->cart->set_quantity($cart_item_key, $qnty);
        echo wp_send_json($result);
        wp_die();
    }

    public function custom_style(){
        if (get_option('acl_focawo_custom_css') != "") {
            ?>
            <style>
                <?php echo get_option('acl_focawo_custom_css');  ?>
            </style>
        <?php }
    }

}
new ACL_FOCAWO_Operation();