<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Motorcycle;
use App\Models\MotorcycleImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
}
