<?php

/**
 * テンプレートパーツ: サムネイル画像
 * * 使用例: get_template_part('template-parts/thumbnail', null, ['class' => 'p-card__thumbnail', 'show_noimage' => false]);
 *
 * @param array $args {
 * @type string $class         追加するCSSクラス
 * @type bool   $show_noimage  画像がない場合にNo Image画像を表示するか (デフォルト: true)
 * }
 */

$extra_class = $args['class'] ?? '';
$show_noimage = $args['show_noimage'] ?? true;
$post_id      = $args['post_id'] ?? get_the_ID();
$image_html   = '';

// アイキャッチ画像が設定されている場合
if (has_post_thumbnail($post_id)) {
    $thumb_id = get_post_thumbnail_id($post_id);
    $alt_text = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
    $alt_text = $alt_text ?: get_the_title($post_id);

    // BEMに基づくクラス名 c-thumbnail__img を付与
    $image_html = get_the_post_thumbnail($post_id, 'medium', [
        'class' => 'c-thumbnail__img',
        'alt'   => esc_attr($alt_text)
    ]);
} else {
    // アイキャッチがなく、投稿本文内に画像がある場合
    $fallback_img = get_first_image_in_post($post_id);

    if ($fallback_img) {
        $image_html = sprintf(
            '<img class="c-thumbnail__img" src="%s" alt="%s">',
            esc_url($fallback_img),
            esc_attr(get_the_title($post_id))
        );
    } else {
        if ($show_noimage) {
            // No Image画像を表示する
            $noimage_png_url = get_theme_file_uri('/assets/img/no-image.png');
            $noimage_webp_url = get_theme_file_uri('/assets/img/no-image.webp');

            $image_html = sprintf(
                '<picture>
            <source srcset="%s" type="image/webp">
            <img class="c-thumbnail__img" src="%s" alt="">
            </picture>',
            esc_url($noimage_webp_url),
            esc_url($noimage_png_url)
            );
        }
    }
}
if (!empty($image_html)):
?>
    <div class="c-thumbnail <?php echo esc_attr($extra_class); ?>">
        <?php echo $image_html; ?>
    </div>
<?php endif; ?>