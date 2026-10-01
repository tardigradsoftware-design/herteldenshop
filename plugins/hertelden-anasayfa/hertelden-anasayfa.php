<?php
/**
 * Plugin Name: Hertelden Ana Sayfa
 * Description: E-ticaret ana sayfasını oluşturur ve statik sayfa olarak ayarlar.
 * Version: 2.3
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
    // Boş sayfa yeterli — template_include ile kendi dosyamızı servisliyoruz
    $existing = get_page_by_path( 'ana-sayfa' );
    $data = [
        'post_title'   => 'Ana Sayfa',
        'post_name'    => 'ana-sayfa',
        'post_content' => '',
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

// Ana sayfa için kendi template dosyamızı kullan — WP/Astra'yı bypass eder
add_filter( 'template_include', 'has_template_override', 99 );
function has_template_override( $template ) {
    if ( is_front_page() && ! is_admin() ) {
        $custom = plugin_dir_path( __FILE__ ) . 'templates/homepage.php';
        if ( file_exists( $custom ) ) {
            return $custom;
        }
    }
    return $template;
}
