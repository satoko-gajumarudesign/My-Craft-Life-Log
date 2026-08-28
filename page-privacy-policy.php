<?php

/**
 * Template Name: プライバシーポリシー
 * Description: プライバシーポリシーを表示するページテンプレート
 */
get_header(); ?>

<div class="l-privacy-policy l-wrapper">
    <div class="p-privacy-policy">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>