<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Motorcycle;
use App\Models\MotorcycleImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tests\TestCase;

class MuhariMokasTest extends TestCase
{
    use RefreshDatabase;

    protected User $employee;
    protected Brand $honda;
    protected Brand $yamaha;

    protected function setUp(): void
    {
        parent::setUp();

        // Create initial employee
        $this->employee = User::factory()->create([
            'email' => 'admin@muharimokas.com',
        ]);

        $this->honda = Brand::create(['name' => 'Honda']);
        $this->yamaha = Brand::create(['name' => 'Yamaha']);
    }

    public function test_public_homepage_renders_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Muhari');
        $response->assertSee('Mokas');
        $response->assertSee('Temukan Motor Bekas Berkualitas');
    }

    public function test_catalog_displays_only_published_motorcycles_by_default(): void
    {
        $published = Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Vario 160 ABS',
            'year' => 2023,
            'price' => 24500000,
            'mileage' => 12000,
            'engine_capacity' => 160,
            'transmission' => 'Automatic',
            'color' => 'Hitam',
            'description' => 'Motor istimewa mulus siap pakai.',
            'status' => Motorcycle::STATUS_PUBLISHED,
        ]);

        $draft = Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Draft Motor Unit',
            'year' => 2022,
            'price' => 15000000,
            'mileage' => 20000,
            'engine_capacity' => 125,
            'transmission' => 'Automatic',
            'color' => 'Merah',
            'description' => 'Masih dalam persiapan.',
            'status' => Motorcycle::STATUS_DRAFT,
        ]);

        $response = $this->get(route('catalog.index'));

        $response->assertStatus(200);
        $response->assertSee('Vario 160 ABS');
        $response->assertDontSee('Draft Motor Unit');
    }

    public function test_catalog_search_and_filters_work(): void
    {
        Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Beat Deluxe',
            'year' => 2021,
            'price' => 14500000,
            'mileage' => 24000,
            'engine_capacity' => 110,
            'transmission' => 'Automatic',
            'color' => 'Silver',
            'description' => 'Motor irit harian.',
            'status' => Motorcycle::STATUS_PUBLISHED,
        ]);

        Motorcycle::create([
            'brand_id' => $this->yamaha->id,
            'created_by' => $this->employee->id,
            'model' => 'NMAX 155',
            'year' => 2023,
            'price' => 29000000,
            'mileage' => 10000,
            'engine_capacity' => 155,
            'transmission' => 'Automatic',
            'color' => 'Biru',
            'description' => 'Maxi scooter nyaman.',
            'status' => Motorcycle::STATUS_PUBLISHED,
        ]);

        // Search by keyword
        $searchResponse = $this->get(route('catalog.index', ['search' => 'NMAX']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('NMAX 155');
        $searchResponse->assertDontSee('Beat Deluxe');

        // Filter by brand
        $brandResponse = $this->get(route('catalog.index', ['brand_id' => $this->honda->id]));
        $brandResponse->assertStatus(200);
        $brandResponse->assertSee('Beat Deluxe');
        $brandResponse->assertDontSee('NMAX 155');

        // Filter by price range
        $priceResponse = $this->get(route('catalog.index', [
            'min_price' => 20000000,
            'max_price' => 35000000,
        ]));
        $priceResponse->assertStatus(200);
        $priceResponse->assertSee('NMAX 155');
        $priceResponse->assertDontSee('Beat Deluxe');

        // Edge case: min_price > max_price should be handled gracefully
        $swappedPriceResponse = $this->get(route('catalog.index', [
            'min_price' => 35000000,
            'max_price' => 20000000,
        ]));
        $swappedPriceResponse->assertStatus(200);
        $swappedPriceResponse->assertSee('NMAX 155');
        $swappedPriceResponse->assertDontSee('Beat Deluxe');
    }

    public function test_product_detail_page_renders_with_whatsapp_integration(): void
    {
        $motorcycle = Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'PCX 160 CBS',
            'year' => 2023,
            'price' => 28500000,
            'mileage' => 8000,
            'engine_capacity' => 160,
            'transmission' => 'Automatic',
            'color' => 'Putih',
            'description' => 'Unit gres kilometer rendah.',
            'status' => Motorcycle::STATUS_PUBLISHED,
        ]);

        $response = $this->get(route('catalog.show', $motorcycle->id));

        $response->assertStatus(200);
        $response->assertSee('PCX 160 CBS');
        $response->assertSee('Rp 28.500.000');
        $response->assertSee('Hubungi Showroom via WhatsApp');
        $response->assertSee(rawurlencode('Honda PCX 160 CBS 2023'));

        // Test SEO slug URL: /katalog/1-honda-pcx-160
        $slugResponse = $this->get('/katalog/' . $motorcycle->id . '-honda-pcx-160');
        $slugResponse->assertStatus(200);
        $slugResponse->assertSee('PCX 160 CBS');
    }

    public function test_sold_motorcycle_displays_terjual_badge_and_disabled_cta(): void
    {
        $sold = Motorcycle::create([
            'brand_id' => $this->yamaha->id,
            'created_by' => $this->employee->id,
            'model' => 'Aerox 155 CyberCity',
            'year' => 2022,
            'price' => 25000000,
            'mileage' => 15000,
            'engine_capacity' => 155,
            'transmission' => 'Automatic',
            'color' => 'Merah',
            'description' => 'Sudah laku terjual.',
            'status' => Motorcycle::STATUS_SOLD,
        ]);

        $response = $this->get(route('catalog.show', $sold->id));

        $response->assertStatus(200);
        $response->assertSee('UNIT TERJUAL');
        $response->assertSee('Unit Telah Terjual (CTA Dinonaktifkan)');
    }

    public function test_draft_or_inactive_motorcycle_returns_404_for_customer(): void
    {
        $draft = Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Private Draft Bike',
            'year' => 2023,
            'price' => 20000000,
            'mileage' => 5000,
            'engine_capacity' => 125,
            'transmission' => 'Automatic',
            'color' => 'Hitam',
            'description' => 'Draft unit.',
            'status' => Motorcycle::STATUS_DRAFT,
        ]);

        $response = $this->get(route('catalog.show', $draft->id));
        $response->assertStatus(404);
    }

    public function test_static_pages_render_successfully(): void
    {
        $this->get(route('about'))->assertStatus(200)->assertSee('Tentang Showroom');
        $this->get(route('contact'))->assertStatus(200)->assertSee('Kontak & Lokasi');
    }

    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_employee_can_login_and_access_dashboard(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'admin@muharimokas.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));

        $dashboardResponse = $this->actingAs($this->employee)->get(route('admin.dashboard'));
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Ringkasan Dashboard');
    }

    public function test_employee_can_create_motorcycle_with_images(): void
    {
        Storage::fake('public');

        $imageFile = UploadedFile::fake()->image('test_motor.jpg', 800, 600);

        $response = $this->actingAs($this->employee)->post(route('admin.motorcycles.store'), [
            'brand_id' => $this->honda->id,
            'model' => 'CBR 150R',
            'year' => 2023,
            'price' => 32000000,
            'mileage' => 7000,
            'engine_capacity' => 150,
            'transmission' => 'Manual',
            'color' => 'Merah Racing',
            'description' => 'Motor sport fairing sangat mulus terawat surat lengkap.',
            'status' => 'published',
            'images' => [$imageFile],
            'primary_image_index' => 0,
        ]);

        $response->assertRedirect(route('admin.motorcycles.index'));

        $this->assertDatabaseHas('motorcycles', [
            'model' => 'CBR 150R',
            'year' => 2023,
            'status' => 'published',
        ]);

        $motorcycle = Motorcycle::where('model', 'CBR 150R')->first();
        $this->assertNotNull($motorcycle);
        $this->assertEquals(1, $motorcycle->images()->count());
        $this->assertTrue($motorcycle->images()->first()->is_primary);
    }

    public function test_employee_can_update_motorcycle(): void
    {
        $motorcycle = Motorcycle::create([
            'brand_id' => $this->yamaha->id,
            'created_by' => $this->employee->id,
            'model' => 'Mio M3',
            'year' => 2020,
            'price' => 9500000,
            'mileage' => 35000,
            'engine_capacity' => 125,
            'transmission' => 'Automatic',
            'color' => 'Kuning',
            'description' => 'Motor harian irit.',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->employee)->put(route('admin.motorcycles.update', $motorcycle->id), [
            'brand_id' => $this->yamaha->id,
            'model' => 'Mio M3 125 CW',
            'year' => 2020,
            'price' => 10000000,
            'mileage' => 35000,
            'engine_capacity' => 125,
            'transmission' => 'Automatic',
            'color' => 'Kuning Metalik',
            'description' => 'Deskripsi diperbarui surat lengkap.',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.motorcycles.index'));

        $motorcycle->refresh();
        $this->assertEquals('Mio M3 125 CW', $motorcycle->model);
        $this->assertEquals('published', $motorcycle->status);
    }

    public function test_employee_can_delete_motorcycle(): void
    {
        $motorcycle = Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Motor to be deleted',
            'year' => 2019,
            'price' => 11000000,
            'mileage' => 40000,
            'engine_capacity' => 110,
            'transmission' => 'Automatic',
            'color' => 'Hitam',
            'description' => 'Unit akan dihapus.',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->employee)->delete(route('admin.motorcycles.destroy', $motorcycle->id));

        $response->assertRedirect(route('admin.motorcycles.index'));
        $this->assertDatabaseMissing('motorcycles', ['id' => $motorcycle->id]);
    }

    public function test_employee_can_export_sold_motorcycles_as_excel(): void
    {
        $sold = Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Sold CBR',
            'year' => 2022,
            'price' => 20000000,
            'mileage' => 10000,
            'engine_capacity' => 150,
            'transmission' => 'Manual',
            'color' => 'Merah',
            'description' => 'Unit terjual.',
            'status' => Motorcycle::STATUS_SOLD,
            'sold_at' => now(),
        ]);
        Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Available Vario',
            'year' => 2023,
            'price' => 22000000,
            'mileage' => 5000,
            'engine_capacity' => 160,
            'transmission' => 'Automatic',
            'color' => 'Hitam',
            'description' => 'Unit tersedia.',
            'status' => Motorcycle::STATUS_PUBLISHED,
        ]);

        Motorcycle::create([
            'brand_id' => $this->yamaha->id,
            'created_by' => $this->employee->id,
            'model' => 'Sold Outside Date Range',
            'year' => 2020,
            'price' => 12000000,
            'mileage' => 30000,
            'engine_capacity' => 125,
            'transmission' => 'Manual',
            'color' => 'Putih',
            'description' => 'Penjualan di luar rentang.',
            'status' => Motorcycle::STATUS_SOLD,
            'sold_at' => now()->subDays(3),
        ]);

        $response = $this->actingAs($this->employee)->get(route('admin.motorcycles.export.sales', [
            'export_type' => 'sales',
            'from_date' => now()->toDateString(),
            'to_date' => now()->toDateString(),
        ]));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $path = tempnam(sys_get_temp_dir(), 'mokas-export-');
        try {
            file_put_contents($path, $response->streamedContent());
            $sheet = IOFactory::load($path)->getActiveSheet();
            $this->assertSame('Motor Terjual', $sheet->getTitle());
            $this->assertSame('Model', $sheet->getCell('C1')->getValue());
            $this->assertSame('Sold CBR', $sheet->getCell('C2')->getValue());
            $this->assertSame(Motorcycle::STATUS_SOLD, $sheet->getCell('J2')->getValue());
            $this->assertSame(now()->format('Y-m-d'), substr($sheet->getCell('L2')->getValue(), 0, 10));
            $this->assertNull($sheet->getCell('C3')->getValue());
        } finally {
            unlink($path);
        }
    }

    public function test_employee_can_export_motorcycle_arrivals_in_newest_first_order(): void
    {
        Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Arrival Outside Date Range',
            'year' => 2020,
            'price' => 12000000,
            'mileage' => 30000,
            'engine_capacity' => 125,
            'transmission' => 'Manual',
            'color' => 'Hitam',
            'description' => 'Data di luar rentang.',
            'status' => Motorcycle::STATUS_DRAFT,
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(3),
        ]);
        $oldest = Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Old Arrival',
            'year' => 2021,
            'price' => 14000000,
            'mileage' => 20000,
            'engine_capacity' => 125,
            'transmission' => 'Automatic',
            'color' => 'Biru',
            'description' => 'Data motor lama.',
            'status' => Motorcycle::STATUS_DRAFT,
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);
        $newest = Motorcycle::create([
            'brand_id' => $this->yamaha->id,
            'created_by' => $this->employee->id,
            'model' => 'New Arrival',
            'year' => 2024,
            'price' => 25000000,
            'mileage' => 1000,
            'engine_capacity' => 155,
            'transmission' => 'Automatic',
            'color' => 'Abu-abu',
            'description' => 'Data motor baru.',
            'status' => Motorcycle::STATUS_PUBLISHED,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->employee)->get(route('admin.motorcycles.export.arrivals', [
            'export_type' => 'arrivals',
            'from_date' => now()->subDay()->toDateString(),
            'to_date' => now()->toDateString(),
        ]));

        $response->assertOk();
        $path = tempnam(sys_get_temp_dir(), 'mokas-export-');
        try {
            file_put_contents($path, $response->streamedContent());
            $sheet = IOFactory::load($path)->getActiveSheet();
            $this->assertSame('Motor Baru Masuk', $sheet->getTitle());
            $this->assertSame('New Arrival', $sheet->getCell('C2')->getValue());
            $this->assertSame('Old Arrival', $sheet->getCell('C3')->getValue());
            $this->assertSame((int) $newest->id, $sheet->getCell('A2')->getValue());
            $this->assertSame((int) $oldest->id, $sheet->getCell('A3')->getValue());
        } finally {
            unlink($path);
        }
    }

    public function test_export_requires_a_valid_inclusive_date_range(): void
    {
        $response = $this->actingAs($this->employee)->get(route('admin.motorcycles.export.arrivals', [
            'export_type' => 'arrivals',
            'from_date' => now()->toDateString(),
            'to_date' => now()->subDay()->toDateString(),
        ]));

        $response->assertRedirect();
        $response->assertSessionHasErrors(['to_date']);
    }

    public function test_employee_can_open_export_date_range_form(): void
    {
        $response = $this->actingAs($this->employee)->get(route('admin.motorcycles.index'));

        $response->assertOk();
        $response->assertSee('Ekspor Penjualan');
        $response->assertSee('Ekspor Motor Masuk');
        $response->assertSee('type="date"', false);
        $response->assertSee('x-show="exportModalOpen"', false);
    }

    public function test_marking_motorcycle_as_sold_records_sale_date(): void
    {
        $motorcycle = Motorcycle::create([
            'brand_id' => $this->honda->id,
            'created_by' => $this->employee->id,
            'model' => 'Sale Date Test',
            'year' => 2022,
            'price' => 17000000,
            'mileage' => 15000,
            'engine_capacity' => 150,
            'transmission' => 'Manual',
            'color' => 'Hitam',
            'description' => 'Tes tanggal penjualan.',
            'status' => Motorcycle::STATUS_PUBLISHED,
        ]);

        $this->actingAs($this->employee)->put(route('admin.motorcycles.update', $motorcycle), [
            'brand_id' => $this->honda->id,
            'model' => $motorcycle->model,
            'year' => $motorcycle->year,
            'price' => $motorcycle->price,
            'mileage' => $motorcycle->mileage,
            'engine_capacity' => $motorcycle->engine_capacity,
            'transmission' => $motorcycle->transmission,
            'color' => $motorcycle->color,
            'description' => $motorcycle->description,
            'status' => Motorcycle::STATUS_SOLD,
        ])->assertRedirect(route('admin.motorcycles.index'));

        $this->assertNotNull($motorcycle->fresh()->sold_at);
    }
}
