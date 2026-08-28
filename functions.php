<?php
// ==========================================
// テーマセットアップ
// ==========================================
function my_theme_setup()
{
    //<title>タグの出力
    add_theme_support('title-tag');

    // アイキャッチ画像を有効化
    add_theme_support('post-thumbnails');

    //カスタムメニューの登録
    register_nav_menus(array(
        'global-navigation' => 'グローバルナビゲーション',
        'footer-cat' => 'フッター：カテゴリーリンク',
        'footer-about' => 'フッター：アバウトミーリンク',
    ));
}
add_action('after_setup_theme', 'my_theme_setup');

// ==========================================
// フロント側のCSSとJSを読み込む
// ==========================================
add_action('wp_enqueue_scripts', 'my_custom_styles');
function my_custom_styles()
{
    wp_enqueue_style(
        'my-main-style',
        get_theme_file_uri('/style.css'),
        array(),
        filemtime(get_theme_file_path('/style.css')) // キャッシュ対策（更新したら即反映）
    );

    // main.js を読み込む
    wp_enqueue_script(
        'my-main-script', // ハンドル名
        get_theme_file_uri('/assets/js/main.js'),
        array(),
        filemtime(get_theme_file_path('/assets/js/main.js')), // キャッシュ対策
        array(
            'strategy'  => 'defer',
            'in_footer' => true,    // </body>の直前で読み込む設定
        )
    );
}

// ==========================================
// ブロックエディター用のカスタムJSを読み込む
// ==========================================
add_action('enqueue_block_editor_assets', 'load_custom_editor_scripts');
function load_custom_editor_scripts()
{
    wp_enqueue_script(
        'custom-editor-js', // スクリプトの識別名
        get_template_directory_uri() . '/editor-custom.js', // JSファイルのパス
        array('wp-rich-text', 'wp-element', 'wp-dom-ready'), // 依存関係（これらが読み込まれた後に実行）
        filemtime(get_template_directory() . '/editor-custom.js'), // キャッシュ対策
        true // フッターで読み込む（高速化の基本です）
    );
}

// ==========================================
// 全カテゴリーのURLストックを作成して返すオリジナル関数
// ==========================================
function get_my_category_links()
{
    $target_slugs = array('code', 'table', 'buddy', 'items');
    $category_links = array();

    foreach ($target_slugs as $slug) {
        $category_data = get_category_by_slug($slug);
        if ($category_data) {
            $category_links[$slug] = get_category_link($category_data->term_id);
        }
    }

    return $category_links;
}

// ==========================================
//  投稿保存時にスラッグを「ターム名-ID」に自動更新する
// ==========================================
add_action('save_post', 'my_update_custom_slug', 20, 2);

function my_update_custom_slug($post_id, $post)
{
    // 自動保存中やリビジョンの場合は除外
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;

    // 対象とする投稿タイプを指定（例：通常の投稿 'post' と カスタム投稿 'news'）
    $allowed_post_types = array('post', 'news');
    if (!in_array($post->post_type, $allowed_post_types)) {
        return;
    }

    // カスタムフィールド（ACF等）からターム情報を取得
    $term_data = get_field('post-category', $post_id);

    $cat_slug = '';
    if ($term_data) {
        $term = is_array($term_data) ? $term_data[0] : $term_data;
        if (is_object($term) && isset($term->slug)) {
            $cat_slug = $term->slug;
        }
    }

    // タームが取れなかった場合のフォールバック（投稿タイプ名をプレフィックスに）
    if (empty($cat_slug)) {
        $cat_slug = $post->post_type;
    }

    // 新しいスラッグの生成
    $new_slug = $cat_slug . '-' . $post_id;

    // 無限ループを防ぎつつ更新
    if ($post->post_name !== $new_slug) {
        remove_action('save_post', 'my_update_custom_slug', 20);
        wp_update_post(array(
            'ID'        => $post_id,
            'post_name' => $new_slug,
        ));
        add_action('save_post', 'my_update_custom_slug', 20, 2);
    }
}

