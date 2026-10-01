<?php
/**
 * Plugin Name: Hertelden Menüler
 * Description: Footer ve Ana navigasyon menülerini otomatik oluşturur ve konumlara atar.
 * Version: 1.0
 * Author: Hertelden Shop
 */

if ( ! defined( 'ABSPATH' ) ) exit;

register_activation_hook( __FILE__, 'hm_create_menus' );

add_action( 'admin_menu', 'hm_admin_menu' );
function hm_admin_menu() {
    add_management_page(
        'Hertelden Menüler',
        'Hertelden Menüler',
        'manage_options',
        'hertelden-menuler',
        'hm_admin_page'
    );
}

function hm_admin_page() {
    $result = '';
    if ( isset( $_POST['hm_run'] ) && check_admin_referer( 'hm_run_action' ) ) {
        $result = hm_create_menus();
    }
    ?>
    <div class="wrap">
        <h1>Hertelden Menüler</h1>
        <p>Footer ve Ana navigasyon menülerini oluşturur ve konumlara atar.</p>
        <form method="post">
            <?php wp_nonce_field( 'hm_run_action' ); ?>
            <p><input type="submit" name="hm_run" class="button button-primary button-large" value="Menüleri Oluştur / Güncelle"></p>
        </form>
        <?php if ( $result ) echo $result; ?>
    </div>
    <?php
}

function hm_create_menus() {
    $log = [];

    // ── 1. FOOTER MENÜSÜ ──────────────────────────────────────────
    $footer_menu_name = 'Footer Menüsü';
    $footer_menu_id   = hm_get_or_create_menu( $footer_menu_name );

    // Yasal sayfalar
    $footer_pages = [
        'gizlilik-politikasi'      => 'Gizlilik Politikası ve KVKK',
        'mesafeli-satis-sozlesmesi' => 'Mesafeli Satış Sözleşmesi',
        'iptal-iade-kosullari'     => 'İptal ve İade Koşulları',
    ];

    // Önce mevcut öğeleri temizle
    $existing_items = wp_get_nav_menu_items( $footer_menu_id );
    if ( $existing_items ) {
        foreach ( $existing_items as $item ) {
            wp_delete_post( $item->ID, true );
        }
    }

    foreach ( $footer_pages as $slug => $label ) {
        $page = get_page_by_path( $slug );
        if ( $page ) {
            wp_update_nav_menu_item( $footer_menu_id, 0, [
                'menu-item-title'     => $label,
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $page->ID,
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ] );
        }
    }

    // Footer menüsünü konuma ata
    hm_assign_menu( $footer_menu_id, 'footer' );
    $log[] = 'Footer Menüsü oluşturuldu (3 yasal sayfa).';

    // ── 2. ANA MENÜ ───────────────────────────────────────────────
    $main_menu_name = 'Ana Menü';
    $main_menu_id   = hm_get_or_create_menu( $main_menu_name );

    // Mevcut öğeleri temizle
    $existing_items = wp_get_nav_menu_items( $main_menu_id );
    if ( $existing_items ) {
        foreach ( $existing_items as $item ) {
            wp_delete_post( $item->ID, true );
        }
    }

    // L1 kategoriler (slug => görünen ad)
    $l1_cats = [
        'sofra'              => 'Sofra',
        'mutfak'             => 'Mutfak',
        'kucuk-ev-aletleri'  => 'Küçük Ev Aletleri',
        'hertelden-home'     => 'Hertelden Home',
        'online-ozel'        => 'Online Özel',
        'koleksiyonlar'      => 'Koleksiyonlar',
        'kampanyalar'        => 'Kampanyalar',
        'evlilik-paketleri'  => 'Evlilik Paketleri',
    ];

    foreach ( $l1_cats as $slug => $label ) {
        $term = get_term_by( 'slug', $slug, 'product_cat' );
        if ( $term ) {
            wp_update_nav_menu_item( $main_menu_id, 0, [
                'menu-item-title'     => $label,
                'menu-item-object'    => 'product_cat',
                'menu-item-object-id' => $term->term_id,
                'menu-item-type'      => 'taxonomy',
                'menu-item-status'    => 'publish',
            ] );
        }
    }

    // Ana menüyü konuma ata (Astra: primary / main-menu)
    hm_assign_menu( $main_menu_id, 'primary' );
    hm_assign_menu( $main_menu_id, 'main-menu' );
    $log[] = 'Ana Menü oluşturuldu (8 L1 kategori).';

    $html  = '<div class="notice notice-success"><p><strong>Tamamlandı!</strong><br>';
    $html .= implode( '<br>', $log );
    $html .= '</p></div>';
    return $html;
}

function hm_get_or_create_menu( $name ) {
    $existing = wp_get_nav_menu_object( $name );
    if ( $existing ) return $existing->term_id;
    $id = wp_create_nav_menu( $name );
    return is_wp_error( $id ) ? 0 : $id;
}

function hm_assign_menu( $menu_id, $location ) {
    $locations = get_theme_mod( 'nav_menu_locations', [] );
    $locations[ $location ] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );
}
