<div id="opening-screen" class="opening__screen">
    <div class="opening__container">
        <img src="<?php echo get_theme_file_uri('/assets/img/run_dog-frame1.svg'); ?>" alt="走る犬 フレーム1" class="opening__frame opening__frame--1">
        <img src="<?php echo get_theme_file_uri('/assets/img/run_dog-frame2.svg'); ?>" alt="走る犬 フレーム2" class="opening__frame opening__frame--2">
    </div>

    <p class="opening__title">My Craft & Life Log</p>
</div>

<script>
    //アニメーションをすでに実行済みの場合CSSで非表示にする
    (function() {
        const today = new Date().toLocaleDateString();
        const visitedDate = localStorage.getItem("visitedDate");

        if (visitedDate === today) {
            
            const openingScreen = document.getElementById("opening-screen");
            if (openingScreen) {
                openingScreen.style.display = "none";
            }
        }
    })();
</script>