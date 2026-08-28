<?php if (is_front_page()): ?>
    <div id="hero" class="p-hero">
        <figure class="p-hero__container">
            <picture>
                <source srcset="<?php echo get_theme_file_uri('/assets/img/hero1.webp'); ?>" type="image/webp">

                <img src="<?php echo get_theme_file_uri('/assets/img/hero1.jpeg'); ?>" alt="<?php echo esc_attr(get_bloginfo('name') . ' - 愛犬の写真'); ?>" class="p-hero__image">
            </picture>

            <figcaption class="p-hero__content">
                <h1 class="p-hero__title">つくる、くらす、みつける<span>My Craft & Life Log</span></h1>
            </figcaption>
        </figure>
    </div>

<?php elseif (is_post_type_archive('news')): ?>
    <div class="l-hero l-hero--spaced">
        <div class="c-marker-title">
            <h1 class="c-marker-title__text">NEWS</h1>
        </div>
    </div>

<?php elseif (is_singular('news')): ?>
    <div class="l-hero">
        <div class="c-breadcrumb-wrapper c-breadcrumb-wrapper--news">
            <?php get_template_part('template-parts/navigation/breadcrumb'); ?>
        </div>
        <div class="c-marker-title">
            <p class="c-marker-title__text c-marker-title__text--sm u-mb-8">NEWS</p>
        </div>
    </div>

<?php elseif (is_home()): ?>
    <div class="l-hero l-hero--spaced">
        <div class="c-marker-title">
            <h1 class="c-marker-title__text">Archive</h1>
        </div>
    </div>
<?php elseif (is_category() || is_single()):
    // 現在のカテゴリIDと名前を取得する準備
    $cat_id = 0;
    $cat_name = '';

    if (is_category()) {
        // カテゴリページを見ている場合
        $current_cat = get_queried_object();
        $cat_id = $current_cat->term_id;
        $cat_name = $current_cat->name;
    } elseif (is_single()) {
        // 個別記事（シングルページ）を見ている場合
        $categories = get_the_category();
        if (! empty($categories)) {
            $cat_id = $categories[0]->term_id; // 記事が属する最初のカテゴリIDを取得
            $cat_name = $categories[0]->name;
        }
    }

    // ACFから画像データを取得する
    // カテゴリの情報を取得する場合、第2引数に 'category_' . カテゴリID を指定します
    $hero_image = get_field('category_hero_img', 'category_' . $cat_id);
?>

    <div class="p-hero-cat">
        <?php if ($hero_image) : ?>
            <img class="p-hero-cat__img" src="<?php echo esc_url($hero_image['url']); ?>"
                alt="<?php echo esc_attr($hero_image['alt'] ? $hero_image['alt'] : $cat_name . 'のイメージ画像'); ?>">
        <?php else : ?>
            <img class="p-hero-cat__img" src="<?php echo esc_url(get_theme_file_uri('/assets/img/default-hero.jpg')); ?>" alt="雑誌風のデフォルトカバー画像">
        <?php endif; ?>

        <div class="p-hero-cat__mask">
            <?php if (is_category()) : ?>
                <h1 class="p-hero-cat__title"><?php echo esc_html($cat_name); ?></h1>
            <?php elseif (is_single()): ?>
                <p class="p-hero-cat__title"><?php echo esc_html($cat_name); ?></p>
            <?php endif; ?>
        </div>
    </div>

<?php elseif (is_page('thanks')): ?>
    <h1 class="p-thanks-title"><?php echo esc_html(get_the_title()) ?></h1>

<?php else: ?>
    <div class="l-hero--spaced">
        <div class="c-marker-title">
            <h1 class="c-marker-title__text"><?php echo esc_html(get_the_title()) ?></h1>
        </div>
    </div>
<?php endif; ?>