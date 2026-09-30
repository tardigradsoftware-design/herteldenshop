<?php
/**
 * Plugin Name: Hertelden Tema Pro
 * Description: Trendyol/Amazon seviyesi satış odaklı tasarım — header, footer, ürün kartları, güven rozetleri.
 * Version:     1.0.0
 * Author:      Hertelden Shop
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'HRT_TEMA_URL', plugin_dir_url( __FILE__ ) );

/* ── CSS yükle ── */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'hertelden-tema-pro',
        HRT_TEMA_URL . 'assets/style.css',
        [],
        '1.0.0'
    );
} );

/* ── Eski anasayfa plugin'ini devre dışı bırak (çakışmasın) ── */
add_action( 'plugins_loaded', function() {
    if ( is_plugin_active( 'hertelden-anasayfa/hertelden-anasayfa.php' ) ) {
        // CSS çakışmasını önlemek için eski plugin'in style'ını kaldır
        add_action( 'wp_enqueue_scripts', function() {
            wp_dequeue_style( 'hertelden-anasayfa' );
        }, 20 );
    }
}, 5 );

/* ══════════════════════════════════════════
   TOP BAR — en üstte bilgi çubuğu
══════════════════════════════════════════ */
add_action( 'wp_body_open', function() {
    echo '
    <div id="hrt-topbar">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            500₺ ve üzeri ÜCRETSİZ KARGO
        </span>
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Güvenli Alışveriş
        </span>
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Kolay İade
        </span>
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            Müşteri Hattı: herteldenshoptr@gmail.com
        </span>
    </div>';
} );

/* ══════════════════════════════════════════
   TRUST BAR — header altı güven çubuğu
══════════════════════════════════════════ */
add_action( 'kadence_before_content', function() {
    hrt_trust_bar();
}, 1 );

// Kadence olmayan temalar için fallback
add_action( 'wp_footer', function() {
    // JS ile body'ye ekle (Kadence hook çalışmazsa)
}, 5 );

function hrt_trust_bar() {
    echo '
    <div id="hrt-trust">
        <ul>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <div><strong>Hızlı Teslimat</strong><br><small style="color:#777;font-weight:400">1-3 iş günü</small></div>
            </li>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <div><strong>Güvenli Ödeme</strong><br><small style="color:#777;font-weight:400">SSL Korumalı</small></div>
            </li>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <div><strong>14 Gün İade</strong><br><small style="color:#777;font-weight:400">Koşulsuz iade</small></div>
            </li>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <div><strong>Orijinal Ürün</strong><br><small style="color:#777;font-weight:400">%100 garantili</small></div>
            </li>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <div><strong>Canlı Destek</strong><br><small style="color:#777;font-weight:400">7/24 WhatsApp</small></div>
            </li>
        </ul>
    </div>';
}

/* ══════════════════════════════════════════
   ANA SAYFA İÇERİĞİ
══════════════════════════════════════════ */
add_action( 'wp_head', function() {
    if ( ! is_front_page() ) return;
    // Sayfa içeriği shortcode yerine hook ile inject edilecek
} );

// Ana sayfa için shortcode — [hertelden_anasayfa_pro]
add_shortcode( 'hertelden_anasayfa_pro', 'hrt_render_homepage' );

