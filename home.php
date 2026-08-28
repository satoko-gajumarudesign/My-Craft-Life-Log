<?php get_header(); ?>

<div class="l-allpost-archive l-wrapper">

    <?php if (have_posts()): ?>
        <div class="p-allpost-archive">
            <?php while (have_posts()): ?>
                <?php the_post(); ?>
                <article class="p-allpost-archive__item c-archive-border">
                    <a class="p-allpost-archive__inner" href="<?php echo esc_url(get_permalink()); ?>">
                        <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                        <h2 class="p-allpost-archive__title">
                            <?php
                            $title = get_the_title();
                            echo esc_html(mb_strimwidth($title, 0, 43, '...', 'UTF-8'));
                            ?>
                        </h2>
                        <?php
                        // 現在の投稿タイプを取得
                        $post_type = get_post_type();

                        if ($post_type === 'news') :
                            // カスタム投稿タイプ「NEWS」の場合
                            echo '<span class="c-label c-label--news">NEWS</span>';

                        elseif ($post_type === 'post') :
                            // 標準投稿の場合（属するカテゴリーを取得して表示）
                            $categories = get_the_category();

                            if (! empty($categories)) {
                                echo '<span class="c-label c-label--category">' . esc_html($categories[0]->name) . '</span>';
                            }
                        endif; ?>
                    </a>
                </article>
            <?php endwhile; ?>
            <?php get_template_part('template-parts/navigation/pagination'); ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>