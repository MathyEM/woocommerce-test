<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'twentywenty-style';
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(), 
        $theme->parent()->get('Version')
    );
}

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

// Custom Post Type - Medarbejdere 
//-- https://www.wpbeginner.com/wp-tutorials/how-to-create-custom-post-types-in-wordpress/
//-- https://developer.wordpress.org/reference/functions/register_post_type/
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );
function create_posttype() {
 
    register_post_type( 'employees',
        array(
            'labels' => array(
                'name' => __( 'Medarbejdere' ),
                'singular_name' => __( 'Medarbejder' )
            ),
            'has_archive' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array('slug' => 'employees'),
            'supports' => array('title', 'thumbnail', 'custom-fields'),
            'taxonomies' => array('departments'),
 
        )
    );
}

//Custom Taxonomy - Afdelinger
//-- https://www.wpbeginner.com/wp-tutorials/create-custom-taxonomies-wordpress/
//-- https://developer.wordpress.org/reference/functions/register_taxonomy/
//Hook into the init action and call create_departments_taxonomy when it fires
add_action( 'init', 'create_departments_taxonomy', 0 );
function create_departments_taxonomy() {
   $labels = array(
    'name' => _x( 'Afdelinger', 'taxonomy general name' ),
    'singular_name' => _x( 'Afdeling', 'taxonomy singular name' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'menu_name' => __( 'Afdelinger' ),
  ); 
 
  register_taxonomy('departments','employees',array(
    'hierarchical' => false,
    'labels' => $labels,
    'publicly_queryable' => true,
    'query_var' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'rewrite' => array( 'slug' => 'departments' ),
  ));
}


//https://premium.wpmudev.org/blog/company-info-global-variables/
/*===================================================================================
* Add global options
* =================================================================================*/

/**
 *
 * The page content surrounding the settings fields. Usually you use this to instruct non-techy people what to do.
 *
 */
function theme_settings_page(){ 
	?>
	<div class="wrap">
		<h1>Virksomhedsinformation</h1>
		<p>Dette er globale virksomhedsoplysninger. Ændringer kan ses flere stedet på websitet</p>
		<form method="post" action="options.php">
			<?php
			settings_fields("section");
			do_settings_sections("theme-options");
			submit_button();
			?>
		</form>
	</div>
	
	<?php }

/**
 *
 * Next comes the settings fields to display. Use anything from inputs and textareas, to checkboxes multi-selects.
 *
 */

// Street address
function display_business_name_element(){ ?>
	
	<input type="text" name="business_name" placeholder="Indtast virksomhedsnavn" value="<?php echo get_option('business_name'); ?>" size="35">

<?php }

// Phone
function display_support_phone_element(){ ?>
	
	<input type="tel" name="support_phone" placeholder="Indtast telefonnummer" value="<?php echo get_option('support_phone'); ?>" size="35">

<?php }

// Street address
function display_street_address_element(){ ?>
	
	<input type="text" name="street_address" placeholder="Indtast gade og husnummer" value="<?php echo get_option('street_address'); ?>" size="35">

<?php }

// City & zipcode
function display_city_element(){ ?>
	
	<input type="text" name="city" placeholder="Indtast by og postnummer" value="<?php echo get_option('city'); ?>" size="35">

<?php }

// Email
function display_support_email_element(){ ?>
	
	<input type="email" name="support_email" placeholder="Indtast email" value="<?php echo get_option('support_email'); ?>" size="35">
	
<?php }

/**
 *
 * Here you tell WP what to enqueue into the <form> area. You need:
 *
 * 1. add_settings_section
 * 2. add_settings_field
 * 3. register_setting
 *
 */

function display_custom_info_fields(){
	
	add_settings_section("section", "Virksomhedsinformation", null, "theme-options");

    add_settings_field("business_name", "Virksomhedsnavn", "display_business_name_element", "theme-options", "section");
	add_settings_field("support_phone", "Support Telefon", "display_support_phone_element", "theme-options", "section");
	add_settings_field("support_email", "Support Email", "display_support_email_element", "theme-options", "section");
	add_settings_field("street_address", "Gade", "display_street_address_element", "theme-options", "section");
	add_settings_field("city", "By og postnummer", "display_city_element", "theme-options", "section");

    register_setting("section", "business_name");
	register_setting("section", "support_phone");
	register_setting("section", "support_email");
	register_setting("section", "street_address");
	register_setting("section", "city");
	
}

add_action("admin_init", "display_custom_info_fields");

/**
 *
 * Tie it all together by adding the settings page to wherever you like. For this example it will appear
 * in Settings > Contact Info
 *
 */

function add_custom_info_menu_item(){
	
	add_options_page("Virksomhedsinformation", "Virksomhedsinformation", "manage_options", "contact-info", "theme_settings_page");
	
}

add_action("admin_menu", "add_custom_info_menu_item");


//Fjern tilbudspris
function disable_wc_price_fields(){
    $my_post_type = 'product';
    global $post;
    $post_id = $post->ID;

    if($post->post_type == $my_post_type && productHasCategory($post_id, "udlejning") ){
        wp_register_script('disable_wc_price_fields', 
        get_stylesheet_directory_uri() . '/js/disable-wc-price-fields.js', array('jquery'), true);
        
        wp_enqueue_script('disable_wc_price_fields');
    }

}
add_action('admin_head-post.php', 'disable_wc_price_fields');

function productHasCategory($post_id, $cat_slug) {
    $categories = wp_get_post_terms($post_id, 'product_cat');
    $cat_count = count( $categories );
    $index = 0;

    foreach ($categories as $category) {
        if ($category->slug == $cat_slug) {
            return true;
        } else {
            if ($index == $cat_count-1) {
                return false;
            }
            continue;
        }
        $index++;
    }
}


//Display rental products' ACF data
function wc_custom_rental_page() {
    if( !productHasCategory(get_the_id(), "udlejning") ) {
        return;
    }

    function wc_display_rental_prices() {
        function get_price_class($sale_price) {
            $classes = "";
            if (!$sale_price) {
                $classes .= "";
            } else {
                $classes .= "line-through";
            }

            return $classes;
        }

        
        $daglig_pris = get_field( 'daglig_vejledende_pris' );
        $daglig_pris_tilbud = get_field( 'daglig_vejledende_pris_tilbud' );
        $daglig_pris_class = get_price_class($daglig_pris_tilbud);
        
        $ugentlig_pris = get_field( 'ugentlig_vejledende_pris' );
        $ugentlig_pris_tilbud = get_field( 'ugentlig_vejledende_pris_tilbud' );
        $ugentlig_pris_class = get_price_class($ugentlig_pris_tilbud);
        
        $maanedlig_pris = get_field( 'maanedlig_vejledende_pris' );
        $maanedlig_pris_tilbud = get_field( 'maanedlig_vejledende_pris_tilbud' );
        $maanedlig_pris_class = get_price_class($maanedlig_pris_tilbud);
        $currency = "kr.";
        
        echo "<div class='rental-prices-container row'>";
        echo "   <div class='col-4'>";
        echo "        <h3>Vejledende pris pr. dag</h3>";
        echo "        <p class='$daglig_pris_class'>$daglig_pris$currency</p>";
        echo "        <p>$daglig_pris_tilbud$currency</p>";
        echo "    </div>";
        echo "    <div class='col-4'>";
        echo "        <h3>Vejledende pris pr. uge</h3>";
        echo "        <p class='$ugentlig_pris_class'>$ugentlig_pris$currency</p>";
        echo "        <p>$ugentlig_pris_tilbud$currency</p>";
        echo "    </div>";
        echo "    <div class='col-4'>";
        echo "        <h3>Vejledende pris pr. måned</h3>";
        echo "        <p class='$maanedlig_pris_class'>$maanedlig_pris$currency</p>";
        echo "        <p>$maanedlig_pris_tilbud$currency</p>";
        echo "    </div>";
        echo "</div>";
    }
    add_action( 'woocommerce_single_product_summary', 'wc_display_rental_prices', 11 );


    //Display "Send rental request"-section
    function wc_rental_request() {
        echo '<form id="request-form" method="post" action="' . admin_url('admin-ajax.php') . '">';
        echo '    <input name="post-id" id="post-id" value="' . get_the_id() . '" type="hidden">';
        echo '    <input class="mt-5" type="email" name="email" id="email" placeholder="Indtast email*" required>';
        echo '    <input class="my-3" type="tel" name="phone" id="phone" placeholder="Indtast telefonnummer*" required>';
        echo '    <input class="btn btn-success" type="submit" value="Send forespørgsel">';
        echo '</form>';
        echo '<div id="rental-response" class="rental-response mt-5"></div>';
    }
    add_action( 'woocommerce_single_product_summary', 'wc_rental_request', 12 );

    //enqueue ajax script
    wp_register_script( "rental_request", get_stylesheet_directory_uri() . '/js/rental_request.js', array('jquery') );
    wp_localize_script( 'rental_request', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'rental_request' );
}
add_action('woocommerce_before_main_content', 'wc_custom_rental_page');


//process rental request
function rental_request() {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $post_id = $_POST['post_id'];

    $daglig_pris = get_field( 'daglig_vejledende_pris', $post_id );
    $daglig_pris_tilbud = get_field( 'daglig_vejledende_pris_tilbud', $post_id );
    
    $ugentlig_pris = get_field( 'ugentlig_vejledende_pris', $post_id );
    $ugentlig_pris_tilbud = get_field( 'ugentlig_vejledende_pris_tilbud', $post_id );
    
    $maanedlig_pris = get_field( 'maanedlig_vejledende_pris', $post_id );
    $maanedlig_pris_tilbud = get_field( 'maanedlig_vejledende_pris_tilbud', $post_id );

    $data['day_price'] = ($daglig_pris_tilbud !== "") ? $daglig_pris_tilbud : $daglig_pris;
    $data['week_price'] = ($ugentlig_pris_tilbud !== "") ? $ugentlig_pris_tilbud : $ugentlig_pris;
    $data['month_price'] = ($maanedlig_pris_tilbud !== "") ? $maanedlig_pris_tilbud : $maanedlig_pris;

    $data['product_name'] = get_the_title($post_id);

    $categories = wp_get_post_terms($post_id, 'product_cat');
    $data['product_cat'] = $categories[0]->name;

    $result = json_encode($data);
    echo $result;
    die();
}
add_action('wp_ajax_rental_request', 'rental_request');
add_action('wp_ajax_nopriv_rental_request', 'rental_request');
