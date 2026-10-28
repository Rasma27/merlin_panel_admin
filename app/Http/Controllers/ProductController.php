<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use RuntimeException;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::query()->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('products.form', ['product' => new Product]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['image_path'] = $this->processImage($request->file('image'), (float) $data['rotation']);
        unset($data['image'], $data['rotation']);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('products.form', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validatedData($request, $product);
        $oldImage = $product->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->processImage($request->file('image'), (float) $data['rotation']);
        }

        unset($data['image'], $data['rotation']);
        $product->update($data);

        if (isset($data['image_path']) && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('admin.products.index')->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $imagePath = $product->image_path;
        $product->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('admin.products.index')->with('status', 'Produk berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'sku' => ['required', 'string', 'max:80', 'unique:products,sku'.($product ? ','.$product->id : '')],
            'name' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:3000'],
            'price' => ['required', 'numeric', 'decimal:0,2', 'gt:0', 'max:9999999999'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
            'image' => [$product ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'rotation' => ['nullable', 'integer', 'in:0,90,180,270'],
        ]);
    }

    private function processImage(UploadedFile $file, float $rotation): string
    {
        $image = (new ImageManager(new Driver))
            ->read($file->getRealPath())
            ->orient()
            ->rotate($rotation)
            ->cover(1000, 1000);

        $image->text('MerlinMarket', $image->width() - 24, $image->height() - 24, function (FontFactory $font): void {
            $font->filename(base_path('vendor/dompdf/dompdf/lib/fonts/DejaVuSans.ttf'))
                ->size(24)
                ->color('#ffffff')
                ->stroke('#252421', 1)
                ->align('right')
                ->valign('bottom');
        });

        $path = 'products/'.Str::uuid().'.webp';
        if (! Storage::disk('public')->put($path, (string) $image->toWebp(85))) {
            throw new RuntimeException('Gambar produk gagal disimpan ke penyimpanan publik.');
        }

        return $path;
    }
}
