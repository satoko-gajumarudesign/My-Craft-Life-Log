<?php
/**
 * ページネーションのテンプレートパーツ
 * 呼び出し元: home.php, archive.php, category.php など
 */

// ページネーションのデータを配列で取得
$pagination = paginate_links( array(
    'mid_size'  => 2,
    'prev_text' => '<span class="screen-reader-text">前のページへ</span><span class="c-pagination__arrow c-pagination__arrow--prev">&lt;</span>',
    'next_text' => '<span class="screen-reader-text">次のページへ</span><span class="c-pagination__arrow c-pagination__arrow--next">&gt;</span>',
    'type'      => 'array',
) );

// ページネーションが存在する場合のみ出力
if ( $pagination ) :
?>
<nav class="c-pagination" aria-label="ページ送り">
    <ul class="c-pagination__list">
        <?php foreach ( $pagination as $page_link ) : ?>
            <li class="c-pagination__item">
                <?php 
                // セキュリティ: 許可されたHTMLタグ（a, spanなど）のみを出力するエスケープ処理
                echo wp_kses_post( $page_link ); 
                ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<?php endif; ?>