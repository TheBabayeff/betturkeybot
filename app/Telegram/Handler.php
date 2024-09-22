<?php

namespace App\Telegram;

use App\Models\TelegramUser;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\DTO\Contact;
use App\Models\User;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Log;

class Handler extends WebhookHandler
{


    public function start()
    {
        $bonusLink = 'https://cutt.ly/uex11MEc';

        $this->reply('🎉 500 TL Deneme Bonusu!  %100 güvenli və hızlı ödeme ✅Şimdi katılın ve 500 TL Deneme Bonusunuzu alın! /bonusu_al ')
        ;


    }


    public function bonusu_al()
    {
        try {
            $chatId = $this->chat->chat_id;
            $memberInfo = $this->chat->memberInfo($chatId);
            $userId = $memberInfo->user()->id();
            $userName = $memberInfo->user()->username() ?? 'Unknown';

            $bonusLink = 'https://cutt.ly/3eTWY5kX';

            $keyboard = Keyboard::make()
                ->row([Button::make('Deneme Bonusu Al')->url($bonusLink)])
                ->row([Button::make('Diğer Bonuslar')->action('show_other_bonuses')])
                ->row([Button::make('Ekstra 101 FreeSpin istermisin?')->action('extrafs')])
                ->row([Button::make('Bayi olarak Para kazanmak istermisin?')->action('bayilik')]);

            // İstifadəçiyə inline keyboard ilə mesaj göndərin
            $this->chat->photo('https://zbahis.bet/assets/images/kilic2.png')
                ->send();

            $this->chat->html("🎉 Tebrikler !  Bonusunuz Aktivleştirildi ! Sitemize üye ol  \n✅ZbahisBot \n💬 Kodu Canlı Destek hattına ilet  \n💰 777 ₺  Deneme Bonusu Al ! ")
                ->keyboard($keyboard)
                ->send();

            TelegramUser::updateOrCreate(
                ['telegram_id' => $userId],
                ['username' => $userName, 'clicked_at' => now()]
            );

        } catch (\Exception $e) {
            // Xəta baş verdikdə Retry düyməsi ilə mesaj göndərin
            $retryKeyboard = Keyboard::make()
                ->row([Button::make('Bonusu Al')->action('bonusu_al')]);

            $this->chat->html("Sistemde bir hata oluştu Lütfen yeniden deneyin")
                ->keyboard($retryKeyboard)
                ->send();
        }
    }

    public function show_other_bonuses()
    {
        $bonusLink = 'https://cutt.ly/uex11MEc';
        $keyboard = Keyboard::make()
            ->row([Button::make('🎁 100% Hoşgeldin Bonusu 5000 TL')->action('hosgeldin_bonusu')])
            ->row([Button::make('🎁 30% Yatırım Bonusu')->action('yatirim_bonusu')])
            ->row([Button::make('🎁 35%  Kripto Bonusu ')->action('kripto_bonusu')])
            ->row([Button::make('Ana menü')->action('bonusu_al')]);

        $this->chat->html("🎁 Diğer Bonuslar:")
            ->keyboard($keyboard)
            ->send();
    }

    public function hosgeldin_bonusu()
    {
        $this->chat->photo('https://zbahis.bet/assets/images/hosgeldin.jpg')

            ->send();
        $bonusLink = 'https://cutt.ly/3eTWY5kX';
        $this->chat->html("%100 Hoşgeldin Bonusu !\n\n" .
            "🎉#BetTürkey'den Harika Bir Karşılama \n" .
            "5000TL İLK YATIRIM BONUSU\n" .
            "NASIL YARARLANILIR - BONUS KURALLARI\n\n" .
            "•Sitemize gerçekleştireceğiniz min 50₺ ilk yatırımınızın ardından yatırım talebi esnasında bonusu seçerek promosyondan yararalanabilirsiniz. Canlı Destek hattımız üzerinden veya bonus talep et seçeneği ile promosyon tarafınıza eklenmemektedir.\n\n" .
            "•İlk üyelik bonusundan yararlanarak Spor bahisleri, Canlı Casino ve Slot oyunlarına katılabilirsiniz.\n\n" .
            "•Tüm Yatırım Yöntemleri için Geçerlidir. Yapacağınız ilk ve 5000 TL ye kadar olan yatırımlarınız için %100 ilk yatırım bonusu talep edebilirsiniz.\n" .
            "\n\n" .
             "🔑 Bu promosyon Tüm Yatırım Yöntemleri için Geçerlidir.\n"
        )->send();

        // Sonra bonusu almaq üçün bir düymə göstəririk
        $keyboard = Keyboard::make()
            ->row([Button::make('Bu Bonusu Al')->url($bonusLink)])
            ->row([Button::make('Diğer Bonuslar')->action('show_other_bonuses')])
            ->row([Button::make('Ana menü')->action('bonusu_al')]);

        $this->chat->html("Bu bonusu almak için aşağıdakı buttona basın:")
            ->keyboard($keyboard)
            ->send();
    }


