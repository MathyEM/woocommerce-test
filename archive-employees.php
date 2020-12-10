<?php get_header(); ?>
    <div class="container">
        <h1>Hello World!</h1>
        <?php
            $terms = get_terms( array(
                'taxonomy' => 'departments',
                'hide_empty' => false,
            ) );

            // the query
            $args = array( 
                'tax_query' => array(
                    array (
                        'taxonomy' => 'departments',
                        'field' => 'slug',
                        'terms' => 'udviklingsafdeling',
                    )
                ),
                'post_type' => 'employees',
            );

            $the_query = new WP_Query( $args ); ?>

            
            <?php if ( $the_query->have_posts() ) : ?>
            
                <!-- pagination here -->
            
                <!-- the loop -->
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <?php $department = get_the_terms( the_post()->ID, 'departments' )[0]->name; ?>

                    <h2><?php the_title(); ?></h2>
                    <h3><?= $department; ?></h3>
                    <pre><?php // var_dump($terms); ?></pre>
                    <br>
                <?php endwhile; ?>
                <!-- end of the loop -->
            
                <!-- pagination here -->
            
                <?php wp_reset_postdata(); ?>
            
            <?php else : ?>
                <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
            <?php endif; ?>
    </div>
<?php get_footer(); ?>