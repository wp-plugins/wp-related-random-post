
<?php 

/******************************************************

Plugin Name: WP Related Random Post 
Plugin URI:  http://www.devscodebd.com
Description: Show the related post on a single post 
Version: 1.0
Author: Alomgir Kabir
Author URI:  http://www.devscodebd.com/me


*******************************************************/


add_filter( 'the_content', function ($content){

   $id = get_the_id();
   if( !is_singular( 'post' )){

           return $content;

   }

   $terms = get_the_terms( $id, 'category' );

   $cats = array();

   foreach ($terms as $term) {
     $cats[] = $term->cat_ID;
   }


   $loop = new WP_Query(

      array(

           'posts_per_page' => 3,   // You can change the posts_per_page=3 to any like 4,5,6 etc.
           'category__in'   => $cats,
           'orderby'        => 'rand',
           'post__not_in'   => array($id)

        ));




   if ($loop->have_posts()) {
     
      $content .='

            <h3> Related Posts</h3>
             <hr />

            <ul class="dev-related-post">';


            while ( $loop->have_posts()) {

               $loop->the_post();

               $content .='

                    <li>
                      <a href="'. get_permalink() .'"> ' . get_the_title() .' </a>  

                     </li> ';
              
            }

            $content .= '</ul>';

            wp_reset_query();
   }

   return $content;
});

?>


