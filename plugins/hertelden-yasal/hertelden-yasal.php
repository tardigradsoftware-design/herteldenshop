<?php
/**
 * Plugin Name: Hertelden Yasal Sayfalar
 * Description: KVKK/Gizlilik Politikası, Mesafeli Satış Sözleşmesi ve İptal-İade Koşulları sayfalarını otomatik oluşturur.
 * Version: 1.0
 * Author: Hertelden Shop
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', 'hy_admin_menu' );
function hy_admin_menu() {
    add_management_page(
        'Hertelden Yasal Sayfalar',
        'Hertelden Yasal Sayfalar',
        'manage_options',
        'hertelden-yasal',
        'hy_admin_page'
    );
}

function hy_admin_page() {
    $result = '';
    if ( isset( $_POST['hy_run'] ) && check_admin_referer( 'hy_run_action' ) ) {
        $result = hy_create_pages();
    }
    ?>
    <div class="wrap">
        <h1>Hertelden Yasal Sayfalar</h1>
        <p>KVKK/Gizlilik Politikası, Mesafeli Satış Sözleşmesi ve İptal-İade Koşulları sayfalarını oluşturur.</p>
        <p><strong>Not:</strong> İçeriklerde <code>[FİRMA UNVANI]</code>, <code>[IBAN]</code> gibi yer tutucular var. Şirket kurulunca bu sayfaları düzenleyip gerçek bilgilerle doldur.</p>
        <p>Tekrar çalıştırmak güvenlidir — varolan sayfalar güncellenir.</p>
        <form method="post">
            <?php wp_nonce_field( 'hy_run_action' ); ?>
            <p><input type="submit" name="hy_run" class="button button-primary button-large" value="Sayfaları Oluştur / Güncelle"></p>
        </form>
        <?php if ( $result ) echo $result; ?>
    </div>
    <?php
}

function hy_create_pages() {
    $pages = [
        [
            'title'   => 'Gizlilik Politikası ve KVKK Aydınlatma Metni',
            'slug'    => 'gizlilik-politikasi',
            'content' => hy_kvkk_content(),
        ],
        [
            'title'   => 'Mesafeli Satış Sözleşmesi',
            'slug'    => 'mesafeli-satis-sozlesmesi',
            'content' => hy_mesafeli_content(),
        ],
        [
            'title'   => 'İptal ve İade Koşulları',
            'slug'    => 'iptal-iade-kosullari',
            'content' => hy_iade_content(),
        ],
    ];

    $created  = [];
    $updated  = [];

    foreach ( $pages as $page ) {
        $existing = get_page_by_path( $page['slug'] );
        if ( $existing ) {
            wp_update_post( [
                'ID'           => $existing->ID,
                'post_title'   => $page['title'],
                'post_content' => $page['content'],
                'post_status'  => 'publish',
            ] );
            $updated[] = $page['title'];
        } else {
            wp_insert_post( [
                'post_title'   => $page['title'],
                'post_name'    => $page['slug'],
                'post_content' => $page['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ] );
            $created[] = $page['title'];
        }
    }

    $html = '<div class="notice notice-success"><p><strong>Tamamlandı!</strong><br>';
    if ( $created ) $html .= 'Oluşturuldu: ' . implode( ', ', $created ) . '<br>';
    if ( $updated ) $html .= 'Güncellendi: ' . implode( ', ', $updated );
    $html .= '</p><p>Sayfaları <a href="' . admin_url( 'edit.php?post_type=page' ) . '">Sayfalar</a> menüsünden düzenleyebilirsin.</p></div>';
    return $html;
}

/* =====================================================
   KVKK / GİZLİLİK POLİTİKASI
===================================================== */
function hy_kvkk_content() {
    return <<<'HTML'
<h2>1. Veri Sorumlusu</h2>
<p>Bu aydınlatma metni, 6698 sayılı Kişisel Verilerin Korunması Kanunu (KVKK) kapsamında <strong>[FİRMA UNVANI]</strong> ("Hertelden Shop" veya "biz") tarafından hazırlanmıştır.</p>
<p>Veri Sorumlusu: <strong>[FİRMA UNVANI]</strong><br>
Adres: <strong>[FİRMA ADRESİ]</strong><br>
E-posta: herteldenshoptr@gmail.com</p>

<h2>2. Toplanan Kişisel Veriler</h2>
<p>Sitemizi ziyaret ettiğinizde veya alışveriş yaptığınızda aşağıdaki kişisel veriler işlenebilir:</p>
<ul>
<li>Ad, soyad</li>
<li>E-posta adresi</li>
<li>Telefon numarası</li>
<li>Teslimat ve fatura adresi</li>
<li>Sipariş ve ödeme bilgileri</li>
<li>IP adresi ve çerez (cookie) verileri</li>
</ul>

<h2>3. Kişisel Verilerin İşlenme Amaçları</h2>
<p>Kişisel verileriniz aşağıdaki amaçlarla işlenmektedir:</p>
<ul>
<li>Sipariş işlemleri ve teslimatın gerçekleştirilmesi</li>
<li>Fatura düzenlenmesi ve yasal yükümlülüklerin yerine getirilmesi</li>
<li>Müşteri hizmetleri ve destek sağlanması</li>
<li>İptal, iade ve değişim işlemlerinin yürütülmesi</li>
<li>Güvenliğin sağlanması ve dolandırıcılığın önlenmesi</li>
<li>Pazarlama ve bilgilendirme (açık rızanız olması halinde)</li>
</ul>

<h2>4. Hukuki Dayanak</h2>
<p>Kişisel verileriniz; sözleşmenin kurulması ve ifası, yasal yükümlülüklerimizin yerine getirilmesi ve meşru menfaatlerimiz kapsamında KVKK'nin 5. maddesi uyarınca işlenmektedir.</p>

<h2>5. Kişisel Verilerin Aktarılması</h2>
<p>Kişisel verileriniz; kargo ve lojistik firmaları, ödeme kuruluşları, e-fatura hizmet sağlayıcıları ve yasal yükümlülükler çerçevesinde kamu kurumlarıyla paylaşılabilir. Yurt dışına veri aktarımı yapılmamaktadır.</p>

<h2>6. Çerezler (Cookie)</h2>
<p>Sitemiz, deneyiminizi iyileştirmek amacıyla çerez kullanmaktadır. Zorunlu çerezler (sepet, oturum) sitenin işleyişi için gereklidir ve devre dışı bırakılamaz. Analitik ve pazarlama çerezleri için rızanız alınmaktadır.</p>

<h2>7. Kişisel Veri Saklama Süresi</h2>
<p>Kişisel verileriniz, ilgili mevzuatta öngörülen süreler ve işleme amacının gerektirdiği süre boyunca saklanır. Ticari kayıtlar ve fatura bilgileri yasal olarak 10 yıl saklanmaktadır.</p>

<h2>8. KVKK Kapsamındaki Haklarınız</h2>
<p>KVKK'nin 11. maddesi uyarınca aşağıdaki haklara sahipsiniz:</p>
<ul>
<li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
<li>Kişisel verileriniz işlenmişse buna ilişkin bilgi talep etme</li>
<li>Kişisel verilerinizin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme</li>
<li>Kişisel verilerinizin eksik veya yanlış işlenmiş olması halinde bunların düzeltilmesini isteme</li>
<li>Kişisel verilerinizin silinmesini veya yok edilmesini isteme</li>
<li>İşlenen verilerinizin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle aleyhinize bir sonucun ortaya çıkmasına itiraz etme</li>
<li>Kişisel verilerinizin kanuna aykırı olarak işlenmesi sebebiyle zarara uğramanız halinde zararın giderilmesini talep etme</li>
</ul>
<p>Haklarınızı kullanmak için herteldenshoptr@gmail.com adresine yazılı başvurabilirsiniz.</p>

<h2>9. Değişiklikler</h2>
<p>Bu gizlilik politikası gerektiğinde güncellenebilir. Önemli değişiklikler sitede duyurulacaktır.</p>
<p><em>Son güncelleme: [TARİH]</em></p>
HTML;
}

