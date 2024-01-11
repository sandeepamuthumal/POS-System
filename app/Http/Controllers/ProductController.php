<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        // Generate the QR code
        $qrCode = QrCode::format('png')
                ->size(200)
                ->margin(2)
                ->generate($product->item_code);
        // Define the folder and filename
        $folder = $this->generateFolderName();
        $filename = $product->item_code;

        // Define the base path for storing the images
        $basePath = public_path('uploads/qrcodes/' . $folder);

        // Check if the folder exists; if not, create it
        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }

        // Save the QR code image to the specified folder
        $filePath = $basePath . '/' . $filename . '.png';
        file_put_contents($filePath, $qrCode);

        $savingFileName = $folder . '/' . $filename . '.png';


        $product->path = $savingFileName;
        $product->update();

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

    public function viewProduct($id)
    {
        $product = Item::find($id);

        return view('admin.pages.products.view',compact('product'));
    }

    public function downloadQrcode($id)
    {
        $qr = Item::find($id);
        $filename = $qr->path;

        $filePath = public_path('uploads/qrcodes/' . $filename);

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        // Handle the case where the file doesn't exist
        abort(404);
    }

    private function generateFolderName()
    {
        $date = Carbon::now();
        $year = $date->year;
        $month = $date->format('m');
        $day = $date->format('d');

        return "{$year}-{$month}-{$day}";
    }
}
