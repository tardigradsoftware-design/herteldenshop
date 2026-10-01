<?php
/**
 * Plugin Name: Hertelden Tema Pro
 * Description: Global e-ticaret tasarım sistemi — header, navigasyon, ürünler, kategori, checkout, footer.
 * Version: 1.1
 * Author: Hertelden Shop
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', 'htp_fonts', 1 );
function htp_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">' . "\n";
}

add_action( 'wp_head', 'htp_css', 100 );
function htp_css() { ?>
<style id="htp">

/* ═══════════════════════════════════════
   TOKENS
═══════════════════════════════════════ */
:root {
  --c-white:    #FFFFFF;
  --c-bg:       #F5F5F5;
  --c-border:   #E5E5E5;
  --c-border-2: #CCCCCC;
  --c-ink:      #111111;
  --c-ink-2:    #555555;
  --c-ink-3:    #999999;
  --c-accent:   #E84D00;
  --c-accent-h: #C44000;
  --c-sale:     #CC0000;
  --c-success:  #16A34A;
  --c-star:     #F59E0B;
  --r:          8px;
  --r-sm:       4px;
  --r-lg:       12px;
  --sh-sm:  0 1px 4px rgba(0,0,0,.07);
  --sh-md:  0 4px 16px rgba(0,0,0,.10);
  --sh-lg:  0 8px 32px rgba(0,0,0,.12);
}

/* ═══════════════════════════════════════
   GLOBAL RESET
═══════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; }

html { overflow-x: hidden; }

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
  font-size: 14px !important;
  color: var(--c-ink) !important;
  background: var(--c-bg) !important;
  -webkit-font-smoothing: antialiased;
  margin: 0 !important;
  padding: 0 !important;
}

h1,h2,h3,h4,h5,h6 {
  font-family: 'Inter', sans-serif !important;
  font-weight: 700 !important;
  color: var(--c-ink) !important;
  letter-spacing: -.02em;
  line-height: 1.2 !important;
}

a { text-decoration: none; color: inherit; }

/* ═══════════════════════════════════════
   ASTRA CONTAINER — TAM GENİŞLİK
═══════════════════════════════════════ */
/* Astra'nın tüm container kısıtlamalarını kaldır */
.ast-container,
#ast-hf-menu-1 .ast-container,
.main-header-bar .ast-container,
.ast-above-header-wrap .ast-container,
.ast-below-header-wrap .ast-container,
.footer-bar-wrap .ast-container,
.ast-footer-widgets-wrap .ast-container,
.ast-small-footer .ast-container {
  max-width: 100% !important;
  width: 100% !important;
  padding-left: 32px !important;
  padding-right: 32px !important;
}

/* Astra global content width override */
.ast-page-builder-template .hfeed,
.ast-no-sidebar .site-main,
.ast-right-sidebar .site-main,
.ast-left-sidebar .site-main,
#primary,
.content-area,
.site-content {
  max-width: 100% !important;
  width: 100% !important;
}

/* İçerik alanı (sayfa/ürün içi) max-width */
.entry-content > *:not(.hs-hero):not(.hs-cats):not(.hs-products):not(.hs-trust):not([class*="hs-"]),
.woocommerce-page .entry-content,
.site-main .ast-article-single {
  max-width: 1320px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 32px;
  padding-right: 32px;
}

/* ═══════════════════════════════════════
   BİLGİ ÇUBUĞU (üst şerit)
═══════════════════════════════════════ */
.htp-topbar {
  background: var(--c-ink);
  color: rgba(255,255,255,.8);
  font-size: 12px;
  text-align: center;
  padding: 7px 32px;
  letter-spacing: .03em;
  font-family: 'Inter', sans-serif;
  width: 100%;
  position: relative;
  z-index: 1000;
}

/* ═══════════════════════════════════════
   HEADER
═══════════════════════════════════════ */
#masthead,
.site-header,
.ast-primary-header-bar,
.main-header-bar {
  background: var(--c-white) !important;
  border-bottom: 1px solid var(--c-border) !important;
  box-shadow: none !important;
  padding: 0 !important;
  position: sticky !important;
  top: 0 !important;
  z-index: 999 !important;
  width: 100% !important;
}

.main-header-bar .ast-container {
  display: flex !important;
  align-items: center !important;
  height: 64px !important;
  gap: 24px !important;
  overflow: visible !important; /* dropdown'ların kırpılmaması için */
}

/* Dropdown'ın çıkabileceği tüm parent'lar overflow:visible olmalı */
#masthead,
.site-header,
.ast-primary-header-bar,
.main-header-bar,
.ast-site-navigation-wrap,
.ast-main-header-nav-wrap,
.main-navigation,
.ast-nav-menu > li {
  overflow: visible !important;
}

