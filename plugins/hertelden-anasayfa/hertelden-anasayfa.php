<?php
/**
 * Plugin Name: Hertelden Ana Sayfa
 * Description: E-ticaret ana sayfasını oluşturur ve WordPress statik sayfa olarak ayarlar.
 * Version: 2.1
 * Author: Hertelden Shop
 */

if ( ! defined( 'ABSPATH' ) ) exit;

register_activation_hook( __FILE__, 'has_setup' );

add_action( 'admin_menu', 'has_admin_menu' );
function has_admin_menu() {
    add_management_page( 'Hertelden Ana Sayfa', 'Hertelden Ana Sayfa', 'manage_options', 'hertelden-anasayfa', 'has_admin_page' );
}
function has_admin_page() {
    $result = '';
    if ( isset( $_POST['has_run'] ) && check_admin_referer( 'has_run_action' ) ) {
        $result = has_setup();
    }
    ?>
    <div class="wrap">
        <h1>Hertelden Ana Sayfa</h1>
        <form method="post"><?php wp_nonce_field( 'has_run_action' ); ?>
            <p><input type="submit" name="has_run" class="button button-primary button-large" value="Ana Sayfayı Oluştur / Güncelle"></p>
        </form>
        <?php if ( $result ) echo $result; ?>
    </div>
    <?php
}

function has_setup() {
    // Boş bir sayfa oluştur — içerik the_content filtresiyle inject edilecek
    $existing = get_page_by_path( 'ana-sayfa' );
    $data = [
        'post_title'   => 'Ana Sayfa',
        'post_name'    => 'ana-sayfa',
        'post_content' => '<!-- hertelden-anasayfa -->',
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ];
    if ( $existing ) {
        $data['ID'] = $existing->ID;
        $id = wp_update_post( $data );
    } else {
        $id = wp_insert_post( $data );
    }
    if ( ! $id || is_wp_error( $id ) ) {
        return '<div class="notice notice-error"><p>Sayfa oluşturulamadı.</p></div>';
    }
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $id );
    return '<div class="notice notice-success"><p><strong>Tamamlandı!</strong> <a href="' . home_url() . '" target="_blank">Siteyi görüntüle →</a></p></div>';
}

// ── İçeriği the_content filtresiyle inject et ──────────────────────────────
add_filter( 'the_content', 'has_inject_content' );
function has_inject_content( $content ) {
    if ( ! is_front_page() || ! is_main_query() ) return $content;
    return has_homepage_html();
}

// Ana sayfa başlığını gizle
add_action( 'wp_head', 'has_hide_title_css' );
function has_hide_title_css() {
    if ( ! is_front_page() ) return;
    echo '<style>
    body.home .entry-title,
    body.home .ast-post-title-bar,
    body.home .page-header,
    body.home .ast-archive-description { display:none!important; }
    body.home .entry-content { padding:0!important; margin:0!important; }
    body.home .site-content .ast-container { max-width:100%!important; padding:0!important; }
    body.home #primary { width:100%!important; padding:0!important; }
    </style>' . "\n";
}

