<?php

class ACL_FoCaWo_Info_Page
{

    function __construct()
    {
        add_action('admin_menu', array($this, 'menu_item'));
    }

    function menu_item(){
        add_submenu_page(
            'acl-floating-cart',
            'ACL Floating Cart for WooCommerce Help & Info',
            'Help',
            'manage_options',
            'focawo-info-page',
            array($this, 'page_content')
        );
    }
    function page_content(){
        ?>
        <style>


            .focawo-info-page-container,.focawo-support-container {
                padding-left: 20px;
            }

            .focawo-info-page-headline {
                border-bottom: 1px dashed #cccccc;
                margin: 0 0 10px;
                padding: 10px 0;
            }
        </style>
        <div class="wrap">

            <div id="poststuff">

                <div id="post-body" class="metabox-holder columns-2">

                    <div id="post-body-content" style="position: relative;">


                        <div class="focawo-info-page-container">
                            <h2 class="focawo-info-page-headline"><?php _e('Help & Info','acl-floating-cart');?></h2>
                            <p>
                                <?php _e('Getting started with','acl-floating-cart');?> <strong>ACL Floating Cart for WooCommerce</strong><?php _e(' instantly after installing the plugin and you may change & save settings on the','acl-floating-cart');?>
                                <a href="<?php echo get_admin_url();?>admin.php?page=acl-floating-cart"><?php _e('Settings','acl-floating-cart') ?></a>  <?php _e('page.','acl-floating-cart');?>
                            </p>
                            <p><?php _e('ACL Floating Cart Plugin has five settings options.','acl-floating-cart');?></p>
                            <ol>
                                <li><strong><?php _e('General','acl-floating-cart');?> </strong>: <?php _e('All General setting for ACL Floating Cart for WooCommerce.','acl-floating-cart');?></li>
                                <li><strong><?php _e('Templates','acl-floating-cart');?></strong> : <?php _e('Option to Choice a Template for your WooCommerce Store.','acl-floating-cart');?></li>
                                <li><strong><?php _e('Cart Icons','acl-floating-cart');?></strong> : <?php _e('Use the default or your custom floating cart icons (main icon & close icon) for respective templates.','acl-floating-cart');?></li>
                                <li><strong><?php _e('Translation','acl-floating-cart');?></strong> : <?php _e('Use to convert to your target laguage of common string on the cart.','acl-floating-cart');?></li>
                                <li><strong><?php _e('Custom Style','acl-floating-cart');?></strong> : <?php _e('Design your store by overriding default with your own style (CSS).','acl-floating-cart');?></li>
                            </ol>
                        </div>
                        <div class="focawo-support-container">
                            <h3 style="text-align: center"><?php _e('Bug report, feature request or any feedback – just inbox us at','acl-floating-cart');?></h3>
                            <p style="text-align: center;font-size: 20px;color:#0D72B2">amadercode@gmail.com</p>

                        </div>

                        <div style="padding: 15px 10px; border: 1px solid #ccc; text-align: center; margin-top: 20px;">
                            <?php _e('Developed By','acl-floating-cart');?>: <a href="https://www.amadercode.com" target="_blank"><?php _e('Web & Mobile Application Developer Company','acl-floating-cart');?></a> -
                            AmaderCode Lab
                        </div>

                    </div>
                    <!-- /post-body-content -->


                </div>
                <!-- /post-body-->

            </div>
            <!-- /poststuff -->

        </div>
        <!-- /wrap -->

        <?php
    }
}

new ACL_FoCaWo_Info_Page();