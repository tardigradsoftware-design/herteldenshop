<?php
/**
 * Plugin Name: Hertelden Tema Pro
 * Description: Global e-ticaret tasarım sistemi — tüm sayfa türleri için eksiksiz CSS ve WooCommerce entegrasyonu.
 * Version: 1.0
 * Author: Hertelden Shop
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', 'htp_fonts', 1 );
function htp_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">' . "\n";
}

add_action( 'wp_head', 'htp_css', 100 );
function htp_css() { ?>
<style id="htp">

/* ═══════════════════════════════════════════════
   DESIGN TOKENS
═══════════════════════════════════════════════ */
:root {
  --c-white:     #FFFFFF;
  --c-bg:        #F5F5F5;
  --c-surface:   #FFFFFF;
  --c-border:    #E5E5E5;
  --c-border-2:  #D4D4D4;
  --c-ink:       #111111;
  --c-ink-2:     #525252;
  --c-ink-3:     #A3A3A3;
  --c-accent:    #E84D00;
  --c-accent-h:  #C44000;
  --c-accent-bg: #FFF4EF;
  --c-sale:      #CC0000;
  --c-success:   #16A34A;
  --c-star:      #F59E0B;

  --r-sm:   4px;
  --r-md:   8px;
  --r-lg:   12px;
  --r-xl:   16px;
  --r-full: 999px;

  --shadow-sm:  0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
  --shadow-md:  0 4px 12px rgba(0,0,0,.10), 0 2px 4px rgba(0,0,0,.06);
  --shadow-lg:  0 8px 24px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
  --shadow-xl:  0 16px 48px rgba(0,0,0,.14);

  --t-fast:   150ms ease;
  --t-base:   200ms ease;
  --t-slow:   300ms ease;

  --w-content: 1280px;
  --gap:       24px;
}

/* ═══════════════════════════════════════════════
   GLOBAL RESET & TYPOGRAPHY
═══════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; }

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
  font-size: 14px !important;
  line-height: 1.6 !important;
  color: var(--c-ink) !important;
  background: var(--c-bg) !important;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

h1, h2, h3, h4, h5, h6 {
  font-family: 'Inter', sans-serif !important;
  font-weight: 700 !important;
  line-height: 1.25 !important;
  color: var(--c-ink) !important;
  letter-spacing: -.02em;
}

a { color: var(--c-ink); text-decoration: none; }
a:hover { color: var(--c-accent); }

img { max-width: 100%; height: auto; display: block; }

/* ═══════════════════════════════════════════════
   LAYOUT WRAPPER
═══════════════════════════════════════════════ */
.ast-container,
.site-content .ast-container {
  max-width: var(--w-content) !important;
  padding-left: 20px !important;
  padding-right: 20px !important;
}

/* ═══════════════════════════════════════════════
   TOP BAR (opsiyonel bilgi şeridi)
═══════════════════════════════════════════════ */
body::before {
  content: 'Ücretsiz kargo · 500₺ ve üzeri tüm siparişler · Güvenli ödeme';
  display: block;
  background: var(--c-ink);
  color: rgba(255,255,255,.85);
  font-size: 12px;
  text-align: center;
  padding: 7px 20px;
  letter-spacing: .03em;
  font-family: 'Inter', sans-serif;
}

/* ═══════════════════════════════════════════════
   HEADER
═══════════════════════════════════════════════ */
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
  z-index: 1000 !important;
}

.main-header-bar .ast-container {
  height: 64px;
  display: flex !important;
  align-items: center !important;
  gap: 32px !important;
}

/* Logo */
.ast-logo-container,
.site-branding,
.site-title {
  flex-shrink: 0 !important;
}
.site-title a {
  font-size: 20px !important;
  font-weight: 800 !important;
  color: var(--c-ink) !important;
  letter-spacing: -.04em;
}
.site-title a span { color: var(--c-accent); }
.custom-logo { height: 36px !important; width: auto !important; }

/* Arama kutusu - header ortası */
.ast-header-search,
.header-search-wrap {
  flex: 1 !important;
  max-width: 560px !important;
}
.ast-header-search form,
.search-form {
  display: flex !important;
  border: 1.5px solid var(--c-border-2) !important;
  border-radius: var(--r-full) !important;
  overflow: hidden;
  transition: border-color var(--t-fast);
  background: var(--c-bg) !important;
}
.ast-header-search form:focus-within,
.search-form:focus-within {
  border-color: var(--c-accent) !important;
  background: var(--c-white) !important;
}
.ast-header-search input[type=search],
.search-form .search-field {
  flex: 1 !important;
  border: none !important;
  outline: none !important;
  background: transparent !important;
  padding: 9px 16px !important;
  font-size: 13.5px !important;
  font-family: 'Inter', sans-serif !important;
  color: var(--c-ink) !important;
  box-shadow: none !important;
}
.ast-header-search button,
.search-form .search-submit {
  background: var(--c-accent) !important;
  color: var(--c-white) !important;
  border: none !important;
  padding: 0 18px !important;
  cursor: pointer;
  font-size: 14px !important;
  transition: background var(--t-fast);
  display: flex;
  align-items: center;
  justify-content: center;
}
.ast-header-search button:hover,
.search-form .search-submit:hover {
  background: var(--c-accent-h) !important;
}