    public function yatirim_bonusu()
    {
        $this->chat->photo('https://zbahis.bet/assets/images/slotbonusu.jpg')

            ->send();
        $bonusLink = 'https://cutt.ly/3eTWY5kX';
        $this->chat->html("%30 KOLAY ÇEVRİMLİ YATIRIM BONUSUNDAN NASIL YARARLANILIR?\n\n" .
            "🎰 Kolay Çevrimli %30 yatırım bonusumuzdan faydalanan Üyelerimiz Kayıp Bonusumuzdan yararlanabilir.\n\n" .
            "🎰 %30 Kolay Çevrimli Yatırım bonusumuzdan faydalanmak isteyen kullanıcı otomatik bonus seçeneği üzerinden promosyonu seçerek yararlanabilmektedir.\n\n" .
            "BONUS KURALLARI\n\n" .
            " %30 Kolay Çevrimli Yatırım bonusumuz sadece spor bahisleri, slot ve canlı casino (rulet, black jack ve casino holdem) lobbylerinde geçerlidir. \n"


        )->send();

        // Sonra bonusu almaq üçün bir düymə göstəririk
        $keyboard = Keyboard::make()
            ->row([Button::make('Bu Bonusu Al')->url($bonusLink)])
            ->row([Button::make('Diğer Bonuslar')->action('show_other_bonuses')])
            ->row([Button::make('Ana menü')->action('bonusu_al')]);

        $this->chat->html("Bu bonusu almak için aşağıdaki buttona basın:")
            ->keyboard($keyboard)
            ->send();
    }

    public function kripto_bonusu()
    {
        $this->chat->photo('https://zbahis.bet/assets/images/kriptobonusu.jpg')

            ->send();
        $bonusLink = 'https://cutt.ly/3eTWY5kX';
        $this->chat->html("ÇEVRİMSİZ %35 KRİPTO YATIRIM BONUSU \n\n" .
            "NASIL YARARLANILIR ? \n\n" .
            "💰 Crypto'yla Yatırım Yap, Kazancını Artır! \n\n" .
            "🔥 %35 Cyrpto yatırım bonusu ile şans seninle!  \n\n" .
            "⏳Bu fırsatı kaçırma,  Her Gün, Her Yatırımda Bu Heyecan Seninle! \n\n" .
            "🚀#BetTürkey ile heyecana ortak ol, zaferi yakala! \n\n"
        )->send();
        // Sonra bonusu almaq üçün bir düymə göstəririk
        $keyboard = Keyboard::make()
            ->row([Button::make('Bu Bonusu Al')->url($bonusLink)])
            ->row([Button::make('Diğer Bonuslar')->action('show_other_bonuses')])
            ->row([Button::make('Ana menü')->action('bonusu_al')]);

        $this->chat->html("Bu bonusu almak için aşağıdaki buttona basın:")
            ->keyboard($keyboard)
            ->send();
    }

    public function extrafs()
    {
        $this->chat->photo('https://zbahis.bet/assets/images/fss.jpeg') ->send();
        $this->chat->html("Ekstradan 101 FreeSpin İstermisin,\n\n" .
            "🎉Botu 3  arkadaşınla Paylaş ve Bonus Al\n\n" .

            "🔑 Kod: ZBOT \n" .
            "🌟Sadece slot alanında geçerlidir \n" .
            "🌟Geçerli oyun : Pragmatic oyunları\n\n" .
            "🌟1000 TL yap 200 TL yatır 500 TL Çek !!\n\n\n"
        )->send();


        $this->chat->html("Kullanım şartları :\n\n")->send();

        $this->chat->photo('https://zbahis.bet/assets/images/fsrule1.png') ->send();
        $this->chat->photo('https://zbahis.bet/assets/images/fsrul2.png') ->send();
        $bonusLink = 'https://cutt.ly/3eTWY5kX';


        // Sonra bonusu almaq üçün bir düymə göstəririk
        $keyboard = Keyboard::make()
            ->row([Button::make('Bu Bonusu Al')->url($bonusLink)])
            ->row([Button::make('Diğer Bonuslar')->action('show_other_bonuses')])
            ->row([Button::make('Ana menü')->action('bonusu_al')]);

        $this->chat->html("Bu bonusu almak için aşağıdakı buttona basın:")
            ->keyboard($keyboard)
            ->send();
    }


    public function bayilik()
    {
        //$this->chat->photo('https://zbahis.bet/assets/images/hosgeldin.jpg')->send();

        $destekHatti = 'https://t.me/betturkeydestek';
        $this->chat->html("Zbahis ile herkes kazanç elde edebilir!\n\n" .
            "Eğer sosyal medya konusunda deneyiminiz varsa ve elinde trafiği olan sayfa yöneticisi, grup lideri ya da başka bir platform sahibiseniz,\n\n" .
            "bu fırsatı kaçırmayın!\n\n" .
            "📌 Sosyal medya aracılığıyla haftalık gelir elde etmek ister misiniz?\n\n" .
            "📌 Kendi sayfalarınızı, TikTok hesaplarınızı ve diğer trafik kaynaklarınızı sunarak,\n\n" .
            "hemen işbirliğine başlayın.\n\n" .
            "📌 Güzel fırsatlarla kazanç sağlayın!\n"
        )->send();

        // Sonra bonusu almaq üçün bir düymə göstəririk
        $keyboard = Keyboard::make()
            ->row([Button::make('Destek Hattına Yazın')->url($destekHatti)])
            ->row([Button::make('Ana menü')->action('bonusu_al')]);

        $this->chat->html("İş Birliğinde bulunmak için :")
            ->keyboard($keyboard)
            ->send();
    }



}