/* Logo sola */
.site-branding,
.ast-logo-container,
.ast-site-identity {
  flex-shrink: 0 !important;
  margin: 0 !important;
}

.site-title {
  margin: 0 !important;
  padding: 0 !important;
  line-height: 1 !important;
}

.site-title a,
.site-title a:visited {
  font-size: 19px !important;
  font-weight: 800 !important;
  color: var(--c-ink) !important;
  letter-spacing: -.04em !important;
  text-decoration: none !important;
}

.custom-logo {
  height: 38px !important;
  width: auto !important;
  display: block !important;
}

/* Navigasyon sağa — genişlik alır */
.ast-site-navigation-wrap,
.ast-main-header-nav-wrap,
.main-navigation {
  flex: 1 !important;
  display: flex !important;
  justify-content: flex-end !important;
  align-items: center !important;
  /* height YOK — dropdown'ın görünmesi için overflow serbest */
  position: relative !important;
}

/* Header sepet ikonu */
.ast-header-woo-cart {
  margin-left: 8px !important;
  flex-shrink: 0 !important;
}

.ast-header-woo-cart .count {
  background: var(--c-accent) !important;
  color: var(--c-white) !important;
  font-size: 10px !important;
  font-weight: 700 !important;
  border-radius: 99px !important;
}

/* ═══════════════════════════════════════
   NAVİGASYON
═══════════════════════════════════════ */
.ast-nav-menu,
#ast-hf-menu-1 ul.menu,
.main-navigation ul.menu {
  display: flex !important;
  align-items: center !important;
  list-style: none !important;
  margin: 0 !important;
  padding: 0 !important;
  gap: 0 !important;
  /* height YOK — dropdown'ların görünmesi için */
  position: static !important;
}

.ast-nav-menu > li > a,
.main-navigation ul.menu > li > a,
#ast-hf-menu-1 ul.menu > li > a {
  font-size: 13.5px !important;
  font-weight: 500 !important;
  color: var(--c-ink) !important;
  padding: 0 14px !important;
  height: 64px !important;
  display: flex !important;
  align-items: center !important;
  white-space: nowrap !important;
  position: relative !important;
  transition: color .15s !important;
  background: transparent !important;
}

.ast-nav-menu > li > a::after,
.main-navigation ul.menu > li > a::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 14px;
  right: 14px;
  height: 2px;
  background: var(--c-accent);
  transform: scaleX(0);
  transition: transform .15s;
}

.ast-nav-menu > li > a:hover,
.main-navigation ul.menu > li > a:hover {
  color: var(--c-accent) !important;
}

.ast-nav-menu > li > a:hover::after,
.ast-nav-menu > li.current-menu-item > a::after,
.ast-nav-menu > li.current-menu-ancestor > a::after {
  transform: scaleX(1);
}

.ast-nav-menu > li.current-menu-item > a,
.ast-nav-menu > li.current-menu-ancestor > a {
  color: var(--c-accent) !important;
}

/* ═══════════════════════════════════════
   MEGA MENÜ — L2 kalın başlık, L3 alt liste
═══════════════════════════════════════ */

/* L1 li — static (panel fixed konumlanıyor) */
.ast-nav-menu > li,
.main-navigation ul.menu > li {
  position: static !important;
}

/* L1 hover: tam genişlik panel */
.ast-nav-menu > li.htp-mega-open > .sub-menu,
.main-navigation ul.menu > li.htp-mega-open > .sub-menu {
  display: flex !important;
  flex-wrap: wrap !important;
  align-items: flex-start !important;
  position: fixed !important;
  left: 0 !important;
  width: 100vw !important;
  background: var(--c-white) !important;
  border-top: 2px solid var(--c-accent) !important;
  border-bottom: 1px solid var(--c-border) !important;
  border-left: none !important;
  border-right: none !important;
  border-radius: 0 !important;
  box-shadow: 0 12px 40px rgba(0,0,0,.12) !important;
  padding: 28px 48px 32px !important;
  gap: 0 !important;
  z-index: 99999 !important;
  min-width: unset !important;
}

/* Panel yokken gizle */
.ast-nav-menu > li > .sub-menu,
.main-navigation ul.menu > li > .sub-menu {
  display: none !important;
}

/* L2 li — kolon bloğu */
.ast-nav-menu > li > .sub-menu > li,
.main-navigation ul.menu > li > .sub-menu > li {
  display: block !important;
  flex: 0 0 auto !important;
  min-width: 160px !important;
  padding: 0 40px 20px 0 !important;
  margin: 0 !important;
  position: static !important;
  background: none !important;
  border: none !important;
}

