<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Motorcycle;
use App\Models\MotorcycleImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MotorcycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) {
            return;
        }

        $honda = Brand::firstOrCreate(['name' => 'Honda']);
        $yamaha = Brand::firstOrCreate(['name' => 'Yamaha']);
        $suzuki = Brand::firstOrCreate(['name' => 'Suzuki']);
        $kawasaki = Brand::firstOrCreate(['name' => 'Kawasaki']);
        $vespa = Brand::firstOrCreate(['name' => 'Vespa']);

        $storagePath = storage_path('app/public/motorcycles');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        $items = [
            [
                'brand_id' => $honda->id,
                'model' => 'Vario 160 ABS',
                'year' => 2023,
                'price' => 24500000,
                'mileage' => 12400,
                'engine_capacity' => 160,
                'transmission' => Motorcycle::TRANSMISSION_AUTOMATIC,
                'color' => 'Hitam Matte',
                'description' => "Kondisi unit sangat istimewa seperti baru. Mesin halus standar pabrik, kelistrikan normal, ban depan belakang tebal 90%. Surat lengkap STNK, BPKB, dan Faktur atas nama perorangan. Pajak hidup panjang sampai Oktober 2027. Kunci kontak keyless 2 pcs lengkap remote dan barcode.",
                'status' => Motorcycle::STATUS_PUBLISHED,
                'accent_color' => '#1E293B',
            ],
            [
                'brand_id' => $yamaha->id,
                'model' => 'NMAX 155 Connected',
                'year' => 2022,
                'price' => 27800000,
                'mileage' => 18200,
                'engine_capacity' => 155,
                'transmission' => Motorcycle::TRANSMISSION_AUTOMATIC,
                'color' => 'Biru Doff (Matte Blue)',
                'description' => "Unit rawatan bengkel resmi Yamaha. Fitur Y-Connect aktif normal, ABS depan belakang berfungsi responsif. Bodi mulus bebas jatuh/tabrakan. BPKB + STNK + Buku Service lengkap. Siap pakai jarak jauh.",
                'status' => Motorcycle::STATUS_PUBLISHED,
                'accent_color' => '#1D4ED8',
            ],
            [
                'brand_id' => $honda->id,
                'model' => 'Beat Deluxe CBS-ISS',
                'year' => 2021,
                'price' => 14500000,
                'mileage' => 24100,
                'engine_capacity' => 110,
                'transmission' => Motorcycle::TRANSMISSION_AUTOMATIC,
                'color' => 'Silver Metalik',
                'description' => "Motor harian sangat irit bahan bakar (eSP 110cc). Idling Stop System (ISS) dan Combi Brake System (CBS) berfungsi prima. Bodi original mulus, ban tebal baru diganti. Dokumen lengkap siap balik nama.",
                'status' => Motorcycle::STATUS_PUBLISHED,
                'accent_color' => '#64748B',
            ],
            [
                'brand_id' => $vespa->id,
                'model' => 'Sprint S 150 i-Get ABS',
                'year' => 2022,
                'price' => 46000000,
                'mileage' => 8500,
                'engine_capacity' => 150,
                'transmission' => Motorcycle::TRANSMISSION_AUTOMATIC,
                'color' => 'Kuning Matte (Giallo Sole)',
                'description' => "Koleksi pribadi jarang pakai. Bodi mulus full decal pelindung transparan. Mesin i-Get 150cc halus tanpa gredeg. Kunci cokelat master dan kunci biru lengkap. Pajak hidup, surat-surat aman terverifikasi.",
                'status' => Motorcycle::STATUS_PUBLISHED,
                'accent_color' => '#D97706',
            ],
            [
                'brand_id' => $kawasaki->id,
                'model' => 'Ninja 250 FI SE',
                'year' => 2020,
                'price' => 48500000,
                'mileage' => 15600,
                'engine_capacity' => 250,
                'transmission' => Motorcycle::TRANSMISSION_MANUAL,
                'color' => 'Hijau Lime KRT Edition',
                'description' => "Motor sport 2 silinder suara merdu padat. Knalpot original tersimpan rapi, part modifikasi branded minimalis. Ban Battlax S22 tebal. Tidak pernah turun sirkuit, bodi kinclong terawat.",
                'status' => Motorcycle::STATUS_PUBLISHED,
                'accent_color' => '#166534',
            ],
            [
                'brand_id' => $yamaha->id,
                'model' => 'Aerox 155 VVA CyberCity',
                'year' => 2023,
                'price' => 26200000,
                'mileage' => 9800,
                'engine_capacity' => 155,
                'transmission' => Motorcycle::TRANSMISSION_AUTOMATIC,
                'color' => 'Cyber Red Metallic',
                'description' => "Edisi spesial CyberCity dengan corak futuristik. Odometer rendah baru 9.800 km. Tarikan responsif, suspensi belakang tabung original nyaman. Kelengkapan surat dijamin asli dan aman.",
                'status' => Motorcycle::STATUS_PUBLISHED,
                'accent_color' => '#C62828',
            ],
            [
                'brand_id' => $honda->id,
                'model' => 'Scoopy Prestige Smart Key',
                'year' => 2022,
                'price' => 19800000,
                'mileage' => 16500,
                'engine_capacity' => 110,
                'transmission' => Motorcycle::TRANSMISSION_AUTOMATIC,
                'color' => 'Hitam Doff (Matte Black)',
                'description' => "Scoopy tipe tertinggi Prestige velg emas original. Smart Key system dengan remote alarm. Bagasi luas, ada soket charger USB aktif. Kondisi sangat terawat.",
                'status' => Motorcycle::STATUS_PUBLISHED,
                'accent_color' => '#334155',
            ],
            [
                'brand_id' => $yamaha->id,
                'model' => 'Fazzio Lux Hybrid',
                'year' => 2022,
                'price' => 18200000,
                'mileage' => 14000,
                'engine_capacity' => 125,
                'transmission' => Motorcycle::TRANSMISSION_AUTOMATIC,
                'color' => 'Prestige Silver',
                'description' => "Desain classy retro modern dengan teknologi Blue Core Hybrid. Sangat nyaman dan stylish untuk perkotaan. Bebas kendala teknis, tinggal gas.",
                'status' => Motorcycle::STATUS_PUBLISHED,
                'accent_color' => '#475569',
            ],
            [
                'brand_id' => $suzuki->id,
                'model' => 'GSX-R150 Keyless',
                'year' => 2019,
                'price' => 17500000,
                'mileage' => 31000,
                'engine_capacity' => 150,
                'transmission' => Motorcycle::TRANSMISSION_MANUAL,
                'color' => 'Biru Suzuki Ecstar MotoGP',
                'description' => "Unit sport fairing DOHC overbore bertenaga. Sudah terjual kepada customer di Rawamangun. Dokumen komplit, unit telah diinspeksi menyeluruh.",
                'status' => Motorcycle::STATUS_SOLD,
                'accent_color' => '#0284C7',
            ],
            [
                'brand_id' => $honda->id,
                'model' => 'PCX 160 CBS',
                'year' => 2023,
                'price' => 28900000,
                'mileage' => 7300,
                'engine_capacity' => 160,
                'transmission' => Motorcycle::TRANSMISSION_AUTOMATIC,
                'color' => 'Putih Mutiara (Wonderful White)',
                'description' => "Unit baru masuk showroom, sedang dalam tahap detailing dan cek berkas administrasi. Siap dipublikasikan segera.",
                'status' => Motorcycle::STATUS_DRAFT,
                'accent_color' => '#64748B',
            ],
        ];

        foreach ($items as $index => $itemData) {
            $accentColor = $itemData['accent_color'];
            unset($itemData['accent_color']);

            $itemData['created_by'] = $admin->id;
            $itemData['published_at'] = ($itemData['status'] === Motorcycle::STATUS_PUBLISHED || $itemData['status'] === Motorcycle::STATUS_SOLD) ? now()->subDays(10 - $index) : null;
            $itemData['sold_at'] = $itemData['status'] === Motorcycle::STATUS_SOLD ? now()->subDays(10 - $index) : null;

            $motorcycle = Motorcycle::create($itemData);

            // Generate 2 realistic SVG images for each unit
            $angles = [
                ['name' => 'Tampak Depan Tiga Perempat', 'suffix' => 'front'],
                ['name' => 'Tampak Samping & Mesin', 'suffix' => 'side'],
            ];

            foreach ($angles as $pos => $angle) {
                $filename = 'motorcycle_' . $motorcycle->id . '_' . $angle['suffix'] . '.svg';
                $filePath = 'motorcycles/' . $filename;
                $fullPath = $storagePath . '/' . $filename;

                $svgContent = $this->createMotorcycleSvg(
                    $motorcycle->brand->name,
                    $motorcycle->model,
                    $motorcycle->year,
                    $angle['name'],
                    $accentColor,
                    $motorcycle->transmission
                );

                File::put($fullPath, $svgContent);

                MotorcycleImage::create([
                    'motorcycle_id' => $motorcycle->id,
                    'image_path' => $filePath,
                    'is_primary' => ($pos === 0),
                    'sort_order' => $pos,
                ]);
            }
        }
    }

    /**
     * Helper to render clean showroom SVG image for each motor
     */
    private function createMotorcycleSvg(string $brand, string $model, int $year, string $angle, string $accentColor, string $transmission): string
    {
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600" width="800" height="600">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#F8FAFC" />
      <stop offset="100%" stop-color="#E2E8F0" />
    </linearGradient>
    <filter id="shadow" x="-5%" y="-5%" width="110%" height="110%">
      <feDropShadow dx="0" dy="8" stdDeviation="12" flood-color="#0F172A" flood-opacity="0.12" />
    </filter>
  </defs>

  <!-- Studio Background -->
  <rect width="800" height="600" fill="url(#bg)" />

  <!-- Studio Floor & Light Platform -->
  <ellipse cx="400" cy="460" rx="320" ry="45" fill="#CBD5E1" opacity="0.6" filter="url(#shadow)" />
  <ellipse cx="400" cy="455" rx="300" ry="38" fill="#F1F5F9" />

  <!-- Motorcycle Body Silhouette & Graphic -->
  <g transform="translate(230, 180) scale(1.7)" filter="url(#shadow)">
    <!-- Wheels -->
    <circle cx="35" cy="115" r="28" fill="#0F172A" />
    <circle cx="35" cy="115" r="18" fill="#F8FAFC" stroke="#64748B" stroke-width="4" />
    <circle cx="35" cy="115" r="6" fill="#0F172A" />

    <circle cx="165" cy="115" r="28" fill="#0F172A" />
    <circle cx="165" cy="115" r="18" fill="#F8FAFC" stroke="#64748B" stroke-width="4" />
    <circle cx="165" cy="115" r="6" fill="#0F172A" />

    <!-- Chassis & Frame -->
    <path d="M35 115 L75 75 L120 75 L165 115" fill="none" stroke="#334155" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" />
    <path d="M75 75 L95 115 L145 115" fill="none" stroke="#475569" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />

    <!-- Main Tank / Body Fairing -->
    <path d="M60 70 Q95 40 135 65 L145 80 L80 82 Z" fill="{$accentColor}" />
    <path d="M125 50 L140 70 L115 70 Z" fill="#C62828" opacity="0.85" />

    <!-- Handlebar & Front Fork -->
    <line x1="135" y1="45" x2="165" y2="115" stroke="#0F172A" stroke-width="6" stroke-linecap="round" />
    <line x1="120" y1="45" x2="148" y2="45" stroke="#0F172A" stroke-width="5" stroke-linecap="round" />

    <!-- Headlight / Visor -->
    <polygon points="148,45 160,52 148,60" fill="#E2E8F0" stroke="#0F172A" stroke-width="2" />
    <circle cx="152" cy="52" r="3" fill="#38BDF8" />

    <!-- Seat -->
    <path d="M65 68 Q90 65 110 68 L105 76 L70 76 Z" fill="#0F172A" />

    <!-- Exhaust -->
    <path d="M95 115 L140 115 L165 98" fill="none" stroke="#94A3B8" stroke-width="6" stroke-linecap="round" />
  </g>

  <!-- Watermark Brand Header -->
  <rect x="40" y="35" width="130" height="34" rx="6" fill="#FFFFFF" stroke="#CBD5E1" stroke-width="1" />
  <text x="52" y="58" font-family="'Inter', sans-serif" font-size="14" font-weight="700" fill="#166534">MUHARIMOKAS</text>

  <!-- Vehicle Info Badge at the Bottom -->
  <rect x="50" y="495" width="700" height="70" rx="10" fill="#FFFFFF" stroke="#E2E8F0" stroke-width="1.5" filter="url(#shadow)" />

  <text x="75" y="528" font-family="'Inter', sans-serif" font-size="20" font-weight="700" fill="#0F172A">{$brand} {$model} ({$year})</text>
  <text x="75" y="549" font-family="'Inter', sans-serif" font-size="13" font-weight="500" fill="#64748B">Transmisi: {$transmission} • {$angle}</text>

  <rect x="615" y="512" width="115" height="36" rx="6" fill="#166534" />
  <text x="672" y="535" font-family="'Inter', sans-serif" font-size="12" font-weight="600" fill="#FFFFFF" text-anchor="middle">VERIFIED UNIT</text>
</svg>
SVG;
    }
}