function has_homepage_html() {
    ob_start();
    ?>
<!-- ── HERO ── -->
<section class="hs-hero">
  <div class="hs-inner">
    <p class="hs-eyebrow">Mutfak &amp; Sofra Dünyası</p>
    <h1 class="hs-title">Evinizin her köşesine<br><em>özenle seçilmiş</em> ürünler</h1>
    <p class="hs-sub">Kaliteli mutfak ve sofra ürünleri, hızlı kargo ve güvenli ödeme.</p>
    <div class="hs-actions">
      <a class="hs-btn" href="/magaza">Alışverişe Başla</a>
      <a class="hs-btn-out" href="/urun-kategorisi/kampanyalar">Kampanyalar</a>
    </div>
  </div>
</section>

<!-- ── KATEGORİLER ── -->
<section class="hs-cats">
  <div class="hs-inner">
    <h2 class="hs-sec-title">Kategoriler</h2>
    <div class="hs-cat-grid">
      <?php
      $cats = [
        ['sofra',             'Sofra',            'M8 30c0-8.8 7.2-16 16-16s16 7.2 16 16H8z M24 14V8'],
        ['mutfak',            'Mutfak',            'M12 8v32 M18 8c0 8-6 10-6 16 M28 12v8a4 4 0 008 0v-8 M32 20v20'],
        ['kucuk-ev-aletleri', 'Küçük Ev Aletleri', 'M10 14h28v20H10z M10 20h28 M20 14v-4 M28 14v-4'],
        ['hertelden-home',    'Hertelden Home',    'M8 22L24 8l16 14v18H30V28H18v12H8z'],
        ['koleksiyonlar',     'Koleksiyonlar',     'M8 8h14v14H8z M26 8h14v14H26z M8 26h14v14H8z M26 26h14v14H26z'],
        ['kampanyalar',       'Kampanyalar',       'M24 8l3.5 7 7.5 1.1-5.5 5.3 1.3 7.6L24 25.5l-6.8 3.5 1.3-7.6L13 16.1l7.5-1.1z M12 38h24'],
        ['evlilik-paketleri', 'Evlilik Paketleri', 'M24 38S8 29 8 18a8 8 0 0116 0 8 8 0 0116 0c0 11-16 20-16 20z'],
        ['online-ozel',       'Online Özel',       'M24 8a16 16 0 100 32A16 16 0 0024 8z M8 24h32 M24 8c-4 4-6 10-6 16s2 12 6 16 M24 8c4 4 6 10 6 16s-2 12-6 16'],
      ];
      foreach ( $cats as $c ) {
          $term = get_term_by( 'slug', $c[0], 'product_cat' );
          $url  = $term ? get_term_link( $term ) : '/urun-kategorisi/' . $c[0];
          echo '<a class="hs-cat-card" href="' . esc_url( $url ) . '">';
          echo '<div class="hs-cat-icon"><svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="' . esc_attr( $c[2] ) . '" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>';
          echo '<span>' . esc_html( $c[1] ) . '</span>';
          echo '</a>';
      }
      ?>
    </div>
  </div>
</section>

<!-- ── ÜRÜNLER ── -->
<section class="hs-products">
  <div class="hs-inner">
    <h2 class="hs-sec-title">Öne Çıkan Ürünler</h2>
    <?php echo do_shortcode('[products limit="8" columns="4" orderby="date" order="DESC"]'); ?>
  </div>
</section>

<!-- ── GÜVEN ── -->
<section class="hs-trust">
  <div class="hs-inner">
    <div class="hs-trust-grid">
      <div class="hs-trust-item">
        <svg viewBox="0 0 48 48" fill="none"><path d="M24 6l14 6v10c0 10-6 18-14 22C10 40 4 32 4 22V12z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M16 24l5 5 10-10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <strong>Güvenli Ödeme</strong><span>SSL korumalı alışveriş</span>
      </div>
      <div class="hs-trust-item">
        <svg viewBox="0 0 48 48" fill="none"><path d="M6 14h28l-4 18H10z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M6 14l-2-6H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="16" cy="38" r="2" stroke="currentColor" stroke-width="2"/><circle cx="28" cy="38" r="2" stroke="currentColor" stroke-width="2"/><path d="M34 14h8l-4 12h-8" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
        <strong>Ücretsiz Kargo</strong><span>500₺ ve üzeri siparişlerde</span>
      </div>
      <div class="hs-trust-item">
        <svg viewBox="0 0 48 48" fill="none"><path d="M24 4C13 4 4 13 4 24s9 20 20 20 20-9 20-20S35 4 24 4z" stroke="currentColor" stroke-width="2"/><path d="M24 14v12l6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <strong>Kolay İade</strong><span>14 gün iade hakkı</span>
      </div>
      <div class="hs-trust-item">
        <svg viewBox="0 0 48 48" fill="none"><path d="M8 16h32v22a2 2 0 01-2 2H10a2 2 0 01-2-2z" stroke="currentColor" stroke-width="2"/><path d="M8 16V10a2 2 0 012-2h28a2 2 0 012 2v6" stroke="currentColor" stroke-width="2"/><path d="M20 8v8M28 8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <strong>e-Arşiv Fatura</strong><span>Her siparişe otomatik</span>
      </div>
    </div>
  </div>
</section>

<style>
.hs-hero{background:#111;color:#fff;padding:80px 24px 88px;text-align:center}
.hs-hero .hs-inner{max-width:680px;margin:0 auto}
.hs-eyebrow{font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#E84D00;margin-bottom:16px;font-family:Inter,sans-serif}
.hs-title{font-size:clamp(28px,5vw,52px);font-weight:800;line-height:1.15;margin-bottom:20px;font-family:Inter,sans-serif;letter-spacing:-.03em}
.hs-title em{font-style:normal;color:#E84D00}
.hs-sub{font-size:16px;color:rgba(255,255,255,.7);margin-bottom:36px;font-family:Inter,sans-serif}
.hs-actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
.hs-btn{background:#E84D00;color:#fff;padding:13px 30px;border-radius:6px;font-weight:700;font-size:14px;text-decoration:none;font-family:Inter,sans-serif;transition:opacity .15s}
.hs-btn:hover{opacity:.88;color:#fff}
.hs-btn-out{border:1.5px solid rgba(255,255,255,.3);color:#fff;padding:13px 30px;border-radius:6px;font-weight:500;font-size:14px;text-decoration:none;font-family:Inter,sans-serif;transition:border-color .15s}
.hs-btn-out:hover{border-color:rgba(255,255,255,.7);color:#fff}

.hs-cats,.hs-products,.hs-trust{padding:56px 24px}
.hs-cats{background:#F5F5F5}
.hs-products{background:#fff}
.hs-trust{background:#F5F5F5}
.hs-inner{max-width:1200px;margin:0 auto}
.hs-sec-title{font-size:22px;font-weight:700;color:#111;margin-bottom:28px;font-family:Inter,sans-serif;letter-spacing:-.02em}

.hs-cat-grid{display:grid;grid-template-columns:repeat(8,1fr);gap:12px}
@media(max-width:1024px){.hs-cat-grid{grid-template-columns:repeat(4,1fr)}}
@media(max-width:600px){.hs-cat-grid{grid-template-columns:repeat(4,1fr);gap:8px}}
.hs-cat-card{background:#fff;border:1px solid #E5E5E5;border-radius:10px;padding:20px 10px 16px;text-align:center;text-decoration:none;color:#111;font-size:12px;font-weight:600;font-family:Inter,sans-serif;transition:box-shadow .15s,transform .15s;display:flex;flex-direction:column;align-items:center;gap:10px}
.hs-cat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.1);transform:translateY(-2px);color:#E84D00}
.hs-cat-icon{width:36px;height:36px;color:#E84D00}
.hs-cat-icon svg{width:100%;height:100%}

.hs-trust-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
@media(max-width:768px){.hs-trust-grid{grid-template-columns:repeat(2,1fr)}}
.hs-trust-item{background:#fff;border:1px solid #E5E5E5;border-radius:10px;padding:24px 16px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:10px}
.hs-trust-item svg{width:34px;height:34px;color:#E84D00}
.hs-trust-item strong{font-size:14px;color:#111;font-family:Inter,sans-serif;font-weight:700}
.hs-trust-item span{font-size:12.5px;color:#666;font-family:Inter,sans-serif}
</style>
    <?php
    return ob_get_clean();
}
