<?php
/**
 * Plugin Name: Hertelden Ana Sayfa
 * Description: E-ticaret ana sayfasını otomatik oluşturur ve WordPress statik sayfa olarak ayarlar.
 * Version: 2.0
 * Author: Hertelden Shop
 */

if ( ! defined( 'ABSPATH' ) ) exit;

register_activation_hook( __FILE__, 'has_setup' );

add_action( 'admin_menu', 'has_admin_menu' );
function has_admin_menu() {
    add_management_page(
        'Hertelden Ana Sayfa',
        'Hertelden Ana Sayfa',
        'manage_options',
        'hertelden-anasayfa',
        'has_admin_page'
    );
}

function has_admin_page() {
    $result = '';
    if ( isset( $_POST['has_run'] ) && check_admin_referer( 'has_run_action' ) ) {
        $result = has_setup();
    }
    ?>
    <div class="wrap">
        <h1>Hertelden Ana Sayfa</h1>
        <p>Ana sayfayı oluşturur ve WordPress statik sayfa olarak ayarlar.</p>
        <form method="post">
            <?php wp_nonce_field( 'has_run_action' ); ?>
            <p><input type="submit" name="has_run" class="button button-primary button-large" value="Ana Sayfayı Oluştur / Güncelle"></p>
        </form>
        <?php if ( $result ) echo $result; ?>
    </div>
    <?php
}

function has_setup() {
    $page_id = has_create_page();
    if ( ! $page_id ) {
        return '<div class="notice notice-error"><p>Ana sayfa oluşturulamadı.</p></div>';
    }

    // WordPress okuma ayarları: statik ana sayfa
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $page_id );

    // CSS hook
    add_action( 'wp_head', 'has_inject_css' );

    return '<div class="notice notice-success"><p><strong>Tamamlandı!</strong> Ana sayfa oluşturuldu ve statik sayfa olarak ayarlandı. <a href="' . home_url() . '" target="_blank">Siteyi görüntüle →</a></p></div>';
}

function has_create_page() {
    $slug    = 'ana-sayfa';
    $existing = get_page_by_path( $slug );

    $content = has_page_content();

    $data = [
        'post_title'   => 'Ana Sayfa',
        'post_name'    => $slug,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ];

    if ( $existing ) {
        $data['ID'] = $existing->ID;
        $id = wp_update_post( $data );
    } else {
        $id = wp_insert_post( $data );
    }

    return is_wp_error( $id ) ? 0 : $id;
}

