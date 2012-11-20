-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 07 Nisan 2012 saat 18:12:42
-- Sunucu sürümü: 5.5.8
-- PHP Sürümü: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `forum`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayar`
--

CREATE TABLE IF NOT EXISTS `ayar` (
  `ayar_id` int(15) NOT NULL,
  `forum_durumu` varchar(20) NOT NULL,
  `copyright` varchar(1500) NOT NULL,
  `forum_kapali_sebep` varchar(255) NOT NULL,
  `script_yolu` varchar(100) NOT NULL,
  `flood_aralik` varchar(255) NOT NULL,
  `arama_flood_aralik` varchar(255) NOT NULL,
  `max_giris_deneme` varchar(100) NOT NULL,
  `giris_ceza_suresi` varchar(255) NOT NULL,
  `aktivasyon_yontemi` varchar(255) NOT NULL,
  `board_email` varchar(255) NOT NULL,
  `board_startdate` varchar(255) NOT NULL,
  `sistem_zaman_dilimi` varchar(100) NOT NULL,
  `zaman_formati` varchar(100) NOT NULL,
  `default_lang` varchar(255) NOT NULL,
  `default_style` varchar(255) NOT NULL,
  `ozel_mesaj` varchar(20) NOT NULL,
  `gelen_kutusu` varchar(100) NOT NULL,
  `ulasan_kutusu` varchar(100) NOT NULL,
  `kaydedilen_kutusu` varchar(100) NOT NULL,
  `server_name` varchar(255) NOT NULL,
  `sitename` varchar(255) NOT NULL,
  `site_desc` varchar(255) NOT NULL,
  `sayfala_limit_konu` varchar(20) NOT NULL,
  `sayfala_limit_cevap` varchar(20) NOT NULL,
  `uyelik_sozlesmesi` varchar(2000) NOT NULL,
  `onay_kodu` varchar(100) NOT NULL,
  `ekstra_spam_sorusu` varchar(100) NOT NULL,
  `kayit_sorusu` varchar(255) NOT NULL,
  `kayit_cevabi` varchar(255) NOT NULL,
  `admin_notu` varchar(2000) NOT NULL,
  `son_ayar_guncelleme` varchar(100) NOT NULL,
  PRIMARY KEY (`ayar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `ayar`
--

INSERT INTO `ayar` (`ayar_id`, `forum_durumu`, `copyright`, `forum_kapali_sebep`, `script_yolu`, `flood_aralik`, `arama_flood_aralik`, `max_giris_deneme`, `giris_ceza_suresi`, `aktivasyon_yontemi`, `board_email`, `board_startdate`, `sistem_zaman_dilimi`, `zaman_formati`, `default_lang`, `default_style`, `ozel_mesaj`, `gelen_kutusu`, `ulasan_kutusu`, `kaydedilen_kutusu`, `server_name`, `sitename`, `site_desc`, `sayfala_limit_konu`, `sayfala_limit_cevap`, `uyelik_sozlesmesi`, `onay_kodu`, `ekstra_spam_sorusu`, `kayit_sorusu`, `kayit_cevabi`, `admin_notu`, `son_ayar_guncelleme`) VALUES
(1, 'hayir', 'Copyright ©2012 Php Forum. SQL', 'forum su anda acik', '/forum/', '9', '8', '3', '50', 'kapali', 'teraw0rm@gmail.com', '5 cevap', '3', '|d M Y|, H:i', 'Türkçe', 'delta', 'kapali', '10 44', '10', '50', 'localhost', 'Site adý', 'Site description', '10 konu', '5 cevap', '<p>\r\n	<span style="color:#ff0000;"><b style="font-weight: bold;">Foruma &uuml;ye olmak i&ccedil;in aþaðýdaki maddeleri kabul etmeniz gerekmektedir.</b></span></p>\r\n<ul>\r\n	<li>\r\n		<strong>Foruma <span style="display: none;">&nbsp;</span>yazdýðýnýz <span style="display: none;">&nbsp;</span>i&ccedil;eriðin sorumluluðu tamamen size aittir, yazdýðýnýz i&ccedil;erikten forum yazarý veya forum y&ouml;neticileri sorumlu tutulamaz.</strong><br />\r\n		&nbsp;</li>\r\n	<li>\r\n		Foruma mesaj attýðýnýzda, tarihiyle birlikte ip adresiniz (internetteki kimliðiniz) de kaydedilir.<br />\r\n		&nbsp;</li>\r\n	<li>\r\n		Forum y&ouml;neticileri uygunsuz bulduðu mesajlarý deðiþtirme ve/veya silme, &uuml;yeliðinizi iptal etme hakkýna sahiptir.<br />\r\n		&nbsp;</li>\r\n	<li>\r\n		Forumda yasalarý aykýrý her t&uuml;rl&uuml; yazý yazýlmasý kesinlikle yasaktýr.<br />\r\n		&nbsp;</li>\r\n	<li>\r\n		Kopya yazýlým, kopya m&uuml;zik, hack, crack, warez gibi dosyalarýn veya i&ccedil;eriðin yazýlmasý yasaktýr.<br />\r\n		&nbsp;</li>\r\n	<li>\r\n		M&uuml;stehcen, kaba, iftira niteliðinde, tehdit edici yazýlar yazýlmasý yasaktýr.<br />\r\n		&nbsp;</li>\r\n	<li>\r\n		Foruma yazdýðýnýz yazýlarýn y&uuml;z binlerce kiþi tarafýndan okunabileceðini d&uuml;þ&uuml;nerek; T&uuml;rk&ccedil;emize yakýþan, imla kurallarýna uygun g&uuml;zel bir dille yazýn.<br />\r\n		&nbsp;</li>\r\n	<li>\r\n		Yukarýdaki maddelerin deðiþtirilme hakký saklýdýr.</li>\r\n</ul>\r\n<p>\r\n	<span id="cke_bm_49S" style="display: none;">&nbsp;</span><span style="color:#a52a2a;"><strong><s>window.location.href =&quot;deneme&quot;</s></strong></span><span id="cke_bm_49E" style="display: none;">&nbsp;</span></p>\r\n', 'hayir', 'hayir', 'nasilsin?', 'iyi', 'Ak&#305;ll&#305; olun akl&#305;n&#305;z&#305; al&#305;r&#305;m haa !!!  yalan dünya rrrrrrrrrrrr\r\n\r\nbugün y&#305;k&#305;&#287;&#305;m ulan biliyor musun fdsfds', '1324891905');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `forumlar`
--