/* Header sağ ikonlar */
.ast-header-woo-cart .count,
.woocommerce-cart-link .count {
  background: var(--c-accent) !important;
  color: var(--c-white) !important;
  font-size: 10px !important;
  font-weight: 700 !important;
  border-radius: var(--r-full) !important;
  padding: 1px 5px !important;
  line-height: 1.4 !important;
}

/* ═══════════════════════════════════════════════
   PRIMARY NAVIGATION
═══════════════════════════════════════════════ */
#ast-hf-menu-1,
.ast-nav-menu,
.main-navigation,
.ast-primary-menu-disabled + .main-header-bar .ast-main-header-wrap {
  background: var(--c-white) !important;
}

.main-navigation {
  border-top: 1px solid var(--c-border) !important;
}

.main-navigation .ast-container {
  height: 44px !important;
  display: flex !important;
  align-items: center !important;
  padding: 0 20px !important;
}

/* Nav items */
.ast-nav-menu > li > a,
.main-navigation ul > li > a {
  font-size: 13.5px !important;
  font-weight: 500 !important;
  color: var(--c-ink) !important;
  padding: 0 14px !important;
  height: 44px !important;
  display: flex !important;
  align-items: center !important;
  white-space: nowrap !important;
  transition: color var(--t-fast) !important;
  position: relative;
}
.ast-nav-menu > li > a:hover,
.main-navigation ul > li > a:hover,
.ast-nav-menu > li.current-menu-item > a,
.ast-nav-menu > li.current-menu-ancestor > a {
  color: var(--c-accent) !important;
}
.ast-nav-menu > li > a::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 14px;
  right: 14px;
  height: 2px;
  background: var(--c-accent);
  transform: scaleX(0);
  transition: transform var(--t-fast);
}
.ast-nav-menu > li > a:hover::after,
.ast-nav-menu > li.current-menu-item > a::after {
  transform: scaleX(1);
}

/* Dropdown */
.ast-nav-menu .sub-menu,
.main-navigation .sub-menu {
  background: var(--c-white) !important;
  border: 1px solid var(--c-border) !important;
  border-radius: var(--r-md) !important;
  box-shadow: var(--shadow-lg) !important;
  min-width: 200px !important;
  padding: 8px 0 !important;
  top: calc(100% + 4px) !important;
}
.ast-nav-menu .sub-menu li a,
.main-navigation .sub-menu li a {
  font-size: 13.5px !important;
  padding: 9px 16px !important;
  color: var(--c-ink-2) !important;
  transition: background var(--t-fast), color var(--t-fast) !important;
  display: block !important;
  height: auto !important;
}
.ast-nav-menu .sub-menu li a:hover,
.main-navigation .sub-menu li a:hover {
  background: var(--c-accent-bg) !important;
  color: var(--c-accent) !important;
}

/* ═══════════════════════════════════════════════
   PAGE CANVAS
═══════════════════════════════════════════════ */
.site-content,
#content {
  background: var(--c-bg) !important;
  padding-top: 0 !important;
}

/* Content area white card */
.entry-content,
.woocommerce-page .entry-content,
.ast-article-single,
article.page .entry-content {
  background: transparent !important;
}

/* ═══════════════════════════════════════════════
   BREADCRUMB
═══════════════════════════════════════════════ */
.woocommerce-breadcrumb,
.ast-breadcrumbs-wrapper,
.rank-math-breadcrumb {
  background: var(--c-white) !important;
  padding: 10px 0 !important;
  margin: 0 0 0 0 !important;
  font-size: 12.5px !important;
  color: var(--c-ink-3) !important;
  border-bottom: 1px solid var(--c-border) !important;
}
.woocommerce-breadcrumb a,
.ast-breadcrumbs-wrapper a,
.rank-math-breadcrumb a {
  color: var(--c-ink-3) !important;
}
.woocommerce-breadcrumb a:hover,
.rank-math-breadcrumb a:hover {
  color: var(--c-accent) !important;
}

