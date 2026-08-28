<?php get_header(); ?>

<div class="l-single l-single--news l-wrapper">
    <div class="p-single">
        <?php
        if (have_posts()) : while (have_posts()) : the_post();
        ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('single__article'); ?>>
                    <h1 class="c-circle-title p-single__title"><?php echo esc_html(get_the_title()) ?></h1>
                    <p class="p-single__time">更新日： <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                    </p>

                    <div class="p-single__content">
                        <?php the_content(); ?>
                    </div>

                </article>

                <?php get_template_part('template-parts/navigation/post-nav'); ?>

        <?php endwhile;
        endif; ?>
    </div>

    <!-- サイドバー -->
    <?php
    get_template_part(
        'template-parts/components/sidebar',
        'posts',
        [
            'modifier'       => 'news',
            'title'          => 'Other News',
            'post_type'      => 'news',
            'post__not_in'   => array(get_the_ID()),
            'posts_per_page' => 10,
        ]
    );
    ?>
</div>


<?php get_footer(); ?>