// ==========================================
// テーマカスタマイザーにSNSリンク設定を追加
// ==========================================
function mytheme_customize_register($wp_customize)
{

    // カスタマイズにセクションの追加
    $wp_customize->add_section('mytheme_sns_section', array(
        'title'       => 'SNS・外部リンク設定',
        'priority'    => 130, // 表示位置
        'description' => 'フッターに表示するSNSやココナラのURLを入力してください。未入力の場合はアイコンが非表示になります。',
    ));

    // --- X (Twitter) の設定 ---
    $wp_customize->add_setting('mytheme_x_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('mytheme_x_url', array(
        'label'       => 'X (Twitter) URL',
        'section'     => 'mytheme_sns_section',
        'type'        => 'url',
    ));

    // --- Instagram の設定 ---
    $wp_customize->add_setting('mytheme_instagram_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('mytheme_instagram_url', array(
        'label'       => 'Instagram URL',
        'section'     => 'mytheme_sns_section',
        'type'        => 'url',
    ));

    // --- ココナラ の設定 ---
    $wp_customize->add_setting('mytheme_coconala_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('mytheme_coconala_url', array(
        'label'       => 'ココナラ マイページURL',
        'section'     => 'mytheme_sns_section',
        'type'        => 'url',
    ));
}
add_action('customize_register', 'mytheme_customize_register');

// ==========================================
// 投稿画面で使えるブロックを制限する
// ==========================================
add_filter('allowed_block_types_all', 'custom_allowed_block_types', 10, 2);
function custom_allowed_block_types($allowed_blocks, $editor_context)
{
    // 制限をかけたい投稿タイプのスラッグを配列（リスト）にまとめる
    $target_post_types = array('post', 'news');

    // 現在の投稿タイプが、上のリストに含まれているかチェック
    if (in_array($editor_context->post->post_type, $target_post_types, true)) {
        return array(
            'core/paragraph', // 本文（段落）
            'core/image',     // 画像
            'core/heading',   // サブタイトル用（見出し）
            'core/list',      // リスト全体（ul/ol）
            'core/list-item', // リスト項目（li）
            'core/quote',     // 引用ブロック（blockquote / cite）を追加
            'core/html',      // カスタムHTML
            'loos-hcb/code-block', //Highlighting Code Block
        );
    }
    // それ以外の投稿タイプ（固定ページなど）はすべてのブロックを許可
    return $allowed_blocks;
}

// ==========================================
// 不要な設定パネル（右サイドバー）を非表示にする
// ==========================================
add_action('init', 'remove_unnecessary_editor_panels');
function remove_unnecessary_editor_panels()
{
    // 「タグ」を非表示（カテゴリだけ残す）
    unregister_taxonomy_for_object_type('post_tag', 'post');

    // その他不要なパネルを非表示
    remove_post_type_support('post', 'comments');      // ディスカッション
    remove_post_type_support('post', 'trackbacks');    // トラックバック
    remove_post_type_support('post', 'author');        // 作成者

}

// ==========================================
// 記事内の画像にaltがない、または空の場合に投稿タイトルを自動挿入する
// ==========================================
add_filter('the_content', 'auto_insert_alt_to_images');

function auto_insert_alt_to_images($content)
{
    // 現在の投稿のタイトルを取得
    $post_title = get_the_title();

    // 投稿内容からimgタグを探して処理をする
    $content = preg_replace_callback('/<img[^>]+>/i', function ($match) use ($post_title) {
        $img_tag = $match[0];

        // alt属性が空（alt=""）、またはalt属性自体が存在しないかをチェック
        if (preg_match('/alt=["\']\s*["\']/i', $img_tag) || !preg_match('/alt=/i', $img_tag)) {

            // 古い空のaltを削除
            $img_tag = preg_replace('/\s*alt=["\']\s*["\']/i', '', $img_tag);

            // 新しく投稿タイトルをaltとして付与
            $img_tag = str_replace('<img', '<img alt="' . esc_attr($post_title) . '"', $img_tag);
        }
        return $img_tag;
    }, $content);

    return $content;
}

