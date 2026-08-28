<?php get_header(); ?>

<div class="l-single l-wrapper">
    <div class="p-single">

        <div class="c-breadcrumb-wrapper">
            <?php get_template_part('template-parts/navigation/breadcrumb'); ?>
        </div>

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('single__article'); ?>>
                    <div class="p-single__title-wrapper">
                        <h1 class="c-circle-title p-single__title">
                            <?php echo esc_html(get_the_title()) ?>
                        </h1>
                        <?php if (has_category("table")): ?>
                            <span class="c-ad-badge">PR</span>
                        <?php endif; ?>
                    </div>
                    <p class="p-single__time">更新日： <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                    </p>
                    <div class="p-single__content">
                        <?php the_content(); ?>
                    </div>
                </article>

                <?php if (has_category("table")): ?>
                    <article class="p-single__ad">
                        <div class="p-single__ad-text">
                            <a href="https://px.a8.net/svt/ejp?a8mat=4B9XTC+DWPKJ6+1QM6+HYFLU" rel="nofollow noopener" target="_blank">【簡単バランスごはん】栄養士の献立で簡単レシピのヨシケイ♪<BR>初回キャンペーン中！</a>
                            <img border="0" width="1" height="1" src="https://www14.a8.net/0.gif?a8mat=4B9XTC+DWPKJ6+1QM6+HYFLU" alt="">
                        </div>
                        <div class="p-single__ad-banner">
                            <a href="https://px.a8.net/svt/ejp?a8mat=4B9XTC+DWPKJ6+1QM6+I17WX" rel="nofollow noopener" target="_blank">
                                <img border="0" width="300" height="250" alt="" src="https://www22.a8.net/svt/bgt?aid=260804208841&wid=001&eno=01&mid=s00000008115003029000&mc=1"></a>
                            <img border="0" width="1" height="1" src="https://www12.a8.net/0.gif?a8mat=4B9XTC+DWPKJ6+1QM6+I17WX" alt="">
                        </div>
                    </article>
                <?php endif; ?>

                <?php get_template_part('template-parts/navigation/post-nav'); ?>

        <?php endwhile;
        endif; ?>
    </div>

    <?php
    // 現在の投稿のカテゴリIDを取得
    $categories = get_the_category();
    $category_ids = array();
    if (! empty($categories)) {
        foreach ($categories as $category) {
            $category_ids[] = $category->term_id;
        }
    }

    get_template_part('template-parts/components/sidebar', 'posts', array(
        'modifier'       => 'post',
        'title'          => 'Other Posts',
        'post_type'      => 'post',
        'category__in'   => $category_ids,
        'post__not_in'   => array(get_the_ID()),
        'posts_per_page' => 5,
    ));
    ?>

</div>


<?php get_footer(); ?>