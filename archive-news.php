<?php get_header(); ?>

<div class="p-archive-news l-wrapper">
    <?php if (have_posts()): ?>
        <div class="p-archive-news__list">
            <?php while (have_posts()): ?>
                <?php the_post(); ?>
                <article class="p-archive-news__item c-archive-border">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <div class="p-archive-news__inner">
                            <h2 class="p-archive-news__title">
                                <?php
                                $title = get_the_title();
                                echo esc_html(mb_strimwidth($title, 0, 43, '...', 'UTF-8'));
                                ?>
                            </h2>
                            <time class="p-archive-news__time" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                        </div>
                        <p>
                            <?php $excerpt = get_the_excerpt();
                            echo esc_html(wp_trim_words($excerpt, 40, '......')); ?>
                        </p>
                    </a>
                </article>
            <?php endwhile; ?>
            <?php get_template_part('template-parts/navigation/pagination'); ?>

        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>