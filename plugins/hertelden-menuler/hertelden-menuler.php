<?php
/**
 * Plugin Name: Hertelden Menüler
 * Description: Footer ve Ana navigasyon menülerini (L1+L2+L3) oluşturur; Max Mega Menu ayarlarını otomatik yapar.
 * Version: 2.1
 * Author: Hertelden Shop
 */

if ( ! defined( 'ABSPATH' ) ) exit;

register_activation_hook( __FILE__, 'hm_create_menus' );

add_action( 'admin_menu', 'hm_admin_menu' );
function hm_admin_menu() {
    add_management_page( 'Hertelden Menüler', 'Hertelden Menüler', 'manage_options', 'hertelden-menuler', 'hm_admin_page' );
}
function hm_admin_page() {
    $result = '';
    if ( isset( $_POST['hm_run'] ) && check_admin_referer( 'hm_run_action' ) ) {
        $result = hm_create_menus();
    }
    if ( isset( $_POST['hm_mega'] ) && check_admin_referer( 'hm_mega_action' ) ) {
        $result = hm_apply_megamenu_to_current_menu();
    }
    ?>
    <div class="wrap">
        <h1>Hertelden Menüler</h1>

        <h2>1. Menüleri Oluştur</h2>
        <p>Footer ve Ana navigasyon menülerini (L1 + L2 + L3) oluşturur veya günceller.</p>
        <form method="post"><?php wp_nonce_field( 'hm_run_action' ); ?>
            <p><input type="submit" name="hm_run" class="button button-primary button-large" value="Menüleri Oluştur / Güncelle"></p>
        </form>

        <h2>2. Max Mega Menu Ayarlarını Uygula</h2>
        <p>Mevcut Ana Menü'deki tüm L1 öğelerine Max Mega Menu "full-width panel" ayarını yazar. Önce Menüyü Oluştur, sonra bu butona bas.</p>
        <form method="post"><?php wp_nonce_field( 'hm_mega_action' ); ?>
            <p><input type="submit" name="hm_mega" class="button button-secondary button-large" value="Max Mega Menu Ayarlarını Uygula"></p>
        </form>

        <?php if ( $result ) echo $result; ?>
    </div>
    <?php
}

function hm_create_menus() {
    $log = [];

    // ── 1. FOOTER MENÜSÜ ──────────────────────────────────────────
    $footer_id = hm_get_or_create_menu( 'Footer Menüsü' );
    hm_clear_menu( $footer_id );

    $footer_pages = [
        'gizlilik-politikasi'       => 'Gizlilik Politikası ve KVKK',
        'mesafeli-satis-sozlesmesi'  => 'Mesafeli Satış Sözleşmesi',
        'iptal-iade-kosullari'       => 'İptal ve İade Koşulları',
    ];
    foreach ( $footer_pages as $slug => $label ) {
        $page = get_page_by_path( $slug );
        if ( $page ) {
            wp_update_nav_menu_item( $footer_id, 0, [
                'menu-item-title'     => $label,
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $page->ID,
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ] );
        }
    }
    hm_assign_menu( $footer_id, 'footer' );
    $log[] = 'Footer Menüsü: 3 yasal sayfa eklendi.';

    // ── 2. ANA MENÜ (L1 + L2 + L3) ───────────────────────────────
    $main_id = hm_get_or_create_menu( 'Ana Menü' );
    hm_clear_menu( $main_id );

    $l1_cats = [
        'sofra'             => 'Sofra',
        'mutfak'            => 'Mutfak',
        'kucuk-ev-aletleri' => 'Küçük Ev Aletleri',
        'hertelden-home'    => 'Hertelden Home',
        'online-ozel'       => 'Online Özel',
        'koleksiyonlar'     => 'Koleksiyonlar',
        'kampanyalar'       => 'Kampanyalar',
        'evlilik-paketleri' => 'Evlilik Paketleri',
    ];

    $l1_item_ids = [];
    $l1_position = 0;

    foreach ( $l1_cats as $slug => $label ) {
        $l1_term = get_term_by( 'slug', $slug, 'product_cat' );
        if ( ! $l1_term ) continue;
        $l1_position++;

        $l1_item_id = wp_update_nav_menu_item( $main_id, 0, [
            'menu-item-title'     => $label,
            'menu-item-object'    => 'product_cat',
            'menu-item-object-id' => $l1_term->term_id,
            'menu-item-type'      => 'taxonomy',
            'menu-item-status'    => 'publish',
            'menu-item-parent-id' => 0,
            'menu-item-position'  => $l1_position,
        ] );

        if ( is_wp_error( $l1_item_id ) ) continue;
        $l1_item_ids[] = $l1_item_id;

        // L2 alt kategoriler
        $l2_terms = get_terms( [
            'taxonomy'   => 'product_cat',
            'parent'     => $l1_term->term_id,
            'hide_empty' => false,
            'number'     => 30,
            'orderby'    => 'menu_order',
            'order'      => 'ASC',
        ] );

        if ( ! $l2_terms || is_wp_error( $l2_terms ) ) continue;

        $l2_position = 0;
        foreach ( $l2_terms as $l2_term ) {
            $l2_position++;
            $l2_item_id = wp_update_nav_menu_item( $main_id, 0, [
                'menu-item-title'     => $l2_term->name,
                'menu-item-object'    => 'product_cat',
                'menu-item-object-id' => $l2_term->term_id,
                'menu-item-type'      => 'taxonomy',
                'menu-item-status'    => 'publish',
                'menu-item-parent-id' => $l1_item_id,
                'menu-item-position'  => $l2_position,
            ] );

            if ( is_wp_error( $l2_item_id ) ) continue;

            // L3 alt kategoriler
            $l3_terms = get_terms( [
                'taxonomy'   => 'product_cat',
                'parent'     => $l2_term->term_id,
                'hide_empty' => false,
                'number'     => 20,
                'orderby'    => 'menu_order',
                'order'      => 'ASC',
            ] );

            if ( ! $l3_terms || is_wp_error( $l3_terms ) ) continue;

            $l3_position = 0;
            foreach ( $l3_terms as $l3_term ) {
                $l3_position++;
                wp_update_nav_menu_item( $main_id, 0, [
                    'menu-item-title'     => $l3_term->name,
                    'menu-item-object'    => 'product_cat',
                    'menu-item-object-id' => $l3_term->term_id,
                    'menu-item-type'      => 'taxonomy',
                    'menu-item-status'    => 'publish',
                    'menu-item-parent-id' => $l2_item_id,
                    'menu-item-position'  => $l3_position,
                ] );
            }
        }
    }

    hm_assign_menu( $main_id, 'primary' );
    hm_assign_menu( $main_id, 'main-menu' );
    $log[] = 'Ana Menü: 8 L1 + L2 + L3 kategoriler eklendi.';

    // ── 3. MAX MEGA MENU — L1 öğelerine otomatik ayar ─────────────
    if ( ! empty( $l1_item_ids ) ) {
        $mega_count = hm_setup_megamenu( $l1_item_ids );
        if ( $mega_count > 0 ) {
            $log[] = "Max Mega Menu: {$mega_count} L1 kategori için mega panel etkinleştirildi.";
        } else {
            $log[] = 'Max Mega Menu: eklenti bulunamadı veya ayar yazılamadı.';
        }
    }

    $html  = '<div class="notice notice-success"><p><strong>Tamamlandı!</strong><br>';
    $html .= implode( '<br>', $log );
    $html .= '</p></div>';
    return $html;
}