function hrt_render_homepage() {
    ob_start();

    /* ── HERO BANNER ── */
    echo '
    <div id="hrt-hero">
        <div class="hrt-hero-inner">
            <div class="hrt-hero-text">
                <span class="hrt-hero-badge">Yeni Sezon</span>
                <h1>Evinizi Güzelleştirin,<br>Hayatınızı Kolaylaştırın</h1>
                <p>Banyo organizerden çeyizlik sofra gruplarına — kaliteli ürünler, uygun fiyatlar.</p>
                <a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="hrt-btn-primary">Alışverişe Başla</a>
            </div>
            <div class="hrt-hero-image">
                <!-- Buraya ürün görseli eklenebilir -->
            </div>
        </div>
    </div>';

    /* ── KATEGORİ ŞERIDI ── */
    $categories = get_terms( [
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
        'number'     => 10,
        'exclude'    => get_option( 'default_product_cat' ),
    ] );

    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        echo '<div class="hrt-section">';
        echo '<div class="hrt-section-title"><h2>Kategoriler</h2><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">Tümünü Gör →</a></div>';
        echo '<div class="hrt-cat-grid">';
        foreach ( $categories as $cat ) {
            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $img_url      = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' ) : '';
            $cat_url      = get_term_link( $cat );
            echo '<a href="' . esc_url( $cat_url ) . '" class="hrt-cat-item">';
            if ( $img_url ) {
                echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $cat->name ) . '" loading="lazy">';
            } else {
                echo '<div style="width:60px;height:60px;background:#f0f0f0;border-radius:50%;margin:0 auto 8px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#FF6B00" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>';
            }
            echo '<span>' . esc_html( $cat->name ) . '</span>';
            echo '</a>';
        }
        echo '</div></div>';
    }

    /* ── ÖNE ÇIKAN ÜRÜNLER ── */
    echo '<div class="hrt-section">';
    echo '<div class="hrt-section-title"><h2>Öne Çıkan Ürünler</h2><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">Tüm Ürünler →</a></div>';
    echo do_shortcode( '[products limit="8" columns="4" orderby="date" order="DESC"]' );
    echo '</div>';

    /* ── PROMO KARTLAR ── */
    $banyo_url  = get_term_link( 'banyo', 'product_cat' );
    $mutfak_url = get_term_link( 'mutfak-sofra', 'product_cat' );
    $banyo_url  = is_wp_error( $banyo_url )  ? wc_get_page_permalink( 'shop' ) : $banyo_url;
    $mutfak_url = is_wp_error( $mutfak_url ) ? wc_get_page_permalink( 'shop' ) : $mutfak_url;

    echo '
    <div class="hrt-section">
        <div class="hrt-promo-grid">
            <div class="hrt-promo-card">
                <div class="hrt-promo-card-content">
                    <h3>Banyo Organizer</h3>
                    <p>Banyonuzu düzenli ve şık tutun</p>
                    <a href="' . esc_url( $banyo_url ) . '">Keşfet</a>
                </div>
            </div>
            <div class="hrt-promo-card blue">
                <div class="hrt-promo-card-content">
                    <h3>Çeyizlik Sofra Setleri</h3>
                    <p>Sofranızı tamamlayan kaliteli ürünler</p>
                    <a href="' . esc_url( $mutfak_url ) . '">Keşfet</a>
                </div>
            </div>
        </div>
    </div>';

    /* ── EN ÇOK SATANLAR ── */
    echo '<div class="hrt-section">';
    echo '<div class="hrt-section-title"><h2>En Çok Satanlar</h2><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">Tümünü Gör →</a></div>';
    echo do_shortcode( '[products limit="4" columns="4" best_selling="true"]' );
    echo '</div>';

    return ob_get_clean();
}

/* ── Ana sayfayı otomatik güncelle (Araçlar menüsü) ── */
add_action( 'admin_menu', function() {
    add_management_page(
        'Hertelden Anasayfa Güncelle',
        'Hertelden Anasayfa Pro',
        'manage_options',
        'hertelden-anasayfa-pro',
        'hrt_admin_homepage_page'
    );
} );

function hrt_admin_homepage_page() {
    $message = '';
    if ( isset( $_POST['hrt_update_homepage'] ) && check_admin_referer( 'hrt_update_homepage' ) ) {
        $page_id = (int) get_option( 'page_on_front' );
        if ( ! $page_id ) {
            $page_id = get_page_by_path( 'anasayfa' ) ? get_page_by_path( 'anasayfa' )->ID : 0;
        }
        if ( $page_id ) {
            wp_update_post( [
                'ID'           => $page_id,
                'post_content' => '[hertelden_anasayfa_pro]',
            ] );
            $message = '<div class="notice notice-success"><p>Ana sayfa güncellendi.</p></div>';
        } else {
            // Sayfa yoksa oluştur
            $new_id = wp_insert_post( [
                'post_title'   => 'Ana Sayfa',
                'post_name'    => 'anasayfa',
                'post_content' => '[hertelden_anasayfa_pro]',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ] );
            update_option( 'page_on_front', $new_id );
            update_option( 'show_on_front', 'page' );
            $message = '<div class="notice notice-success"><p>Ana sayfa oluşturuldu ve ayarlandı.</p></div>';
        }
    }

    echo '<div class="wrap">';
    echo '<h1>Hertelden Anasayfa Pro</h1>';
    echo $message;
    echo '<p>Bu butona tıklayarak ana sayfa içeriğini Hertelden Tema Pro tasarımıyla güncelle.</p>';
    echo '<form method="post">';
    wp_nonce_field( 'hrt_update_homepage' );
    echo '<button name="hrt_update_homepage" class="button button-primary button-large">Ana Sayfayı Güncelle</button>';
    echo '</form></div>';
}

