<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    public function test_admin_can_view_products_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.products.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_product()
    {
        Storage::fake('public');

        $data = [
            'name' => 'New Product',
            'description' => 'New Description',
            'price' => 150.00,
            'category' => 'Gadgets',
            'stock' => 50,
            'image' => UploadedFile::fake()->create('product.jpg', 100) // 100KB dummy file
        ];

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.products.store'), $data);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'New Product']);

        $product = Product::where('name', 'New Product')->first();
        Storage::disk('public')->assertExists($product->image);
    }

    public function test_admin_can_import_products()
    {
        Storage::fake('public');

        $csvContent = "name,description,price,category,stock,image\n" .
            "Imported 1,Desc 1,10.00,Cat 1,10,\n" .
            "Imported 2,Desc 2,20.00,Cat 2,20,\n";

        $file = UploadedFile::fake()->createWithContent('products.csv', $csvContent);

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.products.import'), [
                'file' => $file
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        // Since it's queued, we might not see it in DB immediately in a real environment 
        // without processing the queue, but in tests Sync queue is often used.
        // Let's assume sync for this test context or check if it works.
        $this->assertDatabaseHas('products', ['name' => 'Imported 1']);
        $this->assertDatabaseHas('products', ['name' => 'Imported 2']);
    }
}