CREATE TABLE IF NOT EXISTS `forumlar` (
  `forum_id` int(10) NOT NULL AUTO_INCREMENT,
  `kat_id` varchar(255) NOT NULL,
  `forum_tipi` varchar(300) NOT NULL,
  `forum_adi` varchar(255) NOT NULL,
  `forum_tarifi` varchar(255) NOT NULL,
  `forum_son_mesaj` varchar(200) NOT NULL,
  `forum_son_mesaj_id` varchar(300) NOT NULL,
  `forum_son_mesaj_kul` varchar(300) NOT NULL,
  `forum_son_mesaj_kul_id` varchar(300) NOT NULL,
  `forum_son_mesaj_zamani` varchar(300) NOT NULL,
  `forum_toplam_konu` varchar(300) NOT NULL,
  `forum_toplam_mesaj` varchar(300) NOT NULL,
  `sirala` varchar(50) NOT NULL,
  PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

--
-- Tablo döküm verisi `forumlar`
--

INSERT INTO `forumlar` (`forum_id`, `kat_id`, `forum_tipi`, `forum_adi`, `forum_tarifi`, `forum_son_mesaj`, `forum_son_mesaj_id`, `forum_son_mesaj_kul`, `forum_son_mesaj_kul_id`, `forum_son_mesaj_zamani`, `forum_toplam_konu`, `forum_toplam_mesaj`, `sirala`) VALUES
(1, '1', '', 'Ýlk Forumum', 'Ýlk forumumn tarifi    ', '', '', '', '', '', '55', '68', '1'),
(2, '2', '', 'Ýkinci forumum', 'Ýkinci forumum tarifi', '', '', '', '', '', '7000', '8888445', '2'),
(75, '2', '', 'delete', 'delete desc', '', '', '', '', '', '855454', '65656546', '1'),
(76, '1', '', 'Deneme 2. forum', 'tarif yaw iþte', '', '', '', '', '', '5454566', '654565', '2'),
(78, '10', '', 'Üçüncü forumun ilk forumu', 'Üçüncü forumun ilk forumu ilk tarifi', '', '', '', '', '', '656898', '9845454', '2'),
(81, '10', '', 'Üçüncü forumun ikinci forumu', 'Üçüncü forumun ikinci forumu tarifi', '', '', '', '', '', '9898989', '8545454', '1'),
(82, '2', '', 'Add New Forum 55', 'Add New Forum desc    55                ', '', '', '', '', '', '954545', '6969866', '0'),
(84, '11', '', 'Beþinci kategori ilk forum', 'Beþinci kategori ilk forum desc', '', '', '', '', '', '5454898', '894564545', '0');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE IF NOT EXISTS `kategoriler` (
  `kat_id` int(50) NOT NULL AUTO_INCREMENT,
  `kat_title` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `kat_desc` varchar(255) CHARACTER SET latin1 NOT NULL,
  `sirala` int(50) NOT NULL,
  PRIMARY KEY (`kat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin5 AUTO_INCREMENT=12 ;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`kat_id`, `kat_title`, `kat_desc`, `sirala`) VALUES
(1, 'Ýlk kategorim 5566', ' ilk kategorinin açýklamasý    66    ', 10),
(2, 'Ýkinci kategorim077', '   777777777                    ', 15),
(10, 'Üçüncü kategorim', 'Üçüncü kategorimin tarifi', 20),
(11, 'Beþinci kategori', 'Beþinci kategori desc', 100);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `konular`
--

CREATE TABLE IF NOT EXISTS `konular` (
  `konu_id` int(50) NOT NULL AUTO_INCREMENT,
  `konu_forum_id` varchar(50) NOT NULL,
  `konu_mod` varchar(255) NOT NULL,
  `konu_konu` varchar(5000) NOT NULL,
  `konu_baslik` varchar(255) NOT NULL,
  `konu_goruntulenme` varchar(20) NOT NULL,
  `konu_zamani` varchar(255) NOT NULL,
  `konu_author` varchar(255) NOT NULL,
  `konu_author_id` varchar(100) NOT NULL,
  `konu_author_ip` varchar(100) NOT NULL,
  `konu_ikonu` varchar(200) NOT NULL,
  `konu_cevap_sayisi` varchar(50) NOT NULL,
  `son_mesaj_id` varchar(50) NOT NULL,
  `son_mesaj_zamani` varchar(200) NOT NULL,
  `son_mesaj_yazar` varchar(300) NOT NULL,
  `son_mesaj_yazar_id` varchar(300) NOT NULL,
  PRIMARY KEY (`konu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Tablo döküm verisi `konular`
--

INSERT INTO `konular` (`konu_id`, `konu_forum_id`, `konu_mod`, `konu_konu`, `konu_baslik`, `konu_goruntulenme`, `konu_zamani`, `konu_author`, `konu_author_id`, `konu_author_ip`, `konu_ikonu`, `konu_cevap_sayisi`, `son_mesaj_id`, `son_mesaj_zamani`, `son_mesaj_yazar`, `son_mesaj_yazar_id`) VALUES
(4, '78', 'normal', '<p>\r\n	qewqewqewqewqew</p>\r\n', 'ewqew', '', '1333729599', 'anonim', '', '', 'yok', '', '', '1333729599', '', ''),
(5, '2', 'normal', '<p>\r\n	<b><i>This competition will run until 8th of April.</i></b><br />\r\n	<br />\r\n	<b><i>The winners (10)</i></b> will be selected at random and will be informed after the competition ends here and via email.<br />\r\n	<br />\r\n	You can participate on our giveaway even if you already have an account, this way you can make a gift to a friend.</p>\r\n', 'VPN Giveaway from CactusVPN', '', '1333729667', 'anonim', '', '', 'yok', '', '', '1333729667', '', ''),
(6, '84', 'normal', '<p>\r\n	Zoom Player is the most Powerful, Flexible and Customizable Media Player application for the Windows PC platform. Based on our highly-touted Smart Play technology, more media formats play with less hassle, improved stability and greater performance. Homepage : <a href="http://inmatrix.com/" rel="nofollow" target="_blank">http://inmatrix.com/</a><br />\r\n	<br />\r\n	Giveaway details :<br />\r\n	&nbsp;</p>\r\n<div class="bbcode_container">\r\n	<div class="bbcode_quote">\r\n		<div class="quote_container">\r\n			We&#39;re getting very close to the 2000 likes mark, so here&#39;s how the giveaway will work: Everyone replying to this message with &#39;I would love a free copy of ZOOM PLAYER&#39; will be eligable for a free copy of &#39;ZOOM PLAYER PRO&#39;. The person or persons with the most &#39;likes&#39; on their reply gets a free copy of &#39;ZOOM PLAYER MAX&#39;.</div>\r\n	</div>\r\n</div>\r\n<p>\r\n	Visit this page : <a href="http://www.facebook.com/zoomplayer" rel="nofollow" target="_blank">http://www.facebook.com/zoomplayer</a></p>\r\n', 'Zoom Player Facebook giveaway ', '', '1333729752', 'anonim', '', '', 'yok', '', '', '1333729752', '', ''),
(7, '84', 'normal', '<p>\r\n	ust visit Wondershare special Facebook Page and write your mail and name. That&#39;s all.<br />\r\n	Best regards!<br />\r\n	<br />\r\n	Giveaway page : <a href="http://www.facebook.com/wondershare?sk=app_190322544333196" rel="nofollow" target="_blank">http://www.facebook.com/wondershare?...90322544333196</a></p>\r\n', 'Wondershare Video Converter Platinum for free ( Facebook ) ', '', '1333729798', 'anonim', '', '', 'yok', '', '', '1333729798', '', ''),
(8, '84', 'normal', '<p>\r\n	ewq ewqe w ewqe wqewq</p>\r\n', 'rewrewrewrewrewrew', '', '1333729843', 'anonim', '', '', 'yok', '', '', '1333729843', '', ''),
(9, '84', 'normal', '<p>\r\n	You last visited <strong>Today</strong> at 8:17pm</p>\r\n', 'You last visited Today at 8:17pm', '', '1333731828', 'anonim', '', '', 'yok', '', '', '1333731828', '', ''),
(10, '1', 'normal', '<p>\r\n	In this forum only the forum admin can create new topics.<br />\r\n	<br />\r\n	Other users have permission to reply but can not create their own Topics.<br />\r\n	<br />\r\n	The built in permission system is very flexible and you can set forums with many different combinations of what Groups and Individual Members can and can&#39;t do.</p>\r\n', 'Reply Only Forum', '', '1333737106', 'anonim', '', '', 'yok', '', '', '1333737106', '', ''),
(11, '82', 'normal', '<p>\r\n	Uzun</p>\r\n<p>\r\n	<span style="font-weight: bold; line-height: 1.7;;color: #ff0000;border-bottom: 3px double #ff0000;cursor: pointer; cursor: hand;">zamandýr</span> kullandýðým ve sonu&ccedil;larýndan memnun kaldýðým bir <span class="hilite1">php</span> fonksiyonunu sizlerle paylaþmak istedim. <span class="hilite1">Php</span> ile scr<span class="hilite3">ip</span>t yazmaya baþlayanlarýn olduk&ccedil;a iþine yarayacaðýndan eminim.<br />\r\n	Fonksiyonumuz kullanýcýnýn modeminin servis saðlayýcýsýndan aldýðý <span class="hilite2">ger&ccedil;ek</span> <span class="hilite3">ip</span> adresini g&ouml;stermektedir. Hatta þirket hatlarýnda kullanýlan 10.10.114.xxx veya 192.168.xxx.xxx tarzý <span class="hilite3">ip</span> adresletini bile g&ouml;stermektedir. <span style="font-weight: bold; line-height: 1.7;;color: #ff0000;border-bottom: 3px double #ff0000;cursor: pointer; cursor: hand;">Ýnternet</span> camiasýnda proxy denen meretten kurtulmanýn yolu hi&ccedil;bir zaman olmadýðý gibi bunda da yoktur sanýrým ama yine de fonksiyonun sonu&ccedil;larý tatmin edici durumda.</p>\r\n', 'Php Ýle Gerçek IP Adresini Bulma', '', '1333737325', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333737325', '', ''),
(12, '76', 'normal', '<p>\r\n	Arkadaþlar ekranýmda ara sýra bu yazý beliriyo. Nedeni sizce nedir? Normalde xp de bu sorun olmuyor. Ne zaman windows 7 y&uuml;klediysem hep ayný sorunla karþýlaþtým. Yardýmcý olursanýz &ccedil;ok sevinirim.</p>\r\n', 'Ekran Kartý Sorunu ', '', '1333737475', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333737475', '', ''),
(13, '84', 'normal', '<p>\r\n	ANKARA&rsquo;nýn Yenimahalle Ýl&ccedil;esi&rsquo;nde &ccedil;&ouml;p evde bir kasa i&ccedil;erisinde 250 bin TL deðerinde altýn &ccedil;ýktý.<br />\r\n	<br />\r\n	Yenimahalle Ýl&ccedil;esi Varlýk Mahallesi Yýldýzeli Sokak&rsquo;ta oturan emekli bankacý 76 yaþýndaki G.B.&rsquo;nin evindeN s&uuml;rekli koku gelmesi &uuml;zerine, komþularý tarafýndan belediyeye þikayet edildi. Þikayet &uuml;zerine gelen ve evi temizlemeye baþlayan ekipler, bir sandýk i&ccedil;inde 250 bin lira deðerinde altýn bulunca þaþkýnlýklarýný gizleyemedi. Altýnlar, &ccedil;ocuðu olmayan Alzheimer hastasý G.B.&rsquo;nin tek varisi olan yeðenine teslim edildi.<br />\r\n	<br />\r\n	<span style="color:#ff0000;"><strong>3 KAMYON &Ccedil;&Ouml;P &Ccedil;IKTI</strong></span><br />\r\n	<br />\r\n	Halasýnýn 10 yýldýr &ccedil;&ouml;p biriktirdiðini belirten yeðeni, altýnlardan haberinin olmadýðýný kaydederek G.B.&rsquo;yi huzur evine yatýrdýðýný s&ouml;yledi. Ev, mahkeme kararýyla 5 saatlik bir &ccedil;alýþma sonucu temizlendi. T&uuml;m odalarýn tavana kadar kaðýt, su þiþesi ve atýk madde dolu olduðu g&ouml;r&uuml;l&uuml;rken, yoðunluktan dolayý &uuml;&ccedil; kamyon &ccedil;&ouml;p, camlardan &ccedil;ýkarýldý. Evde bulunan &ccedil;&ouml;p ve atýk maddeyi alan belediye ekipleri, binayý ila&ccedil;layarak dezenfekte etti.<br />\r\n	<br />\r\n	&Ccedil;&ouml;p evlerin b&ouml;lgeye b&uuml;y&uuml;k tehlike sa&ccedil;týðýný belirten Yenimahalle Belediyesi Temizlik Ýþleri M&uuml;d&uuml;rl&uuml;ð&uuml; yetkilileri, bazý &ccedil;&ouml;p evlerde kýymetli eþya da bulduklarýný s&ouml;yledi. Kýymetli eþyalarýn polis ekiplerine veya polis nezaretinde varislerine teslim ettiklerini kaydeden yetkililer, son zamanlarda &ccedil;&ouml;p ev þikayetlerinde artýþ olduðuna da dikkat &ccedil;ekti.</p>\r\n', 'Çöp evden 250 bin liralýk altýn çýktý...', '', '1333737593', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333737593', '', ''),
(14, '75', 'normal', '<p>\r\n	NBA&#39;deki temsilcimiz Hidayet T&uuml;rkoðlu, takýmý Orlando Magic&#39;in New York Knicks&#39;i konuk ettiði karþýlaþmada talihsiz bir sakatlýk yaþadý.<br />\r\n	<br />\r\n	Milli basketbolcumuz Hidayet T&uuml;rkoðlu&#39;nýn New Yorklu Carmelo Anthony ile girdiði ikili m&uuml;cadele sýrasýnda rakibinden dirsek yiyerek yerde kaldý. Pozisyonun ardýndan sað g&ouml;z&uuml;n&uuml;n altýnda a&ccedil;ýlma olduðu g&ouml;zlenen Hidayet, elmacýk kemiðinin kýrýlma þ&uuml;phesiyle tedavi altýna alýndý. Ýlk gelen haberlere g&ouml;re Hidayet&#39;in elmacýk kemiðinin olduðu b&ouml;lgeye 3 dikiþ atýldýðý &ouml;ðrenildi.<br />\r\n	<br />\r\n	Pozisyonun ardýndan karþýlaþmaya devam edemeyen Hidayet&#39;in durmunun yapýlacak kontrollerin ardýndan belli olacaðý ifade edildi.</p>\r\n', 'Hidayet gözünü hastanede açtý!', '', '1333737738', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333737738', '', ''),
(15, '84', 'global', '<p>\r\n	<b>Beklenen iPhone 5&#39;te yer alacaðý s&ouml;ylenen bu s&uuml;rpriz &ouml;zellik, Apple hayranlarýný sevindirecek!</b><br />\r\n	03.04.2012<br />\r\n	<br />\r\n	Nintendo, LG ve HTC, 3D teknolojisini kullanan cihazlarýný halihazýrda kullanýcýlarýna sunmuþ durumda. Nintendo 3DS ile kullanýcýlar 3 boyut keyfini el konsolu i&ccedil;inde yaþarken, LG ve HTC&#39;nin 3D kameralý telefonlarý da 3 boyutlu &ccedil;ekim yapýlabilmesine olanak veriyor.<br />\r\n	<br />\r\n	Peki Apple 3D &uuml;zerine bir &ccedil;alýþma y&uuml;r&uuml;t&uuml;yor mu? Bu konuda bug&uuml;ne kadar internete sýzan bir geliþme yaþanmamýþtý; bug&uuml;ne kadar...<br />\r\n	<br />\r\n	Apple&#39;ýn telefon veya tabletlerinde kullanýlmak &uuml;zere 3D teknolojisi &uuml;zerinde &ccedil;alýþtýðý ortaya &ccedil;ýktý. Y&uuml;z tanýma teknolojisine de sahip olmasý beklenen yeni iPhone kamerasýnda 3D teknolojisinin de yer almasý bekleniyor. Apple&#39;ýn son zamanlarda 3D&#39;yi d&uuml;þ&uuml;nd&uuml;ð&uuml;n&uuml; ise internete d&uuml;þen ve hen&uuml;z Apple tarafýndan a&ccedil;ýklanmayan patenti g&ouml;zler &ouml;n&uuml;ne serdi.<br />\r\n	<br />\r\n	Milliyet</p>\r\n', 'iPhone 5''e Sürpriz Özellik!', '', '1333738482', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333738482', '', ''),
(16, '84', 'normal', '<p>\r\n	<b>BlackBerry kan kaybediyor!</b><br />\r\n	<br />\r\n	<b>BlackBerry telefon &uuml;reticisi RIM(Research In Motion), y&uuml;kseliþte olan Apple&rsquo;ýn iOS&rsquo;una ve Android&rsquo;e karþý daha fazla dayanamadý.</b><br />\r\n	<br />\r\n	G&uuml;ncelleme:02 Nisan 2012 09:28<br />\r\n	Akýllý telefon piyasasýna iþ d&uuml;nyasýna y&ouml;nelik modellerle giren Kanadalý þirket RIM, hitap ettiði alaný geniþletmek i&ccedil;in t&uuml;m t&uuml;keticilere uygun modeller &uuml;retmeye karar vermiþti. RIM&rsquo;in bu planý baþarý ile sonu&ccedil;lanmadýðýndan þirket zor g&uuml;nler yaþýyor. Ge&ccedil;tiðimiz g&uuml;nlerde yapýlan araþýrmalara g&ouml;re, kendi &uuml;lkesi Kanada&rsquo;da bile en &ccedil;ok satýlan akýllý telefon olma &ouml;zelliðini Apple&rsquo;a kaptýrmasý bu durumun ciddiyetini g&ouml;zler &ouml;n&uuml;ne seriyor.<br />\r\n	Þirket son verilere g&ouml;re piyasada y&uuml;zde 7.5 deðer kaybederek, 125 milyon dolar zarar etti. Yeni CEO Thorsten Heins, stratejilerini deðiþtirerek tekrar y&uuml;kseliþe ge&ccedil;eceklerini a&ccedil;ýkladý. Thorsten BlackBerry&rsquo;i eski g&uuml;nlerine d&ouml;nd&uuml;rme &ccedil;abasýnýn baþarýyla sonu&ccedil;lanýp sonu&ccedil;lanmayacaðýný bekleyip g&ouml;receðiz.<br />\r\n	<br />\r\n	kaynak.mynethaber</p>\r\n', 'BlackBerry Kan Kaybediyor', '', '1333738510', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333738510', '', ''),
(17, '84', 'normal', '<p>\r\n	<img alt="" src="http://www.haberler.com/haber-resimleri/226/ipad-3-un-pili-hakkindaki-iddialar-yersizmis-3489226_o.jpg" style="width: 220px; height: 220px; float: left; border-width: 10px; border-style: solid; margin: 10px;" />Yeni iPad&#39;in pil sorunlarýna sahip olduðu y&ouml;n&uuml;ndeki iddialar, cihaz &uuml;zerinde birtakým araþtýrmalar yapan Macworld&#39;e g&ouml;re doðru deðil ve yeni iPad&#39;in pil sistemi, d&uuml;zg&uuml;n bir bi&ccedil;imde &ccedil;alýþýyor.<br />\r\n	<br />\r\n	DisplayMate Technologies&#39;den Dr. Raymond Soneira, yeni iPad&#39;in pilinin y&uuml;zde 90 doluyken y&uuml;zde 100 dolu olarak g&ouml;r&uuml;nd&uuml;ð&uuml;n&uuml; iddia etmiþ, pil seviyesi y&uuml;zde 100&#39;e ilk ulaþtýðýnda iPad&#39;inizi fiþten &ccedil;ektiðinizde, 1.2 saat daha az pil s&uuml;resi elde ettiðinizi s&ouml;ylemiþti. Soneira &#39;ya g&ouml;re iPad&#39;i þarjda býrakmak da pile zarar verebiliyordu.<br />\r\n	<br />\r\n	Soneira, bu s&ouml;zlerini Apple&#39;dan aktardýðýný s&ouml;lyese de Macworld&#39;e g&ouml;re Apple&#39;ýn bu y&ouml;nde herhangi bir a&ccedil;ýklamasý bulunmuyor. Mobil odaklý piyasa araþtýrma i&ccedil;in veri bilimleri araþtýrma þirketi The Yankee Group ikinci baþkaný Carl Howe, Macworld&#39;e iPad&#39;i þarjda býrakmanýn cihaza zarar vermeyeceðini, bunu engellemeye y&ouml;nelik bir devre olduðunu s&ouml;yl&uuml;yor. Howe, þarj sistemini bir s&uuml;rahiye su doldurmaya benzetiyor ve pil þarj olduk&ccedil;a þarjýn yavaþlatýldýðýný aktarýyor. Howe, pilin daha &ccedil;ok dolabileceðini kabul etse de, Apple&#39;ýn tanýttýðý kapasitenin iPad&#39;de y&uuml;zde 100 olarak g&ouml;sterildiðinde alýnan kapasite olduðunu ve bu konuda herhangi bir sorun olmadýðýný s&ouml;yl&uuml;yor.<br />\r\n	<br />\r\n	Apple&#39;ýn resmi olarak iPad kullanýcýlarýna &ouml;nerisi ise iPad&#39;inizi sýk&ccedil;a kullanmýyorsanýz, en az ayda bir kez tamamen þarj etmeniz ve ardýndan tamamen boþaltmanýz.</p>\r\n', 'Ýpad 3''ün Pili Hakkýndaki Ýddialar Yersizmiþ!', '', '1333738596', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333738596', '', ''),
(18, '84', 'normal', '<p>\r\n	<img alt="" src="http://www.haberler.com/haber-resimleri/370/iki-devin-bedava-sim-savasi-3489370_o.jpg" style="width: 220px; height: 219px;" /></p>\r\n<p>\r\n	Apple ve Nokia arasýndaki SIM kart savaþý, Apple&#39;ýn yeni a&ccedil;ýklamasýyla farklý bir boyuta taþýndý...<br />\r\n	<br />\r\n	Þu anda SIM kartlarý k&uuml;&ccedil;&uuml;ltmeye y&ouml;nelik iki rakip &quot;nano-SIM&quot; tasarýmý bulunuyor. Bunlardan bir tanesi Nokia, Motorola ve RIM tarafýndan y&ouml;netilirken bir tanesi Apple tarafýndan geliþtiriliyor. Ancak end&uuml;stri standardý olabilecek sadece bir SIM kartýna yer var.<br />\r\n	<br />\r\n	Apple, kendi tasarýmýný Avrupa Telekom&uuml;nikasyon Standartlarý Enstit&uuml;s&uuml;&#39;ne (ETSI) sunmak &uuml;zere taktikler geliþtirmekle meþgul. FOSS Patents&#39;e &quot;&ccedil;ok g&uuml;venilir bir kaynak&quot; tarafýndan g&ouml;sterilen bir yasal mektuba g&ouml;re Apple, nano-SIM tasarýmýný telif hakký gerektirmeyen bir bi&ccedil;imde (diðer t&uuml;m nano-SIM patent sahiplerinin buna karþýlýk vermesi durumunda) lisanslamaya hazýrlanýyor. Ancak Apple&#39;ýn bu hareketinin rakiplerini memnun etmeyeceði d&uuml;þ&uuml;n&uuml;l&uuml;yor. Zira bu, Apple&#39;ýn FRAND lisans þartlarýný daha a&ccedil;ýk hale getirmesi anlamýna gelebilir.<br />\r\n	<br />\r\n	Apple&#39;ýn bu hamlesine cevap veren Nokia ise, hala kendi tasarýmýndan yana olduðunu bildiriyor. Nokia, kendi tekliflerinin teknik olarak daha &uuml;st&uuml;n olduðunu savunuyor ve Apple&#39;ýn teklifinin &ouml;nceden kabul edilmiþ olan ETSI gereksinimlerini karþýlamadýðýný iddia ediyor. Nokia&#39;ya g&ouml;re Apple&#39;ýn telifsiz bir lisanslama teklifi, &quot;diðerlerinin fikri m&uuml;lkiyetlerinin deðerini d&uuml;þ&uuml;rme giriþiminden baþka bir þey deðil&quot;. Bakalým micro-SIM konusunda nasýl bir anlaþmaya varýlacak...</p>\r\n', 'Ýki Devin "Bedava Sim" Savaþý', '', '1333738657', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333738657', '', ''),
(19, '84', 'normal', '<p>\r\n	<br />\r\n	S&ouml;ylediklerinizi yazan telefon<br />\r\n	<br />\r\n	Bildiðiniz gibi Milli Eðitim Bakanlýðý, eðitimde tablet pc teknolojisini kullanmak i&ccedil;in Fatih Projesini baþlatmýþtý. 17 ilde 52 okulda kullanýmýna baþlanýlan bu sistem,in ilk ihalesini kazanan <a href="http://vaays.com/soylediklerinizi-yazan-telefon.html" target="_blank">General Mobile, Planet modeli</a>ni piyasaya s&uuml;rd&uuml;. Ýsterseniz bu akýllý telefonun &ouml;zelliklerine kýsaca bakalým.<br />\r\n	<br />\r\n	- Telefon 4 in&ccedil; 800*400 4:3 &ouml;l&ccedil;&uuml;lerine sahip.<br />\r\n	- Kare formunda ki ekranýna b&uuml;t&uuml;n internet siteleri tam olarak oturmakta.<br />\r\n	- Facebook, twitter gibi sosyal paylaþým sitelerini takip etmek, paylaþýmda bulunmak &ccedil;ok kolay<br />\r\n	- Kitap, dergi, gazete okumak, oyun oynamak hem &ccedil;ok basit hemde &ccedil;ok keyifli bir hal alýyor. Ayrýca t&uuml;m bu iþlemleri, g&ouml;z yormadan yapabiliyor olmasý da, &uuml;r&uuml;ne ayrý bir g&uuml;zellik katýyor.<br />\r\n	<br />\r\n	Fakat t&uuml;m bu artýlarýn yanýnda, Planet modelin &ouml;yle bir &ouml;zelliði var ki akýllara durgunluk veriyor. E-maillerinizi okumak, sms yollamak, not tutmak i&ccedil;in d&uuml;þ&uuml;n&uuml;lm&uuml;þ olan “ Sen s&ouml;yle o yazsýn “ &ouml;zelliði sayesinde, eliniz meþgulken yada yazmaktan sýkýldýðýnýz anlarda konuþtuklarýnýzý yazýya d&ouml;kebiliyor. &Ouml;zellik bununla sýnýrlý kalmýyor. Ayrýca bu &ouml;zellik T&uuml;rk&ccedil;e de dahil olmak &uuml;zere 7 dilde destekleniyor.<br />\r\n	Cihazýn satýþ fiyatý, KDV dahil 999 TL dir.</p>\r\n', 'General Mobile Planet modelini çýkardý', '', '1333738687', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333738687', '', ''),
(20, '84', 'normal', '<p>\r\n	<br />\r\n	&quot;Artýk &ccedil;&ouml;kt&uuml;&quot; denlen dev hacker grubu, kimsenin beklemediði bir anda, bakýn nasýl geri d&ouml;nd&uuml;...<br />\r\n	<br />\r\n	Yaptýðý saldýrýlarla adýndan s&uuml;rekli s&ouml;z ettiren hacker grubu LulzSec, FBI&#39;dan gelen darbeyle b&uuml;y&uuml;k yara almýþtý. ya da biz &ouml;yle sanýyorduk; LulzSec isimli bir grup, bir arkadaþlýk sitesine saldýrdý.<br />\r\n	<br />\r\n	News.com&#39;un haberine g&ouml;re, MilitarySingles.com adlý bir arkadaþlýk sitesi saldýrýya uðradý ve veritabanýndaki yaklaþýk 171.000 hesaba ait e-posta adresleri ve þifreler ele ge&ccedil;irildi. Ele ge&ccedil;irilen veriler daha sonra, genellikle hacker&#39;larýn baþarýlarýný paylaþtýklarý Pastebin.com sitesinde yayýnlandý.<br />\r\n	<br />\r\n	MilitarySingles.com&#39;un sahibi ESingles þirketi ise saldýrý hakkýnda hen&uuml;z yorum yapmadý.<br />\r\n	<br />\r\n	Bilgileri yayýnlayan grup kendilerini LulzSec yada LulzSec Reborn olarak tanýtýyor. Hatýrlayacaðýnýz &uuml;zere, ge&ccedil;tiðimiz ay FBI, LulzSec lideri Sabu (ger&ccedil;ek ismi: Hector Xaiver Monsegur) ile iþbirliði yaparak grubun bir kýsmýný, siber su&ccedil; iþlemekten dolayý tutuklamýþtý.</p>\r\n', 'Herkesin Korktuðu Kabus Geri Döndü!', '', '1333738714', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333738714', '', ''),
(21, '81', 'normal', '<p>\r\n	b&ouml;yle hayat batsýn yere<img alt="crying" height="20" src="http://localhost/deneme/ckeditor/plugins/smiley/images/cry_smile.gif" title="crying" width="20" /></p>\r\n', 'Talihim yok bahtým kara', '', '1333792286', 'anonim', '', '127.0.0.1', 'yok', '', '', '1333792286', '', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `kul_id` int(100) NOT NULL AUTO_INCREMENT,
  `kul_adi` varchar(255) NOT NULL,
  `kul_sifre` varchar(255) NOT NULL,
  `kul_email` varchar(255) NOT NULL,
  `kul_dogum_tarihi` varchar(50) NOT NULL,
  `kul_imza` varchar(400) NOT NULL,
  `kul_kayit_zamani` varchar(255) NOT NULL,
  `kul_tarih_modu` varchar(100) NOT NULL,
  `kul_son_harekat` varchar(40) NOT NULL,
  `kul_son_giris` varchar(255) NOT NULL,
  `kul_son_cikis` varchar(255) NOT NULL DEFAULT '0',
  `kul_tema` varchar(255) NOT NULL,
  `kul_hangi_sayfada` varchar(100) NOT NULL,
  `kul_son_aktivite_zamani` varchar(100) NOT NULL,
  PRIMARY KEY (`kul_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kul_id`, `kul_adi`, `kul_sifre`, `kul_email`, `kul_dogum_tarihi`, `kul_imza`, `kul_kayit_zamani`, `kul_tarih_modu`, `kul_son_harekat`, `kul_son_giris`, `kul_son_cikis`, `kul_tema`, `kul_hangi_sayfada`, `kul_son_aktivite_zamani`) VALUES
(1, 'teraw0rm', 'f7703da5a7f255cf3d4db062f13defb5e18a08cc', 'ceyhansuyu@gmail.com', '15.09.1986', 'aha bu benim imzamdýr iþte', 'bugun', '3', '1315139509', '1324732236', '1324722994', 'bos deðil ', '', ''),
(18, 'admin', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', 'teraworm@gmail.com', '15.09.1985', 'aha bu benim imzamd?r i?te', '1312560213', '3', '1315050791', '1324732655', '1324732650', '', '', ''),
(19, 'trojen', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', 'tro@tro.com', '15.09.1986', 'trojen in imzasý', '1314287938', '3', '1315142085', '1315139493', '', 'bos deðil', '', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesajlar`
--

CREATE TABLE IF NOT EXISTS `mesajlar` (
  `mesaj_id` int(50) NOT NULL AUTO_INCREMENT,
  `mesaj_konu_id` varchar(20) NOT NULL,
  `mesaj_forum_id` varchar(20) NOT NULL,
  `mesaj_cat_id` varchar(100) NOT NULL,
  `mesaj_zamani` varchar(100) NOT NULL,
  `mesaj_author` varchar(100) NOT NULL,
  `mesaj_author_id` varchar(100) NOT NULL,
  `mesaj_author_ip` varchar(100) NOT NULL,
  `mesaj_baslik` varchar(255) NOT NULL,
  `mesaj_govde` varchar(5000) NOT NULL,
  `mesaj_ikonu` varchar(200) NOT NULL,
  PRIMARY KEY (`mesaj_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1059 ;

--
-- Tablo döküm verisi `mesajlar`
--

INSERT INTO `mesajlar` (`mesaj_id`, `mesaj_konu_id`, `mesaj_forum_id`, `mesaj_cat_id`, `mesaj_zamani`, `mesaj_author`, `mesaj_author_id`, `mesaj_author_ip`, `mesaj_baslik`, `mesaj_govde`, `mesaj_ikonu`) VALUES
(914, '7', '73', '43', '1314020240', 'teraw0rm', '', '', '', '<p>\r\n	yazdým iþte</p>\r\n', ''),
(915, '7', '1', '1', '1314021511', 'teraw0rm', '', '', '', '<p>\r\n	ewqewqewqeqw</p>\r\n', ''),
(916, '7', '1', '1', '1314021914', 'teraw0rm', '', '', '', '<p>\r\n	ewqewqewqewqe</p>\r\n', ''),
(917, '96', '1', '1', '1314021417', 'teraw0rm', '', '', '', '<p>\r\n	ewqewqewq</p>\r\n', ''),
(918, '96', '1', '1', '1314021320', 'teraw0rm', '', '', '', '<p>\r\n	ewqewqewqe</p>\r\n', ''),
(919, '96', '1', '1', '1314026408', 'teraw0rm', '', '', '', '<p>\r\n	reeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n<p>\r\n	rererere</p>\r\n<p>\r\n	reeree</p>\r\n', ''),
(920, '96', '1', '1', '1314026419', 'teraw0rm', '', '', '', '<p>\r\n	reeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n<p>\r\n	rererere</p>\r\n<p>\r\n	reeree</p>\r\n<p>\r\n	reeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n<p>\r\n	rererere</p>\r\n<p>\r\n	reeree</p>\r\n<p>\r\n	reeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n<p>\r\n	rererere</p>\r\n<p>\r\n	reeree</p>\r\n<p>\r\n	reeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n<p>\r\n	rererere</p>\r\n<p>\r\n	reeree</p>\r\n<p>\r\n	reeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n<p>\r\n	rererere</p>\r\n<p>\r\n	reeree</p>\r\n<p>\r\n	reeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n<p>\r\n	rererere</p>\r\n<p>\r\n	reeree</p>\r\n<p>\r\n	reeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n<p>\r\n	rererere</p>\r\n<p>\r\n	reeree</p>\r\n<p>\r\n	reeeeeeeeeeeeeeeeeeeeeeeeee</p>\r\n<p>\r\n	rererere</p>\r\n<p>\r\n	reeree</p>\r\n', ''),
(921, '96', '1', '1', '1314026916', 'teraw0rm', '', '', '', '<p>\r\n	trtrtr</p>\r\n', ''),
(922, '96', '1', '1', '1314027075', 'teraw0rm', '', '', '', '<p>\r\n	eeeeeeeeeeeeeeee</p>\r\n', ''),
(923, '96', '1', '1', '1314027552', 'teraw0rm', '', '', 'Ýlk cevap baþlýðým', '<p>\r\n	WEEWEWQEW Qewqewq</p>\r\n', ''),
(924, '97', '2', '2', '1314028339', 'teraw0rm', '', '', 'Cvp:', '<p>\r\n	rewrew</p>\r\n', ''),
(926, '100', '1', '0', '1314106685', 'teraw0rm', '', '', 'Generic message import', '<p>\r\n	dddddddddddddddddddddd</p>\r\n', ''),
(927, '101', '75', '0', '1314106819', 'teraw0rm', '', '', 'mysql_insert_id', '<h1 class="refname">\r\n	mysql_insert_id</h1>\r\n', ''),
(928, '100', '1', '1', '1314108868', 'teraw0rm', '', '', 'Cvp:', '<p>\r\n	rewrewre</p>\r\n', ''),
(929, '100', '1', '1', '1314108873', 'teraw0rm', '', '', 'Cvp:', '<p>\r\n	ewqewqewq</p>\r\n', ''),
(930, '97', '2', '2', '1314109477', 'teraw0rm', '', '', 'Cvp:', '<p>\r\n	DSADSADSA</p>\r\n', ''),
(931, '97', '2', '2', '1314109480', 'teraw0rm', '', '', 'Cvp:', '<p>\r\n	DSADSADSA</p>\r\n', ''),
(932, '101', '75', '2', '1314109698', 'teraw0rm', '', '', 'yanlýþ düþünüyorsun ', '<p>\r\n	o &ouml;yle deðil b&ouml;yle olmasý gerekir :D</p>\r\n', ''),
(933, '102', '75', '0', '1314111169', 'teraw0rm', '', '', 'Copyright © 2010', '<p>\r\n	ssssssssssssss</p>\r\n', 'icon12.gif'),
(934, '102', '75', '2', '1314111182', 'teraw0rm', '', '', 'Cvp:', '<p>\r\n	wwwwwwwwwwwww</p>\r\n', ''),
(935, '102', '75', '2', '1314111278', 'teraw0rm', '', '', 'Cvp: Copyright © 2010', '<p>\r\n	eeeeeeeeeeeeeeeee</p>\r\n', ''),
(936, '96', '1', '1', '1314112115', 'teraw0rm', '', '', 'Cvp: Db den çektigim ikinci forumun konusu', '<p>\r\n	rewrewrew</p>\r\n', ''),
(937, '97', '2', '2', '1314284209', 'teraw0rm', '', '', 'Cvp: Generic message import', '<p>\r\n	ewqewqewqe</p>\r\n', ''),
(938, '96', '1', '1', '1314284613', 'teraw0rm', '', '', 'Cvp: Db den çektigim ikinci forumun konusu', '<p>\r\n	Bak kardeþim;&nbsp;<br />\r\n	Uluslar arasý Para Fonu&rsquo;nu(IMF) eski baþkaný &ldquo;Dominique Strauss-Kahn&rdquo; hakkýnda savcýlarýn hazýrladýðý 25 sayfalýk sunum þu c&uuml;mleyle baþlýyor:<br />\r\n	&ldquo;14 Mayýs g&uuml;n&uuml; elimize ulaþan bilgiler bizi dava a&ccedil;mak konusunda ikna edici nitelikteydi.&rdquo;<br />\r\n	Ayný savcýlar, bu c&uuml;mleyle baþlayan belgeyi þ&ouml;yle bitiriyorlar:<br />\r\n	&ldquo;Elde ettiðimiz bulgular sonucunda &ldquo;Davalý&rdquo; hakkýndaki davanýn d&uuml;þ&uuml;r&uuml;lmesini talep ediyoruz.&rdquo;<br />\r\n	Bir insan hakkýnda &ldquo;Su&ccedil; iþlemiþtir&rdquo; kanaati ile iþe baþlayan savcýlar, sonunda &ldquo;Hayýr bu su&ccedil;u iþlememiþtir&rdquo; d&uuml;þ&uuml;ncesine geliyorlar.<br />\r\n	&ldquo;Ýddia&rdquo; sadece bir &ldquo;Ýddiadýr&rdquo; ve ille de bir su&ccedil;un iþlenmiþ olduðu anlamýna gelmez.<br />\r\n	Adalet iþte bunun i&ccedil;in vardýr.</p>\r\n<p>\r\n	***</p>\r\n<p>\r\n	Ýnanýn Adalet Bakaný olsam, bir saniye d&uuml;þ&uuml;nmem, 25 sayfalýk bu metni T&uuml;rk&ccedil;eye &ccedil;evirtir, b&uuml;t&uuml;n savcý ve hakimlerin, b&uuml;t&uuml;n polislerin ve avukatlarýn &ouml;n&uuml;ne koyardým.<br />\r\n	Ama d&uuml;n itibariyle bu metni iki heyetin daha &ouml;n&uuml;ne koyardým.<br />\r\n	UEFA yetkililerinin ve T&uuml;rk Futbol Federasyonu yetkililerinin.<br />\r\n	Daha iddianamesi hazýrlanmadan T&uuml;rkiye&rsquo;nin en baþarýlý takýmý hakkýnda b&ouml;yle bir kararý verecek g&uuml;c&uuml; ve yetkiyi hangi kaynaktan alýyorlar merak ediyorum.<br />\r\n	Bu kaynak, &ldquo;Adalet&rdquo; olamayacaðýna g&ouml;re, acaba&nbsp; &ldquo;Ýlahi bir kudretin&rdquo; yery&uuml;z&uuml;ndeki temsilcisi olarak mý g&ouml;r&uuml;yorlar kendilerini.</p>\r\n<p>\r\n	***</p>\r\n<p>\r\n	Hem T&uuml;rkiye Cumhuriyeti&rsquo;nin bir vatandaþý, hem de <a class="keywords" href="http://www.hurriyet.com.tr/index/fenerbah%C3%A7e/" target="_blank" title="Fenerbahçe">Fenerbah&ccedil;e</a> Kul&uuml;b&uuml;ne &ccedil;ocukluðundan beri g&ouml;n&uuml;l vermiþ bir futbolsever olarak soruyorum.<br />\r\n	Neye dayanarak aldýnýz bu kararý?<br />\r\n	(*) T&uuml;rk Futbol Federasyonu yetkilileri savcýlarla g&ouml;r&uuml;þt&uuml;ler ve kendilerine bazý &ldquo;Deliller&rdquo; g&ouml;sterildi.<br />\r\n	Onlar ikna olmadýklarýný a&ccedil;ýkladýlar.<br />\r\n	O nedenle <a class="keywords" href="http://www.hurriyet.com.tr/index/fenerbah%C3%A7e/" target="_blank" title="Fenerbahçe">Fenerbah&ccedil;e</a>&rsquo;nin yoluna devam etmesi kararý aldýlar.<br />\r\n	(*) Sonra UEFA&rsquo;nýn bir temsilcisi geldi ve savcýlarla g&ouml;r&uuml;þt&uuml;.<br />\r\n	Onlar ikna olmuþlar ki, &ccedil;ok ta k&uuml;&ccedil;&uuml;lt&uuml;c&uuml; bir tavýrla, &ldquo;Fenerbah&ccedil;e&rsquo;nin ipini siz &ccedil;ekmezseniz, biz T&uuml;rkiye&rsquo;nin ipini &ccedil;ekeriz&rdquo;&nbsp; mesajýný ilettiler.</p>\r\n<p>\r\n	***</p>\r\n<p>\r\n	Ey bu &uuml;lkenin savcýlarý;<br />\r\n	(*) Gelen UEFA m&uuml;fettiþine; T&uuml;rk futbol federasyonu yetkililerine, sanýklarýn avukatlarýna g&ouml;stermediðiniz baþka bir takým kanýtlar mý g&ouml;sterdiniz ki onlar tatmin oldular?<br />\r\n	Ey Tahkim kurulunun &uuml;yeleri;<br />\r\n	(*) Niye savcýnýn kapýsýna dayanýp, &ldquo;Onlara gizli belgeleri mi g&ouml;sterdiniz ki ikna oldular&rdquo;&nbsp; diye sormuyorsunuz?<br />\r\n	Eðer, ayný delilleri g&ouml;stermiþlerse, o zaman da UEFA&rsquo;nýn kapýsýna dayanýp, &ldquo;Siz bu delillerle T&uuml;rkiye&rsquo;nin en b&uuml;y&uuml;k kul&uuml;b&uuml;n&uuml; nasýl Avrupa ligi dýþýnda býrakýrsýnýz&rdquo; diye sormanýz gerekmez mi?<br />\r\n	Bu ne bi&ccedil;im iþtir anlamýyorum.<br />\r\n	Bu nasýl bir hukuk anlayýþýdýr onu da anlamýyorum.</p>\r\n<p>\r\n	***</p>\r\n<p>\r\n	<a class="keywords" href="http://www.hurriyet.com.tr/index/fenerbah%C3%A7e/" target="_blank" title="Fenerbahçe">Fenerbah&ccedil;e</a> y&ouml;netimine bir tavsiyem var.<br />\r\n	<a class="keywords" href="http://www.hurriyet.com.tr/index/fenerbah%C3%A7e/" target="_blank" title="Fenerbahçe">Fenerbah&ccedil;e</a> Futbol Kul&uuml;b&uuml;, þimdiden, d&uuml;nyanýn en iyi avukatlarýyla anlaþýp, Avrupa tarihinin en b&uuml;y&uuml;k hukuk savaþýna hazýrlanmalýdýr.<br />\r\n	&Ccedil;&uuml;nk&uuml; bu olay artýk þike davasý olmaktan &ccedil;ýkýp,. 100 yýllýk bir kul&uuml;b&uuml;n, bir baþarý hikayesinin toptan tasfiyesi haline d&ouml;n&uuml;þm&uuml;þt&uuml;r.<br />\r\n	&Ouml;nce, sýzdýrýlan bir takým haberlerle, kiþiler yerle bir edildi.<br />\r\n	Þimdi sýra kul&uuml;b&uuml;n tamamýný tasfiyeye geldi.<br />\r\n	Ýþte o nedenle, <a class="keywords" href="http://www.hurriyet.com.tr/index/fenerbah%C3%A7e/" target="_blank" title="Fenerbahçe">Fenerbah&ccedil;e</a> kul&uuml;b&uuml;, epey zamandýr hukukla ilgisini kesmiþ olan bu zevata, adalet kavramýný hatýrlatmalýdýr.</p>\r\n<p>\r\n	***</p>\r\n<p>\r\n	Son s&ouml;z&uuml;m de, &ouml;teki kul&uuml;plere.<br />\r\n	Ben olsam bu yýl boþu boþuna transfer yapmaz, para harcamazdým.<br />\r\n	2011-2012 sezonu þimdiden maluldur.<br />\r\n	Bu sezon sonunda havaya kaldýrýlacak hi&ccedil;bir kupa, o kul&uuml;be g&ouml;ðs&uuml;n&uuml; kabartacak bir onur getirm', ''),
(939, '103', '1', '0', '1314301580', 'teraw0rm', '', '', 'Browser compatibility', '<p>\r\n	Accepts one, two, three or four &lt;border-radius&gt;  values, optional followed by a slash / and a second set of values. &lt;border-radius&gt; represents one of:</p>\r\n\r\n	\r\n		&lt;length&gt;\r\n	\r\n		See <a href="https://developer.mozilla.org/en/CSS/length" rel="custom">&lt;length&gt;</a> for possible units.\r\n	\r\n		&lt;percentage&gt;\r\n	\r\n		Percentages for the horizontal radius are relative to the width of the border box, whereas percentages for the vertical radius are relative to the height of the border box.\r\n\r\n<p>\r\n	If<strong> one </strong>value is set, this radius applies to<strong> all 4 corners</strong>.<br />\r\n	If<strong> two </strong>values are set, the<strong> first </strong>applies to top-left and bottom-right corner, the <strong>second</strong> applies to top-right and bottom-left corner.<br />\r\n	<strong>Four</strong> values apply to the top-left, top-right, bottom-right, bottom-left corner in that order.<br />\r\n	<strong>Three</strong> values: The second value applies to top-right and also bottom-left.</p>\r\n<p>\r\n	If the slash followed by a second set of radii is specified, the values before the slash are used to specify the horizontal radius, while the values after the slash specify the vertical radius.&nbsp; If the slash is omitted, then the same values are used to set both horizontal and vertical radii.</p>\r\n', 'icon6.gif'),
(940, '103', '1', '1', '1314350005', 'trojen', '', '', 'Cvp: Browser compatibility', '<p>\r\n	sen ne deyor ben bilmeyor <img alt="cheeky" height="20" src="http://localhost/forum/ckeditor/plugins/smiley/images/tounge_smile.gif" title="cheeky" width="20" /></p>\r\n', ''),
(941, '104', '2', '0', '1314350209', 'trojen', '', '', 'Gözaltý torbalarýna veda edin', '<p>\r\n	G&ouml;z kapaklarýnda d&uuml;þme ve g&ouml;zaltý torbalarý en g&uuml;zel g&ouml;zlere bile g&ouml;lge d&uuml;þ&uuml;r&uuml;yor ama basit estetik m&uuml;dahalelerle yýllara meydan okuyan canlý ve saðlýklý bakýþlara sahip olabilirsiniz. Estetik ve Cerrahi Uzmaný Prof. Dr. Erol Kýþlaoðlu, g&ouml;z &ccedil;evresi estetiði hakkýnda merak edilenleri anlatýyor...</p>\r\n<p>\r\n	G&ouml;z &ccedil;evresi sorunlarýnýn lokal anestezi ile acýsýz ve &ccedil;ok kýsa s&uuml;rede d&uuml;zeltilebileceðini s&ouml;yleyen Prof. Dr. Kýþlaoðlu &#39;&#39;G&ouml;z kapaðý yaþlanmaya baðlý olarak ya da kalýtsal nedenlerle &ccedil;ok gen&ccedil; yaþlarda da torbalanabilir. Bazen de g&ouml;z kapaðý derisinde torbalanma olmadan sadece sarkma ya da gevþeme g&ouml;r&uuml;lebilir. T&uuml;m bunlar kiþiyi yorgun ve yaþlý g&ouml;sterir. Bu durumun estetik g&ouml;r&uuml;n&uuml;m bozukluðuna neden olmasý yanýnda, sarkýk haldeki &uuml;st g&ouml;z kapaklarýnýn g&ouml;z&uuml;n &ouml;n&uuml;n&uuml; kapatmasý kiþinin g&ouml;rmesini de engelleyebilir&#39;&#39; dedi.</p>\r\n<h4>\r\n	G&ouml;z Kapaðý Ameliyatý Nasýl Yapýlýr?</h4>\r\n<p>\r\n	&#39;&#39;G&ouml;z kapaðý estetiði ameliyatý ya da blefaroplasti, g&ouml;z kapaklarýna uygulanan estetik cerrahi giriþimdir. Alt ve &uuml;st g&ouml;z kapaklarýndan fazla sarkma ve torbalanmaya neden olan deri fazlalýklarý &ccedil;ýkarýlýr ancak &ccedil;ýkarýlan doku miktarlarýnýn &ccedil;ok iyi planlanmasý gerekir&#39;&#39; diyen Prof. Kýþlaoðlu, operasyon sýrasýnda yapýlanlarý þ&ouml;yle a&ccedil;ýkladý; &#39;&#39;Estetik g&ouml;z kapaðý ameliyatý ile fazla deri alýnýr ve ayrýca fýtýklaþmýþ yað dokusu &ouml;n&uuml;ndeki zar kuvvetlendirilir. Bu þekilde hem g&uuml;zel bir g&ouml;r&uuml;n&uuml;m elde edilir hem de kiþinin rahat g&ouml;rmesi saðlanmýþ olur. G&ouml;z kapaðý estetiði lokal anestezi ile yapýlýr ancak hastanýn talebine g&ouml;re veya baþka iþlemler de yapýlacaksa genel anestezi altýnda da yapýlabilir. Hastanýn mevcut þik&acirc;yetlerine g&ouml;re sadece &uuml;st veya alt kapaklar ya da her ikisi de ayný anda ameliyat edilebilir. Ameliyat ortalama 1&ndash;1,5 saat s&uuml;rer&#39;&#39;</p>\r\n<h4>\r\n	Operasyon Sonrasý Ýz Kalýyor mu?</h4>\r\n<p>\r\n	&Uuml;st g&ouml;z kapaðý i&ccedil;in kesi g&ouml;z kapaðýnýn katlanma yerinden yapýlýr. &Uuml;st g&ouml;z kapaðýnda gizli bir dikiþ ve alt g&ouml;z kapaðýnda kirpik dibinde kendiliðinden kaybolan dikiþler vardýr. Bu nedenle iz g&ouml;r&uuml;nmez. Ayrýca g&ouml;z kapaklarý insan derisinde en az iz býrakan b&ouml;lgelerdendir. Ameliyat sonrasý &ouml;dem oluþumunu &ouml;nlemek i&ccedil;in g&ouml;z 1 saat kapalý tutulur. Hasta hemen evine d&ouml;nebilir. Herhangi bir sargý ya da pansuman s&ouml;z konusu deðildir. Hasta iki g&uuml;n sonra banyo yapabilir, doðal ihtiya&ccedil;larýný rahatlýkla giderebilir. D&ouml;rt g&uuml;n sonra &uuml;st g&ouml;z kapaðýndaki dikiþ alýnýr. Bu s&uuml;re zarfýnda hasta g&uuml;neþ g&ouml;zl&uuml;ð&uuml; takarak g&uuml;nl&uuml;k hayatýna devam edebilir. Bu operasyon tek baþýna uygulanýrken kaþ kaldýrma ve y&uuml;z germe operasyonlarý ile kombine edilebilir.</p>\r\n<h4>\r\n	Yeni G&ouml;z Kapaðý Þeklini Ne Kadar Korur?</h4>\r\n<p>\r\n	Genellikle bu operasyonlar iyi sonu&ccedil; verir ve revizyon (yeniden cerrahi giriþim) nadiren gerekli g&ouml;r&uuml;l&uuml;r. G&ouml;z kapaklarýnýn yeni þekli, yer&ccedil;ekimi dolayýsýyla bazen 5&ndash;10 yýl bazen de &ouml;m&uuml;r boyu dayanýr.</p>\r\n', 'icon3.gif'),
(942, '97', '2', '2', '1314350320', 'trojen', '', '', 'Cvp: Generic message import', '<p>\r\n	deneme 123</p>\r\n', ''),
(943, '105', '1', '0', '1314351295', 'trojen', '', '', 'deneme konudur ', '<p>\r\n	deneme konudur</p>\r\n', 'icon5.gif'),
(944, '105', '1', '1', '1314972211', 'teraw0rm', '', '', 'Cvp: deneme konudur ', '<p>\r\n	deneme mesaj</p>\r\n', ''),
(1005, '105', '1', '1', '1315074004', 'trojen', '', '', 'Cvp: deneme konudur ', '<p>\r\n	dddddddddd</p>\r\n', ''),
(1006, '105', '1', '1', '1315074007', 'trojen', '', '', 'Cvp: deneme konudur ', '<p>\r\n	dddddddddddddd</p>\r\n', ''),
(1007, '105', '1', '1', '1315074864', 'teraw0rm', '', '', 'Cvp: deneme konudur ', '<p>\r\n	rewrewrew</p>\r\n', ''),
(1008, '105', '1', '1', '1315074893', 'teraw0rm', '', '', 'Cvp: deneme konudur ', '<p>\r\n	rewrewrewrew</p>\r\n', ''),
(1009, '105', '1', '1', '1315074920', 'trojen', '', '', 'Cvp: deneme konudur ', '<p>\r\n	rewrewrew</p>\r\n', ''),
(1010, '100', '1', '1', '1315075200', 'teraw0rm', '', '', 'Cvp: Generic message import', '<p>\r\n	rewrewrw</p>\r\n', ''),
(1011, '101', '75', '2', '1315075369', 'teraw0rm', '', '', 'Cvp: mysql_insert_id', '<p>\r\n	rrrrrrrrrrrrrrrrr</p>\r\n', ''),
(1012, '101', '75', '2', '1315075640', 'teraw0rm', '', '', 'Cvp: mysql_insert_id', '<p>\r\n	eeeeeeeeeeeeeee</p>\r\n', ''),
(1013, '96', '1', '1', '1315075943', 'teraw0rm', '', '', 'Cvp: Db den çektigim ikinci forumun konusu', '<p>\r\n	rewrewrwrew</p>\r\n', ''),
(1014, '100', '1', '1', '1315076025', 'teraw0rm', '', '', 'Cvp: Generic message import', '<p>\r\n	mustafa geldi boþ gelmedi dondurmayla geldi Allllahhhhhhhhh</p>\r\n', ''),
(1015, '102', '75', '2', '1315077011', 'trojen', '', '', 'Cvp: Copyright © 2010', '<p>\r\n	54354354354</p>\r\n', ''),
(1016, '102', '75', '2', '1315077594', 'trojen', '', '', 'Cvp: Copyright © 2010', '<p>\r\n	rerererere</p>\r\n', ''),
(1017, '102', '75', '2', '1315077598', 'trojen', '', '', 'Cvp: Copyright © 2010', '<p>\r\n	rererere</p>\r\n', ''),
(1018, '101', '75', '2', '1315077733', 'trojen', '', '', 'Cvp: mysql_insert_id', '<p>\r\n	ewewewew</p>\r\n', ''),
(1019, '101', '75', '2', '1315077762', 'trojen', '', '', 'Cvp: mysql_insert_id', '<p>\r\n	phpBB2 son s&uuml;r&uuml;m paketini alttaki linklerden y&uuml;kleyebilirsiniz.Eðer ilk kez phpBB kuracaksanýz <strong>Tam Paket</strong> s&uuml;r&uuml;m&uuml;n&uuml;, bir &ouml;nceki phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Deðiþecek Dosyalar</strong> paketini, yama dosyalarý kullanarak phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarýnýzý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Yama Dosyalarý</strong> paketini, bir &ouml;nceki phpBB dosyalarýnýzýn i&ccedil;erisindeki kodlarý deðiþtirerek s&uuml;r&uuml;m&uuml;n&uuml;z&uuml; y&uuml;kseltecekseniz (Ekstra MOD y&uuml;kleyenler i&ccedil;in &ouml;nerilir) <strong>Kod Deðiþiklikleri</strong> paketini indirebilirsiniz. phpBB&#39;yi y&uuml;kleyip kullanmadan &ouml;nce l&uuml;tfen Lisans S&ouml;zleþmesini okuyup koþul ve þartlarý anlayýnýz.phpBB2 son s&uuml;r&uuml;m paketini alttaki linklerden y&uuml;kleyebilirsiniz.Eðer ilk kez phpBB kuracaksanýz <strong>Tam Paket</strong> s&uuml;r&uuml;m&uuml;n&uuml;, bir &ouml;nceki phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Deðiþecek Dosyalar</strong> paketini, yama dosyalarý kullanarak phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarýnýzý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Yama Dosyalarý</strong> paketini, bir &ouml;nceki phpBB dosyalarýnýzýn i&ccedil;erisindeki kodlarý deðiþtirerek s&uuml;r&uuml;m&uuml;n&uuml;z&uuml; y&uuml;kseltecekseniz (Ekstra MOD y&uuml;kleyenler i&ccedil;in &ouml;nerilir) <strong>Kod Deðiþiklikleri</strong> paketini indirebilirsiniz. phpBB&#39;yi y&uuml;kleyip kullanmadan &ouml;nce l&uuml;tfen Lisans S&ouml;zleþmesini okuyup koþul ve þartlarý anlayýnýz.phpBB2 son s&uuml;r&uuml;m paketini alttaki linklerden y&uuml;kleyebilirsiniz.Eðer ilk kez phpBB kuracaksanýz <strong>Tam Paket</strong> s&uuml;r&uuml;m&uuml;n&uuml;, bir &ouml;nceki phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Deðiþecek Dosyalar</strong> paketini, yama dosyalarý kullanarak phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarýnýzý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Yama Dosyalarý</strong> paketini, bir &ouml;nceki phpBB dosyalarýnýzýn i&ccedil;erisindeki kodlarý deðiþtirerek s&uuml;r&uuml;m&uuml;n&uuml;z&uuml; y&uuml;kseltecekseniz (Ekstra MOD y&uuml;kleyenler i&ccedil;in &ouml;nerilir) <strong>Kod Deðiþiklikleri</strong> paketini indirebilirsiniz. phpBB&#39;yi y&uuml;kleyip kullanmadan &ouml;nce l&uuml;tfen Lisans S&ouml;zleþmesini okuyup koþul ve þartlarý anlayýnýz.phpBB2 son s&uuml;r&uuml;m paketini alttaki linklerden y&uuml;kleyebilirsiniz.Eðer ilk kez phpBB kuracaksanýz <strong>Tam Paket</strong> s&uuml;r&uuml;m&uuml;n&uuml;, bir &ouml;nceki phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Deðiþecek Dosyalar</strong> paketini, yama dosyalarý kullanarak phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarýnýzý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Yama Dosyalarý</strong> paketini, bir &ouml;nceki phpBB dosyalarýnýzýn i&ccedil;erisindeki kodlarý deðiþtirerek s&uuml;r&uuml;m&uuml;n&uuml;z&uuml; y&uuml;kseltecekseniz (Ekstra MOD y&uuml;kleyenler i&ccedil;in &ouml;nerilir) <strong>Kod Deðiþiklikleri</strong> paketini indirebilirsiniz. phpBB&#39;yi y&uuml;kleyip kullanmadan &ouml;nce l&uuml;tfen Lisans S&ouml;zleþmesini okuyup koþul ve þartlarý anlayýnýz.phpBB2 son s&uuml;r&uuml;m paketini alttaki linklerden y&uuml;kleyebilirsiniz.Eðer ilk kez phpBB kuracaksanýz <strong>Tam Paket</strong> s&uuml;r&uuml;m&uuml;n&uuml;, bir &ouml;nceki phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Deðiþecek Dosyalar</strong> paketini, yama dosyalarý kullanarak phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarýnýzý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Yama Dosyalarý</strong> paketini, bir &ouml;nceki phpBB dosyalarýnýzýn i&ccedil;erisindeki kodlarý deðiþtirerek s&uuml;r&uuml;m&uuml;n&uuml;z&uuml; y&uuml;kseltecekseniz (Ekstra MOD y&uuml;kleyenler i&ccedil;in &ouml;nerilir) <strong>Kod Deðiþiklikleri</strong> paketini indirebilirsiniz. phpBB&#39;yi y&uuml;kleyip kullanmadan &ouml;nce l&uuml;tfen Lisans S&ouml;zleþmesini okuyup koþul ve þartlarý anlayýnýz.phpBB2 son s&uuml;r&uuml;m paketini alttaki linklerden y&uuml;kleyebilirsiniz.Eðer ilk kez phpBB kuracaksanýz <strong>Tam Paket</strong> s&uuml;r&uuml;m&uuml;n&uuml;, bir &ouml;nceki phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Deðiþecek Dosyalar</strong> paketini, yama dosyalarý kullanarak phpBB s&uuml;r&uuml;m&uuml;n&uuml;zdeki dosyalarýnýzý yenileriyle deðiþtirerek y&uuml;kseltecekseniz <strong>Sadece Yama Dosyalarý</strong> paketini, bir &ouml;nceki phpBB dosyalarýnýzýn i&ccedil;erisindeki kod', ''),
(1020, '102', '75', '2', '1315078124', 'trojen', '', '', 'Cvp: Copyright © 2010', '<p>\r\n	43434343</p>\r\n', ''),
(1021, '102', '75', '2', '1315078147', 'trojen', '', '', 'Cvp: Copyright © 2010', '<p>\r\n	trtrtrt</p>\r\n', ''),
(1022, '102', '75', '2', '1315078164', 'trojen', '', '', 'Cvp: Copyright © 2010', '<p>\r\n	rerereeerrrrrrrrrrrrrrrr</p>\r\n', ''),
(1023, '97', '2', '2', '1315078718', 'teraw0rm', '', '', 'Cvp: Generic message import', '<p>\r\n	<span class="html">ALWAYS use this function! I just encountered a bug in my code where I forgot to use this function. I also happen to be using mysql_pconnect() for a persistent connection. If you forget to free the result, it can hold the old result set open indefinitely within the HTTP process.<br />\r\n	<br />\r\n	The upshot (in my application) was that I did updates that happened in a different HTTP process, but they mysteriously didn&#39;t show up in another HTTP process. After panicking that MySQL had mysterious data corruption and/or synchronization problems, I traced it back to this where an old result set was held open.</span><span class="html">ALWAYS use this function! I just encountered a bug in my code where I forgot to use this function. I also happen to be using mysql_pconnect() for a persistent connection. If you forget to free the result, it can hold the old result set open indefinitely within the HTTP process.<br />\r\n	<br />\r\n	The upshot (in my application) was that I did updates that happened in a different HTTP process, but they mysteriously didn&#39;t show up in another HTTP process. After panicking that MySQL had mysterious data corruption and/or synchronization problems, I traced it back to this where an old result set was held open.</span><span class="html">ALWAYS use this function! I just encountered a bug in my code where I forgot to use this function. I also happen to be using mysql_pconnect() for a persistent connection. If you forget to free the result, it can hold the old result set open indefinitely within the HTTP process.<br />\r\n	<br />\r\n	The upshot (in my application) was that I did updates that happened in a different HTTP process, but they mysteriously didn&#39;t show up in another HTTP process. After panicking that MySQL had mysterious data corruption and/or synchronization problems, I traced it back to this where an old result set was held open.</span><span class="html">ALWAYS use this function! I just encountered a bug in my code where I forgot to use this function. I also happen to be using mysql_pconnect() for a persistent connection. If you forget to free the result, it can hold the old result set open indefinitely within the HTTP process.<br />\r\n	<br />\r\n	The upshot (in my application) was that I did updates that happened in a different HTTP process, but they mysteriously didn&#39;t show up in another HTTP process. After panicking that MySQL had mysterious data corruption and/or synchronization problems, I traced it back to this where an old result set was held open.</span><span class="html">ALWAYS use this function! I just encountered a bug in my code where I forgot to use this function. I also happen to be using mysql_pconnect() for a persistent connection. If you forget to free the result, it can hold the old result set open indefinitely within the HTTP process.<br />\r\n	<br />\r\n	The upshot (in my application) was that I did updates that happened in a different HTTP process, but they mysteriously didn&#39;t show up in another HTTP process. After panicking that MySQL had mysterious data corruption and/or synchronization problems, I traced it back to this where an old result set was held open.</span></p>\r\n', ''),
(1024, '97', '2', '2', '1315078854', 'teraw0rm', '', '', 'Cvp: Generic message import', '<p>\r\n	ewqewqew</p>\r\n', ''),
(1025, '102', '75', '2', '1315079330', 'trojen', '', '', 'Cvp: Copyright © 2010', '\r\n	<p>rere\r\n		&nbsp;</p>\r\n\r\n', ''),
(1026, '97', '2', '2', '1315079531', 'teraw0rm', '', '', 'Cvp: Generic message import', '<p>\r\n	eeeeeeeeeeeeeeeee</p>\r\n', ''),
(1027, '97', '2', '2', '1315079558', 'teraw0rm', '', '', 'Cvp: Generic message import', '<p>\r\n	ewewewew</p>\r\n', ''),
(1028, '96', '1', '1', '1315082315', 'trojen', '', '', 'Cvp: Db den çektigim ikinci forumun konusu', '<p>\r\n	phpBB is a free flat-forum bulletin board software solution that can be used to stay in touch with a group of people or can power your entire website. With an <a href="http://www.phpbb.com/customise/db/modifications-1/?sid=7759500463bb0fe965ed524e9105a742">extensive database of user-created modifications</a> and <a href="http://www.phpbb.com/customise/db/styles-2/?sid=7759500463bb0fe965ed524e9105a742">styles database</a> containing hundreds of style and image packages to customise your board, you can create a very unique forum in minutes.</p>\r\n<p>\r\n	No other bulletin board software offers a greater complement of features, while maintaining efficiency and ease of use. Best of all, phpBB is completely free. We welcome you to <a href="http://www.phpbb.com/demo/?sid=7759500463bb0fe965ed524e9105a742">test it</a> for yourself today. If you have any questions please visit our <a href="http://www.phpbb.com/community/?sid=7759500463bb0fe965ed524e9105a742">Community Forum</a> where our staff and members of the community will be happy to assist you with anything from configuring the software to modifying the code for individual needs. <a href="http://www.phpbb.com/about/?sid=7759500463bb0fe965ed524e9105a742">Learn more about phpBB.</a>&nbsp;</p>\r\n', ''),
(1029, '104', '2', '2', '1315084025', 'teraw0rm', '', '', 'Cvp: Gözaltý torbalarýna veda edin', '<p>\r\n	ewqewqewqewqwe</p>\r\n', ''),
(1030, '106', '2', '0', '1315084166', 'teraw0rm', '', '', 'Diablo III', '<p>\r\n	AND THE HEAVENS</p>\r\n<p>\r\n	&nbsp;&nbsp;&nbsp;SHALL TREMBLE</p>\r\n<p>\r\n	&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;Explore fully realized realms of Sanctuary &ndash; the living, breathing gothic fantasy world of Diablo III &ndash; rendered in gorgeous 3D.<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;Battle the unholy forces of the Burning Hells with all-new character classes such as the otherworldly Witch Doctor, or with re-imagined warriors from Diablo&rsquo;s past, like the powerful Barbarian.<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;Rain Hell on your enemies and use the interactive environment as a weapon: lay cunning traps, turn destructible objects against your foes, and use environmental obstacles to your advantage.<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;Experience the intensity of multiplayer Diablo III over an all-new, wickedly enhanced Battle.net platform with numerous enhancements to make connecting with your friends easier, and cooperative gameplay more fun.</p>\r\n', ''),
(1031, '107', '2', '0', '1315084447', 'teraw0rm', '', '', 'Diablo III', '<p>\r\n	&nbsp;&nbsp;&nbsp;&nbsp;Explore fully realized realms of Sanctuary &ndash; the living, breathing gothic fantasy world of Diablo III &ndash; rendered in gorgeous 3D.<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;Battle the unholy forces of the Burning Hells with all-new character classes such as the otherworldly Witch Doctor, or with re-imagined warriors from Diablo&rsquo;s past, like the powerful Barbarian.<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;Rain Hell on your enemies and use the interactive environment as a weapon: lay cunning traps, turn destructible objects against your foes, and use environmental obstacles to your advantage.<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;Experience the intensity of multiplayer Diablo III over an all-new, wickedly enhanced Battle.net platform with numerous enhancements to make connecting with your friends easier, and cooperative gameplay more fun.</p>\r\n<p>\r\n	&nbsp;</p>\r\n', ''),
(1032, '107', '2', '2', '1315084563', 'trojen', '', '', 'Cvp: Diablo III', '<p>\r\n	ne zaman &ccedil;ýkacak bilginiz var mý?</p>\r\n', ''),
(1033, '107', '2', '2', '1315084601', 'teraw0rm', '', '', 'Cvp: Diablo III', '<p>\r\n	inan bilmiyorum</p>\r\n', ''),
(1034, '108', '1', '0', '1315139452', 'teraw0rm', '', '', 'Elektirkler yeni geldi', '<p>\r\n	&ccedil;ok þ&uuml;k&uuml;r geldi.</p>\r\n', ''),
(1035, '108', '1', '1', '1315139521', 'trojen', '', '', 'Cvp: Elektirkler yeni geldi', '<p>\r\n	:D</p>\r\n', ''),
(1036, '108', '1', '1', '1324240964', 'admin', '', '', 'Cvp: Elektirkler yeni geldi', '<p>\r\n	rerere</p>\r\n', ''),
(1037, '108', '1', '1', '1324242385', 'admin', '', '', 'Cvp: Elektirkler yeni geldi', '<p>\r\n	fdsfds</p>\r\n', ''),
(1038, '103', '1', '1', '1324242403', 'admin', '', '', 'Cvp: Browser compatibility', '<p>\r\n	rewrewrewrew</p>\r\n', ''),
(1039, '108', '1', '1', '1324242413', 'teraw0rm', '', '', 'Cvp: Elektirkler yeni geldi', '<p>\r\n	tretretre</p>\r\n', ''),
(1040, '103', '1', '1', '1324242430', 'teraw0rm', '', '', 'Cvp: Browser compatibility', '<p>\r\n	tretretr</p>\r\n', ''),
(1041, '100', '1', '1', '1324242729', 'admin', '', '', 'Cvp: Generic message import', '<p>\r\n	rewrewr ewrew rewr ewrewr wrwer werew</p>\r\n', ''),
(1042, '100', '1', '1', '1324388080', 'teraw0rm', '', '', 'Cvp: Generic message import', '<p>\r\n	fsdfdsfds</p>\r\n', ''),
(1043, '109', '76', '0', '1324388588', 'teraw0rm', '', '', 'Deneme 2. forumun ilk konusu olsun bu', '<p>\r\n	nasýl bir konu olsun bilmem</p>\r\n', 'icon3.gif'),
(1044, '110', '76', '0', '1324388637', 'teraw0rm', '', '', 'fdsfds', '<p>\r\n	fdsfdsfds</p>\r\n', ''),
(1045, '111', '76', '0', '1324388642', 'teraw0rm', '', '', 'fdsfd', '<p>\r\n	sfdsfdsfdsfdsfdsf</p>\r\n', ''),
(1046, '112', '76', '0', '1324388651', 'teraw0rm', '', '', 'rerewrewrewr', '<p>\r\n	ewrewrewrew werew rew rewr ewrew</p>\r\n', ''),
(1047, '112', '76', '1', '1324673503', 'teraw0rm', '', '', 'Cvp: rerewrewrewr', '<p>\r\n	ewqewqe</p>\r\n', ''),
(1048, '100', '1', '1', '1324674175', 'teraw0rm', '', '', 'Cvp: Generic message import', '<p>\r\n	tretretre</p>\r\n', ''),
(1049, '113', '2', '0', '1324674271', 'teraw0rm', '', '', 'reeeeeeer', '<p>\r\n	rrrrrrrrrrrrrrrrrrrrrr</p>\r\n', ''),
(1050, '104', '2', '2', '1324674757', 'teraw0rm', '', '', 'Cvp: Gözaltý torbalarýna veda edin', '<p>\r\n	wqewqewqewqe</p>\r\n', ''),
(1051, '104', '2', '2', '1324675164', 'teraw0rm', '', '', 'Cvp: Gözaltý torbalarýna veda edin', '<p>\r\n	ddddddddddddd</p>\r\n', ''),
(1052, '114', '2', '0', '1324675474', 'teraw0rm', '', '', 'wwwwwwwwwwwwwww', '<p>\r\n	wwwwwwwwwwwwwwwwwwwww</p>\r\n', ''),
(1053, '114', '2', '2', '1324675780', 'teraw0rm', '', '', 'Cvp: wwwwwwwwwwwwwww', '<p>\r\n	wwwwwwwwwwww</p>\r\n', ''),
(1054, '104', '2', '2', '1324675792', 'teraw0rm', '', '', 'Cvp: Gözaltý torbalarýna veda edin', '<p>\r\n	wwwwwwwwww</p>\r\n', ''),
(1055, '104', '2', '2', '1324723033', 'teraw0rm', '', '', 'Cvp: Gözaltý torbalarýna veda edin', '<p>\r\n	wwwwwwwwwww</p>\r\n', ''),
(1056, '114', '2', '2', '1324723062', 'teraw0rm', '', '', 'Cvp: wwwwwwwwwwwwwww', '<p>\r\n	eeeeeeeeeeeeee</p>\r\n', ''),
(1057, '115', '76', '0', '1324723073', 'teraw0rm', '', '', 'eeeeeeeeeee', '<p>\r\n	eeeeeeeeeeeeeeeeeee</p>\r\n', ''),
(1058, '116', '75', '0', '1324732267', 'teraw0rm', '', '', 'rewr', '<p>\r\n	ewrewrewrew</p>\r\n', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oturumlar`
--

CREATE TABLE IF NOT EXISTS `oturumlar` (
  `sid` int(100) NOT NULL AUTO_INCREMENT,
  `s_kul_id` varchar(101) NOT NULL,
  `s_oturum` varchar(1000) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Tablo döküm verisi `oturumlar`
--

INSERT INTO `oturumlar` (`sid`, `s_kul_id`, `s_oturum`) VALUES
(78, '1', '#WDfB9XDv@nGG_Xki#7xwq7p0ad-dshUlby'),
(79, '18', 'KX$sAUAAPxN6@SU)j9OiZ}{5Yt{x6GWpS5+'),
(80, '19', '39t8rg]b(+aH9-A@)+kG]Bl8DbJL#-}Tskv');
