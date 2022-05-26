<?php

namespace App\Http\Controllers;

use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = ProductVariant::where('id_product', $id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('product.variant.delete', [$data->id_product, $data->id]) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })
                ->addColumn('size', function ($data) {
                    return ProductSize::find($data->id_product_size)->size;
                })
                ->addColumn('color', function ($data) {
                    return ProductColor::find($data->id_product_color)->color_name;
                })
                ->addColumn('photo', function ($data) {
                    return '<img src="' . Storage::url($data->photo) . '" width="100px" height="100px" />';
                })
                ->rawColumns(['action', 'size', 'color', 'photo'])
                ->make(true);
        }
        return view('pages.product.variant', compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_view(Request $request, $id)
    {
        $data_color = \App\Models\ProductColor::all();
        $data_size = \App\Models\ProductSize::all();
        return view('pages.product.variant-create', compact('data_color', 'data_size', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_process(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required',
            'price' => 'required',
            'discounted_price' => 'required',
            'photo'  => 'required',
            'size'  => 'required',
            'color'  => 'required',
        ]);

        $product_variant = new ProductVariant();
        $product_variant->id_product = $id;
        $product_variant->id_product_color = $request->color;
        $product_variant->id_product_size = $request->size;
        $product_variant->stock = $request->stock;
        $product_variant->price = $request->price;
        $product_variant->discounted_price = $request->discounted_price;
        $product_variant->photo = Storage::disk('public')->put('product-variant', $request->file('photo'));
        $product_variant->save();

        return redirect()->route('product.variant', compact('id'))->withSuccess('Product created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function delete($product_id, $id)
    {
        $product = ProductVariant::find($id);
        $product->delete();

        return redirect()->route('product.variant', $product_id)->withSuccess('Product Variant deleted successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductVariant $productVariant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariant $productVariant)
    {
        //
    }
}
