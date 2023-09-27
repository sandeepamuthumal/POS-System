<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    public function products()
    {
        $all_product_count = Item::where('status', 1)->count();
        $categories = Category::all();

        $products = Item::leftJoin('categories', 'categories.id','=','items.categories_id')
                        ->where('items.status',1)
                        ->orderBy('items.id','DESC')
                        ->select('items.*','categories.category')
                        ->get();

        return view('admin.pages.products.index',compact('products','all_product_count','categories'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        $product_code = Helper::IDGenerator(new Item, 'item_code', 4, 'PT');

        return view('admin.pages.products.create',compact('categories','product_code'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category',
        ]);

        //store the category
        $category = new Category;
        $category->category = $request->category_name;
        $category->save();

        return response()->json(['success' => true]);
    }

    public function loadCategory()
    {
        $categories = Category::all();

        return response()->json(['success'=>true, 'categories' => $categories]);
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'product_code' => 'required|unique:items,item_code',
            'category' => 'required',
            'product_name' => 'required',
            'price' => 'required'
        ]);

        //store product
        $product = new Item;
        $product->item_code = $request->product_code;
        $product->item_name = $request->product_name;
        $product->categories_id = $request->category;
        $product->description = $request->description;
        $product->unit_price = $request->price;
        $product->discount = $request->discount;
        $product->available_stock = $request->quantity;
        if ($request->hasfile('product_image')) {
            $x = 70;
            $file = $request->file('product_image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $img = \Image::make($file);
            $img->save(public_path('uploads/products/' . $filename), $x);
            $product->image = $filename;
        }

        $product->status = 1;
        $product->save();

        return redirect()->back()->with('message','Product created successfully');
    }

    public function deleteProduct($id)
    {
        //change status for delete
        $product = Item::find($id);
        $product->status = 0;
        $product->update();

        return response()->json(['success' => true]);
    }

    public function editProduct(Request $request)
    {
        $product = Item::find($request->id);
        return response()->json(['success' =>true, 'product' => $product]);
    }

    public function updateProduct(Request $request)
    {
        $request->validate([
            'product_code' => 'required',
            'category' => 'required',
            'product_name' => 'required',
        ]);

        //update product
        $product = Item::find($request->product_id);
        $product->item_code = $request->product_code;
        $product->item_name = $request->product_name;
        $product->categories_id = $request->category;
        $product->description = $request->description;
        $product->unit_price = $request->price;
        $product->discount = $request->discount;
        $product->available_stock = $request->quantity;
        if ($request->hasfile('product_image')) {
            $x = 70;
            $file = $request->file('product_image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $img = \Image::make($file);
            $img->save(public_path('uploads/products/' . $filename), $x);
            $product->image = $filename;
        }

        $product->status = 1;
        $product->update();

        return response()->json(['success' => true]);
    }
}
