<?php
/**
 * Hertelden Shop - Ana Sayfa Template
 * Astra header + footer ile tam sayfa render.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<style>
/* Ana sayfa layout düzeltmesi — Astra wrapper'larını block'a çek */
.htp-home-title { display:none!important; }

/* Tüm içerik sarmalayıcıları block + tam genişlik */
#content, .site-content,
#content .ast-container, .site-content .ast-container,
#primary, .content-area,
#main, .site-main,
.ast-article-single, article.page,
.entry-content, .post-content {
  display: block !important;
  float: none !important;
  width: 100% !important;
  max-width: 100% !important;
  padding: 0 !important;
  margin: 0 !important;
}
</style>

<!-- ── HERO ── -->
<section style="background:#111111;color:#fff;padding:88px 32px;text-align:center;width:100%">
  <div style="max-width:700px;margin:0 auto">
    <p style="font-size:11px;letter-spacing:.15em;text-transform:uppercase;color:#E84D00;margin:0 0 18px;font-family:Inter,sans-serif;font-weight:600">Mutfak &amp; Sofra Dünyası</p>
    <h1 style="font-size:clamp(30px,4.5vw,54px);font-weight:800;line-height:1.12;margin:0 0 20px;font-family:Inter,sans-serif;letter-spacing:-.035em;color:#fff">
      Evinizin her köşesine<br><span style="color:#E84D00">özenle seçilmiş</span> ürünler
    </h1>
    <p style="font-size:17px;color:rgba(255,255,255,.65);margin:0 0 40px;font-family:Inter,sans-serif;line-height:1.6">
      Kaliteli mutfak ve sofra ürünleri, hızlı kargo ve güvenli ödeme.
    </p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
      <a href="<?php echo esc_url( wc_get_page_permalink('shop') ?: home_url('/magaza') ); ?>"
         style="background:#E84D00;color:#fff;padding:14px 32px;border-radius:7px;font-weight:700;font-size:15px;text-decoration:none;font-family:Inter,sans-serif;display:inline-block">
        Alışverişe Başla
      </a>
      <?php
      $kamp = get_term_by('slug','kampanyalar','product_cat');
      $kamp_url = $kamp ? get_term_link($kamp) : home_url('/urun-kategorisi/kampanyalar');
      ?>
      <a href="<?php echo esc_url($kamp_url); ?>"
         style="border:1.5px solid rgba(255,255,255,.35);color:#fff;padding:14px 32px;border-radius:7px;font-weight:500;font-size:15px;text-decoration:none;font-family:Inter,sans-serif;display:inline-block">
        Kampanyalar
      </a>
    </div>
  </div>
</section>

<!-- ── KATEGORİLER ── -->
<section style="padding:60px 32px;background:#F5F5F5;width:100%">
  <div style="max-width:1360px;margin:0 auto">
    <h2 style="font-size:22px;font-weight:700;color:#111;margin:0 0 28px;font-family:Inter,sans-serif;letter-spacing:-.025em">Kategoriler</h2>
    <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:14px">
      <?php
      $cats = [
        'sofra'             => 'Sofra',
        'mutfak'            => 'Mutfak',
        'kucuk-ev-aletleri' => 'Küçük Ev Aletleri',
        'hertelden-home'    => 'Hertelden Home',
        'koleksiyonlar'     => 'Koleksiyonlar',
        'kampanyalar'       => 'Kampanyalar',
        'evlilik-paketleri' => 'Evlilik Paketleri',
        'online-ozel'       => 'Online Özel',
      ];
      foreach ( $cats as $slug => $label ) :
          $term = get_term_by( 'slug', $slug, 'product_cat' );
          $url  = $term ? get_term_link( $term ) : home_url( '/urun-kategorisi/' . $slug );
      ?>
      <a href="<?php echo esc_url($url); ?>"
         style="background:#fff;border:1px solid #E5E5E5;border-radius:12px;padding:22px 10px 18px;text-align:center;text-decoration:none;color:#111;font-size:12px;font-weight:600;font-family:Inter,sans-serif;display:flex;flex-direction:column;align-items:center;gap:12px;transition:box-shadow .2s,transform .2s"
         onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.1)';this.style.transform='translateY(-3px)'"
         onmouseout="this.style.boxShadow='none';this.style.transform='none'">
        <div style="width:44px;height:44px;background:#FFF4EF;border-radius:50%;display:flex;align-items:center;justify-content:center">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#E84D00" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 6h18M3 12h18M3 18h18"/>
          </svg>
        </div>
        <span><?php echo esc_html($label); ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── ÖNERILEN ÜRÜNLER ── -->
<section style="padding:60px 32px;background:#fff;width:100%">
  <div style="max-width:1360px;margin:0 auto">
    <h2 style="font-size:22px;font-weight:700;color:#111;margin:0 0 28px;font-family:Inter,sans-serif;letter-spacing:-.025em">Öne Çıkan Ürünler</h2>
    <?php echo do_shortcode('[products limit="8" columns="4" orderby="date" order="DESC"]'); ?>
    <div style="text-align:center;margin-top:36px">
      <a href="<?php echo esc_url( wc_get_page_permalink('shop') ?: home_url('/magaza') ); ?>"
         style="display:inline-block;border:1.5px solid #E84D00;color:#E84D00;padding:12px 32px;border-radius:7px;font-weight:600;font-size:14px;text-decoration:none;font-family:Inter,sans-serif">
        Tüm Ürünleri Gör
      </a>
    </div>
  </div>
</section>

<!-- ── GÜVEN ── -->
<section style="padding:60px 32px;background:#F5F5F5;width:100%">
  <div style="max-width:1360px;margin:0 auto">
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px">
      <?php
      $trust = [
        ['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z M9 12l2 2 4-4','Güvenli Ödeme','SSL korumalı alışveriş'],
        ['M5 12h14 M12 5l7 7-7 7','Ücretsiz Kargo','500₺ ve üzeri siparişlerde'],
        ['M3 12a9 9 0 1018 0 9 9 0 00-18 0 M12 8v4l3 3','Kolay İade','14 gün iade hakkı'],
        ['M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z M14 2v6h6 M16 13H8 M16 17H8 M10 9H8','e-Arşiv Fatura','Her siparişe otomatik'],
      ];
      foreach ( $trust as $t ) : ?>
      <div style="background:#fff;border:1px solid #E5E5E5;border-radius:12px;padding:28px 20px;text-align:center">
        <div style="width:48px;height:48px;background:#FFF4EF;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#E84D00" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="<?php echo esc_attr($t[0]); ?>"/>
          </svg>
        </div>
        <strong style="display:block;font-size:14px;font-weight:700;color:#111;font-family:Inter,sans-serif;margin-bottom:5px"><?php echo esc_html($t[1]); ?></strong>
        <span style="font-size:13px;color:#666;font-family:Inter,sans-serif"><?php echo esc_html($t[2]); ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
