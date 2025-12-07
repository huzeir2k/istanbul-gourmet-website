<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        // Protect endpoints — adapt to your auth (sanctum/session)
        $this->middleware('auth:sanctum')->except(['index','show']);
    }

    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        // Text search
        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('sku', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%")
                    ->orWhere('short_description', 'like', "%$q%");
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by brand
        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        // Price range filter (in cents)
        if ($request->has('min_price') && $request->min_price) {
            $minCents = (int) round(floatval($request->min_price) * 100);
            $query->where('price_cents', '>=', $minCents);
        }

        if ($request->has('max_price') && $request->max_price) {
            $maxCents = (int) round(floatval($request->max_price) * 100);
            $query->where('price_cents', '<=', $maxCents);
        }

        // Sorting
        $sortBy = $request->query('sort_by', 'name');
        $sortOrder = $request->query('sort_order', 'asc');
        $validSortFields = ['name', 'price_cents', 'created_at', 'stock'];

        if (in_array($sortBy, $validSortFields)) {
            $query->orderBy($sortBy, in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc');
        } else {
            $query->orderBy('name');
        }

        $perPage = $request->query('per_page', 20);
        return $query->paginate($perPage);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // store price from 'price' field into price_cents through model mutator
        $product = new Product($data);

        if (empty($product->slug)) {
            $product->slug = Str::slug($product->name . '-' . Str::random(6));
        }

        // image handling
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $f) {
                $images[] = $f->store('products', 'public');
            }
            $product->images = $images;
        }

        $product->save();

        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // update price via mutator if present
        if (array_key_exists('price', $data)) {
            $product->price = $data['price'];
        }

        $product->fill($data);

        if ($request->hasFile('image')) {
            // delete old image (optional)
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('images')) {
            $images = $product->images ?? [];
            foreach ($request->file('images') as $f) {
                $images[] = $f->store('products', 'public');
            }
            $product->images = $images;
        }

        $product->save();

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        // Soft delete
        $product->delete();

        return response()->json(null, 204);
    }
}