/* L2 bağlantı = kalın kolon başlığı */
.ast-nav-menu > li > .sub-menu > li > a,
.main-navigation ul.menu > li > .sub-menu > li > a {
  display: block !important;
  font-size: 12px !important;
  font-weight: 700 !important;
  color: var(--c-ink) !important;
  text-transform: uppercase !important;
  letter-spacing: .07em !important;
  padding: 0 0 8px 0 !important;
  margin-bottom: 6px !important;
  border-bottom: 1px solid var(--c-border) !important;
  height: auto !important;
  background: none !important;
  transition: color .12s !important;
  white-space: nowrap !important;
}
.ast-nav-menu > li > .sub-menu > li > a:hover,
.main-navigation ul.menu > li > .sub-menu > li > a:hover {
  color: var(--c-accent) !important;
  background: none !important;
}
.ast-nav-menu > li > .sub-menu > li > a::after { display: none !important; }

/* L3 sub-menu — static, her zaman görünür (panel açıkken) */
.ast-nav-menu > li > .sub-menu > li > .sub-menu,
.main-navigation ul.menu > li > .sub-menu > li > .sub-menu {
  display: block !important;
  position: static !important;
  box-shadow: none !important;
  border: none !important;
  border-radius: 0 !important;
  background: none !important;
  padding: 0 !important;
  min-width: unset !important;
  width: auto !important;
  z-index: auto !important;
}

/* L3 öğe linkleri */
.ast-nav-menu > li > .sub-menu > li > .sub-menu > li > a,
.main-navigation ul.menu > li > .sub-menu > li > .sub-menu > li > a {
  display: block !important;
  font-size: 13px !important;
  font-weight: 400 !important;
  color: var(--c-ink-2) !important;
  padding: 4px 0 !important;
  height: auto !important;
  background: none !important;
  transition: color .12s !important;
  white-space: nowrap !important;
}
.ast-nav-menu > li > .sub-menu > li > .sub-menu > li > a:hover,
.main-navigation ul.menu > li > .sub-menu > li > .sub-menu > li > a:hover {
  color: var(--c-accent) !important;
  background: none !important;
}
.ast-nav-menu > li > .sub-menu > li > .sub-menu > li > a::after { display: none !important; }

/* ═══════════════════════════════════════
   BREADCRUMB
═══════════════════════════════════════ */
.woocommerce-breadcrumb,
.ast-breadcrumbs-wrapper {
  background: var(--c-white) !important;
  border-bottom: 1px solid var(--c-border) !important;
  padding: 10px 32px !important;
  margin: 0 !important;
  font-size: 12.5px !important;
  color: var(--c-ink-3) !important;
  width: 100% !important;
}

.woocommerce-breadcrumb a { color: var(--c-ink-3) !important; }
.woocommerce-breadcrumb a:hover { color: var(--c-accent) !important; }

/* ═══════════════════════════════════════
   MAĞAZA / ARŞİV SAYFASI
═══════════════════════════════════════ */
.woocommerce-archive .site-main,
.tax-product_cat .site-main,
.post-type-archive-product .site-main,
.woocommerce .site-main {
  background: var(--c-bg) !important;
  padding: 24px 32px 56px !important;
  max-width: 100% !important;
}

.woocommerce-shop .ast-container,
.tax-product_cat .ast-container,
.post-type-archive-product .ast-container {
  max-width: 1400px !important;
  margin: 0 auto !important;
}

/* Kategori başlık */
.woocommerce-products-header {
  margin-bottom: 20px !important;
}
.woocommerce-products-header__title {
  font-size: 24px !important;
  font-weight: 700 !important;
  color: var(--c-ink) !important;
  margin: 0 !important;
}

/* Araç çubuğu */
.woocommerce-result-count { font-size: 13px !important; color: var(--c-ink-2) !important; }
.woocommerce-ordering select {
  border: 1px solid var(--c-border-2) !important;
  border-radius: var(--r-sm) !important;
  padding: 7px 28px 7px 10px !important;
  font-size: 13px !important;
  font-family: 'Inter', sans-serif !important;
  background: var(--c-white) !important;
  color: var(--c-ink) !important;
  cursor: pointer;
}

/* ═══════════════════════════════════════
   ÜRÜN KARTLARI
═══════════════════════════════════════ */
.woocommerce ul.products,
.woocommerce-page ul.products {
  display: grid !important;
  grid-template-columns: repeat(4, 1fr) !important;
  gap: 16px !important;
  margin: 0 !important;
  padding: 0 !important;
  list-style: none !important;
  float: none !important;
  width: 100% !important;
}