function has_page_content() {
    return <<<'HTML'
<!-- HERO BANNER -->
<section class="hs-hero">
    <div class="hs-hero-inner">
        <p class="hs-hero-eyebrow">Mutfak &amp; Sofra Dünyası</p>
        <h1 class="hs-hero-title">Evinizin her köşesine<br><span>özenle seçilmiş</span> ürünler</h1>
        <p class="hs-hero-sub">Kaliteli mutfak ve sofra ürünleri, hızlı kargo ve güvenli ödeme.</p>
        <div class="hs-hero-actions">
            <a class="hs-btn-primary" href="/magaza">Alışverişe Başla</a>
            <a class="hs-btn-ghost" href="/urun-kategorisi/kampanyalar">Kampanyalar</a>
        </div>
    </div>
</section>

<!-- KATEGORİ ŞERİDİ -->
<section class="hs-cats">
    <div class="hs-section-inner">
        <h2 class="hs-section-title">Kategoriler</h2>
        <div class="hs-cat-grid">
            <a class="hs-cat-card" href="/urun-kategorisi/sofra">
                <div class="hs-cat-icon">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2"/><path d="M14 24h20M24 14v20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
                <span>Sofra</span>
            </a>
            <a class="hs-cat-card" href="/urun-kategorisi/mutfak">
                <div class="hs-cat-icon">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8v32M18 8c0 8-6 10-6 16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><rect x="28" y="8" width="8" height="14" rx="4" stroke="currentColor" stroke-width="2"/><path d="M32 22v18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
                <span>Mutfak</span>
            </a>
            <a class="hs-cat-card" href="/urun-kategorisi/kucuk-ev-aletleri">
                <div class="hs-cat-icon">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="14" width="28" height="22" rx="3" stroke="currentColor" stroke-width="2"/><path d="M10 20h28M20 14v-4M28 14v-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
                <span>Küçük Ev Aletleri</span>
            </a>
            <a class="hs-cat-card" href="/urun-kategorisi/hertelden-home">
                <div class="hs-cat-icon">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 22L24 8l16 14v18H30V28H18v12H8V22z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                </div>
                <span>Hertelden Home</span>
            </a>
            <a class="hs-cat-card" href="/urun-kategorisi/koleksiyonlar">
                <div class="hs-cat-icon">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="8" y="8" width="14" height="14" rx="2" stroke="currentColor" stroke-width="2"/><rect x="26" y="8" width="14" height="14" rx="2" stroke="currentColor" stroke-width="2"/><rect x="8" y="26" width="14" height="14" rx="2" stroke="currentColor" stroke-width="2"/><rect x="26" y="26" width="14" height="14" rx="2" stroke="currentColor" stroke-width="2"/></svg>
                </div>
                <span>Koleksiyonlar</span>
            </a>
            <a class="hs-cat-card" href="/urun-kategorisi/kampanyalar">
                <div class="hs-cat-icon">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 8l3.5 7 7.5 1.1-5.5 5.3 1.3 7.6L24 25.5l-6.8 3.5 1.3-7.6L13 16.1l7.5-1.1L24 8z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M12 38h24" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
                <span>Kampanyalar</span>
            </a>
            <a class="hs-cat-card" href="/urun-kategorisi/evlilik-paketleri">
                <div class="hs-cat-icon">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 38s-16-9-16-20a8 8 0 0116 0 8 8 0 0116 0c0 11-16 20-16 20z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                </div>
                <span>Evlilik Paketleri</span>
            </a>
            <a class="hs-cat-card" href="/urun-kategorisi/online-ozel">
                <div class="hs-cat-icon">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="16" stroke="currentColor" stroke-width="2"/><path d="M8 24h32M24 8c-4 4-6 10-6 16s2 12 6 16M24 8c4 4 6 10 6 16s-2 12-6 16" stroke="currentColor" stroke-width="2"/></svg>
                </div>
                <span>Online Özel</span>
            </a>
        </div>
    </div>
</section>

<!-- ÖZEL ÜRÜNLER -->
<section class="hs-products">
    <div class="hs-section-inner">
        <h2 class="hs-section-title">Öne Çıkan Ürünler</h2>
        [products limit="8" columns="4" orderby="date" order="DESC"]
    </div>
</section>

<!-- GÜVEN ROZETLERİ -->
<section class="hs-trust">
    <div class="hs-section-inner">
        <div class="hs-trust-grid">
            <div class="hs-trust-item">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 6l14 6v10c0 10-6 18-14 22C10 40 4 32 4 22V12l20-6z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M16 24l5 5 10-10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <strong>Güvenli Alışveriş</strong>
                <span>SSL korumalı ödeme</span>
            </div>
            <div class="hs-trust-item">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 14h28l-4 18H10L6 14z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M6 14l-2-6H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="16" cy="38" r="2" stroke="currentColor" stroke-width="2"/><circle cx="28" cy="38" r="2" stroke="currentColor" stroke-width="2"/><path d="M34 14h8l-4 12h-8" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                <strong>Hızlı Kargo</strong>
                <span>500₺ üzeri ücretsiz</span>
            </div>
            <div class="hs-trust-item">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 4C13 4 4 13 4 24s9 20 20 20 20-9 20-20S35 4 24 4z" stroke="currentColor" stroke-width="2"/><path d="M24 14v12l6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <strong>Kolay İade</strong>
                <span>14 gün iade hakkı</span>
            </div>
            <div class="hs-trust-item">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 16h32v22a2 2 0 01-2 2H10a2 2 0 01-2-2V16z" stroke="currentColor" stroke-width="2"/><path d="M8 16V10a2 2 0 012-2h28a2 2 0 012 2v6" stroke="currentColor" stroke-width="2"/><path d="M20 8v8M28 8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <strong>Fatura</strong>
                <span>Her siparişe e-arşiv</span>
            </div>
        </div>
    </div>
</section>
HTML;
}

