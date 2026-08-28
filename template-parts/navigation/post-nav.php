<?php

/**
 * 記事詳細ページ用 前後記事ナビゲーション
 *
 * 記事の下部に表示する、前の記事・次の記事へのリンク部品です。
 * 現在表示している投稿タイプ（post や news）を自動で判定し、
 * 通常のブログ記事（post）の場合は同じカテゴリー内の前後記事を取得します。
 */
?>
<nav class="c-post-nav" aria-label="記事のナビゲーション">
    <?php
    $post_type = get_post_type();
    $in_same_term = false;

    if ($post_type === 'post') {
        $in_same_term = true;
    } elseif ($post_type === 'news') {
        $in_same_term = false;
    }
    // 前後記事のデータを配列に定義
    $nav_items = [
        'prev' => [
            'post'     => get_previous_post($in_same_term),
            'label'    => '前の記事へ',
            'modifier' => 'prev', // BEMのモディファイア用
            'svg_path' => 'M15 18l-6-6 6-6', // 左向き矢印
        ],
        'next' => [
            'post'     => get_next_post($in_same_term),
            'label'    => '次の記事へ',
            'modifier' => 'next',
            'svg_path' => 'M9 18l6-6-6-6', // 右向き矢印
        ]
    ];

    // ② foreachでループ処理
    foreach ($nav_items as $item) :
        $nav_post = $item['post'];

        // 記事が存在しない場合はスキップ（次のループへ）
        if (empty($nav_post)) {
            continue;
        }

        // 共通データの取得
        $nav_url   = get_permalink($nav_post->ID);
        $nav_time  = get_the_date('Y-m-d', $nav_post->ID);
        $nav_date  = get_the_date('', $nav_post->ID);
        $nav_title = $nav_post->post_title;
    ?>
        <!-- BEM規則に従ったHTML出力 -->
        <a class="c-post-nav__item c-post-nav__item--<?php echo esc_attr($item['modifier']); ?>" href="<?php echo esc_url($nav_url); ?>">
            <div class="c-post-nav__content">
                <span class="c-post-nav__label">
                    <!-- modifierによって左右でSVGのアイコンを変更 -->
                    <svg class="c-post-nav__icon c-post-nav__icon--<?php echo esc_attr($item['modifier']); ?>" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                        <path d="<?php echo esc_attr($item['svg_path']); ?>" />
                    </svg>
                    <?php echo esc_html($item['label']); ?>
                </span>

                <div class="c-post-nav__reference">
                    <figure class="c-post-nav__thumb">
                        <?php get_template_part('template-parts/components/thumbnail', null, [
                            'class'        => 'c-post-nav__img', // FLOCSSの配置用クラスを渡す
                            'show_noimage' => true,
                            'post_id'      => $nav_post->ID        // いまループしている記事のIDを渡す！
                        ]); ?>
                    </figure>
                    <div class="c-post-nav__meta">
                        <span class="c-post-nav__title"><?php echo esc_html($nav_title); ?></span>
                        <time class="c-post-nav__date" datetime="<?php echo esc_attr($nav_time); ?>">(<?php echo esc_html($nav_date); ?>)</time>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</nav>