@media (max-width: 1100px) {
  .woocommerce ul.products,
  .woocommerce-page ul.products {
    grid-template-columns: repeat(3, 1fr) !important;
  }
}
@media (max-width: 680px) {
  .woocommerce ul.products,
  .woocommerce-page ul.products {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 10px !important;
  }
}

.woocommerce ul.products li.product,
.woocommerce-page ul.products li.product {
  background: var(--c-white) !important;
  border: 1px solid var(--c-border) !important;
  border-radius: var(--r-lg) !important;
  padding: 0 !important;
  margin: 0 !important;
  float: none !important;
  width: auto !important;
  display: flex !important;
  flex-direction: column !important;
  overflow: hidden;
  position: relative;
  transition: box-shadow .18s, transform .18s !important;
}

.woocommerce ul.products li.product:hover,
.woocommerce-page ul.products li.product:hover {
  box-shadow: var(--sh-md) !important;
  transform: translateY(-3px) !important;
}

.woocommerce ul.products li.product img {
  width: 100% !important;
  aspect-ratio: 1 / 1 !important;
  object-fit: cover !important;
  border-radius: 0 !important;
  transition: transform .3s !important;
  display: block !important;
}
.woocommerce ul.products li.product:hover img {
  transform: scale(1.05) !important;
}

.woocommerce ul.products li.product .woocommerce-loop-product__title {
  font-size: 13.5px !important;
  font-weight: 500 !important;
  color: var(--c-ink) !important;
  line-height: 1.45 !important;
  margin: 12px 12px 4px !important;
  padding: 0 !important;
  display: -webkit-box !important;
  -webkit-line-clamp: 2 !important;
  -webkit-box-orient: vertical !important;
  overflow: hidden !important;
}

.woocommerce ul.products li.product .price {
  display: block !important;
  margin: 2px 12px 10px !important;
  font-size: 15px !important;
  font-weight: 700 !important;
  color: var(--c-ink) !important;
  padding: 0 !important;
}
.woocommerce ul.products li.product .price ins {
  text-decoration: none !important;
  color: var(--c-accent) !important;
}
.woocommerce ul.products li.product .price del {
  font-size: 11.5px !important;
  font-weight: 400 !important;
  color: var(--c-ink-3) !important;
  margin-right: 4px !important;
}

.woocommerce ul.products li.product .onsale {
  background: var(--c-sale) !important;
  color: #fff !important;
  font-size: 11px !important;
  font-weight: 700 !important;
  border-radius: var(--r-sm) !important;
  padding: 3px 7px !important;
  top: 8px !important;
  left: 8px !important;
  min-height: auto !important;
  min-width: auto !important;
  line-height: 1.4 !important;
  letter-spacing: .03em;
}

.woocommerce ul.products li.product .button,
.woocommerce ul.products li.product .add_to_cart_button {
  display: block !important;
  width: calc(100% - 24px) !important;
  margin: 0 12px 12px !important;
  background: var(--c-accent) !important;
  color: var(--c-white) !important;
  border: none !important;
  border-radius: var(--r) !important;
  padding: 10px 16px !important;
  font-size: 13px !important;
  font-weight: 600 !important;
  font-family: 'Inter', sans-serif !important;
  text-align: center !important;
  cursor: pointer !important;
  transition: background .15s !important;
  text-decoration: none !important;
  box-sizing: border-box !important;
}
.woocommerce ul.products li.product .button:hover {
  background: var(--c-accent-h) !important;
  color: #fff !important;
}

/* ═══════════════════════════════════════
   TEK ÜRÜN SAYFASI
═══════════════════════════════════════ */
.single-product .site-main,
.woocommerce.single-product .site-main {
  background: var(--c-bg) !important;
  padding: 0 !important;
}

.woocommerce div.product {
  background: var(--c-white) !important;
  border-radius: var(--r-lg) !important;
  padding: 32px !important;
  border: 1px solid var(--c-border) !important;
  margin: 24px 32px !important;
}

@media (max-width: 768px) {
  .woocommerce div.product { margin: 12px !important; padding: 20px !important; }
}

.woocommerce div.product div.images img {
  border-radius: var(--r) !important;
}
.woocommerce div.product div.images .flex-control-thumbs {
  margin-top: 10px !important;
  display: flex !important;
  gap: 8px !important;
}
.woocommerce div.product div.images .flex-control-thumbs li {
  float: none !important;
  width: auto !important;
  flex: 1 !important;
}
.woocommerce div.product div.images .flex-control-thumbs img {
  border-radius: var(--r-sm) !important;
  border: 2px solid transparent !important;
  cursor: pointer;
  transition: border-color .15s !important;
}
.woocommerce div.product div.images .flex-control-thumbs .flex-active {
  border-color: var(--c-accent) !important;
}

