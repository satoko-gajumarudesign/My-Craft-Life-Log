<?php
// サイドバー用 関連記事リストコンポーネント

//  @var array $args 
//    - modifier : BEMのモディファイア用文字列 (例: 'news', 'code' など)
//    - title    : セクションのタイトル
//    - その他 WP_Query のパラメータ
// コンポーネント用の引数を受け取り、デフォルト値を設定

$modifier = $args['modifier'] ?? 'default';
$title    = $args['title'] ?? 'Other Posts';

// WP_Query用のパラメータだけを抽出（独自引数を除外）
$query_args = $args;
unset($query_args['modifier'], $query_args['title']);

$component_query = new WP_Query($query_args);

if ($component_query->have_posts()) : ?>

    <section class="p-sidebar-posts p-sidebar-posts--<?php echo esc_attr($modifier); ?>">
        <h2 class="p-sidebar-posts__title"><?php echo esc_html($title); ?></h2>
        <div class="p-sidebar-posts__items">

            <?php while ($component_query->have_posts()) : $component_query->the_post(); ?>
                <?php
                // 画像が存在するかどうかの判定
                $has_image = has_post_thumbnail() || !empty(get_first_image_in_post());

                // 画像の有無に合わせて、出力するHTMLタグを切り替える準備
                $wrapper_tag = $has_image ? 'figure' : 'div';
                $body_tag    = $has_image ? 'figcaption' : 'div';
                ?>

                <article class="p-sidebar-posts__item">
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="p-sidebar-posts__link">

                        <<?php echo $wrapper_tag; ?> class="p-sidebar-posts__figure">
                            <?php if ($has_image): ?>
                                <?php get_template_part('template-parts/components/thumbnail', null, [
                                    'class' => 'p-sidebar-posts__thumbnail',
                                    'show_noimage' => false
                                ]); ?>
                            <?php endif; ?>
                            <<?php echo $body_tag; ?> class="p-sidebar-posts__body">
                                <h3 class="p-sidebar-posts__post-title--<?php echo esc_attr($modifier); ?>">
                                    <?php
                                    $title = get_the_title();
                                    echo esc_html(mb_strimwidth($title, 0, 43, '...', 'UTF-8'));
                                    ?>
                                </h3>
                                <time class="p-sidebar-posts__time p-sidebar-posts__time" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                            </<?php echo $body_tag; ?>>
                        </<?php echo $wrapper_tag; ?>>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <div class="p-sidebar-posts__empty">
        <p class="p-sidebar-posts__empty-text">
            --他の記事が更新されるとここに表示されます--
        </p>
    </div>
<?php endif; ?>