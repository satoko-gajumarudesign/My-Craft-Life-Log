<?php

/**
 * Template Name: thanks
 * Description: 送信完了ページを表示するページテンプレート
 */
get_header(); ?>

<div class="l-thanks l-wrapper">
    <div class="p-thanks">
        <p class="p-thanks__text">
            お問い合わせありがとうございます。<br>
            メッセージの送信が完了いたしました。
        </p>
        <p class="p-thanks__note">
            内容を確認の上、数日以内に担当者よりご連絡させていただきます。<br>
            自動返信メールを送信しておりますので、ご確認ください。<br>
            尚、内容によっては返信を控えさせていただく場合がございますので、予めご了承ください。
        </p>

        <div class="p-thanks__button">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="c-home-btn">
                トップページへ戻る
            </a>
        </div>
    </div>
</div>

    <?php get_footer(); ?>