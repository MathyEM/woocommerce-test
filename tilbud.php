<?php /* Template Name: Tilbudsprodukter */ ?>
<?php get_header(); ?>
    <div class="wrapper">
        <div class="container">
            <h1>Hello world!</h1>
            <h2>
                <?php
                    global $wp;
                    echo home_url($wp->request)
                ?>
            </h2>
            <div class="order-filter-container">
                <?php
                    wc_custom_orderby();
                ?>
            </div>
            <div class="products-container">
                <?php
                    wc_do_product_loop( wc_do_orderby( $_GET['orderby'] ?? "" ), wc_do_filter_cat($_GET) ?? "" );
                    
                ?>
            </div>
        </div>
    </div>
<?php get_footer('shop'); ?>
<?php
function wc_custom_orderby() {
    $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
    $catalog_orderby_options = apply_filters(
        'woocommerce_catalog_orderby',
        array(
            'menu_order' => __( 'Default sorting', 'woocommerce' ),
            'date'       => __( 'Sort by latest', 'woocommerce' ),
            'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
            'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
        )
    );

    $default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
    // phpcs:disable WordPress.Security.NonceVerification.Recommended
    $orderby = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby;
    // phpcs:enable WordPress.Security.NonceVerification.Recommended
                                
    wc_get_template(
        'loop/orderby.php',
        array(
            'catalog_orderby_options' => $catalog_orderby_options,
            'orderby'                 => $orderby,
            'show_default_orderby'    => $show_default_orderby,
        )
    );
}

function wc_do_orderby( $get_orderby ) {
    switch ($get_orderby) {
        case 'menu_order':
            return false;
            break;

        case 'date':
            $orderby['orderby'] = 'date';
            $orderby['order'] = 'ASC';
            $orderby['meta_key'] = '';
            break;

        case 'price':
            $orderby['orderby'] = 'meta_value_num';
            $orderby['order'] = 'ASC';
            $orderby['meta_key'] = '_price';
            break;

        case 'price-desc':
            $orderby['orderby'] = 'meta_value_num';
            $orderby['order'] = 'DESC';
            $orderby['meta_key'] = '_price';
            break;

        default:
            return false;
            break;
    }

    return $orderby;
}

function wc_do_filter_cat( $get_filter_cat ) {
    $get_keys = array_keys($get_filter_cat);
<<<<<<< HEAD
    $get_keys_keys = preg_grep("/((category-)([a-zA-Z\S]+))/", $get_keys); //((category-)([a-zA-Z\S]+))
=======
    $get_keys_keys = preg_grep("/((category-)([a-zA-Z\S]+))/", $get_keys);
>>>>>>> 4e2911962f32d15f4b00d3ee6d1318897e6fd659

    $filtered_categories = [];

    foreach ($get_keys_keys as $key => $value) {
        if ($_GET[$value] !== 0) {
            array_push($filtered_categories, $_GET[$value]);
        }
    }

    return $filtered_categories;
}

function wc_do_product_loop( $orderby, $filterby ) {
    add_action( 'woocommerce_after_shop_loop_item_title', 'wc_add_long_description' );
    function wc_add_long_description() {
        global $product;
        
        ?>
            <span class="description">
                <?php echo apply_filters( 'the_content', $product->get_description() ) ?>
            </span>
        <?php
    }

    $args = array(
        'wc_query' => 'product_query',
        'post_type' => 'product',
        'posts_per_page' => 12,
        'meta_query' => array( //only get products on sale
            array(
                'key'     => '_sale_price',
                'value'   => 0,
                'compare' => '>'
            )
        )
    );

    if (isset($orderby)) {
        $args['orderby'] = $orderby['orderby'];
        $args['order'] = $orderby['order'];
        $args['meta_key'] = $orderby['meta_key'];
    }

    if (is_array($filterby)) {
        $args['product_cat'] = "sko";
        foreach ($filterby as $key => $value) {
            if ($key !== 0) {
                $args['product_cat'] .= ", " . $value;
            } else {
                $args['product_cat'] = $value;
            }
        }
    }

    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();
            wc_get_template_part( 'content', 'product' );
        endwhile;
    } else {
        echo __( 'No products found' );
    }
    wp_reset_postdata();
}