/* ═══════════════════════════════════════════════
   CATEGORY / SHOP ARCHIVE — LAYOUT
═══════════════════════════════════════════════ */
.woocommerce-archive .site-main,
.tax-product_cat .site-main,
.post-type-archive-product .site-main {
  padding: 20px 0 48px !important;
}

/* Kategori başlığı */
.woocommerce-products-header {
  background: var(--c-white) !important;
  padding: 24px 0 !important;
  margin-bottom: 20px !important;
  border-bottom: 1px solid var(--c-border) !important;
}
.woocommerce-products-header__title {
  font-size: 22px !important;
  font-weight: 700 !important;
  color: var(--c-ink) !important;
  margin: 0 !important;
}

/* Toolbar (sıralama + ürün sayısı) */
.woocommerce-ordering,
.woocommerce-result-count {
  font-size: 13px !important;
  color: var(--c-ink-2) !important;
  font-family: 'Inter', sans-serif !important;
}
.woocommerce-ordering select {
  border: 1px solid var(--c-border) !important;
  border-radius: var(--r-sm) !important;
  padding: 6px 28px 6px 10px !important;
  font-size: 13px !important;
  font-family: 'Inter', sans-serif !important;
  background-color: var(--c-white) !important;
  color: var(--c-ink) !important;
  cursor: pointer;
}

/* ═══════════════════════════════════════════════
   PRODUCT CARDS — THE CORE
═══════════════════════════════════════════════ */
.woocommerce ul.products,
.woocommerce-page ul.products {
  display: grid !important;
  grid-template-columns: repeat(4, 1fr) !important;
  gap: 16px !important;
  margin: 0 !important;
  padding: 0 !important;
  list-style: none !important;
}

@media (max-width: 1024px) {
  .woocommerce ul.products,
  .woocommerce-page ul.products {
    grid-template-columns: repeat(3, 1fr) !important;
  }
}
@media (max-width: 640px) {
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
  display: flex !important;
  flex-direction: column !important;
  transition: box-shadow var(--t-base), transform var(--t-base) !important;
  overflow: hidden;
  position: relative;
  cursor: pointer;
}
.woocommerce ul.products li.product:hover,
.woocommerce-page ul.products li.product:hover {
  box-shadow: var(--shadow-md) !important;
  transform: translateY(-2px) !important;
}

/* Ürün görseli */
.woocommerce ul.products li.product a.woocommerce-loop-product__link,
.woocommerce ul.products li.product > a:first-child {
  display: block !important;
}
.woocommerce ul.products li.product img {
  width: 100% !important;
  aspect-ratio: 1 / 1 !important;
  object-fit: cover !important;
  border-radius: 0 !important;
  transition: transform var(--t-slow) !important;
}
.woocommerce ul.products li.product:hover img {
  transform: scale(1.04) !important;
}

/* Ürün içerik alanı */
.woocommerce ul.products li.product .woocommerce-loop-product__link + *,
.woocommerce ul.products li.product h2,
.woocommerce ul.products li.product .woocommerce-loop-product__title {
  padding: 0 !important;
}

/* Tüm metin alanı wrapper */
.woocommerce ul.products li.product .product-inner,
.woocommerce ul.products li.product > a + span,
.woocommerce ul.products li.product > a.add_to_cart_button {
  padding: 12px !important;
}

.woocommerce ul.products li.product .woocommerce-loop-product__title {
  font-size: 13.5px !important;
  font-weight: 500 !important;
  color: var(--c-ink) !important;
  line-height: 1.45 !important;
  margin: 12px 12px 4px !important;
  display: -webkit-box !important;
  -webkit-line-clamp: 2 !important;
  -webkit-box-orient: vertical !important;
  overflow: hidden !important;
}

/* Fiyat */
.woocommerce ul.products li.product .price {
  display: block !important;
  margin: 4px 12px 12px !important;
  font-size: 15px !important;
  font-weight: 700 !important;
  color: var(--c-ink) !important;
}
.woocommerce ul.products li.product .price ins {
  text-decoration: none !important;
  color: var(--c-accent) !important;
}
.woocommerce ul.products li.product .price del {
  font-size: 12px !important;
  color: var(--c-ink-3) !important;
  font-weight: 400 !important;
  margin-right: 4px !important;
}

/* İndirim rozeti */
.woocommerce ul.products li.product .onsale {
  background: var(--c-sale) !important;
  color: var(--c-white) !important;
  font-size: 11px !important;
  font-weight: 700 !important;
  border-radius: var(--r-sm) !important;
  padding: 3px 7px !important;
  top: 10px !important;
  left: 10px !important;
  min-height: auto !important;
  min-width: auto !important;
  line-height: 1.4 !important;
  letter-spacing: .03em;
}