// ==========================================
//記事本文の末尾にサンクスメッセージを自動追加する
// ==========================================
// @param string $content 記事の本文.
function mytheme_add_thank_you_message($content)
{
    // 管理画面、またはメインクエリ（主たるループ）以外では処理をスキップ
    if (is_admin() || ! is_main_query()) {
        return $content;
    }
    if (is_singular('post')) {
        $message = '<p class="p-thank-text">ここまで読んでくださり、ありがとうございます。</p>';

        $content .= wp_kses_post($message);
    }
    return $content;
}
add_filter('the_content', 'mytheme_add_thank_you_message');

// ==========================================
//  見出しブロックからH1の選択肢を除外する
// ==========================================
add_filter('register_block_type_args', 'disable_h1_in_heading_block', 10, 2);

function disable_h1_in_heading_block($args, $block_type)
{
    // 処理対象が見出しブロック（core/heading）以外なら何もせず終了
    if ('core/heading' !== $block_type) {
        return $args;
    }

    // ドロップダウンの選択肢をH2のみに上書き設定する
    $args['attributes']['levelOptions']['default'] = [2];

    return $args;
}

// ==========================================
// 記事本文から最初の画像URLを取得する関数
// ==========================================
//投稿本文内の最初の画像URLを取得する
function get_first_image_in_post($post_id = null)
{
    // 引数があればその投稿、なければ現在の投稿オブジェクトを安全に取得
    $target_post = get_post($post_id);

    // 投稿が存在しない、またはコンテンツが空の場合は早期リターン
    if (empty($target_post) || empty($target_post->post_content)) {
        return '';
    }

    $first_img = '';

    // 記事のコンテンツからimgタグのsrc属性を検索
    if (preg_match_all('/<img\s+[^>]*src=[\'"]([^\'"]+)[\'"]/i', $target_post->post_content, $matches)) {
        $first_img = $matches[1][0];
    }

    // 安全のために esc_url_raw を通して返す
    return esc_url_raw($first_img);
}

// ==========================================
// メインクエリのカスタマイズ（表示件数や投稿タイプの制御）
// ==========================================
function my_custom_pre_get_posts($query)
{
    // 管理画面のページ、またはメインクエリでない場合は処理をしない
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    // home.php（投稿一覧ページ）の設定
    if ($query->is_home()) {
        // 'post' と 'news' の両方を取得
        $query->set('post_type', array('post', 'news'));
        // 表示件数を15件に設定
        $query->set('posts_per_page', 15);

        $query->set('ignore_sticky_posts', 1);
    }

    // カテゴリーのアーカイブページの設定
    if ($query->is_category()) {
        // 表示件数を8件に設定
        $query->set('posts_per_page', 8);
    }

    // 「NEWS」のアーカイブページの設定
    if ($query->is_post_type_archive('news')) {
        // 表示件数を15件に設定
        $query->set('posts_per_page', 15);
    }
}
add_action('pre_get_posts', 'my_custom_pre_get_posts');

/* ========================================================
Contact Form 7 カスタマイズ
========================================================= */
// 自動整形(wpautop)を無効化
add_filter('wpcf7_autop_or_not', '__return_false');

//デフォルトCSSを無効化
add_filter('wpcf7_load_css', '__return_false');

/* ========================================================
 * Google Analytics (GA4) トラッキングコードの出力
========================================================= */
function add_google_analytics()
{
    // 管理画面にログインしている間は計測しない（自分のアクセスを除外して純粋な読者データのみを収集）
    if (! is_user_logged_in()) :
?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-RPEH2DFL2H"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-RPEH2DFL2H');
        </script>
<?php
    endif;
}
add_action('wp_head', 'add_google_analytics');
