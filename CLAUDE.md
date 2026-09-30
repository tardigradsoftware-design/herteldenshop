# herteldenshop.com — E-ticaret Projesi Durumu

## Hedef (unutma!)
Sadece bir web sitesi değil, **tam merkezi bir e-ticaret sistemi**:
- Kendi site (WooCommerce) + tüm pazaryerleri (Trendyol, Hepsiburada, N11) TEK panelden yönetilecek
- Merkezi stok senkronizasyonu (bir kanalda satılan üründe tüm kanallarda stok otomatik düşecek)
- Merkezi sipariş takibi (hangi kanaldan gelirse gelsin tek yerden görülecek)
- Kargo entegrasyonu tüm kanallar için ortak
- Faturalandırma otomatik (e-arşiv), tüm kanallardaki satışlar için

## Ürün grupları
- Banyo organizer
- Çeyizlik mutfak-sofra grupları
- Fenomen ürünler (trend/viral ürünler)

## İşletme yapısı
- Şahıs firması **kardeşinin adına** kurulacak (henüz kurulmadı)
- Kullanıcının kendi banka hesapları var — fatura/ödeme akışı uyumu netleşmedi, mali müşavire danışılacak
- Nebim V3 kullanılmayacak (eski işverenin sistemiydi, artık alakası yok)

## Platform kararı (netleşti)
WordPress + WooCommerce'te **kalınıyor**. Ticimax/IdeaSoft gibi ücretli SaaS'a geçilmeyecek çünkü:
- Zaten büyük iş bitti (aşağıya bak), sıfırdan kuruluma değmez
- Ücretli SaaS aylık maliyet demek, kullanıcı ücretsiz çözüm tercih ediyor
- Asıl eksik görsel tasarımdı, platform sorunu değildi

## Teknik altyapı (kuruldu)
- Domain: **herteldenshop.com**
- Hosting: Hostinger Single plan (Almanya/Frankfurt sunucu, LiteSpeed)
- Platform: WordPress + WooCommerce
- Tema: Kadence (ücretsiz) + Kadence Blocks
- Mağaza e-postası: herteldenshoptr@gmail.com
- E-posta gönderimi: WP Mail SMTP + Gmail App Password ile kuruldu, test edildi, çalışıyor (test siparişinde mail başarıyla geldi)

## WooCommerce ayarları — TAMAMLANDI
- Genel: adres, TL para birimi, vergi dahil fiyatlandırma
- Ürünler: kg/cm ölçü birimleri, stok yönetimi ayarları
- Vergi: %20 standart KDV, %10 azaltılmış oran (valiz vb. için), fiyatlar vergi dahil gösteriliyor
- Gönderim: "Türkiye" bölgesi → Sabit fiyat (kargo ücreti) + Asgari 500₺ üzeri ücretsiz kargo (kupon indiriminden önce hesaplanıyor)
- Ödemeler: Banka Havalesi/EFT aktif edilecek (henüz IBAN net değil, kardeşin şirket hesabı bekleniyor). Kapıda ödeme İSTENMİYOR. Kart ödemesi (iyzico/PayTR) şirket kurulunca eklenecek
- Hesaplar/gizlilik: Misafir ödeme açık, hesap oluşturma "ödemeden sonra"
- E-postalar: bildirim alıcıları herteldenshoptr@gmail.com olarak güncellendi
- Site görünürlüğü: "Çok yakında" modu (sadece mağaza sayfası gizli) — ürünler + ödeme + yasal sayfalar tamamlanınca "Yayında"ya geçilecek
- Gelişmiş: sayfa atamaları otomatik/doğru