/* Sepete ekle butonu */
.woocommerce ul.products li.product .button,
.woocommerce ul.products li.product .add_to_cart_button {
  display: block !important;
  width: calc(100% - 24px) !important;
  margin: 0 12px 12px !important;
  background: var(--c-accent) !important;
  color: var(--c-white) !important;
  border: none !important;
  border-radius: var(--r-md) !important;
  padding: 10px 16px !important;
  font-size: 13px !important;
  font-weight: 600 !important;
  font-family: 'Inter', sans-serif !important;
  text-align: center !important;
  cursor: pointer !important;
  transition: background var(--t-fast) !important;
  letter-spacing: .01em;
}
.woocommerce ul.products li.product .button:hover,
.woocommerce ul.products li.product .add_to_cart_button:hover {
  background: var(--c-accent-h) !important;
  color: var(--c-white) !important;
}

/* ═══════════════════════════════════════════════
   SINGLE PRODUCT PAGE
═══════════════════════════════════════════════ */
.woocommerce div.product {
  background: var(--c-white) !important;
  border-radius: var(--r-lg) !important;
  padding: 32px !important;
  box-shadow: none !important;
  border: 1px solid var(--c-border) !important;
  margin: 24px 0 !important;
}

/* Ürün görseli */
.woocommerce div.product div.images {
  border-radius: var(--r-md) !important;
  overflow: hidden !important;
}
.woocommerce div.product div.images img {
  border-radius: var(--r-md) !important;
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
.woocommerce div.product div.images .flex-control-thumbs li img {
  border-radius: var(--r-sm) !important;
  border: 2px solid transparent !important;
  cursor: pointer;
  transition: border-color var(--t-fast) !important;
}
.woocommerce div.product div.images .flex-control-thumbs li img.flex-active {
  border-color: var(--c-accent) !important;
}

/* Ürün başlık ve fiyat */
.woocommerce div.product .product_title {
  font-size: 22px !important;
  font-weight: 700 !important;
  line-height: 1.3 !important;
  margin-bottom: 12px !important;
  color: var(--c-ink) !important;
}
.woocommerce div.product p.price,
.woocommerce div.product span.price {
  font-size: 26px !important;
  font-weight: 800 !important;
  color: var(--c-accent) !important;
  margin-bottom: 20px !important;
  display: block !important;
}
.woocommerce div.product p.price del,
.woocommerce div.product span.price del {
  font-size: 16px !important;
  color: var(--c-ink-3) !important;
  font-weight: 400 !important;
  margin-right: 8px !important;
}

/* Rating */
.woocommerce div.product .woocommerce-product-rating {
  margin-bottom: 16px !important;
}
.woocommerce .star-rating span::before { color: var(--c-star) !important; }

/* Ürün özeti metin */
.woocommerce div.product .woocommerce-product-details__short-description {
  font-size: 14px !important;
  color: var(--c-ink-2) !important;
  line-height: 1.7 !important;
  margin-bottom: 20px !important;
  padding-bottom: 20px !important;
  border-bottom: 1px solid var(--c-border) !important;
}

/* Miktar + sepet */
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
  border-radius: var(--r-md) !important;
  padding: 10px 12px !important;
  font-size: 15px !important;
  font-weight: 600 !important;
  text-align: center !important;
  font-family: 'Inter', sans-serif !important;
  color: var(--c-ink) !important;
}
.woocommerce div.product form.cart .single_add_to_cart_button,
.woocommerce #respond input#submit,
.woocommerce a.button,
.woocommerce button.button {
  background: var(--c-accent) !important;
  color: var(--c-white) !important;
  border: none !important;
  border-radius: var(--r-md) !important;
  padding: 12px 28px !important;
  font-size: 15px !important;
  font-weight: 700 !important;
  font-family: 'Inter', sans-serif !important;
  cursor: pointer !important;
  transition: background var(--t-fast) !important;
  letter-spacing: .01em;
}
.woocommerce div.product form.cart .single_add_to_cart_button:hover {
  background: var(--c-accent-h) !important;
}

/* Meta (SKU, kategori) */
.woocommerce div.product .product_meta {
  font-size: 12.5px !important;
  color: var(--c-ink-3) !important;
  margin-top: 16px !important;
  padding-top: 16px !important;
  border-top: 1px solid var(--c-border) !important;
}
.woocommerce div.product .product_meta a {
  color: var(--c-ink-2) !important;
}
.woocommerce div.product .product_meta a:hover {
  color: var(--c-accent) !important;
}

