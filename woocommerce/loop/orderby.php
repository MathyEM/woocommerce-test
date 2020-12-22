<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form class="woocommerce-ordering" id="sort-filter" method="get" action="">
	<select name="orderby" class="orderby p-2" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" name="paged" value="1" />
    <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
<?php  
    $orderby = 'name';
    $order = 'asc';
    $hide_empty = true;
    $cat_args = array(
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
    );
    
    $product_categories = get_terms( 'product_cat', $cat_args );
    
    if( !empty($product_categories) ){
        echo '
        <ul class="filter-categories mt-3">';
            foreach ($product_categories as $key => $category) {
                if ( $_GET['category-'.$category->slug] !== "0" ) {
                    $checked = "checked=checked";
                } else {
                    $checked = "";
                }
                echo '
                <li class="filter-category">';
                    echo '<input type="hidden" name="category-' . $category->slug . '" value="0">';
                    echo '
                    <input
                        type="checkbox" name="category-' . $category->slug . '" id="category-' . $category->slug . '" 
                        value="' . $category->slug . '"
                        ' . $checked . '
                    >';
                    echo '<label for="category-' . $category->slug . '">' . $category->name . '</label>';
                echo '</li>';
            }
        echo '<input class="ml-5 py-1 px-3 btn btn-success" type="submit" value="Filtrér">';
        echo '</ul>';
    }
?>
</form>