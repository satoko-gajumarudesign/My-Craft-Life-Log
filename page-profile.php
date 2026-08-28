<?php 
/**
 * Template Name: profile
 * Description: プロフィールを表示するページテンプレート
 */
get_header(); ?>

<div class="p-profile l-wrapper">
    
<?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif;
        ?>
</div>

<?php get_footer(); ?>