/* Tabs */
.woocommerce div.product .woocommerce-tabs ul.tabs {
  border-bottom: 1px solid var(--c-border) !important;
  margin-bottom: 0 !important;
  padding: 0 !important;
  display: flex;
  gap: 0;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li {
  background: transparent !important;
  border: none !important;
  margin: 0 !important;
  padding: 0 !important;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li a {
  font-size: 14px !important;
  font-weight: 600 !important;
  color: var(--c-ink-2) !important;
  padding: 12px 20px !important;
  display: block;
  border-bottom: 2px solid transparent;
  transition: color var(--t-fast), border-color var(--t-fast) !important;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover {
  color: var(--c-accent) !important;
  border-bottom-color: var(--c-accent) !important;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li::before,
.woocommerce div.product .woocommerce-tabs ul.tabs li::after,
.woocommerce div.product .woocommerce-tabs ul.tabs::before { display: none !important; }
.woocommerce div.product .woocommerce-tabs .panel {
  margin: 0 !important;
  padding: 24px 0 !important;
  background: transparent !important;
  border: none !important;
  font-size: 14px !important;
  color: var(--c-ink-2) !important;
  line-height: 1.75 !important;
}

/* İlgili ürünler */
.related.products,
.upsells.products,
.cross-sells {
  margin-top: 48px !important;
}
.related.products > h2,
.upsells.products > h2 {
  font-size: 18px !important;
  font-weight: 700 !important;
  margin-bottom: 20px !important;
  padding-bottom: 12px !important;
  border-bottom: 1px solid var(--c-border) !important;
}

/* ═══════════════════════════════════════════════
   CART PAGE
═══════════════════════════════════════════════ */
.woocommerce-cart .woocommerce {
  background: transparent !important;
}

.woocommerce-cart-form table.cart {
  background: var(--c-white) !important;
  border-radius: var(--r-lg) !important;
  border: 1px solid var(--c-border) !important;
  border-collapse: separate !important;
  border-spacing: 0 !important;
  overflow: hidden;
  margin-bottom: 24px !important;
}
.woocommerce-cart-form table.cart thead tr th {
  background: var(--c-bg) !important;
  color: var(--c-ink-2) !important;
  font-size: 12px !important;
  font-weight: 600 !important;
  letter-spacing: .06em !important;
  text-transform: uppercase !important;
  padding: 12px 16px !important;
  border-bottom: 1px solid var(--c-border) !important;
}
.woocommerce-cart-form table.cart tbody td {
  padding: 16px !important;
  border-bottom: 1px solid var(--c-border) !important;
  vertical-align: middle !important;
  font-size: 14px !important;
}
.woocommerce-cart-form table.cart tbody tr:last-child td { border-bottom: none !important; }

.woocommerce-cart-form table.cart td.product-thumbnail img {
  width: 72px !important;
  height: 72px !important;
  object-fit: cover !important;
  border-radius: var(--r-md) !important;
  border: 1px solid var(--c-border) !important;
}
.woocommerce-cart-form table.cart td.product-name a {
  font-weight: 600 !important;
  color: var(--c-ink) !important;
}
.woocommerce-cart-form table.cart td.product-price,
.woocommerce-cart-form table.cart td.product-subtotal {
  font-weight: 700 !important;
  color: var(--c-ink) !important;
}

.woocommerce-cart-form table.cart td.product-quantity input {
  width: 60px !important;
  border: 1.5px solid var(--c-border-2) !important;
  border-radius: var(--r-sm) !important;
  padding: 6px 8px !important;
  text-align: center !important;
  font-family: 'Inter', sans-serif !important;
}

/* Sepet totals */
.cart-collaterals .cart_totals {
  background: var(--c-white) !important;
  border: 1px solid var(--c-border) !important;
  border-radius: var(--r-lg) !important;
  padding: 24px !important;
}
.cart_totals h2 {
  font-size: 16px !important;
  font-weight: 700 !important;
  margin-bottom: 16px !important;
  padding-bottom: 12px !important;
  border-bottom: 1px solid var(--c-border) !important;
}
.cart_totals table {
  width: 100% !important;
  border-collapse: collapse !important;
}
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
  color: var(--c-ink) !important;
}
.cart_totals .wc-proceed-to-checkout a {
  display: block !important;
  background: var(--c-accent) !important;
  color: var(--c-white) !important;
  text-align: center !important;
  padding: 14px !important;
  border-radius: var(--r-md) !important;
  font-size: 15px !important;
  font-weight: 700 !important;
  font-family: 'Inter', sans-serif !important;
  margin-top: 16px !important;
  transition: background var(--t-fast) !important;
}
.cart_totals .wc-proceed-to-checkout a:hover {
  background: var(--c-accent-h) !important;
}

/* ═══════════════════════════════════════════════
   CHECKOUT PAGE
═══════════════════════════════════════════════ */
.woocommerce-checkout #customer_details,
.woocommerce-checkout #order_review_heading + #order_review {
  background: var(--c-white) !important;
  border: 1px solid var(--c-border) !important;
  border-radius: var(--r-lg) !important;
  padding: 28px !important;
}

.woocommerce-checkout h3 {
  font-size: 16px !important;
  font-weight: 700 !important;
  margin-bottom: 20px !important;
  padding-bottom: 12px !important;
  border-bottom: 1px solid var(--c-border) !important;
}

.woocommerce-checkout .form-row label {
  font-size: 13px !important;
  font-weight: 500 !important;
  color: var(--c-ink-2) !important;
  margin-bottom: 5px !important;
  display: block !important;
}
.woocommerce-checkout .form-row input,
.woocommerce-checkout .form-row select,
.woocommerce-checkout .form-row textarea {
  width: 100% !important;
  border: 1.5px solid var(--c-border-2) !important;
  border-radius: var(--r-md) !important;
  padding: 10px 12px !important;
  font-size: 14px !important;
  font-family: 'Inter', sans-serif !important;
  color: var(--c-ink) !important;
  background: var(--c-white) !important;
  transition: border-color var(--t-fast) !important;
  box-shadow: none !important;
}
.woocommerce-checkout .form-row input:focus,
.woocommerce-checkout .form-row select:focus,
.woocommerce-checkout .form-row textarea:focus {
  outline: none !important;
  border-color: var(--c-accent) !important;
}

/* Ödeme kutuları */
.woocommerce-checkout #payment {
  background: var(--c-bg) !important;
  border-radius: var(--r-lg) !important;
  padding: 24px !important;
  border: 1px solid var(--c-border) !important;
}
.woocommerce-checkout #payment ul.payment_methods {
  border-bottom: 1px solid var(--c-border) !important;
  padding-bottom: 16px !important;
  margin-bottom: 16px !important;
}
.woocommerce-checkout #payment ul.payment_methods li {
  padding: 10px 12px !important;
  border-radius: var(--r-sm) !important;
  transition: background var(--t-fast) !important;
}
.woocommerce-checkout #payment ul.payment_methods li:hover {
  background: var(--c-white) !important;
}