.woocommerce div.product .product_title {
  font-size: 22px !important;
  font-weight: 700 !important;
  margin-bottom: 12px !important;
}

.woocommerce div.product p.price,
.woocommerce div.product span.price {
  font-size: 28px !important;
  font-weight: 800 !important;
  color: var(--c-accent) !important;
  margin-bottom: 20px !important;
  display: block !important;
}
.woocommerce div.product p.price del { font-size: 16px !important; color: var(--c-ink-3) !important; font-weight: 400 !important; margin-right: 8px !important; }

.woocommerce div.product .woocommerce-product-details__short-description {
  font-size: 14px !important;
  color: var(--c-ink-2) !important;
  line-height: 1.7 !important;
  padding-bottom: 20px !important;
  border-bottom: 1px solid var(--c-border) !important;
  margin-bottom: 20px !important;
}

.woocommerce div.product form.cart {
  display: flex !important;
  align-items: center !important;
  gap: 12px !important;
  flex-wrap: wrap !important;
  margin-bottom: 20px !important;
}

.woocommerce div.product form.cart .qty {
  width: 72px !important;
  border: 1.5px solid var(--c-border-2) !important;
  border-radius: var(--r) !important;
  padding: 10px 12px !important;
  font-size: 15px !important;
  font-weight: 600 !important;
  text-align: center !important;
  font-family: 'Inter', sans-serif !important;
}

.woocommerce div.product form.cart .single_add_to_cart_button {
  background: var(--c-accent) !important;
  color: #fff !important;
  border: none !important;
  border-radius: var(--r) !important;
  padding: 12px 28px !important;
  font-size: 15px !important;
  font-weight: 700 !important;
  font-family: 'Inter', sans-serif !important;
  cursor: pointer !important;
  transition: background .15s !important;
  flex: 1 !important;
  text-align: center !important;
}
.woocommerce div.product form.cart .single_add_to_cart_button:hover {
  background: var(--c-accent-h) !important;
}