/**
 * Max Mega Menu — menü oluşturma sırasında meta yaz (fallback).
 */
function hm_setup_megamenu( array $l1_item_ids ) {
    $count = 0;
    foreach ( $l1_item_ids as $item_id ) {
        hm_write_megamenu_meta( $item_id );
        $count++;
    }
    return $count;
}

/**
 * Max Mega Menu — mevcut Ana Menü'den L1 öğeleri okuyarak meta yazar.
 * "Max Mega Menu Ayarlarını Uygula" butonuna bağlı.
 */
function hm_apply_megamenu_to_current_menu() {
    $menu = wp_get_nav_menu_object( 'Ana Menü' );
    if ( ! $menu ) {
        return '<div class="notice notice-error"><p>Ana Menü bulunamadı. Önce menüyü oluştur.</p></div>';
    }

    $items = wp_get_nav_menu_items( $menu->term_id, [ 'update_post_term_cache' => false ] );
    if ( ! $items ) {
        return '<div class="notice notice-error"><p>Menü öğesi bulunamadı.</p></div>';
    }

    $l1_count = 0;
    foreach ( $items as $item ) {
        if ( (int) $item->menu_item_parent === 0 ) {
            hm_write_megamenu_meta( $item->ID );
            $l1_count++;
        }
    }

    // Max Mega Menu tema ayarı — "Birincil menü" lokasyonu için mega etkin
    hm_ensure_megamenu_location( $menu->term_id );

    return '<div class="notice notice-success"><p><strong>Tamamlandı!</strong> ' . $l1_count . ' L1 öğesine Max Mega Menu full-width panel ayarı yazıldı.</p></div>';
}

/**
 * Tek bir nav menu item'ına Max Mega Menu meta'sını yaz.
 */
function hm_write_megamenu_meta( $item_id ) {
    // Mevcut ayarları oku, yoksa boş array
    $existing = get_post_meta( $item_id, '_megamenu', true );
    if ( ! is_array( $existing ) ) $existing = [];

    $settings = array_merge( $existing, [
        'enabled'                          => 'true',
        'panel_width'                      => 'full_width',
        'panel_position'                   => 'left',
        'panel_columns_mobile_breakpoint'  => '768',
        'hide_arrow'                       => false,
        'disable_link'                     => false,
        'item_align'                       => 'left',
    ] );

    update_post_meta( $item_id, '_megamenu', $settings );
}

/**
 * Max Mega Menu'nün menu_locations option'ına bu menüyü ekle.
 */
function hm_ensure_megamenu_location( $menu_id ) {
    $option_key = 'megamenu_settings';
    $settings   = get_option( $option_key, [] );

    // Tüm kayıtlı location'ları tara, "primary" veya "Birincil" içereni bul
    $nav_locs = get_registered_nav_menus();
    foreach ( array_keys( $nav_locs ) as $loc ) {
        $assigned = get_nav_menu_locations();
        if ( isset( $assigned[ $loc ] ) && (int) $assigned[ $loc ] === (int) $menu_id ) {
            if ( ! isset( $settings['locations'][ $loc ] ) ) {
                $settings['locations'][ $loc ] = [ 'enabled' => 1 ];
            } else {
                $settings['locations'][ $loc ]['enabled'] = 1;
            }
        }
    }

    update_option( $option_key, $settings );
}

function hm_clear_menu( $menu_id ) {
    $items = wp_get_nav_menu_items( $menu_id );
    if ( $items ) {
        foreach ( $items as $item ) {
            wp_delete_post( $item->ID, true );
        }
    }
}

function hm_get_or_create_menu( $name ) {
    $existing = wp_get_nav_menu_object( $name );
    if ( $existing ) return $existing->term_id;
    $id = wp_create_nav_menu( $name );
    return is_wp_error( $id ) ? 0 : $id;
}

function hm_assign_menu( $menu_id, $location ) {
    $locations            = get_theme_mod( 'nav_menu_locations', [] );
    $locations[$location] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );
}
