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
                        'terms' => 'salgsafdeling',
                    )
                ),
                'post_type' => 'employees',
            );

            $the_query = new WP_Query( $args ); ?>

            
            <?php if ( $the_query->have_posts() ) : ?>
            
                <!-- pagination here -->
            
                <!-- the loop -->
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <?php
                        $department = wp_get_post_terms($post->ID, 'departments');
                        $job_title = get_post_meta($post->ID, 'employee_title')[0];
                        $tel_no = get_post_meta($post->ID, 'employee_tel')[0];
                    
                    ?>
                    <?php the_post_thumbnail('thumbnail'); ?>
                    <h2><?php the_title(); ?></h2>
                    <h3><?=$department[0]->name;?></h3>
                    <h4><?=$job_title;?></h4>
                    <a href="tel:0045<?=$tel_no?>"><h4>+45 <?=$tel_no;?></h4></a>
                    <pre><?php var_dump($job_title) ?></pre>
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