/* Sipariş ver butonu */
#place_order {
  background: var(--c-accent) !important;
  color: var(--c-white) !important;
  border: none !important;
  border-radius: var(--r-md) !important;
  padding: 14px 32px !important;
  font-size: 16px !important;
  font-weight: 700 !important;
  font-family: 'Inter', sans-serif !important;
  cursor: pointer !important;
  width: 100% !important;
  letter-spacing: .01em;
  transition: background var(--t-fast) !important;
}
#place_order:hover { background: var(--c-accent-h) !important; }

/* ═══════════════════════════════════════════════
   ACCOUNT PAGES
═══════════════════════════════════════════════ */
.woocommerce-account .woocommerce {
  background: var(--c-white) !important;
  border: 1px solid var(--c-border) !important;
  border-radius: var(--r-lg) !important;
  padding: 28px !important;
  margin: 24px 0 !important;
}
.woocommerce-account .woocommerce-MyAccount-navigation {
  border-right: 1px solid var(--c-border) !important;
  padding-right: 24px !important;
}
.woocommerce-account .woocommerce-MyAccount-navigation ul {
  list-style: none !important;
  padding: 0 !important;
  margin: 0 !important;
}
.woocommerce-account .woocommerce-MyAccount-navigation ul li a {
  display: block !important;
  padding: 9px 12px !important;
  border-radius: var(--r-sm) !important;
  font-size: 13.5px !important;
  color: var(--c-ink-2) !important;
  font-weight: 500 !important;
  transition: background var(--t-fast), color var(--t-fast) !important;
}
.woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a,
.woocommerce-account .woocommerce-MyAccount-navigation ul li a:hover {
  background: var(--c-accent-bg) !important;
  color: var(--c-accent) !important;
}

