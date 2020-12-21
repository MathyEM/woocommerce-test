<?php get_header(); ?>
    <div class="wrapper">
        <div class="container">
            <h1>Hello world!</h1>
            <div class="products-container">
                <?php
                    add_action( 'woocommerce_after_shop_loop_item_title', 'wc_add_long_description' );
                    function wc_add_long_description() {
                        global $product;

                        ?>
                            <span class="description">
                                <?php echo apply_filters( 'the_content', $product->post->post_content ) ?>
                            </span>
                        <?php
                    }
                    $args = array(
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
                    $loop = new WP_Query( $args );
                    if ( $loop->have_posts() ) {
                        while ( $loop->have_posts() ) : $loop->the_post();
                            wc_get_template_part( 'content', 'product' );
                        endwhile;
                    } else {
                        echo __( 'No products found' );
                    }
                    wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>