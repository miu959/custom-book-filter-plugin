<?php 
//get_header();
?>


<form role="search" action="" method="get" id="searchform">
                <input type="text" name="s" placeholder="Search Books"/>
                <input type="hidden" name="post_type" value="books" /> <!-- // hidden 'books' value -->
                <br><lable for="price">Price Range</lable>
                <input type="range" min="500" max="1000" class="slider" id="myRange">
                <p>Value: <span id="demo"></span></p>

                <?php 
                $taxonomy = "authors";
                $taxonomies = get_terms( array(
                    'taxonomy' => $taxonomy,
                    'hide_empty' => false
                ) );	
                if ( !empty($taxonomies) ) :
                    echo '<label for="book_authors">Books Authors List: </label>';
                    $output = '<select name="book_authors" id="book_authors">';
                    foreach( $taxonomies as $category ) {
                        $output.= '<option value="'. esc_attr( $category->slug ) .'">'. esc_html( $category->name ) .'</option>';
                    }
                    $output.='</select>';
                    echo $output;
                endif;

                $taxonomy2 = "publishers";
                $taxonomies2 = get_terms( array(
                    'taxonomy' => $taxonomy2,
                    'hide_empty' => false
                ) );	
                if ( !empty($taxonomies2) ) :
                    echo '<label for="book_publisher">Books Publishers List: </label>';
                    $output2 = '<select name="book_publisher" id="book_publisher">';
                    foreach( $taxonomies2 as $category2 ) {
                        $output2.= '<option value="'. esc_attr( $category2->slug ) .'">'. esc_html( $category2->name ) .'</option>';
                    }
                    $output2.='</select>';
                    echo $output2;
                endif;

                ?>


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
?>

<div class="container">
    <div class="row">  
        <div class="col-md-12">
            <?php 
            $v_args = array(
                'post_type' => 'books',
                'posts_per_page' => -1,
                'order_by' => 'title',
                'order' => 'asc',
                's'             =>  $_name, 
                /*'meta_query'    =>  array(
                    array(
                        'key'     => '_bookprice_meta_key', 
                        'value'   => $_price,
                        'compare' => 'BETWEEN',
                    ),
                )*/
            );
            $SearchQuery = new WP_Query( $v_args );
            if( $SearchQuery->have_posts() ) :
                while( $SearchQuery->have_posts() ) : $SearchQuery->the_post(); ?>
                    <div class="cms-book-list">
                        <h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php the_excerpt(); ?>
                        Price: <?php echo get_post_meta( get_the_ID(), '_bookprice_meta_key', true ); ?><br>
                        <a href="<?php echo get_permalink(); ?>" class="btn">Read More</a>
                    </div>
                <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>


<?php 
//get_footer();
?>