<?php
//The main template file (最終フォールバック用)

get_header(); ?>

<div class="p-archive l-wrapper">
    <?php if (have_posts()): ?>
        <div class="p-archive__list">
            <?php while (have_posts()): the_post(); ?>
                <article class="p-archive__item">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <figure class="p-archive__inner">
                            <figcaption class="p-archive__content">
                                <h2 class="p-archive__title">
                                    <?php
                                    $title = get_the_title();
                                    echo esc_html(mb_strimwidth($title, 0, 43, '...', 'UTF-8'));
                                    ?>
                                </h2>
                                <p>
                                    <?php $excerpt = get_the_excerpt();
                                    echo esc_html(mb_strimwidth($excerpt, 0, 86, '......', 'UTF-8')); ?>
                                </p>
                                <p class="p-archive__time">更新日： <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                                </p>
                            </figcaption>

                            <?php get_template_part('template-parts/components/thumbnail', null, [
                                'class' => 'p-archive__thumbnail',
                                'show_noimage' => true
                            ]); ?>
                        </figure>
                    </a>
                </article>
            <?php endwhile; ?>
            <?php get_template_part('template-parts/navigation/pagination'); ?>
        </div>
    <?php else : ?>
        <p>記事が見つかりませんでした</p>
    <?php endif; ?>
</div>


<?php get_footer(); ?>