// CSS frontend
add_action( 'wp_head', 'has_inject_css' );
function has_inject_css() {
    if ( ! is_front_page() ) return;
    ?>
    <style>
    /* ── HERTELDEN ANA SAYFA v2.0 ── */
    :root {
        --hs-bg:       #F7F5F2;
        --hs-ink:      #22201D;
        --hs-ink2:     #5A5651;
        --hs-accent:   #EC7920;
        --hs-border:   #E4E0DA;
        --hs-white:    #FFFFFF;
        --hs-radius:   10px;
    }

    body.home { background: var(--hs-bg); }

    .hs-hero {
        background: var(--hs-ink);
        color: var(--hs-white);
        padding: 80px 24px 88px;
        text-align: center;
    }
    .hs-hero-inner { max-width: 720px; margin: 0 auto; }
    .hs-hero-eyebrow {
        font-size: 13px;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--hs-accent);
        margin-bottom: 16px;
        font-family: Inter, sans-serif;
    }
    .hs-hero-title {
        font-size: clamp(32px, 5vw, 52px);
        font-weight: 700;
        line-height: 1.18;
        margin-bottom: 20px;
        font-family: Georgia, 'Times New Roman', serif;
        letter-spacing: -.02em;
    }
    .hs-hero-title span { color: var(--hs-accent); }
    .hs-hero-sub {
        font-size: 17px;
        color: rgba(255,255,255,.7);
        margin-bottom: 36px;
        font-family: Inter, sans-serif;
    }
    .hs-hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    .hs-btn-primary {
        background: var(--hs-accent);
        color: var(--hs-white);
        padding: 14px 32px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        font-family: Inter, sans-serif;
        transition: opacity .15s;
    }
    .hs-btn-primary:hover { opacity: .88; color: var(--hs-white); }
    .hs-btn-ghost {
        border: 1.5px solid rgba(255,255,255,.35);
        color: var(--hs-white);
        padding: 14px 32px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 15px;
        text-decoration: none;
        font-family: Inter, sans-serif;
        transition: border-color .15s;
    }
    .hs-btn-ghost:hover { border-color: rgba(255,255,255,.75); color: var(--hs-white); }

    .hs-section-inner { max-width: 1180px; margin: 0 auto; padding: 0 24px; }
    .hs-section-title {
        font-size: 26px;
        font-weight: 700;
        color: var(--hs-ink);
        margin-bottom: 32px;
        font-family: Georgia, serif;
    }

    .hs-cats { padding: 64px 0; background: var(--hs-bg); }
    .hs-cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 16px;
    }
    .hs-cat-card {
        background: var(--hs-white);
        border: 1px solid var(--hs-border);
        border-radius: var(--hs-radius);
        padding: 24px 16px 20px;
        text-align: center;
        text-decoration: none;
        color: var(--hs-ink);
        font-size: 13px;
        font-weight: 600;
        font-family: Inter, sans-serif;
        transition: box-shadow .15s, transform .15s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .hs-cat-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,.10);
        transform: translateY(-2px);
        color: var(--hs-accent);
    }
    .hs-cat-icon {
        width: 40px;
        height: 40px;
        color: var(--hs-accent);
    }
    .hs-cat-icon svg { width: 100%; height: 100%; }

    .hs-products { padding: 64px 0; background: var(--hs-white); }
    /* WooCommerce ürün kartları */
    .hs-products ul.products { gap: 20px !important; }
    .hs-products ul.products li.product {
        border: 1px solid var(--hs-border) !important;
        border-radius: var(--hs-radius) !important;
        padding: 16px !important;
        transition: box-shadow .15s !important;
        background: var(--hs-white) !important;
    }
    .hs-products ul.products li.product:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,.09) !important;
    }
    .hs-products ul.products li.product img {
        border-radius: 6px !important;
        aspect-ratio: 1;
        object-fit: cover;
    }
    .hs-products .woocommerce-loop-product__title {
        font-size: 14px !important;
        font-family: Inter, sans-serif !important;
        color: var(--hs-ink) !important;
    }
    .hs-products .price { color: var(--hs-accent) !important; font-weight: 700 !important; }
    .hs-products .button {
        background: var(--hs-accent) !important;
        color: var(--hs-white) !important;
        border-radius: 6px !important;
        font-family: Inter, sans-serif !important;
        font-size: 13px !important;
        padding: 10px 16px !important;
    }

    .hs-trust { padding: 64px 0; background: var(--hs-bg); }
    .hs-trust-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
    }
    .hs-trust-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 10px;
        padding: 28px 16px;
        background: var(--hs-white);
        border: 1px solid var(--hs-border);
        border-radius: var(--hs-radius);
    }
    .hs-trust-item svg { width: 36px; height: 36px; color: var(--hs-accent); }
    .hs-trust-item strong {
        font-size: 15px;
        color: var(--hs-ink);
        font-family: Inter, sans-serif;
    }
    .hs-trust-item span {
        font-size: 13px;
        color: var(--hs-ink2);
        font-family: Inter, sans-serif;
    }

    @media (max-width: 640px) {
        .hs-hero { padding: 56px 16px 64px; }
        .hs-cat-grid { grid-template-columns: repeat(4, 1fr); gap: 10px; }
        .hs-cat-card { padding: 18px 8px 14px; font-size: 11px; }
    }
    </style>
    <?php
}
