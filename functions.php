<?php 
// GET PARENT STYLE SHEET
//add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
//function enqueue_parent_styles() {
  //  wp_enqueue_style( 'parent-style', get_template_directory_uri().'/assets/css/theme-style.css' );
	//wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css' );
//}

// add_action( 'wp_enqueue_scripts', 'enqueue_child_styles' );
// function enqueue_child_styles() {
	// $parent_style = 'searchactions-parent-style';
   //  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
   //  wp_enqueue_style( 'child-style',
     //    get_stylesheet_directory_uri() . '/style.css',
      //   array( $parent_style ),
       //  wp_get_theme()->get('Version')
   //  );
// }

// LATEST BLOG POSTS - KEEP?
function latest_blog_list( $atts ){

echo '<div class="grid-container">';
echo '<div class="post-row">';
echo '<div class="grid-x grid-margin-x images-shadow latest-blog-articles" data-equalizer data-equalize-on="large">';
$the_query = new WP_Query( 'posts_per_page=3' );
while ($the_query -> have_posts()) : $the_query -> the_post();
echo '<div class="large-4 cell">';
echo '<div class="post-wrapper" data-equalizer-watch>';
echo '<a href="'; echo the_permalink();echo '" title="'; echo the_title();echo '">';the_post_thumbnail('full'); echo '</a>';
echo '<div class="post-box">';
echo '<div class="date"><p>';echo get_the_date();echo '</p></div>';
echo '<div class="title"><h3><a href="'; echo the_permalink();echo '" title="'; echo the_title();echo '">';echo the_title();echo '</a></h3></div>';
echo '</div>';
echo '</div>';
echo '<div class="post-link"><a class="text-gradient" data-hover="Read Article" title="read article" href="';
the_permalink();
echo '">Read Article <i class="fa fa-caret-right" aria-hidden="true"></i></a></div>';
echo '</div>';
endwhile;
wp_reset_postdata();
echo '</div>';
echo '</div>'; // .post-row
echo '</div>'; //.grid-container

}
add_shortcode( 'latest_blog_articles', 'latest_blog_list' );

// LATEST BLOG POSTS - KEEP?
add_shortcode( 'list-faqs', 'faq_parameters_shortcode' );
function faq_parameters_shortcode( $atts, $content ) {
	ob_start();
	extract( shortcode_atts( array (
		'category' => '',
		'taxonomy' => '',
		
	), $atts ) );
	$options = array(
		'post_type' => 'faq',
		'category_name' => $category,
		'taxonomy_name' => $taxonomy,
		'order' => 'ASC',
		'order_by' => 'date',
		
	);
	$query = new WP_Query( $options );
	if ( $query->have_posts() ) { ?>
		<ul class="thin accordion faq" data-accordion data-allow-all-closed="true">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<li class="accordion-item" data-accordion-item>
				<a href="#" class="accordion-title"><?php the_title(); ?></a>
				<div class="accordion-content" data-tab-content>
					<?php echo wp_strip_all_tags( get_the_content() ); ?>
				</div>
			</li>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</ul>
	<?php $myvariable = ob_get_clean();
	return $myvariable;
	}	
}

function my_acf_format_value_for_api($value, $post_id, $field){
	return str_replace( ']]>', ']]>', apply_filters( 'the_content', $value) );
}
function my_on_init(){
	if(!is_admin()){
		add_filter('acf/format_value_for_api/type=wysiwyg', 'my_acf_format_value_for_api', 10, 3);
	}
}
add_action('init', 'my_on_init');