<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Site Settings
            ['key' => 'site_name', 'value' => 'E-commerce Shop', 'group' => 'site'],
            ['key' => 'site_email', 'value' => 'admin@ecommerce.mn', 'group' => 'site'],
            ['key' => 'site_phone', 'value' => '+976 88888888', 'group' => 'site'],
            ['key' => 'site_address', 'value' => 'Улаанбаатар хот, Монгол Улс', 'group' => 'site'],
            ['key' => 'currency', 'value' => 'MNT', 'group' => 'site'],
            ['key' => 'logo_path', 'value' => null, 'group' => 'site'],

            // Payment Settings
            ['key' => 'cod_enabled', 'value' => '1', 'group' => 'payment'],
            ['key' => 'card_enabled', 'value' => '1', 'group' => 'payment'],

            // Order Settings
            ['key' => 'order_auto_pending', 'value' => '1', 'group' => 'order'],
            ['key' => 'free_shipping_threshold', 'value' => '100000', 'group' => 'order'],
            ['key' => 'allow_refund', 'value' => '1', 'group' => 'order'],

            // Security Settings
            ['key' => 'admin_email_notifications', 'value' => '1', 'group' => 'security'],
            ['key' => 'maintenance_mode', 'value' => '0', 'group' => 'security'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
