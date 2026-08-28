<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php $category_links = get_my_category_links(); ?>

    <?php wp_body_open(); ?>
    <header class="l-header">
        <div class="p-header l-wrapper">
            <div class="p-header__title">
                <a class="p-header__link" href="<?php echo esc_url(home_url('/')); ?>">
                    <img class="p-header__img" src="<?php echo get_theme_file_uri('/assets/img/logo.svg') ?>" alt="">
                </a>
            </div>
            <?php
            wp_nav_menu(array(
                'theme_location'  => 'global-navigation',
                'container'       => 'nav',                 // <nav>タグで囲む
                'container_class' => 'p-header__nav--pc',   // navに付与するクラス
                'menu_class'      => 'p-header__list--pc',  // ulに付与するクラス
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>', // IDを消してスッキリさせる
            ));
            ?>
        </div>

        <button class="c-menu-toggle" aria-label="メニューを開く" aria-expanded="false" aria-controls="drawer">
            <span class="c-menu-toggle__bar"></span>
            <span class="c-menu-toggle__bar"></span>
            <span class="c-menu-toggle__bar"></span>
        </button>

        <div class="p-header__drawer" id="drawer">
            <?php
            wp_nav_menu(array(
                'theme_location'  => 'global-navigation',
                'container'       => 'nav',                 // <nav>タグで囲む
                'container_class' => 'p-header__nav--sp',   // navに付与するクラス
                'menu_class'      => 'p-header__list--sp',  // ulに付与するクラス
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>', // IDを消してスッキリさせる
            ));
            ?>
        </div>
    </header>

    <main class="l-main">
        <?php get_template_part('template-parts/components/hero', 'main'); ?>