/* =====================================================
   MESAFELİ SATIŞ SÖZLEŞMESİ
===================================================== */
function hy_mesafeli_content() {
    return <<<'HTML'
<p><em>Bu sözleşme, 6502 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği kapsamında düzenlenmiştir.</em></p>

<h2>MADDE 1 — TARAFLAR</h2>
<p><strong>SATICI</strong><br>
Unvan: <strong>[FİRMA UNVANI]</strong><br>
Adres: <strong>[FİRMA ADRESİ]</strong><br>
E-posta: herteldenshoptr@gmail.com<br>
Web sitesi: herteldenshop.com</p>

<p><strong>ALICI</strong><br>
Sipariş sırasında girilen ad, soyad ve adres bilgileri geçerlidir.</p>

<h2>MADDE 2 — KONU</h2>
<p>Bu sözleşme; Alıcı'nın herteldenshop.com üzerinden sipariş verdiği ürün(ler)in satışı ve teslimatına ilişkin tarafların hak ve yükümlülüklerini düzenler.</p>

<h2>MADDE 3 — SÖZLEŞME KONUSU ÜRÜN</h2>
<p>Ürün bilgileri (ad, adet, birim fiyat, toplam tutar, KDV) sipariş onay e-postasında ve sipariş özet sayfasında yer almaktadır.</p>

<h2>MADDE 4 — GENEL HÜKÜMLER</h2>
<ul>
<li>Alıcı, sipariş vermeden önce ürün bilgilerini, fiyatı ve ödeme koşullarını okuduğunu ve kabul ettiğini beyan eder.</li>
<li>Sipariş onayı e-posta ile bildirilir. Bu bildirim sözleşmenin kurulduğunun teyididir.</li>
<li>Satıcı, stok yetersizliği veya mücbir sebep halinde siparişi iptal etme hakkını saklı tutar; bu durumda ödeme 14 gün içinde iade edilir.</li>
</ul>

<h2>MADDE 5 — TESLİMAT</h2>
<ul>
<li>Ürünler, sipariş tarihinden itibaren en geç <strong>7 iş günü</strong> içinde kargoya verilir.</li>
<li>Teslimat adresi, Alıcı'nın sipariş sırasında belirttiği adrestir.</li>
<li>Kargo ücreti, sipariş tutarına göre belirlenir. 500 ₺ ve üzeri siparişlerde kargo ücretsizdir.</li>
<li>Ürün hasarlı teslim edilmişse Alıcı, tutanak tutarak kargo görevlisine iade etmelidir.</li>
</ul>

<h2>MADDE 6 — ÖDEME</h2>
<p>Ödeme yöntemleri:</p>
<ul>
<li><strong>Banka Havalesi / EFT:</strong> Sipariş sonrası gösterilen IBAN bilgisine, sipariş numarasını açıklama olarak yazarak ödeme yapılır. Ödeme 2 iş günü içinde teyit edilir.</li>
<li><strong>Kredi/Banka Kartı:</strong> [Ödeme sistemi kurulunca eklenecektir]</li>
</ul>

<h2>MADDE 7 — CAYMA HAKKI</h2>
<p>Alıcı, teslim tarihinden itibaren <strong>14 gün</strong> içinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir.</p>
<p>Cayma hakkı kullanımı için herteldenshoptr@gmail.com adresine e-posta ile bildirim yapılması yeterlidir.</p>
<p>Cayma hakkı aşağıdaki ürünlerde kullanılamaz (Mesafeli Sözleşmeler Yönetmeliği Madde 15):</p>
<ul>
<li>Alıcı tarafından açılmış, ambalajı bozulmuş hijyenik ürünler</li>
<li>Niteliği itibarıyla iade edilemeyecek, çabuk bozulabilecek veya son kullanma tarihi geçebilecek mallar</li>
</ul>

<h2>MADDE 8 — İADE SÜRECİ</h2>
<p>Cayma hakkı kullanıldığında:</p>
<ul>
<li>Ürün, bildirim tarihinden itibaren 10 gün içinde iade edilmelidir.</li>
<li>İade kargo ücreti Alıcı'ya aittir (ürün hatalı veya ayıplıysa Satıcı üstlenir).</li>
<li>Ödeme iadesi, ürünün teslim alınmasından itibaren 14 gün içinde yapılır.</li>
</ul>

<h2>MADDE 9 — AYIPLI MAL</h2>
<p>Teslim edilen ürün ayıplı (hatalı, eksik, bozuk) ise Alıcı; onarım, değişim, bedel indirimi veya iade haklarından birini kullanabilir. Bu durumda kargo ücreti Satıcı'ya aittir.</p>

<h2>MADDE 10 — GİZLİLİK</h2>
<p>Alıcı'ya ait kişisel veriler Gizlilik Politikamız kapsamında işlenir. Ödeme bilgileri şifreli kanallar üzerinden iletilir ve Satıcı tarafından saklanmaz.</p>

<h2>MADDE 11 — UYUŞMAZLIK</h2>
<p>Uyuşmazlıklarda Tüketici Mahkemeleri ve Tüketici Hakem Heyetleri yetkilidir. Başvuru için T.C. Ticaret Bakanlığı'nın tüketici portalı kullanılabilir: <a href="https://tuketici.ticaret.gov.tr" target="_blank">tuketici.ticaret.gov.tr</a></p>

<h2>MADDE 12 — YÜRÜRLÜK</h2>
<p>Bu sözleşme, Alıcı'nın siparişi onaylamasıyla birlikte yürürlüğe girer.</p>
<p><em>Son güncelleme: [TARİH]</em></p>
HTML;
}