/* ══════════════════════════════════════════
   FOOTER
══════════════════════════════════════════ */
add_action( 'wp_footer', function() {
    echo '
    <div id="hrt-footer-main">
        <div class="hrt-footer-about">
            <h4>Hertelden Shop</h4>
            <p>Banyo organizer, çeyizlik mutfak ve sofra grupları, fenomen ürünler — kaliteli ve uygun fiyatlı.</p>
            <p style="font-size:12px;color:rgba(255,255,255,.4)">herteldenshoptr@gmail.com</p>
        </div>
        <div>
            <h4>Bilgi</h4>
            <ul>
                <li><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '">Tüm Ürünler</a></li>
                <li><a href="' . esc_url( get_permalink( get_page_by_path( 'hakkimizda' ) ) ) . '">Hakkımızda</a></li>
                <li><a href="' . esc_url( get_permalink( get_page_by_path( 'iletisim' ) ) ) . '">İletişim</a></li>
            </ul>
        </div>
        <div>
            <h4>Yardım</h4>
            <ul>
                <li><a href="' . esc_url( wc_get_page_permalink( 'myaccount' ) ) . '">Hesabım</a></li>
                <li><a href="' . esc_url( wc_get_page_permalink( 'cart' ) ) . '">Sepetim</a></li>
                <li><a href="' . esc_url( get_permalink( get_page_by_path( 'iptal-iade-kosullari' ) ) ) . '">İade Koşulları</a></li>
                <li><a href="' . esc_url( get_permalink( get_page_by_path( 'mesafeli-satis-sozlesmesi' ) ) ) . '">Satış Sözleşmesi</a></li>
            </ul>
        </div>
        <div>
            <h4>Güvenli Alışveriş</h4>
            <ul>
                <li><a href="' . esc_url( get_permalink( get_page_by_path( 'gizlilik-politikasi-kvkk' ) ) ) . '">Gizlilik & KVKK</a></li>
                <li><a href="#">SSL Sertifikası</a></li>
            </ul>
        </div>
    </div>
    <div id="hrt-footer-bottom">
        <p>© ' . date('Y') . ' Hertelden Shop — Tüm hakları saklıdır.</p>
        <div class="hrt-payment-icons">
            <span>HAVALE/EFT</span>
            <span>SSL</span>
        </div>
    </div>';
}, 20 );

/* ══════════════════════════════════════════
   HEADER ARAMA KUTUSU ENJEKSİYONU
   (Kadence'in native search'ını güçlendir)
══════════════════════════════════════════ */
add_action( 'wp_head', function() {
    ?>
    <style>
    /* Kadence search override */
    .wp-block-search__input,
    .kadence-search-form input[type="search"],
    .search-form input[type="search"] {
        border: 2px solid #FF6B00 !important;
        border-radius: 6px 0 0 6px !important;
        padding: 10px 16px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 14px !important;
        outline: none !important;
    }
    .wp-block-search__button,
    .kadence-search-form button,
    .search-form button[type="submit"] {
        background: #FF6B00 !important;
        border: none !important;
        border-radius: 0 6px 6px 0 !important;
        color: #fff !important;
        padding: 10px 18px !important;
    }
    /* Kadence header içindeki cart badge */
    .header-cart-wrap .cart-count { background: #FF6B00 !important; }

    /* Kadence primary nav link hover */
    #primary-navigation a:hover,
    #site-navigation a:hover { color: #FF6B00 !important; }
    </style>
    <?php
} );