/* Tabs */
.woocommerce div.product .woocommerce-tabs ul.tabs {
  border-bottom: 1px solid var(--c-border) !important;
  display: flex !important;
  padding: 0 !important;
  margin-bottom: 0 !important;
  background: none !important;
}
.woocommerce div.product .woocommerce-tabs ul.tabs::before,
.woocommerce div.product .woocommerce-tabs ul.tabs li::before,
.woocommerce div.product .woocommerce-tabs ul.tabs li::after { display: none !important; }
.woocommerce div.product .woocommerce-tabs ul.tabs li {
  background: none !important;
  border: none !important;
  margin: 0 !important;
  padding: 0 !important;
  border-radius: 0 !important;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li a {
  font-size: 14px !important;
  font-weight: 600 !important;
  color: var(--c-ink-2) !important;
  padding: 12px 20px !important;
  display: block !important;
  border-bottom: 2px solid transparent;
  background: none !important;
  transition: color .15s, border-color .15s !important;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover {
  color: var(--c-accent) !important;
  border-bottom-color: var(--c-accent) !important;
}
.woocommerce div.product .woocommerce-tabs .panel {
  background: transparent !important;
  border: none !important;
  margin: 0 !important;
  padding: 24px 0 !important;
  font-size: 14px !important;
  line-height: 1.75 !important;
  color: var(--c-ink-2) !important;
}

/* Varyasyon seçenekleri */
.woocommerce div.product .variations select {
  border: 1.5px solid var(--c-border-2) !important;
  border-radius: var(--r) !important;
  padding: 9px 12px !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 14px !important;
  background: var(--c-white) !important;
}

/* Star rating */
.woocommerce .star-rating span::before { color: var(--c-star) !important; }

/* İlgili ürünler */
.related.products > h2,
.upsells.products > h2 {
  font-size: 18px !important;
  font-weight: 700 !important;
  margin-bottom: 20px !important;
  padding-bottom: 12px !important;
  border-bottom: 1px solid var(--c-border) !important;
}

/* ═══════════════════════════════════════
   SEPET SAYFASI
═══════════════════════════════════════ */
.woocommerce-cart .site-main {
  padding: 24px 32px 56px !important;
}

.woocommerce-cart-form table.cart {
  background: var(--c-white) !important;
  border-radius: var(--r-lg) !important;
  border: 1px solid var(--c-border) !important;
  border-collapse: separate !important;
  border-spacing: 0 !important;
  overflow: hidden;
  width: 100% !important;
}
.woocommerce-cart-form table.cart thead tr th {
  background: var(--c-bg) !important;
  font-size: 12px !important;
  font-weight: 600 !important;
  letter-spacing: .06em !important;
  text-transform: uppercase !important;
  color: var(--c-ink-2) !important;
  padding: 12px 16px !important;
  border-bottom: 1px solid var(--c-border) !important;
}
.woocommerce-cart-form table.cart tbody td {
  padding: 16px !important;
  border-bottom: 1px solid var(--c-border) !important;
  vertical-align: middle !important;
}
.woocommerce-cart-form table.cart td.product-thumbnail img {
  width: 72px !important;
  height: 72px !important;
  object-fit: cover !important;
  border-radius: var(--r) !important;
  border: 1px solid var(--c-border) !important;
}
.woocommerce-cart-form table.cart td.product-name a { font-weight: 600 !important; }
.woocommerce-cart-form table.cart td.product-price,
.woocommerce-cart-form table.cart td.product-subtotal { font-weight: 700 !important; }
.woocommerce-cart-form table.cart td.product-quantity input {
  width: 60px !important;
  border: 1.5px solid var(--c-border-2) !important;
  border-radius: var(--r-sm) !important;
  padding: 6px 8px !important;
  text-align: center !important;
  font-family: 'Inter', sans-serif !important;
}

.cart-collaterals .cart_totals {
  background: var(--c-white) !important;
  border: 1px solid var(--c-border) !important;
  border-radius: var(--r-lg) !important;
  padding: 24px !important;
}
.cart_totals h2 {
  font-size: 16px !important;
  margin-bottom: 16px !important;
  padding-bottom: 12px !important;
  border-bottom: 1px solid var(--c-border) !important;
}
.cart_totals table { width: 100% !important; border-collapse: collapse !important; }
.cart_totals table th,
.cart_totals table td {
  padding: 10px 0 !important;
  border-bottom: 1px solid var(--c-border) !important;
  font-size: 14px !important;
}
.cart_totals table .order-total th,
.cart_totals table .order-total td {
  font-size: 16px !important;
  font-weight: 700 !important;
  border-bottom: none !important;
}
.cart_totals .wc-proceed-to-checkout a {
  display: block !important;
  background: var(--c-accent) !important;
  color: #fff !important;
  text-align: center !important;
  padding: 14px !important;
  border-radius: var(--r) !important;
  font-size: 15px !important;
  font-weight: 700 !important;
  margin-top: 16px !important;
  transition: background .15s !important;
}
.cart_totals .wc-proceed-to-checkout a:hover { background: var(--c-accent-h) !important; }

/* ═══════════════════════════════════════
   CHECKOUT SAYFASI
═══════════════════════════════════════ */
.woocommerce-checkout .site-main { padding: 24px 32px 56px !important; }

.woocommerce-checkout h3 {
  font-size: 16px !important;
  font-weight: 700 !important;
  margin-bottom: 20px !important;
  padding-bottom: 12px !important;
  border-bottom: 1px solid var(--c-border) !important;
}

.woocommerce-checkout .form-row input,
.woocommerce-checkout .form-row select,
.woocommerce-checkout .form-row textarea {
  width: 100% !important;
  border: 1.5px solid var(--c-border-2) !important;
  border-radius: var(--r) !important;
  padding: 10px 12px !important;
  font-size: 14px !important;
  font-family: 'Inter', sans-serif !important;
  background: var(--c-white) !important;
  transition: border-color .15s !important;
  box-shadow: none !important;
}
.woocommerce-checkout .form-row input:focus,
.woocommerce-checkout .form-row select:focus,
.woocommerce-checkout .form-row textarea:focus {
  outline: none !important;
  border-color: var(--c-accent) !important;
}
.woocommerce-checkout .form-row label {
  font-size: 13px !important;
  font-weight: 500 !important;
  color: var(--c-ink-2) !important;
  margin-bottom: 5px !important;
  display: block !important;
}

.woocommerce-checkout #payment {
  background: var(--c-bg) !important;
  border-radius: var(--r-lg) !important;
  padding: 24px !important;
  border: 1px solid var(--c-border) !important;
}

#place_order {
  background: var(--c-accent) !important;
  color: #fff !important;
  border: none !important;
  border-radius: var(--r) !important;
  padding: 14px 32px !important;
  font-size: 16px !important;
  font-weight: 700 !important;
  font-family: 'Inter', sans-serif !important;
  cursor: pointer !important;
  width: 100% !important;
  transition: background .15s !important;
}
#place_order:hover { background: var(--c-accent-h) !important; }

