<?php $category_links = get_my_category_links(); ?>

</main>

<footer class="l-footer">
    <div class="p-footer l-wrapper">
        <div class="p-footer__section">
            <h2 class="p-footer__title">Categories</h2>
            <?php
            wp_nav_menu(array(
                'theme_location'  => 'footer-cat',
                'container'       => false,
                'menu_class'      => 'p-footer__list',  // ulに付与するクラス
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>', // IDを消してスッキリさせる
            ));
            ?>
        </div>

        <div class="p-footer__section">
            <h2 class="p-footer__title">About Me</h2>
            <?php
            wp_nav_menu(array(
                'theme_location'  => 'footer-about',
                'container'       => false,
                'menu_class'      => 'p-footer__list',  // ulに付与するクラス
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>', // IDを消してスッキリさせる
            ));
            ?>
        </div>

        <div class="p-footer__section p-footer__section--social">
            <h2 class="p-footer__title">Follow Me</h2>
            <div class="p-footer__social">

                <?php
                $x_url = get_theme_mod('mytheme_x_url');
                $instagram_url = get_theme_mod('mytheme_instagram_url');
                $coconala_url = get_theme_mod('mytheme_coconala_url');
                ?>

                <?php if ($x_url): ?>
                    <a href="<?php echo esc_url($x_url); ?>" target="_blank" rel="noopener" aria-hidden="true">X
                        <i class="p-footer__social-icon fa-brands fa-x-twitter"></i>
                    </a>
                <?php endif; ?>

                <?php if ($instagram_url): ?>
                    <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener" aria-hidden="true">Instagram
                        <i class="p-footer__social-icon fa-brands fa-instagram"></i>
                    </a>
                <?php endif; ?>

                <?php if ($coconala_url): ?>
                    <a href="<?php echo esc_url($coconala_url); ?>" target="_blank" rel="noopener" aria-hidden="true">
                        ココナラ</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="p-footer__policy">
        <a class="p-footer__link" href="<?php echo esc_url(home_url('/privacy-policy/'))  ?>">Privacy policy</a>
    </div>

    <p class="p-footer__copy">@ 2026 SATOKO. All Rights Reserved.</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>


<?php wp_footer(); ?>
</body>

</html>