<?php $category_links = get_my_category_links();
get_header();

// 各セクションのデータを配列にまとめる（設定値の分離）
$journal_sections = [
    'code' => [
        'title'        => 'CODE',
        'desc'         => 'ゼロからの挑戦。創作の楽しさと、格闘の記録。',
        'show_excerpt' => true,
    ],
    'table' => [
        'title'        => 'TABLE',
        'desc'         => '節約派にこそ推したい、ヨシケイのミールキット。',
        'show_excerpt' => false,
    ],
    'buddy' => [
        'title'        => 'BUDDY',
        'desc'         => '愛犬がじゅまると過ごす日々の記録。',
        'show_excerpt' => false,
    ],
    'items' => [
        'title'        => 'ITEMS',
        'desc'         => '暮らしに彩りを。心から推せるものだけ。',
        'show_excerpt' => false,
    ],
]; ?>

<div id="journal" class="p-journal l-wrapper">
    <?php
    // 配列をループさせてセクションを自動生成する
    foreach ($journal_sections as $slug => $data) :
    ?>
        <section id="<?php echo esc_attr($slug); ?>" class="p-journal__container">
            <h2 class="p-journal__title"><?php echo esc_html($data['title']); ?></h2>
            <span class="c-title-desc"><?php echo esc_html($data['desc']); ?></span>

            <?php
            // 取得したい記事の条件（引数）を設定
            $args = array(
                'post_type'      => 'post',
                'category_name'  => $slug,
                'posts_per_page' => 3,
                'no_found_rows'  => true,
            );

            //  WP_Queryのインスタンスを作成（サブクエリの実行）
            $category_query = new WP_Query($args);

            // ループの開始
            if ($category_query->have_posts()) : ?>
                <div class="p-journal__items">
                    <?php while ($category_query->have_posts()) : $category_query->the_post();
                    ?>
                        <?php get_template_part('template-parts/components/card', 'journal', [
                            'show_excerpt' => $data['show_excerpt'],
                            'modifier' => 'p-journal-card--' . $slug
                        ]); ?>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>まだ記事がありません。</p>
            <?php endif;
            wp_reset_postdata();
            ?>

            <a class="p-journal__link" href="<?php echo esc_url($category_links[$slug]); ?>">VIEW MORE<i class="p-journal__link-icon fa-solid fa-angles-right"></i></a>
        </section>
    <?php endforeach; ?>
</div>

<section class="p-top-news l-wrapper">
    <h2 class="p-top-news__title">NEWS</h2>
    <div class="p-top-news__container">
        <?php
        // 取得したい記事の条件（引数）を設定
        $args = array(
            'post_type'      => 'news',
            'posts_per_page' => 5,
            'post_status' => 'publish',
            'no_found_rows'  => true,
        );

        // WP_Queryのインスタンスを作成（サブクエリの実行）
        $category_query = new WP_Query($args);

        // ループの開始
        if ($category_query->have_posts()) : ?>
            <ul class="p-top-news__items">
                <?php while ($category_query->have_posts()) : $category_query->the_post();
                ?>
                    <li class="p-top-news__item">
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <time class="p-top-news__time" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                            <?php echo esc_html(get_the_title()); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif;
        wp_reset_postdata();
        ?>
        <a class="p-journal__link" href="<?php echo esc_url(get_post_type_archive_link('news')); ?>">VIEW MORE<i class="p-journal__link-icon fa-solid fa-angles-right"></i></a>
    </div>
</section>

<?php get_footer(); ?>