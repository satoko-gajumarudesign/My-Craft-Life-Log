<?php
//  Journal用 カードコンポーネント

//   記事のカード型レイアウトを表示するためのテンプレート部品です。
//   get_template_part() の第3引数（$args）から設定を受け取り、表示を動的に切り替えます。

//   @var array $args
//     - show_excerpt (bool)   : 記事の抜粋（抜粋文）を表示するかどうか。（true: 表示, false: 非表示）
//     - modifier     (string) : BEM規則に基づくCSSのモディファイアクラス名。（例: 'p-journal-card--code' など）

// 渡された引数を受け取る。セットされていない場合は false をデフォルトにする
$show_excerpt = $args['show_excerpt'] ?? false;
$modifier = $args['modifier'] ?? '';
?>
<article class="p-journal-card <?php echo esc_attr($modifier); ?>">
    <a href="<?php echo esc_url(get_permalink()); ?>" class="p-journal-card__link">
        <figure class="p-journal-card__figure">
            <?php get_template_part('template-parts/components/thumbnail',null, [
                'class' => 'p-journal-card__thumbnail',
                'show_noimage' => true
            ]); ?>
            <figcaption class="p-journal-card__content">
                <h3 class="p-journal-card__title">
                    <?php
                    $title = get_the_title();
                    echo esc_html(mb_strimwidth($title, 0, 43, '...', 'UTF-8'));
                    ?>
                </h3>

                <!-- 引数が true で、かつ抜粋が存在する場合のみ表示 -->
                <?php if ($show_excerpt) : ?>
                    <p class="p-journal-card__excerpt">
                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 30, '......')); ?>
                    </p>
                <?php endif; ?>

                <time class="p-journal-card__date" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
                    <?php echo esc_html(get_the_date()); ?>
                </time>
            </figcaption>
        </figure>
    </a>
</article>