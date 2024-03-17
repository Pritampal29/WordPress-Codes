<?php
global $product;

/****************************************************************************************/
/**
 * Show Woo-Commerce Price in Pages
 * 
 */

$price = $product->get_price();
echo $price;

/****************************************************************************************/
/**
 * Woo-Commerce Support in functions.php File
 * 
 */

    add_theme_support("woocommerce",array(
        "thumbnail_image_width" => 150,
        "single_image_width" => 200,
        "product_grid" => array(
            "default_columns" => 10,
            "min_columns" => 2, // Appearing in shop Page
            "max_columns" => 3  // Appearing in shop Page
        )
    ));

/****************************************************************************************/
/**
 * Remove Woo-Commerce Sidebar From Shop Page
 * 
 */
    remove_action('woocommerce_sidebar','woocommerce_get_sidebar');

/****************************************************************************************/
/**
 * Open Extra Div before Content & Close The Same div After Main Content in functions.php file
 * 
 */

	function open_extra_div() {
		echo "<div class='class_name'><div class='class_name2'>";
	}
	add_action('woocommerce_before_main_content','open_extra_div',5);

	function close_extra_div() {
		echo "</div></div>";
	}
	add_action('woocommerce_after_main_content','close_extra_div',5);
 	
/****************************************************************************************/
/**
 * Open Class on Woo-Commerce Sidebar in functions.php file
 * 
 */

    function open_sidebar_column_grid() {
        echo "<div class='col-md-4'>";
    }
    add_action('woocommerce_before_main_content','open_sidebar_column_grid',6);



    // Add Sidebar In-Between those Div
    add_action('woocommerce_before_main_content','woocommerce_get_sidebar',7);


    /**
     * Close Class on Woo-Commerce Sidebar in functions.php file
     */

    function close_sidebar_column_grid() {
        echo "</div>";
    }
    add_action('woocommerce_before_main_content','close_sidebar_column_grid',8);

/****************************************************************************************/
/**
 * Open Class on Woo-Commerce Main Content in functions.php file
 * 
 */

    function open_product_column_grid() {
        echo "<div class='col-md-8'>";
    }
    add_action('woocommerce_before_main_content','open_product_column_grid',9);


    /**
     * Close Class on Woo-Commerce Main Content in functions.php file
     */

    function close_product_column_grid() {
        echo "</div>";
    }
    add_action('woocommerce_before_main_content','close_product_column_grid',10);

/****************************************************************************************/
/**
 * In Single Product Page If Need to Show full Width Page without Sidebar
 * 
 */

    add_action('template_redirect','load_template_layout');
    function load_template_layout() {
        if(is_shop()) {
            // Add Open Class on Woo-Commerce Sidebar & Open Class on Woo-Commerce Main Content Code Here
        }
    }