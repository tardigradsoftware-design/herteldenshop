<?php
/**
 * Plugin Name: Hertelden Kategoriler
 * Description: Tüm ürün kategorilerini ve Rank Math SEO verilerini tek tıkla oluşturur.
 * Version: 1.0
 * Author: Hertelden Shop
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', 'hk_admin_menu' );
function hk_admin_menu() {
    add_management_page(
        'Hertelden Kategoriler',
        'Hertelden Kategoriler',
        'manage_options',
        'hertelden-kategoriler',
        'hk_admin_page'
    );
}

function hk_admin_page() {
    $result = '';
    if ( isset( $_POST['hk_run'] ) && check_admin_referer( 'hk_run_action' ) ) {
        $result = hk_create_categories();
    }
    ?>
    <div class="wrap">
        <h1>Hertelden Kategoriler</h1>
        <p>Bu araç, mağazanın tüm ürün kategorilerini (<strong>~130 kategori</strong>) hiyerarşik olarak oluşturur ve her birine Rank Math SEO verisi (başlık, açıklama, odak kelime) ekler.</p>
        <p><strong>Tekrar çalıştırmak güvenlidir</strong> — varolan kategoriler atlanır, eksikler eklenir.</p>
        <form method="post">
            <?php wp_nonce_field( 'hk_run_action' ); ?>
            <p><input type="submit" name="hk_run" class="button button-primary button-large" value="Kategorileri Oluştur / Güncelle"></p>
        </form>
        <?php if ( $result ) echo $result; ?>
    </div>
    <?php
}

function hk_create_categories() {
    $categories = hk_get_category_data();
    $created = 0;
    $skipped = 0;
    $errors  = [];
    $term_ids = [];

    foreach ( $categories as $cat ) {
        $parent_id = 0;
        if ( ! empty( $cat['parent_slug'] ) ) {
            if ( isset( $term_ids[ $cat['parent_slug'] ] ) ) {
                $parent_id = $term_ids[ $cat['parent_slug'] ];
            } else {
                $existing_parent = get_term_by( 'slug', $cat['parent_slug'], 'product_cat' );
                if ( $existing_parent ) {
                    $parent_id = $existing_parent->term_id;
                    $term_ids[ $cat['parent_slug'] ] = $parent_id;
                }
            }
        }

        $existing = get_term_by( 'slug', $cat['slug'], 'product_cat' );
        if ( $existing ) {
            $term_id = $existing->term_id;
            $skipped++;
        } else {
            $args = [ 'slug' => $cat['slug'] ];
            if ( $parent_id ) $args['parent'] = $parent_id;
            if ( ! empty( $cat['description'] ) ) $args['description'] = $cat['description'];

            $result = wp_insert_term( $cat['name'], 'product_cat', $args );
            if ( is_wp_error( $result ) ) {
                $errors[] = $cat['name'] . ': ' . $result->get_error_message();
                continue;
            }
            $term_id = $result['term_id'];
            $created++;
        }

        $term_ids[ $cat['slug'] ] = $term_id;

        // Rank Math SEO
        if ( ! empty( $cat['seo_title'] ) )
            update_term_meta( $term_id, 'rank_math_title', $cat['seo_title'] );
        if ( ! empty( $cat['seo_description'] ) )
            update_term_meta( $term_id, 'rank_math_description', $cat['seo_description'] );
        if ( ! empty( $cat['seo_focus_keyword'] ) )
            update_term_meta( $term_id, 'rank_math_focus_keyword', $cat['seo_focus_keyword'] );
    }

    $html  = '<div class="notice notice-success"><p>';
    $html .= "<strong>Tamamlandı:</strong> {$created} kategori oluşturuldu, {$skipped} zaten vardı.";
    $html .= '</p></div>';
    if ( $errors ) {
        $html .= '<div class="notice notice-error"><p><strong>Hatalar:</strong><br>' . implode( '<br>', $errors ) . '</p></div>';
    }
    return $html;
}

function hk_get_category_data() {
    return [

        /* =====================================================
           L1 — KATALOG
        ===================================================== */
        [
            'name'              => 'Sofra',
            'slug'              => 'sofra',
            'parent_slug'       => '',
            'seo_title'         => 'Sofra Ürünleri | Hertelden Shop',
            'seo_description'   => 'Yemek takımları, çatal kaşık bıçak, servis setleri ve daha fazlası. Sofra düzeniyle fark yarat — Hertelden Shop\'ta en uygun fiyatlar.',
            'seo_focus_keyword' => 'sofra ürünleri',
        ],
        [
            'name'              => 'Mutfak',
            'slug'              => 'mutfak',
            'parent_slug'       => '',
            'seo_title'         => 'Mutfak Ürünleri | Hertelden Shop',
            'seo_description'   => 'Tencere setleri, mutfak gereçleri, saklama kapları ve içecek hazırlama ürünleri. Mutfağınızı Hertelden Shop ile donatın.',
            'seo_focus_keyword' => 'mutfak ürünleri',
        ],
        [
            'name'              => 'Küçük Ev Aletleri',
            'slug'              => 'kucuk-ev-aletleri',
            'parent_slug'       => '',
            'seo_title'         => 'Küçük Ev Aletleri | Hertelden Shop',
            'seo_description'   => 'Tost makinesi, blender, kahve makinesi, çay makinesi ve daha fazlası. Uygun fiyatlı küçük ev aletleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'küçük ev aletleri',
        ],
        [
            'name'              => 'Hertelden Home',
            'slug'              => 'hertelden-home',
            'parent_slug'       => '',
            'seo_title'         => 'Hertelden Home — Ev Tekstili ve Yaşam | Hertelden Shop',
            'seo_description'   => 'Yatak odası tekstili, banyo ürünleri, çeyiz setleri ve ev gereçleri. Evinizi Hertelden Home koleksiyonuyla güzelleştirin.',
            'seo_focus_keyword' => 'hertelden home ev tekstili',
        ],

        /* =====================================================
           L1 — VİTRİN
        ===================================================== */
        [
            'name'              => 'Online Özel',
            'slug'              => 'online-ozel',
            'parent_slug'       => '',
            'seo_title'         => 'Online Özel Ürünler | Hertelden Shop',
            'seo_description'   => 'Sadece Hertelden Shop\'ta bulunan özel setler ve exclusive ürünler. Fırsatları kaçırmadan keşfedin.',
            'seo_focus_keyword' => 'online özel ürünler',
        ],
        [
            'name'              => 'Koleksiyonlar',
            'slug'              => 'koleksiyonlar',
            'parent_slug'       => '',
            'seo_title'         => 'Koleksiyonlar | Hertelden Shop',
            'seo_description'   => 'Renk, malzeme ve tasarıma göre özenle seçilmiş koleksiyonlar. Hertelden Shop imzalı seriler bir arada.',
            'seo_focus_keyword' => 'hertelden koleksiyonlar',
        ],
        [
            'name'              => 'Kampanyalar',
            'slug'              => 'kampanyalar',
            'parent_slug'       => '',
            'seo_title'         => 'Kampanyalı Ürünler | Hertelden Shop',
            'seo_description'   => 'Dönemsel indirimler ve özel kampanyalar. Hertelden Shop\'ta en iyi fırsatları yakalayın.',
            'seo_focus_keyword' => 'kampanyalı ev ürünleri',
        ],
        [
            'name'              => 'Evlilik Paketleri',
            'slug'              => 'evlilik-paketleri',
            'parent_slug'       => '',
            'seo_title'         => 'Evlilik Paketleri ve Çeyiz Setleri | Hertelden Shop',
            'seo_description'   => 'Çeyiz listenizi tamamlayacak evlilik paketleri. Sofra, yatak odası ve banyo setleri tek pakette Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'evlilik paketi çeyiz seti',
        ],

        /* =====================================================
           SOFRA — L2
        ===================================================== */
        [
            'name'              => 'Yemek Takımı',
            'slug'              => 'yemek-takimi',
            'parent_slug'       => 'sofra',
            'seo_title'         => 'Yemek Takımı Fiyatları | Hertelden Shop',
            'seo_description'   => '6, 8 ve 12 kişilik porselen yemek takımları. Günlük kullanım ve özel davetler için şık yemek takımları Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'yemek takımı',
        ],
        [
            'name'              => 'Çatal Kaşık Bıçak Takımı',
            'slug'              => 'catal-kasik-bicak',
            'parent_slug'       => 'sofra',
            'seo_title'         => 'Çatal Kaşık Bıçak Takımı | Hertelden Shop',
            'seo_description'   => '6 ve 12 kişilik çatal kaşık bıçak takımları. Paslanmaz çelik, dayanıklı ve şık tasarım — Hertelden Shop\'ta uygun fiyatlarla.',
            'seo_focus_keyword' => 'çatal kaşık bıçak takımı',
        ],
        [
            'name'              => 'Kahvaltı & Pasta Sunum Setleri',
            'slug'              => 'kahvalti-pasta',
            'parent_slug'       => 'sofra',
            'seo_title'         => 'Kahvaltı Takımı ve Pasta Setleri | Hertelden Shop',
            'seo_description'   => 'Porselen ve seramik kahvaltı takımları, pasta sunum setleri. Sabah kahvaltısını şölenine dönüştür — Hertelden Shop.',
            'seo_focus_keyword' => 'kahvaltı takımı pasta seti',
        ],
        [
            'name'              => 'Kahve Fincanı ve Çay Setleri',
            'slug'              => 'kahve-cay',
            'parent_slug'       => 'sofra',
            'seo_title'         => 'Kahve Fincanı ve Çay Takımı | Hertelden Shop',
            'seo_description'   => 'Türk kahvesi fincan takımları ve çay setleri. Misafirlerinizi etkileyecek şık fincan takımları Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'kahve fincanı çay takımı',
        ],
        [
            'name'              => 'Servis ve Sunum',
            'slug'              => 'servis-sunum',
            'parent_slug'       => 'sofra',
            'seo_title'         => 'Servis ve Sunum Ürünleri | Hertelden Shop',
            'seo_description'   => 'Tepsi, baharat takımı, kadeh, supla ve sunum kapları. Sofranızı profesyonelce kurun — Hertelden Shop.',
            'seo_focus_keyword' => 'servis sunum ürünleri',
        ],
        [
            'name'              => 'Tekli Ürünler',
            'slug'              => 'tekli-urunler',
            'parent_slug'       => 'sofra',
            'seo_title'         => 'Tekli Sofra Ürünleri | Hertelden Shop',
            'seo_description'   => 'Servis tabağı, beslenme seti ve tekli sofra ürünleri. Eksiklerinizi tamamlayın — Hertelden Shop.',
            'seo_focus_keyword' => 'tekli sofra ürünleri',
        ],

        /* SOFRA — L3 */
        [
            'name'              => '12 Kişilik Yemek Takımı',
            'slug'              => '12-kisilik-yemek-takimi',
            'parent_slug'       => 'yemek-takimi',
            'seo_title'         => '12 Kişilik Yemek Takımı | Hertelden Shop',
            'seo_description'   => '12 kişilik porselen yemek takımı modelleri. Büyük davetler ve özel günler için kaliteli yemek takımları uygun fiyatla.',
            'seo_focus_keyword' => '12 kişilik yemek takımı',
        ],
        [
            'name'              => '8 Kişilik Yemek Takımı',
            'slug'              => '8-kisilik-yemek-takimi',
            'parent_slug'       => 'yemek-takimi',
            'seo_title'         => '8 Kişilik Yemek Takımı | Hertelden Shop',
            'seo_description'   => '8 kişilik porselen yemek takımı seçenekleri. Aile yemekleri ve davetler için ideal — Hertelden Shop.',
            'seo_focus_keyword' => '8 kişilik yemek takımı',
        ],
        [
            'name'              => '6 Kişilik Yemek Takımı',
            'slug'              => '6-kisilik-yemek-takimi',
            'parent_slug'       => 'yemek-takimi',
            'seo_title'         => '6 Kişilik Yemek Takımı | Hertelden Shop',
            'seo_description'   => '6 kişilik kompakt yemek takımları. Hem günlük kullanım hem misafir sofrası için — Hertelden Shop.',
            'seo_focus_keyword' => '6 kişilik yemek takımı',
        ],
        [
            'name'              => 'Günlük Yemek Takımları',
            'slug'              => 'gunluk-yemek-takimi',
            'parent_slug'       => 'yemek-takimi',
            'seo_title'         => 'Günlük Yemek Takımı | Hertelden Shop',
            'seo_description'   => 'Dayanıklı ve uygun fiyatlı günlük yemek takımları. Her gün kullanım için pratik seçenekler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'günlük yemek takımı',
        ],
        [
            'name'              => 'Bone Porselen Yemek Takımı',
            'slug'              => 'bone-porselen-yemek-takimi',
            'parent_slug'       => 'yemek-takimi',
            'seo_title'         => 'Bone Porselen Yemek Takımı | Hertelden Shop',
            'seo_description'   => 'Hafif ve zarif bone porselen yemek takımları. Üstün kalite ve ince işçilik — Hertelden Shop.',
            'seo_focus_keyword' => 'bone porselen yemek takımı',
        ],
        [
            'name'              => 'Yuvarlak Yemek Takımı',
            'slug'              => 'yuvarlak-yemek-takimi',
            'parent_slug'       => 'yemek-takimi',
            'seo_title'         => 'Yuvarlak Yemek Takımı | Hertelden Shop',
            'seo_description'   => 'Yuvarlak tabak tasarımlı porselen yemek takımları. Modern ve klasik seçenekler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'yuvarlak yemek takımı',
        ],
        [
            'name'              => 'Porselen Yemek Takımı',
            'slug'              => 'porselen-yemek-takimi',
            'parent_slug'       => 'yemek-takimi',
            'seo_title'         => 'Porselen Yemek Takımı | Hertelden Shop',
            'seo_description'   => 'Kaliteli porselen yemek takımı modelleri. Sofistike tasarım, dayanıklı malzeme — Hertelden Shop.',
            'seo_focus_keyword' => 'porselen yemek takımı',
        ],
        [
            'name'              => 'Tekli Tabaklar',
            'slug'              => 'tekli-tabaklar',
            'parent_slug'       => 'yemek-takimi',
            'seo_title'         => 'Tekli Tabak | Hertelden Shop',
            'seo_description'   => 'Yemek, çorba ve servis tabağı tekli seçenekler. Sete tamamlama veya yedek alım için ideal — Hertelden Shop.',
            'seo_focus_keyword' => 'tekli tabak',
        ],
        [
            'name'              => '12 Kişilik Çatal Kaşık Bıçak Takımı',
            'slug'              => '12-kisilik-catal-kasik-bicak',
            'parent_slug'       => 'catal-kasik-bicak',
            'seo_title'         => '12 Kişilik Çatal Kaşık Bıçak Takımı | Hertelden Shop',
            'seo_description'   => '12 kişilik paslanmaz çelik çatal kaşık bıçak takımları. Davet sofralarına özel şık çekmece kutusuyla — Hertelden Shop.',
            'seo_focus_keyword' => '12 kişilik çatal kaşık bıçak',
        ],
        [
            'name'              => '6 Kişilik Çatal Kaşık Bıçak Takımı',
            'slug'              => '6-kisilik-catal-kasik-bicak',
            'parent_slug'       => 'catal-kasik-bicak',
            'seo_title'         => '6 Kişilik Çatal Kaşık Bıçak Takımı | Hertelden Shop',
            'seo_description'   => '6 kişilik pratik çatal kaşık bıçak setleri. Kaliteli paslanmaz çelik, uygun fiyat — Hertelden Shop.',
            'seo_focus_keyword' => '6 kişilik çatal kaşık bıçak',
        ],
        [
            'name'              => 'Kahvaltı Takımı',
            'slug'              => 'kahvalti-takimi',
            'parent_slug'       => 'kahvalti-pasta',
            'seo_title'         => 'Kahvaltı Takımı | Hertelden Shop',
            'seo_description'   => 'Eksiksiz kahvaltı takımları. Tabak, kase, fincan ve servis gereçleri bir arada — Hertelden Shop.',
            'seo_focus_keyword' => 'kahvaltı takımı',
        ],
        [
            'name'              => 'Porselen Kahvaltı Takımları',
            'slug'              => 'porselen-kahvalti-takimi',
            'parent_slug'       => 'kahvalti-pasta',
            'seo_title'         => 'Porselen Kahvaltı Takımı | Hertelden Shop',
            'seo_description'   => 'Şık porselen kahvaltı takımları. Hafta sonu brunch\'larınız için zarif seçenekler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'porselen kahvaltı takımı',
        ],
        [
            'name'              => 'Seramik Kahvaltı Takımları',
            'slug'              => 'seramik-kahvalti-takimi',
            'parent_slug'       => 'kahvalti-pasta',
            'seo_title'         => 'Seramik Kahvaltı Takımı | Hertelden Shop',
            'seo_description'   => 'El yapımı görünümlü seramik kahvaltı takımları. Doğal dokular ve sıcak renkler — Hertelden Shop.',
            'seo_focus_keyword' => 'seramik kahvaltı takımı',
        ],
        [
            'name'              => 'Pasta Setleri',
            'slug'              => 'pasta-setleri',
            'parent_slug'       => 'kahvalti-pasta',
            'seo_title'         => 'Pasta Seti ve Sunum Takımı | Hertelden Shop',
            'seo_description'   => 'Pasta tabağı, servis spatulası ve sunum setleri. Pasta sunumunuzu profesyonelleştirin — Hertelden Shop.',
            'seo_focus_keyword' => 'pasta seti',
        ],
        [
            'name'              => 'Kahve Fincan Takımı',
            'slug'              => 'kahve-fincan-takimi',
            'parent_slug'       => 'kahve-cay',
            'seo_title'         => 'Kahve Fincan Takımı | Hertelden Shop',
            'seo_description'   => 'Türk kahvesi ve espresso fincan takımları. Misafirlerinize özel sunum için şık fincan seçenekleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'kahve fincan takımı',
        ],
        [
            'name'              => 'Çay Takımı',
            'slug'              => 'cay-takimi',
            'parent_slug'       => 'kahve-cay',
            'seo_title'         => 'Çay Takımı | Hertelden Shop',
            'seo_description'   => 'Porselen ve cam çay takımları. İnce belli veya modern tasarım çay bardakları ve takımları Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'çay takımı',
        ],
        [
            'name'              => 'Baharat Takımı',
            'slug'              => 'baharat-takimi',
            'parent_slug'       => 'servis-sunum',
            'seo_title'         => 'Baharat Takımı | Hertelden Shop',
            'seo_description'   => 'Tuz, biber ve baharat takımları. Masada şık sunum için ideal baharat seti modelleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'baharat takımı',
        ],
        [
            'name'              => 'Tepsi',
            'slug'              => 'tepsi',
            'parent_slug'       => 'servis-sunum',
            'seo_title'         => 'Servis Tepsisi | Hertelden Shop',
            'seo_description'   => 'Metal, ahşap ve melamin servis tepsileri. Pratik ve şık tepsi modelleri Hertelden Shop\'ta uygun fiyatla.',
            'seo_focus_keyword' => 'servis tepsisi',
        ],
        [
            'name'              => 'Kurabiyelik & Şekerlik',
            'slug'              => 'kurabiyelik-sekerlik',
            'parent_slug'       => 'servis-sunum',
            'seo_title'         => 'Kurabiyelik ve Şekerlik | Hertelden Shop',
            'seo_description'   => 'Şık kurabiyelik ve şekerlik modelleri. Misafir masanızı tamamlayan sunum kapları Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'kurabiyelik şekerlik',
        ],
        [
            'name'              => 'Kadeh',
            'slug'              => 'kadeh',
            'parent_slug'       => 'servis-sunum',
            'seo_title'         => 'Kadeh ve Şarap Bardağı | Hertelden Shop',
            'seo_description'   => 'Su bardağı, şarap kadehi ve meşrubat bardakları. Özel davetler için şık kadeh seti Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'kadeh bardak',
        ],
        [
            'name'              => 'Supla',
            'slug'              => 'supla',
            'parent_slug'       => 'servis-sunum',
            'seo_title'         => 'Supla | Hertelden Shop',
            'seo_description'   => 'Amerikan servis, ahşap ve porselen supla modelleri. Sofranıza düzen ve şıklık katın — Hertelden Shop.',
            'seo_focus_keyword' => 'supla',
        ],
        [
            'name'              => 'Sufle Kabı',
            'slug'              => 'sufle-kabi',
            'parent_slug'       => 'servis-sunum',
            'seo_title'         => 'Sufle Kabı | Hertelden Shop',
            'seo_description'   => 'Fırına dayanıklı sufle ve porselen kase modelleri. Hem pişirme hem sunum için ideal — Hertelden Shop.',
            'seo_focus_keyword' => 'sufle kabı porselen kase',
        ],
        [
            'name'              => 'Servis Tabağı',
            'slug'              => 'servis-tabagi',
            'parent_slug'       => 'tekli-urunler',
            'seo_title'         => 'Servis Tabağı | Hertelden Shop',
            'seo_description'   => 'Büyük servis tabağı ve sunum plakaları. Misafir sofrası için gösterişli seçenekler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'servis tabağı',
        ],
        [
            'name'              => 'Beslenme Seti',
            'slug'              => 'beslenme-seti',
            'parent_slug'       => 'tekli-urunler',
            'seo_title'         => 'Beslenme Seti | Hertelden Shop',
            'seo_description'   => 'Çocuk ve yetişkin beslenme setleri. Okul, iş ve piknik için pratik çözümler — Hertelden Shop.',
            'seo_focus_keyword' => 'beslenme seti',
        ],

        /* =====================================================
           MUTFAK — L2
        ===================================================== */
        [
            'name'              => 'Pişirme',
            'slug'              => 'pisirme',
            'parent_slug'       => 'mutfak',
            'seo_title'         => 'Pişirme Ürünleri — Tencere ve Tava | Hertelden Shop',
            'seo_description'   => 'Tencere setleri, döküm tencere, emaye tava ve daha fazlası. Mutfağınız için profesyonel kalite — Hertelden Shop.',
            'seo_focus_keyword' => 'tencere tava pişirme',
        ],
        [
            'name'              => 'Mutfak Gereçleri',
            'slug'              => 'mutfak-gerecleri',
            'parent_slug'       => 'mutfak',
            'seo_title'         => 'Mutfak Gereçleri | Hertelden Shop',
            'seo_description'   => 'Bıçak setleri, kesme tahtası, servis gereçleri. Mutfakta işinizi kolaylaştıracak her şey Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'mutfak gereçleri',
        ],
        [
            'name'              => 'Saklama Kabı',
            'slug'              => 'saklama',
            'parent_slug'       => 'mutfak',
            'seo_title'         => 'Saklama Kabı | Hertelden Shop',
            'seo_description'   => 'Emaye, cam ve plastik saklama kapları. Gıdalarınızı taze tutun — uygun fiyatlı saklama çözümleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'saklama kabı',
        ],
        [
            'name'              => 'İçecek Hazırlama',
            'slug'              => 'icecek-hazirlama',
            'parent_slug'       => 'mutfak',
            'seo_title'         => 'İçecek Hazırlama — Cezve, Çaydanlık | Hertelden Shop',
            'seo_description'   => 'Cezve, çaydanlık ve demlik modelleri. Çay ve kahve ritüelinizi Hertelden Shop\'la tamamlayın.',
            'seo_focus_keyword' => 'cezve çaydanlık demlik',
        ],
        [
            'name'              => 'Mutfak Tekstili',
            'slug'              => 'mutfak-tekstili',
            'parent_slug'       => 'mutfak',
            'seo_title'         => 'Mutfak Tekstili | Hertelden Shop',
            'seo_description'   => 'Mutfak havlusu ve tekstil ürünleri. Dayanıklı ve şık mutfak tekstili Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'mutfak tekstili havlu',
        ],

        /* MUTFAK — L3 (Pişirme) */
        [
            'name'              => 'Tencere Setleri',
            'slug'              => 'tencere-setleri',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Tencere Seti | Hertelden Shop',
            'seo_description'   => 'Çelik ve granit tencere setleri. Komple çeyiz seti veya mutfak yenilemesi için ideal — Hertelden Shop.',
            'seo_focus_keyword' => 'tencere seti',
        ],
        [
            'name'              => 'Tek Tencere',
            'slug'              => 'tek-tencere',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Tek Tencere | Hertelden Shop',
            'seo_description'   => 'Tek parça tencere modelleri. 18 cm\'den 28 cm\'e kadar boyut seçenekleri — Hertelden Shop.',
            'seo_focus_keyword' => 'tek tencere',
        ],
        [
            'name'              => 'Döküm Tencere',
            'slug'              => 'dokum-tencere',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Döküm Tencere | Hertelden Shop',
            'seo_description'   => 'Uzun ömürlü döküm tencere modelleri. Eşit ısı dağılımı ve yüksek dayanıklılık — Hertelden Shop.',
            'seo_focus_keyword' => 'döküm tencere',
        ],
        [
            'name'              => 'Düdüklü Tencere',
            'slug'              => 'duduklu-tencere',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Düdüklü Tencere | Hertelden Shop',
            'seo_description'   => 'Paslanmaz çelik ve çeşitli litreajlarda düdüklü tencere. Hızlı pişirme, enerji tasarrufu — Hertelden Shop.',
            'seo_focus_keyword' => 'düdüklü tencere',
        ],
        [
            'name'              => 'Kızartma Tenceresi',
            'slug'              => 'kizartma-tenceresi',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Kızartma Tenceresi | Hertelden Shop',
            'seo_description'   => 'Yapışmaz ve çelik kızartma tenceresi modelleri. Güvenli kızartma için doğru araç — Hertelden Shop.',
            'seo_focus_keyword' => 'kızartma tenceresi',
        ],
        [
            'name'              => 'Emaye Tencere',
            'slug'              => 'emaye-tencere',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Emaye Tencere | Hertelden Shop',
            'seo_description'   => 'Renkli emaye tencere modelleri. Şık görünüm ve dayanıklı yapı bir arada — Hertelden Shop.',
            'seo_focus_keyword' => 'emaye tencere',
        ],
        [
            'name'              => 'Çelik & Granit Çeyiz Seti',
            'slug'              => 'celik-granit-ceyiz-seti',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Çelik ve Granit Çeyiz Seti | Hertelden Shop',
            'seo_description'   => 'Çelik ve granit kaplı çeyiz mutfak setleri. Yeni yuvalar için eksiksiz pişirme takımı — Hertelden Shop.',
            'seo_focus_keyword' => 'çelik granit çeyiz seti tencere',
        ],
        [
            'name'              => 'Döküm Tava',
            'slug'              => 'dokum-tava',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Döküm Tava | Hertelden Shop',
            'seo_description'   => 'Sağlam döküm demir tava modelleri. Et, sebze ve her şey için mükemmel ısı dağılımı — Hertelden Shop.',
            'seo_focus_keyword' => 'döküm tava',
        ],
        [
            'name'              => 'Emaye Tava',
            'slug'              => 'emaye-tava',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Emaye Tava | Hertelden Shop',
            'seo_description'   => 'Renkli emaye kaplı tava modelleri. Fırına uyumlu, yapışmaz yüzey — Hertelden Shop.',
            'seo_focus_keyword' => 'emaye tava',
        ],
        [
            'name'              => 'Tava & Tava Seti',
            'slug'              => 'tava-seti',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Tava ve Tava Seti | Hertelden Shop',
            'seo_description'   => 'Yapışmaz, granit ve çelik tava setleri. Her ateşe uyumlu tava modelleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'tava seti',
        ],
        [
            'name'              => 'Sahan & Sahan Seti',
            'slug'              => 'sahan-seti',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Sahan ve Sahan Seti | Hertelden Shop',
            'seo_description'   => 'Geleneksel ve modern sahan modelleri. Tatlı ve pilav için kullanışlı sahan seti — Hertelden Shop.',
            'seo_focus_keyword' => 'sahan seti',
        ],
        [
            'name'              => 'Sütlük & Sosluk',
            'slug'              => 'sutluk-sosluk',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Sütlük ve Sosluk | Hertelden Shop',
            'seo_description'   => 'Çelik ve porselen sütlük ile sosluk modelleri. Mutfak düzeninizi tamamlayın — Hertelden Shop.',
            'seo_focus_keyword' => 'sütlük sosluk',
        ],
        [
            'name'              => 'Çelik Tencere',
            'slug'              => 'celik-tencere',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Çelik Tencere | Hertelden Shop',
            'seo_description'   => '18/10 paslanmaz çelik tencere modelleri. Sağlık güvenli, uzun ömürlü — Hertelden Shop.',
            'seo_focus_keyword' => 'çelik tencere',
        ],
        [
            'name'              => 'Wok Tava',
            'slug'              => 'wok-tava',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Wok Tava | Hertelden Shop',
            'seo_description'   => 'Çelik ve döküm wok tava modelleri. Asya mutfağı ve hızlı kızartma için ideal — Hertelden Shop.',
            'seo_focus_keyword' => 'wok tava',
        ],
        [
            'name'              => 'Çelik Tava',
            'slug'              => 'celik-tava',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Çelik Tava | Hertelden Shop',
            'seo_description'   => 'Paslanmaz çelik tava modelleri. Yüksek ısıya dayanıklı, fırın uyumlu — Hertelden Shop.',
            'seo_focus_keyword' => 'çelik tava',
        ],
        [
            'name'              => 'Kek Kalıpları',
            'slug'              => 'kek-kaliplari',
            'parent_slug'       => 'pisirme',
            'seo_title'         => 'Kek Kalıbı | Hertelden Shop',
            'seo_description'   => 'Yuvarlak, dikdörtgen ve özel şekilli kek kalıpları. Fırın uyumlu, yapışmaz kek kalıpları Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'kek kalıbı',
        ],
        /* MUTFAK — L3 (Mutfak Gereçleri) */
        [
            'name'              => 'Bıçak & Bıçak Setleri',
            'slug'              => 'bicak-setleri',
            'parent_slug'       => 'mutfak-gerecleri',
            'seo_title'         => 'Mutfak Bıçağı ve Bıçak Seti | Hertelden Shop',
            'seo_description'   => 'Şef bıçağı, ekmek bıçağı ve komple bıçak setleri. Keskin ve dayanıklı çelik bıçaklar Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'mutfak bıçağı bıçak seti',
        ],
        [
            'name'              => 'Kesme Tahtası',
            'slug'              => 'kesme-tahtasi',
            'parent_slug'       => 'mutfak-gerecleri',
            'seo_title'         => 'Kesme Tahtası | Hertelden Shop',
            'seo_description'   => 'Ahşap, cam ve plastik kesme tahtası modelleri. Hijyenik ve dayanıklı kesme tahtaları uygun fiyatla Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'kesme tahtası',
        ],
        [
            'name'              => 'Servis Gereçleri & Küçük Gereçler',
            'slug'              => 'servis-gerecleri',
            'parent_slug'       => 'mutfak-gerecleri',
            'seo_title'         => 'Servis Gereçleri ve Küçük Mutfak Gereçleri | Hertelden Shop',
            'seo_description'   => 'Kepçe, spatula, süzgeç ve küçük mutfak gereçleri. Mutfakta işinizi kolaylaştıracak her şey Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'mutfak servis gereçleri',
        ],
        [
            'name'              => 'Karıştırma Kabı',
            'slug'              => 'karistirma-kabi',
            'parent_slug'       => 'mutfak-gerecleri',
            'seo_title'         => 'Karıştırma Kabı | Hertelden Shop',
            'seo_description'   => 'Çelik ve plastik karıştırma kabı setleri. Hamur yoğurma ve malzeme hazırlamak için ideal — Hertelden Shop.',
            'seo_focus_keyword' => 'karıştırma kabı',
        ],
        /* MUTFAK — L3 (Saklama) */
        [
            'name'              => 'Emaye Saklama Kabı',
            'slug'              => 'emaye-saklama',
            'parent_slug'       => 'saklama',
            'seo_title'         => 'Emaye Saklama Kabı | Hertelden Shop',
            'seo_description'   => 'Renkli emaye saklama kapları ve setleri. Mutfak tezgahına şıklık katın — Hertelden Shop.',
            'seo_focus_keyword' => 'emaye saklama kabı',
        ],
        [
            'name'              => 'Cam Saklama Kabı',
            'slug'              => 'cam-saklama',
            'parent_slug'       => 'saklama',
            'seo_title'         => 'Cam Saklama Kabı | Hertelden Shop',
            'seo_description'   => 'Hava geçirmez cam saklama kabı setleri. Gıda güvenli, mikrodalga uyumlu — Hertelden Shop.',
            'seo_focus_keyword' => 'cam saklama kabı',
        ],
        [
            'name'              => 'Plastik Saklama Kabı',
            'slug'              => 'plastik-saklama',
            'parent_slug'       => 'saklama',
            'seo_title'         => 'Plastik Saklama Kabı | Hertelden Shop',
            'seo_description'   => 'BPA free plastik saklama kabı setleri. Bulaşık makinesine uyumlu, pratik ve uygun fiyatlı — Hertelden Shop.',
            'seo_focus_keyword' => 'plastik saklama kabı',
        ],
        [
            'name'              => 'Termos',
            'slug'              => 'termos',
            'parent_slug'       => 'saklama',
            'seo_title'         => 'Termos | Hertelden Shop',
            'seo_description'   => 'Çay, kahve ve yemek termosu modelleri. Saatlerce sıcak, pratik taşıma — Hertelden Shop.',
            'seo_focus_keyword' => 'termos',
        ],
        /* MUTFAK — L3 (İçecek Hazırlama) */
        [
            'name'              => 'Cezve & Cezve Seti',
            'slug'              => 'cezve',
            'parent_slug'       => 'icecek-hazirlama',
            'seo_title'         => 'Cezve ve Cezve Seti | Hertelden Shop',
            'seo_description'   => 'Bakır, çelik ve döküm cezve modelleri. Geleneksel Türk kahvesi için en iyi seçim — Hertelden Shop.',
            'seo_focus_keyword' => 'cezve',
        ],
        [
            'name'              => 'Çaydanlık',
            'slug'              => 'caydanlik',
            'parent_slug'       => 'icecek-hazirlama',
            'seo_title'         => 'Çaydanlık | Hertelden Shop',
            'seo_description'   => 'Çelik ve emaye çaydanlık modelleri. Ocak üstü ve ocak altı çaydanlık Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'çaydanlık',
        ],
        [
            'name'              => 'Demlik',
            'slug'              => 'demlik',
            'parent_slug'       => 'icecek-hazirlama',
            'seo_title'         => 'Demlik | Hertelden Shop',
            'seo_description'   => 'Cam, çelik ve porselen demlik modelleri. Çay demlemek için doğru araç — Hertelden Shop.',
            'seo_focus_keyword' => 'demlik',
        ],
        /* MUTFAK — L3 (Mutfak Tekstili) */
        [
            'name'              => 'Mutfak Havlusu',
            'slug'              => 'mutfak-havlusu',
            'parent_slug'       => 'mutfak-tekstili',
            'seo_title'         => 'Mutfak Havlusu | Hertelden Shop',
            'seo_description'   => 'Hızlı kuruyan ve dayanıklı mutfak havlusu setleri. Pamuk ve microfleece seçenekleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'mutfak havlusu',
        ],

        /* =====================================================
           KÜÇÜK EV ALETLERİ — L2
        ===================================================== */
        [
            'name'              => 'Pişirme ve Kızartma',
            'slug'              => 'pisirme-kizartma',
            'parent_slug'       => 'kucuk-ev-aletleri',
            'seo_title'         => 'Pişirme ve Kızartma Aletleri | Hertelden Shop',
            'seo_description'   => 'Tost makinesi, fritöz, waffle makinesi. Mutfağınızı kolaylaştıran elektrikli pişirme aletleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'tost makinesi fritöz waffle',
        ],
        [
            'name'              => 'Gıda Hazırlama',
            'slug'              => 'gida-hazirlama',
            'parent_slug'       => 'kucuk-ev-aletleri',
            'seo_title'         => 'Gıda Hazırlama Aletleri | Hertelden Shop',
            'seo_description'   => 'Blender, kıyma makinesi, hamur yoğurma. Mutfak hazırlıklarını hızlandıracak elektrikli aletler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'blender kıyma makinesi gıda hazırlama',
        ],
        [
            'name'              => 'Kahve Makinesi',
            'slug'              => 'kahve-makinesi',
            'parent_slug'       => 'kucuk-ev-aletleri',
            'seo_title'         => 'Kahve Makinesi | Hertelden Shop',
            'seo_description'   => 'Türk kahvesi ve filtre kahve makinesi modelleri. Evde barista kalitesi kahve — Hertelden Shop.',
            'seo_focus_keyword' => 'kahve makinesi',
        ],
        [
            'name'              => 'Elektrikli İçecek Hazırlama',
            'slug'              => 'elektrikli-icecek',
            'parent_slug'       => 'kucuk-ev-aletleri',
            'seo_title'         => 'Elektrikli İçecek Hazırlama | Hertelden Shop',
            'seo_description'   => 'Çay makinesi, kettle, elektrikli cezve ve meyve sıkacağı. İçecek hazırlamayı kolaylaştıran aletler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'çay makinesi kettle elektrikli içecek',
        ],

        /* KÜÇÜK EV ALETLERİ — L3 (Pişirme ve Kızartma) */
        [
            'name'              => 'Tost Makinesi',
            'slug'              => 'tost-makinesi',
            'parent_slug'       => 'pisirme-kizartma',
            'seo_title'         => 'Tost Makinesi | Hertelden Shop',
            'seo_description'   => 'Izgara ve kapaklı tost makinesi modelleri. Hızlı ve lezzetli tost için Hertelden Shop.',
            'seo_focus_keyword' => 'tost makinesi',
        ],
        [
            'name'              => 'Fritöz',
            'slug'              => 'fritoz',
            'parent_slug'       => 'pisirme-kizartma',
            'seo_title'         => 'Fritöz | Hertelden Shop',
            'seo_description'   => 'Yağlı ve yağsız (air fryer) fritöz modelleri. Sağlıklı ve hızlı kızartma — Hertelden Shop.',
            'seo_focus_keyword' => 'fritöz',
        ],
        [
            'name'              => 'Waffle Makinesi',
            'slug'              => 'waffle-makinesi',
            'parent_slug'       => 'pisirme-kizartma',
            'seo_title'         => 'Waffle Makinesi | Hertelden Shop',
            'seo_description'   => 'Kare ve yuvarlak waffle makinesi modelleri. Ev yapımı waffle için uygun fiyatlı seçenekler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'waffle makinesi',
        ],
        /* KÜÇÜK EV ALETLERİ — L3 (Gıda Hazırlama) */
        [
            'name'              => 'Hamur Yoğurma Makinesi',
            'slug'              => 'hamur-yogurma',
            'parent_slug'       => 'gida-hazirlama',
            'seo_title'         => 'Hamur Yoğurma Makinesi | Hertelden Shop',
            'seo_description'   => 'Spiral ve planet karıştırıcı hamur yoğurma makineleri. Ekmek ve pasta yapımı için güçlü motorlar — Hertelden Shop.',
            'seo_focus_keyword' => 'hamur yoğurma makinesi',
        ],
        [
            'name'              => 'Kıyma Makinesi',
            'slug'              => 'kiyma-makinesi',
            'parent_slug'       => 'gida-hazirlama',
            'seo_title'         => 'Kıyma Makinesi | Hertelden Shop',
            'seo_description'   => 'Elektrikli ve manuel kıyma makinesi modelleri. Ev yapımı köfte ve kıyma için — Hertelden Shop.',
            'seo_focus_keyword' => 'kıyma makinesi',
        ],
        [
            'name'              => 'Blender',
            'slug'              => 'blender',
            'parent_slug'       => 'gida-hazirlama',
            'seo_title'         => 'Blender | Hertelden Shop',
            'seo_description'   => 'El blenderi ve klasik blender modelleri. Çorba, smoothie ve sos için güçlü ve sessiz motorlar — Hertelden Shop.',
            'seo_focus_keyword' => 'blender',
        ],
        [
            'name'              => 'Blender Seti',
            'slug'              => 'blender-seti',
            'parent_slug'       => 'gida-hazirlama',
            'seo_title'         => 'Blender Seti | Hertelden Shop',
            'seo_description'   => 'Blender, doğrayıcı ve aksesuarları bir arada. Çok fonksiyonlu blender seti Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'blender seti',
        ],
        [
            'name'              => 'Smoothie Blender',
            'slug'              => 'smoothie-blender',
            'parent_slug'       => 'gida-hazirlama',
            'seo_title'         => 'Smoothie Blender | Hertelden Shop',
            'seo_description'   => 'Yüksek güçlü smoothie blender modelleri. Protein shake ve meyve smoothie için kişisel boyut seçenekleri — Hertelden Shop.',
            'seo_focus_keyword' => 'smoothie blender',
        ],
        /* KÜÇÜK EV ALETLERİ — L3 (Kahve Makinesi) */
        [
            'name'              => 'Türk Kahvesi Makinesi',
            'slug'              => 'turk-kahvesi-makinesi',
            'parent_slug'       => 'kahve-makinesi',
            'seo_title'         => 'Türk Kahvesi Makinesi | Hertelden Shop',
            'seo_description'   => 'Otomatik ve yarı otomatik Türk kahvesi makineleri. Köpüklü ve lezzetli Türk kahvesi her gün — Hertelden Shop.',
            'seo_focus_keyword' => 'türk kahvesi makinesi',
        ],
        [
            'name'              => 'Filtre Kahve Makinesi',
            'slug'              => 'filtre-kahve-makinesi',
            'parent_slug'       => 'kahve-makinesi',
            'seo_title'         => 'Filtre Kahve Makinesi | Hertelden Shop',
            'seo_description'   => 'Damla filtre kahve makinesi modelleri. Sabah kahvaltısının vazgeçilmezi uygun fiyatla Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'filtre kahve makinesi',
        ],
        /* KÜÇÜK EV ALETLERİ — L3 (Elektrikli İçecek Hazırlama) */
        [
            'name'              => 'Elektrikli Cezve',
            'slug'              => 'elektrikli-cezve',
            'parent_slug'       => 'elektrikli-icecek',
            'seo_title'         => 'Elektrikli Cezve | Hertelden Shop',
            'seo_description'   => 'Otomatik ısıtmalı elektrikli cezve modelleri. Ocak gerekmez, her yerde Türk kahvesi — Hertelden Shop.',
            'seo_focus_keyword' => 'elektrikli cezve',
        ],
        [
            'name'              => 'Çay Makinesi',
            'slug'              => 'cay-makinesi',
            'parent_slug'       => 'elektrikli-icecek',
            'seo_title'         => 'Çay Makinesi | Hertelden Shop',
            'seo_description'   => 'Semaver ve elektrikli çay makinesi modelleri. Demli çay için pratik otomatik çözümler — Hertelden Shop.',
            'seo_focus_keyword' => 'çay makinesi',
        ],
        [
            'name'              => 'Kettle',
            'slug'              => 'kettle',
            'parent_slug'       => 'elektrikli-icecek',
            'seo_title'         => 'Kettle Su Isıtıcı | Hertelden Shop',
            'seo_description'   => 'Cam ve çelik kettle su ısıtıcı modelleri. Hızlı kaynama, güvenli kapak — Hertelden Shop.',
            'seo_focus_keyword' => 'kettle su ısıtıcı',
        ],
        [
            'name'              => 'Meyve Sıkacağı',
            'slug'              => 'meyve-sikacagi',
            'parent_slug'       => 'elektrikli-icecek',
            'seo_title'         => 'Meyve Sıkacağı | Hertelden Shop',
            'seo_description'   => 'Elektrikli ve manuel meyve sıkacağı modelleri. Taze portakal suyu için uygun fiyatlı seçenekler — Hertelden Shop.',
            'seo_focus_keyword' => 'meyve sıkacağı',
        ],
        [
            'name'              => 'Buz Makinesi',
            'slug'              => 'buz-makinesi',
            'parent_slug'       => 'elektrikli-icecek',
            'seo_title'         => 'Buz Makinesi | Hertelden Shop',
            'seo_description'   => 'Hızlı buz yapan taşınabilir buz makinesi modelleri. Serinletici içecekler için — Hertelden Shop.',
            'seo_focus_keyword' => 'buz makinesi',
        ],

        /* =====================================================
           HERTELDEN HOME — L2
        ===================================================== */
        [
            'name'              => 'Yatak Odası',
            'slug'              => 'yatak-odasi',
            'parent_slug'       => 'hertelden-home',
            'seo_title'         => 'Yatak Odası Tekstili | Hertelden Shop',
            'seo_description'   => 'Nevresim takımı, battaniye, pike ve yorgan. Kalitenin hissedildiği yatak odası tekstili Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'yatak odası tekstili nevresim',
        ],
        [
            'name'              => 'Sofra & Mutfak Tekstili',
            'slug'              => 'sofra-mutfak-tekstili',
            'parent_slug'       => 'hertelden-home',
            'seo_title'         => 'Sofra ve Mutfak Tekstili | Hertelden Shop',
            'seo_description'   => 'Masa örtüsü, runner, amerikan servis ve kurulama bezi. Sofra düzenini tamamlayan tekstil ürünleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'sofra tekstili masa örtüsü',
        ],
        [
            'name'              => 'Çeyiz Setleri',
            'slug'              => 'ceyiz-setleri',
            'parent_slug'       => 'hertelden-home',
            'seo_title'         => 'Çeyiz Setleri | Hertelden Shop',
            'seo_description'   => '8 ve 11 parça yatak çeyiz setleri. Yeni ev için eksiksiz çeyiz hazırlığı — Hertelden Shop.',
            'seo_focus_keyword' => 'çeyiz seti',
        ],
        [
            'name'              => 'Banyo',
            'slug'              => 'banyo',
            'parent_slug'       => 'hertelden-home',
            'seo_title'         => 'Banyo Ürünleri ve Tekstili | Hertelden Shop',
            'seo_description'   => 'Banyo havlusu, bornoz, paspas ve banyo setleri. Banyonuzu ferahlatın — Hertelden Shop.',
            'seo_focus_keyword' => 'banyo ürünleri havlu bornoz',
        ],
        [
            'name'              => 'Ev Gereçleri',
            'slug'              => 'ev-gerecleri',
            'parent_slug'       => 'hertelden-home',
            'seo_title'         => 'Ev Gereçleri | Hertelden Shop',
            'seo_description'   => 'Ütü masası, çamaşır kurutma askısı, çöp kutusu ve pratik ev gereçleri. Evinizi organize edin — Hertelden Shop.',
            'seo_focus_keyword' => 'ev gereçleri organizasyon',
        ],

        /* HERTELDEN HOME — L3 (Yatak Odası) */
        [
            'name'              => 'Battaniye',
            'slug'              => 'battaniye',
            'parent_slug'       => 'yatak-odasi',
            'seo_title'         => 'Battaniye | Hertelden Shop',
            'seo_description'   => 'Tek ve çift kişilik battaniye modelleri. Pamuk, polar ve akrilik seçenekleri uygun fiyatla Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'battaniye',
        ],
        [
            'name'              => 'Çift Kişilik Battaniye',
            'slug'              => 'cift-kisilik-battaniye',
            'parent_slug'       => 'yatak-odasi',
            'seo_title'         => 'Çift Kişilik Battaniye | Hertelden Shop',
            'seo_description'   => 'Çift kişilik büyük battaniye modelleri. 200x220 ve daha geniş ölçüler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'çift kişilik battaniye',
        ],
        [
            'name'              => 'Pike',
            'slug'              => 'pike',
            'parent_slug'       => 'yatak-odasi',
            'seo_title'         => 'Pike | Hertelden Shop',
            'seo_description'   => 'Tek ve çift kişilik pike modelleri. İlkbahar ve yaz için ideal ince örtü seçenekleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'pike yatak örtüsü',
        ],
        [
            'name'              => 'Çift Kişilik Nevresim Takımı',
            'slug'              => 'cift-kisilik-nevresim',
            'parent_slug'       => 'yatak-odasi',
            'seo_title'         => 'Çift Kişilik Nevresim Takımı | Hertelden Shop',
            'seo_description'   => 'Çift kişilik nevresim takımı modelleri. Pamuk, saten ve mikrofiber çeşitleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'çift kişilik nevresim takımı',
        ],
        [
            'name'              => 'Çift Kişilik Yatak Örtüsü',
            'slug'              => 'cift-kisilik-yatak-ortusu',
            'parent_slug'       => 'yatak-odasi',
            'seo_title'         => 'Çift Kişilik Yatak Örtüsü | Hertelden Shop',
            'seo_description'   => 'Çift kişilik yatak örtüsü ve pike modelleri. Odanıza şıklık katacak renkler ve desenler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'çift kişilik yatak örtüsü',
        ],
        [
            'name'              => 'Tek Kişilik Nevresim Takımı',
            'slug'              => 'tek-kisilik-nevresim',
            'parent_slug'       => 'yatak-odasi',
            'seo_title'         => 'Tek Kişilik Nevresim Takımı | Hertelden Shop',
            'seo_description'   => 'Tek kişilik nevresim takımı modelleri. Çocuk, genç ve yetişkin odaları için çeşitli desenler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'tek kişilik nevresim takımı',
        ],
        [
            'name'              => 'Yorgan & Yastık',
            'slug'              => 'yorgan-yastik',
            'parent_slug'       => 'yatak-odasi',
            'seo_title'         => 'Yorgan ve Yastık | Hertelden Shop',
            'seo_description'   => 'Tek ve çift kişilik yorgan, uyku yastığı ve dekoratif yastık. Kaliteli uyku için doğru seçim — Hertelden Shop.',
            'seo_focus_keyword' => 'yorgan yastık',
        ],
        /* HERTELDEN HOME — L3 (Sofra & Mutfak Tekstili) */
        [
            'name'              => 'Masa Örtüsü',
            'slug'              => 'masa-ortusu',
            'parent_slug'       => 'sofra-mutfak-tekstili',
            'seo_title'         => 'Masa Örtüsü | Hertelden Shop',
            'seo_description'   => 'Yuvarlak, dikdörtgen ve kare masa örtüsü modelleri. Leke tutmaz ve saten seçenekler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'masa örtüsü',
        ],
        [
            'name'              => 'Runner',
            'slug'              => 'runner',
            'parent_slug'       => 'sofra-mutfak-tekstili',
            'seo_title'         => 'Sofra Runner | Hertelden Shop',
            'seo_description'   => 'Masa orta şeridi (runner) modelleri. Sofra düzenine modern dokunuş — Hertelden Shop.',
            'seo_focus_keyword' => 'sofra runner',
        ],
        [
            'name'              => 'Amerikan Servis',
            'slug'              => 'amerikan-servis',
            'parent_slug'       => 'sofra-mutfak-tekstili',
            'seo_title'         => 'Amerikan Servis | Hertelden Shop',
            'seo_description'   => 'Tekstil, PVC ve hasır amerikan servis modelleri. Takım halinde veya tekli seçenekler — Hertelden Shop.',
            'seo_focus_keyword' => 'amerikan servis',
        ],
        [
            'name'              => 'Kurulama Bezi',
            'slug'              => 'kurulama-bezi',
            'parent_slug'       => 'sofra-mutfak-tekstili',
            'seo_title'         => 'Kurulama Bezi | Hertelden Shop',
            'seo_description'   => 'Mutfak ve sofra kurulama bezi setleri. Hızlı emen, tüy bırakmayan bez modelleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'kurulama bezi',
        ],
        /* HERTELDEN HOME — L3 (Çeyiz Setleri) */
        [
            'name'              => '8 Parça Yatak Çeyiz Seti',
            'slug'              => '8-parca-ceyiz-seti',
            'parent_slug'       => 'ceyiz-setleri',
            'seo_title'         => '8 Parça Yatak Çeyiz Seti | Hertelden Shop',
            'seo_description'   => '8 parça nevresim, pike ve yastık içeren yatak çeyiz seti. Yeni ev hediyeliği olarak ideal — Hertelden Shop.',
            'seo_focus_keyword' => '8 parça çeyiz seti',
        ],
        [
            'name'              => '11 Parça Yatak Çeyiz Seti',
            'slug'              => '11-parca-ceyiz-seti',
            'parent_slug'       => 'ceyiz-setleri',
            'seo_title'         => '11 Parça Yatak Çeyiz Seti | Hertelden Shop',
            'seo_description'   => '11 parça eksiksiz yatak çeyiz seti. Nevresim, battaniye, pike ve yastık takımı bir arada — Hertelden Shop.',
            'seo_focus_keyword' => '11 parça çeyiz seti',
        ],
        /* HERTELDEN HOME — L3 (Banyo) */
        [
            'name'              => 'Yüz Havlusu',
            'slug'              => 'yuz-havlusu',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Yüz Havlusu | Hertelden Shop',
            'seo_description'   => 'Yumuşak ve hızlı kuruyan yüz havlusu modelleri. Pamuk ve bambu seçenekleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'yüz havlusu',
        ],
        [
            'name'              => 'Banyo Havlusu',
            'slug'              => 'banyo-havlusu',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Banyo Havlusu | Hertelden Shop',
            'seo_description'   => 'Pamuk ve bambu banyolu banyo havlusu modelleri. Şık desenler ve uzun ömürlü kumaş — Hertelden Shop.',
            'seo_focus_keyword' => 'banyo havlusu',
        ],
        [
            'name'              => 'Plaj Havlusu',
            'slug'              => 'plaj-havlusu',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Plaj Havlusu | Hertelden Shop',
            'seo_description'   => 'Büyük boy ve renkli plaj havlusu modelleri. Yaz tatilinin vazgeçilmezi — Hertelden Shop.',
            'seo_focus_keyword' => 'plaj havlusu',
        ],
        [
            'name'              => 'Havlu Seti',
            'slug'              => 'havlu-seti',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Havlu Seti | Hertelden Shop',
            'seo_description'   => 'El, yüz ve banyo havlusundan oluşan takım seti. Çeyiz listesi ve ev hediyesi için ideal — Hertelden Shop.',
            'seo_focus_keyword' => 'havlu seti',
        ],
        [
            'name'              => 'Banyo Paspası',
            'slug'              => 'banyo-paspasi',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Banyo Paspası | Hertelden Shop',
            'seo_description'   => 'Kaymaz taban ve yumuşak yüzeyli banyo paspası modelleri. Tek parça ve set seçenekleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'banyo paspası',
        ],
        [
            'name'              => 'Bornoz Takımı',
            'slug'              => 'bornoz-takimi',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Bornoz Takımı | Hertelden Shop',
            'seo_description'   => 'Kadın, erkek ve çocuk bornoz modelleri. Pamuk ve kadife seçenekleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'bornoz takımı',
        ],
        [
            'name'              => 'Çamaşır Spreyi',
            'slug'              => 'camasir-spreyi',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Çamaşır Spreyi | Hertelden Shop',
            'seo_description'   => 'Tekstil tazeleyici ve koku giderici çamaşır spreyi. Havlular ve çarşaflar için pratik çözüm — Hertelden Shop.',
            'seo_focus_keyword' => 'çamaşır spreyi',
        ],
        [
            'name'              => 'Oda Kokusu',
            'slug'              => 'oda-kokusu',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Oda Kokusu ve Banyo Parfümü | Hertelden Shop',
            'seo_description'   => 'Difüzör, sprey ve çubuklu oda kokusu modelleri. Evinizi ferahlatın — Hertelden Shop.',
            'seo_focus_keyword' => 'oda kokusu',
        ],
        [
            'name'              => 'Tuvalet Fırçası',
            'slug'              => 'tuvalet-fircasi',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Tuvalet Fırçası | Hertelden Shop',
            'seo_description'   => 'Şık ve hijyenik tuvalet fırçası ve tutacak modelleri. Paslanmaz çelik ve plastik seçenekler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'tuvalet fırçası',
        ],
        [
            'name'              => 'Banyo Seti',
            'slug'              => 'banyo-seti',
            'parent_slug'       => 'banyo',
            'seo_title'         => 'Banyo Seti | Hertelden Shop',
            'seo_description'   => 'Havlu, paspas, bornoz ve aksesuar içeren komple banyo setleri. Banyo düzenini tek alışverişte tamamlayın — Hertelden Shop.',
            'seo_focus_keyword' => 'banyo seti',
        ],
        /* HERTELDEN HOME — L3 (Ev Gereçleri) */
        [
            'name'              => 'Ütü Masası',
            'slug'              => 'utu-masasi',
            'parent_slug'       => 'ev-gerecleri',
            'seo_title'         => 'Ütü Masası | Hertelden Shop',
            'seo_description'   => 'Katlanabilir ve yükseklik ayarlı ütü masası modelleri. Konforlu ütüleme için ideal — Hertelden Shop.',
            'seo_focus_keyword' => 'ütü masası',
        ],
        [
            'name'              => 'Çamaşır Kurutma Askısı',
            'slug'              => 'camasir-kurutma-askisi',
            'parent_slug'       => 'ev-gerecleri',
            'seo_title'         => 'Çamaşır Kurutma Askısı | Hertelden Shop',
            'seo_description'   => 'İç mekan ve dış mekan çamaşır kurutma askısı modelleri. Katlanabilir, paslanmaz çelik seçenekler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'çamaşır kurutma askısı',
        ],
        [
            'name'              => 'Çöp Kutusu',
            'slug'              => 'cop-kutusu',
            'parent_slug'       => 'ev-gerecleri',
            'seo_title'         => 'Çöp Kutusu | Hertelden Shop',
            'seo_description'   => 'Mutfak, banyo ve ofis için çöp kutusu modelleri. Pedallı ve otomatik kapak seçenekleri Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'çöp kutusu',
        ],
        [
            'name'              => 'Bulaşıklık',
            'slug'              => 'bulasiklik',
            'parent_slug'       => 'ev-gerecleri',
            'seo_title'         => 'Bulaşıklık | Hertelden Shop',
            'seo_description'   => 'Tezgah üstü ve dolap içi bulaşıklık modelleri. Paslanmaz çelik ve plastik seçenekler Hertelden Shop\'ta.',
            'seo_focus_keyword' => 'bulaşıklık',
        ],
        [
            'name'              => 'Çamaşır Sepeti',
            'slug'              => 'camasir-sepeti',
            'parent_slug'       => 'ev-gerecleri',
            'seo_title'         => 'Çamaşır Sepeti | Hertelden Shop',
            'seo_description'   => 'Bambu, plastik ve çamaşır torbası çamaşır sepeti modelleri. Banyo ve yatak odası için — Hertelden Shop.',
            'seo_focus_keyword' => 'çamaşır sepeti',
        ],
        [
            'name'              => 'Kağıt Havluluk',
            'slug'              => 'kagit-havluluk',
            'parent_slug'       => 'ev-gerecleri',
            'seo_title'         => 'Kağıt Havluluk | Hertelden Shop',
            'seo_description'   => 'Tezgah üstü ve duvara monte kağıt havluluk modelleri. Mutfak ve banyo için şık seçenekler — Hertelden Shop.',
            'seo_focus_keyword' => 'kağıt havluluk',
        ],

    ];
}
