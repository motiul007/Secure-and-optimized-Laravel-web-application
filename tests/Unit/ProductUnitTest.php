<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Imports\ProductImport;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_import_mapping()
    {
        $import = new ProductImport();
        $row = [
            "name" => "Test Product",
            "description" => "Test Description",
            "price" => 99.99,
            "category" => "Test Category",
            "stock" => 10,
            "image" => null
        ];

        $product = $import->model($row);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals("Test Product", $product->name);
        $this->assertEquals("defaults/product.png", $product->image);
    }
}
