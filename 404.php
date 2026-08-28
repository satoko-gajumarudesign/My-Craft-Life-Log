<?php get_header(); ?>

<section class="l-404">
    <div class="p-404__container">
        <h1 class="p-404__title">Not Found</h1>
        <h2 class="p-404__subtitle">お探しのページが見つかりませんでした。</h2>

        <p class="p-404__text">
            申し訳ありません。<br>
            アクセスされたページは削除されたか、URLが変更された可能性があります。
        </p>

        <a href="<?php echo esc_url(home_url('/')); ?>" class="c-home-btn">
            トップページへ戻る
        </a>
    </div>
</section>

<?php get_footer(); ?>