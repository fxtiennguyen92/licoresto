<?php

namespace App\Http\Controllers;

use App\Http\Common\ImageStorage;
use App\Http\Constants\HttpStatusCode;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class ProductController extends Controller
{
    /**
     * View product list
     */
    public function list(Request $request)
    {
    }

    /**
     * Create new product
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = $this->validateRequest($request->all());
        if ($validator->fails()) {
            return response($validator->errors(), HttpStatusCode::BAD_REQUEST);
        }

        try {
            // Create with required data
            $product = Product::create([
                'id' => Uuid::uuid4(),
                'name' => $request->name,
            ]);

            // Other data
            if ($request->has('description')) $product->description = $request->description;
            if ($request->has('price')) $product->description = $request->price;
            if ($request->has('discount_flg')) $product->description = $request->discount_flg;
            if ($request->has('net_price')) $product->description = $request->net_price;
            if ($request->has('featured_flg')) $product->description = $request->featured_flg;
            if ($request->has('popular_flg')) $product->description = $request->popular_flg;
            if ($request->has('published_flg')) $product->description = $request->published_flg;

            // Image
            if (is_uploaded_file($request->image)) {
                $imgSource = $request->get('image');
                $fileName = uniqid() . '.' . $request->image->extension();
                $imageLink = ImageStorage::store($imgSource, $fileName, 'products');

                $product->image = $imageLink;
            }

            // Save
            $product->save();
            return response($product, HttpStatusCode::OK);

        } catch (\Exception $e) {
            return response($e->getMessage(), HttpStatusCode::INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * View product by id
     */
    public function view(string $id, Request $request)
    {
    }

    /**
     * Update product
     */
    public function edit(string $id, Request $request)
    {
    }

    /**
     * Delete product
     */
    public function delete(string $id, Request $request)
    {
    }

    /**
     * Validate request
     */
    protected function validateRequest(array $data, string $currentId = null)
    {
        // Check unique
        $uniqueRule = ($currentId) ? (',name,' . $currentId) : '';

        $rules = [
            'name' => 'nullable|max:200|unique:products' . $uniqueRule,
            'image' => 'nullable|file|extensions:jpg,jpeg,png,svg,webp,avif,gif,ico,bmp,tif,tiff',
            'price' => 'nullable|numeric',
            'discount_flg' => 'nullable|boolean',
            'net_price' => 'nullable|numeric',
            'featured_flg' => 'nullable|boolean',
            'popular_flg' => 'nullable|boolean',
            'published_flg' => 'nullable|boolean',
            'active_flg' => 'nullable|boolean',
        ];

        $validator = Validator::make($data, $rules);

        return $validator;
    }
}