/* ═══════════════════════════════════════
   GENEL BUTONLAR
═══════════════════════════════════════ */
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce #respond input#submit {
  background: var(--c-accent) !important;
  color: #fff !important;
  border-radius: var(--r) !important;
  font-family: 'Inter', sans-serif !important;
  font-weight: 600 !important;
  font-size: 14px !important;
  border: none !important;
  transition: background .15s !important;
  cursor: pointer !important;
}
.woocommerce a.button:hover,
.woocommerce button.button:hover { background: var(--c-accent-h) !important; color: #fff !important; }
.woocommerce a.button.alt,
.woocommerce button.button.alt { background: var(--c-ink) !important; }
.woocommerce a.button.alt:hover { background: #333 !important; }

/* ═══════════════════════════════════════
   FORMLAR
═══════════════════════════════════════ */
input[type=text],input[type=email],input[type=password],
input[type=number],input[type=tel],textarea,select {
  border: 1.5px solid var(--c-border-2) !important;
  border-radius: var(--r) !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 14px !important;
  color: var(--c-ink) !important;
  background: var(--c-white) !important;
  transition: border-color .15s !important;
}
input:focus,textarea:focus,select:focus {
  outline: none !important;
  border-color: var(--c-accent) !important;
  box-shadow: 0 0 0 3px rgba(232,77,0,.1) !important;
}

/* ═══════════════════════════════════════
   NOTICE / MESAJLAR
═══════════════════════════════════════ */
.woocommerce-message { border-left-color: var(--c-success) !important; }
.woocommerce-info { border-left-color: #3B82F6 !important; }
.woocommerce-error { border-left-color: var(--c-sale) !important; }
.woocommerce-message::before { color: var(--c-success) !important; }
.woocommerce-info::before { color: #3B82F6 !important; }

/* ═══════════════════════════════════════
   SAYFALAMA
═══════════════════════════════════════ */
.woocommerce-pagination ul,
nav.woocommerce-pagination {
  margin: 32px 0 !important;
  text-align: center !important;
}
.woocommerce-pagination ul {
  display: inline-flex !important;
  gap: 6px !important;
  list-style: none !important;
  padding: 0 !important;
}
.woocommerce-pagination ul li a,
.woocommerce-pagination ul li span {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  width: 36px !important;
  height: 36px !important;
  border-radius: var(--r-sm) !important;
  border: 1px solid var(--c-border) !important;
  font-size: 13.5px !important;
  font-weight: 500 !important;
  color: var(--c-ink-2) !important;
  background: var(--c-white) !important;
  transition: all .15s !important;
}
.woocommerce-pagination ul li a:hover { border-color: var(--c-accent) !important; color: var(--c-accent) !important; }
.woocommerce-pagination ul li span.current {
  background: var(--c-accent) !important;
  border-color: var(--c-accent) !important;
  color: #fff !important;
  font-weight: 700 !important;
}

/* ═══════════════════════════════════════
   SIDEBAR WIDGET
═══════════════════════════════════════ */
#secondary .widget,
.widget-area .widget {
  background: var(--c-white) !important;
  border: 1px solid var(--c-border) !important;
  border-radius: var(--r-lg) !important;
  padding: 20px !important;
  margin-bottom: 16px !important;
}
#secondary .widget-title,
.widget-area .widget-title {
  font-size: 14px !important;
  font-weight: 700 !important;
  margin-bottom: 14px !important;
  padding-bottom: 10px !important;
  border-bottom: 1px solid var(--c-border) !important;
}
.widget_price_filter .ui-slider-range,
.widget_price_filter .ui-slider-handle { background: var(--c-accent) !important; }
.widget_product_categories ul li a { font-size: 13.5px !important; color: var(--c-ink-2) !important; }
.widget_product_categories ul li a:hover { color: var(--c-accent) !important; }

/* ═══════════════════════════════════════
   FOOTER
═══════════════════════════════════════ */
.site-footer,
#colophon {
  background: #111111 !important;
  color: rgba(255,255,255,.7) !important;
  margin-top: 0 !important;
  padding-top: 0 !important;
  width: 100% !important;
}

.ast-footer-widgets-wrap,
.ast-footer-widgets {
  background: #111111 !important;
  padding: 56px 32px 40px !important;
}

.ast-footer-widgets-wrap .widget-title,
.site-footer .widget-title {
  color: var(--c-white) !important;
  font-size: 12.5px !important;
  font-weight: 700 !important;
  letter-spacing: .08em !important;
  text-transform: uppercase !important;
  margin-bottom: 16px !important;
  padding-bottom: 10px !important;
  border-bottom: 1px solid rgba(255,255,255,.12) !important;
}
.site-footer .widget ul { list-style: none !important; padding: 0 !important; margin: 0 !important; }
.site-footer .widget ul li { margin-bottom: 8px !important; }
.site-footer .widget ul li a { color: rgba(255,255,255,.6) !important; font-size: 13.5px !important; transition: color .15s !important; }
.site-footer .widget ul li a:hover { color: var(--c-white) !important; }
.site-footer .widget p { color: rgba(255,255,255,.6) !important; font-size: 13.5px !important; line-height: 1.7 !important; }

.ast-small-footer,
.footer-bar-wrap {
  background: #0A0A0A !important;
  border-top: 1px solid rgba(255,255,255,.08) !important;
  padding: 14px 32px !important;
  width: 100% !important;
}
.ast-small-footer p,
.ast-small-footer .ast-footer-copyright {
  font-size: 12.5px !important;
  color: rgba(255,255,255,.4) !important;
  margin: 0 !important;
}
.ast-small-footer a { color: rgba(255,255,255,.55) !important; }
.ast-small-footer a:hover { color: var(--c-white) !important; }

/* ═══════════════════════════════════════
   MOBİL
═══════════════════════════════════════ */
@media (max-width: 921px) {
  .ast-header-break-point .main-header-bar .ast-container { height: 56px !important; }
  .ast-header-break-point body::before { display: none; }

  .ast-header-break-point .main-header-bar-navigation {
    background: var(--c-white) !important;
    border-top: 1px solid var(--c-border) !important;
    box-shadow: var(--sh-lg) !important;
  }
  .ast-header-break-point .main-navigation .menu-item a {
    font-size: 15px !important;
    padding: 13px 20px !important;
    border-bottom: 1px solid var(--c-border) !important;
    color: var(--c-ink) !important;
    height: auto !important;
  }
  .ast-header-break-point .main-navigation .menu-item a:hover {
    background: #FFF4EF !important;
    color: var(--c-accent) !important;
  }

  .woocommerce-cart .site-main,
  .woocommerce-checkout .site-main,
  .woocommerce-archive .site-main,
  .single-product .site-main { padding: 16px !important; }

  .woocommerce div.product { margin: 12px !important; padding: 16px !important; }
  .ast-footer-widgets-wrap { padding: 40px 20px 28px !important; }
  .ast-small-footer { padding: 12px 20px !important; }
}

@media (max-width: 600px) {
  .ast-container,
  .main-header-bar .ast-container {
    padding-left: 16px !important;
    padding-right: 16px !important;
  }
}

/* ═══════════════════════════════════════
   YARDIMCI
═══════════════════════════════════════ */
body.admin-bar #masthead { top: 32px !important; }
body.admin-bar .htp-mega-open > .sub-menu { margin-top: 32px !important; }
@media (max-width: 782px) { body.admin-bar #masthead { top: 46px !important; } }


.clear,
.woocommerce .col2-set::after { display: none !important; }
.woocommerce .col2-set {
  display: grid !important;
  grid-template-columns: 1fr 1fr !important;
  gap: 24px !important;
}
@media (max-width: 640px) {
  .woocommerce .col2-set { grid-template-columns: 1fr !important; }
}

</style>

<?php
// Topbar enjekte et
add_action( 'wp_body_open', function() {
    if ( ! is_admin() ) {
        echo '<div class="htp-topbar">Ücretsiz kargo &nbsp;·&nbsp; 500₺ ve üzeri tüm siparişler &nbsp;·&nbsp; Güvenli ödeme</div>';
    }
} );

// Mega menü JS
add_action( 'wp_footer', function() {
    if ( is_admin() ) return;
    ?>
<script>
(function(){
  document.addEventListener('DOMContentLoaded', function(){
    var items = document.querySelectorAll('.ast-nav-menu > li, .main-navigation ul.menu > li');
    if (!items.length) return;

    function headerBottom() {
      var h = document.querySelector('#masthead, .main-header-bar, .site-header');
      return h ? Math.round(h.getBoundingClientRect().bottom) : 64;
    }

    items.forEach(function(li){
      var sub = li.querySelector(':scope > .sub-menu');
      if (!sub) return;
      var t;
      function open(){ clearTimeout(t); sub.style.top = headerBottom()+'px'; li.classList.add('htp-mega-open'); }
      function close(){ t = setTimeout(function(){ li.classList.remove('htp-mega-open'); }, 80); }
      li.addEventListener('mouseenter', open);
      li.addEventListener('mouseleave', close);
      sub.addEventListener('mouseenter', function(){ clearTimeout(t); });
      sub.addEventListener('mouseleave', close);
    });
  });
})();
</script>
    <?php
} );

}
