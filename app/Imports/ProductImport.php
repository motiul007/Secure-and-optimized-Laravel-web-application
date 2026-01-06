<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ProductImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, ShouldQueue, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            \Illuminate\Support\Facades\Log::error('Import failure at row ' . $failure->row() . ': ' . json_encode($failure->errors()));
        }
    }

    public function model(array $row)
    {
        \Illuminate\Support\Facades\Log::info('Processing row: ' . json_encode($row));
        return new Product([
            "name" => $row["name"],
            "description" => $row["description"],
            "price" => $row["price"],
            "category" => $row["category"],
            "stock" => $row["stock"],
            "image" => $row["image"] ?? "defaults/images.jpg",
        ]);
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required|numeric|min:0",
            "category" => "required|string",
            "stock" => "required|integer|min:0",
            "image" => "nullable|string",
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