/* ═══════════════════════════════════════════════
   MESSAGES & NOTICES
═══════════════════════════════════════════════ */
.woocommerce-message,
.woocommerce-info,
.woocommerce-error,
.wc-block-components-notice-banner {
  border-radius: var(--r-md) !important;
  border-left-width: 4px !important;
  font-size: 14px !important;
  font-family: 'Inter', sans-serif !important;
}
.woocommerce-message { border-left-color: var(--c-success) !important; }
.woocommerce-info { border-left-color: #3B82F6 !important; }
.woocommerce-error { border-left-color: var(--c-sale) !important; }
.woocommerce-message::before { color: var(--c-success) !important; }
.woocommerce-info::before { color: #3B82F6 !important; }
.woocommerce-error::before { color: var(--c-sale) !important; }

/* ═══════════════════════════════════════════════
   FORMS — GENEL
═══════════════════════════════════════════════ */
input[type=text],
input[type=email],
input[type=password],
input[type=number],
input[type=tel],
textarea,
select {
  border: 1.5px solid var(--c-border-2) !important;
  border-radius: var(--r-md) !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 14px !important;
  color: var(--c-ink) !important;
  background: var(--c-white) !important;
  transition: border-color var(--t-fast) !important;
}
input:focus, textarea:focus, select:focus {
  outline: none !important;
  border-color: var(--c-accent) !important;
  box-shadow: 0 0 0 3px rgba(232,77,0,.12) !important;
}

/* ═══════════════════════════════════════════════
   BUTONLAR — GENEL
═══════════════════════════════════════════════ */
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce #respond input#submit {
  background: var(--c-accent) !important;
  color: var(--c-white) !important;
  border-radius: var(--r-md) !important;
  font-family: 'Inter', sans-serif !important;
  font-weight: 600 !important;
  font-size: 14px !important;
  border: none !important;
  transition: background var(--t-fast) !important;
  cursor: pointer !important;
}
.woocommerce a.button:hover,
.woocommerce button.button:hover {
  background: var(--c-accent-h) !important;
  color: var(--c-white) !important;
}
.woocommerce a.button.alt,
.woocommerce button.button.alt {
  background: var(--c-ink) !important;
}
.woocommerce a.button.alt:hover { background: #333 !important; }

/* ═══════════════════════════════════════════════
   PAGINATION
═══════════════════════════════════════════════ */
.woocommerce-pagination ul,
.page-numbers {
  display: flex !important;
  gap: 6px !important;
  list-style: none !important;
  padding: 0 !important;
  justify-content: center !important;
  margin: 32px 0 !important;
}
.woocommerce-pagination ul li a,
.woocommerce-pagination ul li span,
.page-numbers li a,
.page-numbers li span {
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
  transition: all var(--t-fast) !important;
}
.woocommerce-pagination ul li a:hover,
.page-numbers li a:hover {
  border-color: var(--c-accent) !important;
  color: var(--c-accent) !important;
}
.woocommerce-pagination ul li span.current,
.page-numbers li span.current {
  background: var(--c-accent) !important;
  border-color: var(--c-accent) !important;
  color: var(--c-white) !important;
  font-weight: 700 !important;
}

/* ═══════════════════════════════════════════════
   FOOTER
═══════════════════════════════════════════════ */
.site-footer,
#colophon {
  background: #111111 !important;
  color: rgba(255,255,255,.75) !important;
  margin-top: 0 !important;
  padding-top: 0 !important;
}

.ast-footer-widgets-wrap,
.ast-footer-widgets {
  background: #111111 !important;
  padding: 56px 0 40px !important;
}

/* Footer widget başlıkları */
.ast-footer-widgets-wrap .widget-title,
.site-footer .widget-title {
  color: var(--c-white) !important;
  font-size: 13px !important;
  font-weight: 700 !important;
  letter-spacing: .08em !important;
  text-transform: uppercase !important;
  margin-bottom: 16px !important;
  padding-bottom: 10px !important;
  border-bottom: 1px solid rgba(255,255,255,.12) !important;
}

/* Footer linkler */
.site-footer .widget ul,
.ast-footer-widgets-wrap .widget ul {
  list-style: none !important;
  padding: 0 !important;
  margin: 0 !important;
}
.site-footer .widget ul li,
.ast-footer-widgets-wrap .widget ul li {
  margin-bottom: 8px !important;
}
.site-footer .widget ul li a,
.ast-footer-widgets-wrap .widget ul li a {
  color: rgba(255,255,255,.65) !important;
  font-size: 13.5px !important;
  transition: color var(--t-fast) !important;
}
.site-footer .widget ul li a:hover,
.ast-footer-widgets-wrap .widget ul li a:hover {
  color: var(--c-white) !important;
}

/* Footer metin widgetları */
.site-footer .widget p,
.ast-footer-widgets-wrap .widget p {
  color: rgba(255,255,255,.6) !important;
  font-size: 13.5px !important;
  line-height: 1.7 !important;
}

/* Footer alt çubuk */
.ast-small-footer,
.footer-bar-wrap {
  background: #0A0A0A !important;
  border-top: 1px solid rgba(255,255,255,.08) !important;
  padding: 14px 20px !important;
}
.ast-small-footer .ast-footer-copyright,
.ast-small-footer p {
  font-size: 12.5px !important;
  color: rgba(255,255,255,.45) !important;
  margin: 0 !important;
}
.ast-small-footer a {
  color: rgba(255,255,255,.55) !important;
}
.ast-small-footer a:hover { color: var(--c-white) !important; }

/* ═══════════════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════════════ */
#secondary,
.widget-area {
  font-size: 14px !important;
}
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
  color: var(--c-ink) !important;
  margin-bottom: 14px !important;
  padding-bottom: 10px !important;
  border-bottom: 1px solid var(--c-border) !important;
}

