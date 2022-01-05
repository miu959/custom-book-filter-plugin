<form role="search" action="" method="get" id="searchform">
                <input type="text" name="s" placeholder="Search Books"/>
                <input type="hidden" name="post_type" value="books" /> <!-- // hidden 'books' value -->
                <br><lable for="price">Price Range</lable>
                <input type="range" min="500" max="1000" class="slider" id="myRange">
                <p>Value: <span id="demo"></span></p>
                <input type="submit" alt="Search" value="Search" />
            </form>
			<script>
	var slider = document.getElementById("myRange");
	var output = document.getElementById("demo");
	output.innerHTML = slider.value;

	slider.oninput = function() {
	output.innerHTML = this.value;
	}
	</script>
<?php 
$_name = $_GET['s'] != '' ? $_GET['s'] : '';
$_price = $_GET['myRange'] != '' ? $_GET['myRange'] : '';


$v_args = array(
    'post_type'     =>  'books', // your CPT
    's'             =>  $_name, 
    'meta_query'    =>  array(
        array(
            'key'     => '_bookprice_meta_key', 
            'value'   => $_price,
            'compare' => 'BETWEEN',
        ),
    )
);
$SearchQuery = new WP_Query( $v_args );
if( $SearchQuery->have_posts() ) :
    while( $SearchQuery->have_posts() ) : $SearchQuery->the_post();
        the_title(); 
        echo get_post_meta( $post->ID, '_bookprice_meta_key', true );
    endwhile;
else :
    _e( 'Sorry, nothing matched your search criteria', 'textdomain' );
endif;
wp_reset_postdata();

?>