/* =====================================================
   İPTAL VE İADE KOŞULLARI
===================================================== */
function hy_iade_content() {
    return <<<'HTML'
<h2>İptal Koşulları</h2>

<h3>Sipariş İptali</h3>
<ul>
<li>Sipariş <strong>kargoya verilmeden önce</strong> iptal edilebilir.</li>
<li>İptal talebi için herteldenshoptr@gmail.com adresine sipariş numaranızı bildirin.</li>
<li>Kargoya verilmiş siparişler iptal edilemez; ancak teslim aldıktan sonra iade hakkınızı kullanabilirsiniz.</li>
<li>Ödeme iadesi, iptal onayından itibaren <strong>14 gün</strong> içinde gerçekleştirilir.</li>
</ul>

<h2>İade Koşulları</h2>

<h3>Cayma Hakkı (14 Gün)</h3>
<p>6502 sayılı Tüketicinin Korunması Hakkında Kanun gereğince, ürünü teslim aldığınız tarihten itibaren <strong>14 gün</strong> içinde herhangi bir sebep göstermeksizin iade edebilirsiniz.</p>

<h3>İade Kabul Koşulları</h3>
<ul>
<li>Ürün orijinal ambalajında ve kullanılmamış olmalıdır.</li>
<li>Ürüne ait tüm aksesuarlar, belgeler ve hediye ürünler iade edilmelidir.</li>
<li>Fatura veya sipariş numarası ile birlikte gönderilmelidir.</li>
</ul>

<h3>İade Kabul Edilmeyen Durumlar</h3>
<ul>
<li>Ambalajı açılmış hijyenik ürünler (bornoz, havlu seti vb. — yıkanmış veya kullanılmış)</li>
<li>Müşteri tarafından hasar görmüş ürünler</li>
<li>Kişiye özel üretilmiş ürünler</li>
<li>14 günlük cayma süresi geçmiş ürünler (aşağıdaki garanti hakları saklı kalmak kaydıyla)</li>
</ul>

<h2>Ayıplı (Hatalı/Bozuk) Ürün İadesi</h2>
<p>Teslim aldığınız ürün hatalı, eksik veya bozuksa 14 günlük süreye bakılmaksızın aşağıdaki haklardan birini kullanabilirsiniz:</p>
<ul>
<li><strong>Ücretsiz onarım</strong></li>
<li><strong>Yeni ürünle değişim</strong></li>
<li><strong>Bedel indirimi</strong></li>
<li><strong>Tam iade</strong></li>
</ul>
<p>Bu durumda iade kargo ücreti tarafımıza aittir.</p>

<h2>İade Süreci</h2>
<ol>
<li>herteldenshoptr@gmail.com adresine <strong>sipariş numaranız</strong> ve <strong>iade gerekçenizi</strong> bildirin.</li>
<li>İade onayı tarafımızdan e-posta ile gönderilir.</li>
<li>Ürünü orijinal ambalajında, fatura ile birlikte kargoya verin.</li>
<li>Ürün tarafımıza ulaştıktan sonra <strong>14 gün</strong> içinde ödeme iadesi yapılır.</li>
</ol>

<h3>İade Kargo Ücreti</h3>
<ul>
<li><strong>Cayma hakkı kapsamındaki iadelerde:</strong> Kargo ücreti alıcıya aittir.</li>
<li><strong>Hatalı/ayıplı ürün iadelerinde:</strong> Kargo ücreti Hertelden Shop\'a aittir.</li>
</ul>

<h2>Ödeme İadesi</h2>
<ul>
<li><strong>Havale/EFT ile ödeme:</strong> İade, bildirdiginiz IBAN'a yapilir.</li>
<li><strong>Kredi karti ile ödeme:</strong> İade, kartiniza iade edilir (bankaniza göre 3-10 is günü sürebilir).</li>
</ul>

<h2>İletişim</h2>
<p>İptal ve iade işlemleri için:<br>
E-posta: <a href="mailto:herteldenshoptr@gmail.com">herteldenshoptr@gmail.com</a></p>
<p><em>Son güncelleme: [TARİH]</em></p>
HTML;
}