## Tamamlanan işler
- **124 ürün kategorisi** oluşturuldu (hiyerarşik: ör. Banyo → Banyo Havlusu, Banyo Paspası vb.)
- **Yasal sayfalar** — özel plugin (`hertelden-yasal-sayfalar`) ile otomatik oluşturuldu: Gizlilik Politikası/KVKK, Mesafeli Satış Sözleşmesi, İptal-İade Koşulları (footer menüsünde). İçeriklerde [Şahıs Firması Unvanı] gibi placeholder'lar var, şirket kurulunca doldurulacak
- **9 demo ürün** eklendi (plugin (`hertelden-demo-urunler`) ile otomatik, 15 hedeflenmişti, 6 tanesi kategori slug uyuşmazlığı yüzünden atlandı, kullanıcı 9 ile devam kararı verdi). Bunlar gerçek satılacak ürünler değil, test amaçlı — SEO/görsel emeği verilmeyecek
- **Logo yüklendi** — Safe SVG eklentisi ile SVG güvenlik kısıtlaması aşıldı, Kadence Site Identity üzerinden logo aktif, alt metin girildi ("Hertelden Shop Logosu")
- **Satın alma akışı test edildi** — ürün → sepet → checkout → Banka Havalesi/EFT → sipariş oluşturuldu (#1334) → email bildirimi başarıyla geldi (hem admin hem müşteri tarafı çalışıyor, mail içeriği profesyonel: ürün, toplam, KDV, adres, ödeme yöntemi hepsi doğru)
- **SEO otomasyonu** — özel plugin (`hertelden-seo-oto`) ile 124 kategoriye Rank Math meta title/description/focus keyword otomatik yazıldı (format: "{Kategori} Fiyatları - Hertelden Shop" + satış odaklı açıklama). Tekrar çalıştırmak için: Araçlar → Hertelden SEO Otomasyon
- **Rank Math kurulum sihirbazı tamamlandı** (Gelişmiş mod, Site Türü: Sanal mağaza, Web Sitesi Adı/Kuruluş Adı: "Hertelden Shop", Site Haritaları'nda "Ürün kategorileri" taksonomisi dahil edildi)
- **Ana sayfa oluşturuldu** — özel plugin (`hertelden-anasayfa`) ile otomatik: kategori şeridi, hero banner, ürün vitrini (WooCommerce shortcode), güven rozetleri. v1.2'de emoji kaldırıldı, gerçek SVG ikonlar + WooCommerce ürün kartlarına site geneli profesyonel CSS eklendi (gölge, hover, kare görsel oranı)
- **Tasarım yönü belirlendi ama henüz uygulanmadı** — kullanıcı "amatör duruyor" dedi, frontend-design ilkeleri yüklendi. Planlanan yön: sıcak gri-beyaz zemin (#F7F5F2), mürekkep siyahı (#22201D), turuncu (#EC7920) sadece vurgu, başlıklarda serif font (Fraunces) + gövdede sans (Inter), kategori kutularında marka tonları (kirli turuncu/hardal/adaçayı/toprak). **Kullanıcı "şimdilik bekle" dedi, henüz uygulanmadı.**

## Sırada ne var (öncelik sırası)
1. ~~Yasal sayfalar~~ ✅
2. ~~Ürün kategorileri + ilk ürünler~~ ✅
3. ~~Logo~~ ✅
4. ~~Satın alma akışı testi~~ ✅
5. ~~Rank Math kurulumu~~ ✅
6. **Google Search Console bağlantısı — ŞİMDİLİK ATLANDI, site "Yayında" moduna geçince MUTLAKA yapılacak** (kullanıcı özellikle hatırlatılmasını istedi, unutma)
7. **Ana sayfa görsel tasarımını yukarıdaki plana göre uygula** (kullanıcı onay verince)
8. Kalan ürün sayfalarına da Rank Math meta ekle (kategoriler bitti, ürünler kaldı — ama şu an demo ürün, gerçek ürünler gelince yapılacak)
9. **Şirket resmileşince:**
   - iyzico/PayTR kart ödemesi bağlanacak
   - Eafatura/Faturatik ile otomatik e-arşiv fatura kurulacak (kullanıcı manuel fatura kesmeyi hiç istemiyor, tam otomasyon şart)
   - Yasal sayfalardaki [Şahıs Firması Unvanı] placeholder'ları doldurulacak
10. **Pazaryeri entegrasyonu + merkezi stok** — Pazarus / API Isarud / BirFatura gibi çözümlerle Trendyol, Hepsiburada, N11 bağlanacak
11. **Kargo entegrasyonu** genişletilecek (tüm kanallar için ortak)
12. Gerçek ürünler + gerçek ürün fotoğrafları yüklenecek (demo ürünlerin yerine)
13. Site "Yayında" moduna alınacak (bu adımda Google Search Console bağlantısı da yapılacak)

## Oluşturulan özel WordPress eklentileri (plugin'ler)
Bunların hepsi kullanıcının bilgisayarında ZIP olarak duruyor, admin panelde kurulu:
- `hertelden-yasal-sayfalar` — 3 yasal sayfa oluşturur
- `hertelden-demo-urunler` — 15 demo ürün oluşturur (9'u başarılı)
- `hertelden-seo-oto` — tüm kategorilere Rank Math SEO verisi yazar (Araçlar menüsünden tekrar çalıştırılabilir)
- `hertelden-anasayfa` — Ana Sayfa içeriğini oluşturur + site geneli ürün kartı CSS'i ekler (Araçlar menüsünden tekrar çalıştırılabilir, v1.2)

## Kullanıcı tercihleri (unutma)
- Her zaman ücretsiz + profesyonel çözüm önerilsin, önce ücretsiz seçenek sunulsun
- Hız/performans öncelikli ama en ucuz yoldan sağlanmalı
- Manuel iş istemiyor, mümkün olan her yerde tam otomasyon istiyor (plugin ile toplu işlem tercih ediliyor)
- **Otomasyonlarda asla basite kaçma — manuel yapılsaydı ne olacaksa otomasyon da tam onu yapmalı, kısayol yok**
- Kapıda ödeme istemiyor, sadece IBAN + kart
- Çok kısa, adım adım, emir kipi talimatlar istiyor ("tam olarak anlamıyorum seni bazen" geri bildirimi aldı) — paragraf açıklama değil, numaralı liste
- Baskı hissetmek istemiyor, ama teknik olarak doğru sıra neyse onu takip etmek istiyor (kararı Claude'a bırakıyor)
- Amatör/emoji dolu tasarım istemiyor, Amazon/Trendyol/Karaca/Schafer seviyesinde profesyonel görünüm istiyor — ama klişe/şablon gibi de durmasın, markaya özel bir tasarım dili istiyor
- İş sürekliliği önemsiyor: neler yapıldığının, neler kaldığının bir yerde (bu dosya gibi) kayıtlı olmasını istiyor
