<?php

/**
 * パンくずリストのテンプレートパーツ
 */

// 記事ページ（シングルページ）以外なら何も表示せずに終了
if (! is_single()) {
    return;
}
?>

<nav class="c-breadcrumb" aria-label="breadcrumb">
    <ol class="c-breadcrumb__list">

        <li class="c-breadcrumb__item">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="c-breadcrumb__link">HOME</a>
        </li>

        <?php
        // 現在の投稿タイプを取得
        $post_type = get_post_type();
        // カスタム投稿タイプの場合（NEWSなど）
        if ($post_type !== 'post'):
            $post_type_object = get_post_type_object($post_type);
            if ($post_type_object && $post_type_object->has_archive): ?>
                <li class="c-breadcrumb__item">
                    <a href="<?php echo esc_url(get_post_type_archive_link($post_type)); ?>" class="c-breadcrumb__link"><?php echo esc_html($post_type_object->label); ?>
                    </a>
                </li>
        <?php
            endif;
        endif;
        ?>

        <?php if ($post_type === 'post') :
            //現在の記事のカテゴリーへのリンク
            $categories = get_the_category();
            if ($categories) :
                $cat = $categories[0]; ?>
                <li class="c-breadcrumb__item">
                    <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="c-breadcrumb__link"><?php echo esc_html($cat->name); ?></a>
                </li>
                <?php endif;
        else :
            $taxonomies = get_object_taxonomies($post_type);
            if (!empty($taxonomies)):
                // カスタム投稿タイプにカテゴリーがあればアーカイブのリンクを表示
                $terms = get_the_terms(get_the_ID(), $taxonomies[0]);
                if ($terms && !is_wp_error($terms)) :
                    $term = $terms[0]; ?>
                    <li class="c-breadcrumb__item">
                        <a href="<?php echo esc_url(get_term_link($term)); ?>" class="c-breadcrumb__link"><?php echo esc_html($term->name) ?></a>
                    </li>
        <?php
                endif;
            endif;
        endif;
        ?>

        <li class="c-breadcrumb__item" aria-current="page">
            <?php echo esc_html(get_the_title()); ?>
        </li>
    </ol>
</nav>