/* Fiyat filtresi slider */
.widget_price_filter .price_slider_wrapper .ui-widget-content {
  background: var(--c-border) !important;
}
.widget_price_filter .price_slider_wrapper .ui-slider-range,
.widget_price_filter .price_slider_wrapper .ui-slider-handle {
  background: var(--c-accent) !important;
}

/* Kategori widget */
.widget_product_categories ul li a {
  color: var(--c-ink-2) !important;
  font-size: 13.5px !important;
  transition: color var(--t-fast) !important;
}
.widget_product_categories ul li a:hover {
  color: var(--c-accent) !important;
}

/* ═══════════════════════════════════════════════
   ANA SAYFA OVERRİDE (hertelden-anasayfa plugin ile birlikte)
═══════════════════════════════════════════════ */
body.home,
body.page-template-default.home {
  background: var(--c-bg) !important;
}
body.home .entry-content > section {
  margin-left: calc(50% - 50vw) !important;
  margin-right: calc(50% - 50vw) !important;
  padding-left: calc(50vw - 50%) !important;
  padding-right: calc(50vw - 50%) !important;
}

/* ═══════════════════════════════════════════════
   SCROLL TO TOP (minimal)
═══════════════════════════════════════════════ */
#scroll-to-top,
.ast-scroll-top {
  background: var(--c-accent) !important;
  border-radius: var(--r-full) !important;
  border: none !important;
}

/* ═══════════════════════════════════════════════
   ASTRA THEME SPECIFIC OVERRIDES
═══════════════════════════════════════════════ */
/* Astra'nın varsayılan mavi/mor renklerini sıfırla */
:root {
  --ast-global-color-0: var(--c-accent) !important;
  --ast-global-color-2: var(--c-ink) !important;
}
.ast-builder-layout-element .ast-site-header-cart .count {
  background: var(--c-accent) !important;
}
.ast-primary-header-bar .ast-search-icon .ast-icon {
  color: var(--c-ink-2) !important;
}
/* Astra içerik padding */
.ast-page-builder-template .hfeed, .ast-no-sidebar.ast-right-sidebar .site-main {
  padding-top: 0 !important;
}

/* ═══════════════════════════════════════════════
   LOADING SKELETON (opsiyonel görsel iyileştirme)
═══════════════════════════════════════════════ */
@keyframes shimmer {
  0% { background-position: -800px 0; }
  100% { background-position: 800px 0; }
}

/* ═══════════════════════════════════════════════
   MOBILE MENU
═══════════════════════════════════════════════ */
@media (max-width: 921px) {
  .ast-header-break-point .main-header-bar {
    padding: 0 16px !important;
    height: 56px !important;
  }
  .ast-header-break-point .ast-mobile-menu-trigger-minimal {
    color: var(--c-ink) !important;
  }
  .ast-header-break-point .ast-above-header-bar,
  body::before { display: none !important; }

  /* Mobile nav panel */
  .ast-header-break-point .main-header-bar-navigation {
    background: var(--c-white) !important;
    border-top: 1px solid var(--c-border) !important;
    box-shadow: var(--shadow-xl) !important;
  }
  .ast-header-break-point .main-navigation .menu-item a {
    font-size: 15px !important;
    padding: 12px 20px !important;
    border-bottom: 1px solid var(--c-border) !important;
    color: var(--c-ink) !important;
  }
  .ast-header-break-point .main-navigation .menu-item a:hover {
    background: var(--c-accent-bg) !important;
    color: var(--c-accent) !important;
  }
}

/* ═══════════════════════════════════════════════
   UTILITY
═══════════════════════════════════════════════ */
.woocommerce-page .woocommerce > * { margin-bottom: 0 !important; }
.woocommerce .col2-set { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 24px !important; }
@media (max-width: 640px) {
  .woocommerce .col2-set { grid-template-columns: 1fr !important; }
}
.clear { display: none !important; }

/* WordPress admin bar compensate */
body.admin-bar::before { display: none !important; }

</style>
<?php } ?>
