/**
 * エディターのツールバー機能を制限するJS
 */
wp.domReady(function () {
    // ツールバーから不要な文字装飾機能を削除します
    wp.richText.unregisterFormatType('core/bold');          // 太字
    wp.richText.unregisterFormatType('core/italic');        // 斜体
    wp.richText.unregisterFormatType('core/strikethrough'); // 打ち消し線
    wp.richText.unregisterFormatType('core/keyboard');      // キーボード入力
    wp.richText.unregisterFormatType('core/code');          // インラインコード
    wp.richText.unregisterFormatType('core/superscript');   // 上付き文字
    wp.richText.unregisterFormatType('core/subscript');     // 下付き文字
});