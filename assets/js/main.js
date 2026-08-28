// SPメニューの開閉処理
const menuToggle = document.querySelector('.c-menu-toggle');
const drawer = document.getElementById('drawer');

const toggleMenu = () => {
    const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';

    menuToggle.setAttribute('aria-expanded', String(!isOpen));
    drawer.classList.toggle('is-open');
    menuToggle.classList.toggle('is-open');
    document.body.classList.toggle('no-scroll');
}

menuToggle.addEventListener('click', toggleMenu);
drawer.addEventListener('click', toggleMenu);

// --- GSAPアニメーションの設定 ---
gsap.registerPlugin(ScrollTrigger);

const containers = gsap.utils.toArray('.p-journal__items');

containers.forEach(container => {
    const cards = gsap.utils.toArray('.p-journal-card', container);

    if (cards.length === 0) return;

    const firstCard = cards[0];

    // アニメーションを設定
    gsap.from(cards, {
        scrollTrigger: {
            trigger: container,
            start: "top 70%",
            toggleActions: "play none none none",
        },

        x: (index, target) => {
            return firstCard.offsetLeft - target.offsetLeft;
        },
        y: (index, target) => {
            return firstCard.offsetTop - target.offsetTop;
        },
        opacity: 0,
        duration: 1.5,
        ease: "power3.out",
        stagger: 0
    });

});

// アーカイブのフェードインアニメーション
document.addEventListener('DOMContentLoaded', function () {

    archiveItem = document.querySelectorAll('.p-archive__item');

    const Observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-show');
                Observer.unobserve(entry.target);
            }
        })
    }, {
        // オプション：要素が画面の下から50px入ったタイミングで発火させる
        rootMargin: '0px 0px -50px 0px'
    });

    archiveItem.forEach(element => {
        Observer.observe(element);
    })
});

// 送信成功後、作成したサンクスページのURLへ遷移させる
document.addEventListener('wpcf7mailsent', function (event) {
    location = '/contact/thanks/';
}, false);

// お問い合わせのテキストエリアの文字数表示
document.addEventListener('DOMContentLoaded', () => {
    const textarea = document.getElementById('your-message');
    const countSpan = document.getElementById('js-message-count');

    if (textarea && countSpan) {
        textarea.addEventListener('input', () => {
            // 入力された文字数を取得して表示を更新
            const currentLength = textarea.value.length;
            countSpan.textContent = currentLength;
        });
    }
});