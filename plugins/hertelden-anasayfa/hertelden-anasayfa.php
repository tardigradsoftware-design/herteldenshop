<?php
/**
 * Plugin Name: Hertelden Ana Sayfa
 * Description: E-ticaret ana sayfasını oluşturur ve statik sayfa olarak ayarlar.
 * Version: 2.2
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
    $existing = get_page_by_path( 'ana-sayfa' );
    $data = [
        'post_title'   => 'Ana Sayfa',
        'post_name'    => 'ana-sayfa',
        'post_content' => '[hertelden_anasayfa]',
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

// Kısa kod ile içerik — sanitizasyon sorununu tamamen bypass eder
add_shortcode( 'hertelden_anasayfa', 'has_render' );
function has_render() {
    ob_start();
    has_homepage_html();
    return ob_get_clean();
}

// Başlığı gizle
add_action( 'wp_head', 'has_hide_title' );
function has_hide_title() {
    if ( ! is_front_page() ) return;
    echo '<style>
    body.home .entry-title,
    body.home .ast-post-title-bar,
    body.home .page-title-bar { display:none!important; }
    body.home .entry-content,
    body.home .ast-article-single,
    body.home #primary { padding:0!important; margin:0!important; max-width:100%!important; }
    body.home .site-content .ast-container { max-width:100%!important; padding:0!important; }
    </style>' . "\n";
}

function has_homepage_html() { ?>
<!-- HERO -->
<section style="background:#111;color:#fff;padding:80px 24px 88px;text-align:center;width:100%">
  <div style="max-width:680px;margin:0 auto">
    <p style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#E84D00;margin-bottom:16px;font-family:Inter,sans-serif">Mutfak &amp; Sofra Dünyası</p>
    <h1 style="font-size:clamp(28px,5vw,52px);font-weight:800;line-height:1.15;margin-bottom:20px;font-family:Inter,sans-serif;letter-spacing:-.03em;color:#fff">Evinizin her köşesine<br><span style="color:#E84D00">özenle seçilmiş</span> ürünler</h1>
    <p style="font-size:16px;color:rgba(255,255,255,.7);margin-bottom:36px;font-family:Inter,sans-serif">Kaliteli mutfak ve sofra ürünleri, hızlı kargo ve güvenli ödeme.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
      <a href="/magaza" style="background:#E84D00;color:#fff;padding:13px 30px;border-radius:6px;font-weight:700;font-size:14px;text-decoration:none;font-family:Inter,sans-serif">Alışverişe Başla</a>
      <a href="/urun-kategorisi/kampanyalar" style="border:1.5px solid rgba(255,255,255,.3);color:#fff;padding:13px 30px;border-radius:6px;font-weight:500;font-size:14px;text-decoration:none;font-family:Inter,sans-serif">Kampanyalar</a>
    </div>
  </div>
</section>

<!-- KATEGORİLER -->
<section style="padding:56px 32px;background:#F5F5F5;width:100%">
  <div style="max-width:1320px;margin:0 auto">
    <h2 style="font-size:22px;font-weight:700;color:#111;margin-bottom:28px;font-family:Inter,sans-serif;letter-spacing:-.02em">Kategoriler</h2>
    <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:12px">
      <?php
      $cats = [
        ['sofra','Sofra'],['mutfak','Mutfak'],['kucuk-ev-aletleri','Küçük Ev Aletleri'],
        ['hertelden-home','Hertelden Home'],['koleksiyonlar','Koleksiyonlar'],
        ['kampanyalar','Kampanyalar'],['evlilik-paketleri','Evlilik Paketleri'],['online-ozel','Online Özel'],
      ];
      foreach ( $cats as $c ) :
          $term = get_term_by( 'slug', $c[0], 'product_cat' );
          $url  = $term ? get_term_link( $term ) : '/urun-kategorisi/' . $c[0];
      ?>
      <a href="<?php echo esc_url( $url ); ?>" style="background:#fff;border:1px solid #E5E5E5;border-radius:10px;padding:20px 10px 16px;text-align:center;text-decoration:none;color:#111;font-size:12px;font-weight:600;font-family:Inter,sans-serif;display:flex;flex-direction:column;align-items:center;gap:10px;transition:box-shadow .15s">
        <div style="width:36px;height:36px;background:#FFF4EF;border-radius:50%;display:flex;align-items:center;justify-content:center">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E84D00" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        </div>
        <span><?php echo esc_html( $c[1] ); ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ÜRÜNLER -->
<section style="padding:56px 32px;background:#fff;width:100%">
  <div style="max-width:1320px;margin:0 auto">
    <h2 style="font-size:22px;font-weight:700;color:#111;margin-bottom:28px;font-family:Inter,sans-serif;letter-spacing:-.02em">Öne Çıkan Ürünler</h2>
    <?php echo do_shortcode('[products limit="8" columns="4" orderby="date" order="DESC"]'); ?>
  </div>
</section>

<!-- GÜVEN -->
<section style="padding:56px 32px;background:#F5F5F5;width:100%">
  <div style="max-width:1320px;margin:0 auto">
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px">
      <?php
      $trust = [
        ['Güvenli Ödeme','SSL korumalı alışveriş'],
        ['Ücretsiz Kargo','500₺ ve üzeri siparişlerde'],
        ['Kolay İade','14 gün iade hakkı'],
        ['e-Arşiv Fatura','Her siparişe otomatik'],
      ];
      foreach ( $trust as $t ) : ?>
      <div style="background:#fff;border:1px solid #E5E5E5;border-radius:10px;padding:24px 16px;text-align:center">
        <div style="width:40px;height:40px;background:#FFF4EF;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E84D00" stroke-width="1.8" stroke-linecap="round"><path d="M12 2l3 6 6 1-4.5 4.3 1.1 6.2L12 16.5l-5.6 3 1.1-6.2L3 9l6-1z"/></svg>
        </div>
        <strong style="display:block;font-size:14px;font-weight:700;color:#111;font-family:Inter,sans-serif;margin-bottom:4px"><?php echo esc_html($t[0]); ?></strong>
        <span style="font-size:12.5px;color:#666;font-family:Inter,sans-serif"><?php echo esc_html($t[1]); ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php }
