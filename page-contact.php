<?php

/**
 * Template Name: お問い合わせ
 * Description: お問い合わせフォームを表示するページテンプレート
 */
get_header(); ?>

<div class="l-contact l-wrapper">
    <div class="p-contact">
        <p class="p-contact__guide">サイトに関するご質問や、お仕事のご相談はこちらからお願いいたします。</p>

        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif;
        ?>

        <p class="p-contact-attention">※送信前に、当サイトのプライバシーポリシーをご一読いただき、同意の上で送信をお願いいたします。</p>

    </div>
</div>

<?php get_footer(); ?>