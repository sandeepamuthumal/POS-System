<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Customer;
use App\Models\Item;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SalesController extends Controller
{
    public function pos()
    {
        $order_code = Helper::IDGenerator(new Sale, 'sale_code', 4, 'ORD');
        $customers = Customer::where('status', 1)->get();

        return view('admin.pages.sales.pos', compact('order_code', 'customers'));
    }

    public function showProduct(Request $request)
    {
        $product = Item::where('item_code', $request->product_code)->first();

        return response()->json(['success' => true, 'product' => $product]);
    }

    public function storeSaleProduct(Request $request)
    {
        $request->validate([
            'quantity' => 'required',
        ]);

        $is_sale = Sale::where('sale_code', $request->sale_code)->exists();
        $user_id = Session::get('pos_log_user');

        if ($is_sale == false) {
            $sale = new Sale();
            $sale->sale_code = $request->sale_code;
            $sale->customers_id = $request->customer;
            $sale->sale_date = $request->sale_date;
            $sale->log_user_id = $user_id;
            $sale->status = 2;
            $sale->save();
        } else {
            $sale = Sale::where('sale_code', $request->sale_code)->first();
        }

        //store products
        $product_qty = $request->quantity;

        $product = Item::find($request->product_id);

        if ($product->available_stock >= $product_qty) {
            //get purchases
            $grn_items = PurchaseItem::where('items_id', $request->product_id)->where('available_qty', '>', 0)->get();

            foreach ($grn_items as $gitem) {
                $grn_item = PurchaseItem::find($gitem->id);

                if ($grn_item->available_qty >= $product_qty) {
                    $grn_item->available_qty = $grn_item->available_qty * 1 - $product_qty * 1;
                    $grn_item->update();

                    $product->available_stock = $product->available_stock * 1 - $product_qty * 1;
                    $product->update();

                    $sale_item = new SaleItem;
                    $sale_item->sales_id = $sale->id;
                    $sale_item->items_id = $request->product_id;
                    $sale_item->order_qty = $product_qty;
                    $sale_item->unit_price = $grn_item->purchase_price;
                    $sale_item->sell_price = $product->unit_price;
                    $sale_item->status = 1;
                    $sale_item->save();

                    break;
                } else {
                    $available_qty = $grn_item->available_qty;
                    $product_qty = $product_qty * 1 - $available_qty * 1;

                    $product->available_stock = $product->available_stock * 1 - $available_qty * 1;
                    $product->update();

                    $sale_item = new SaleItem;
                    $sale_item->sales_id = $sale->id;
                    $sale_item->items_id = $request->product_id;
                    $sale_item->order_qty = $request->quantity;
                    $sale_item->unit_price = $grn_item->purchase_price;
                    $sale_item->sell_price = $product->unit_price;
                    $sale_item->status = 1;
                    $sale_item->save();

                    $grn_item->available_qty = 0;
                    $grn_item->update();
                }
            }
        }

        //get all sales items
        $sale_items = SaleItem::where('status', 1)
            ->selectRaw('sum(order_qty) as total_qty, items_id , MAX(sell_price) as sell_price')
            ->where('sales_id', $sale->id)
            ->groupBy('items_id')
            ->get();

        foreach ($sale_items as $item) {
            $item_product = Item::find($item->items_id);
            $products[$item->items_id] = $item_product->item_name;
        }

        return response()->json(['products' => $products, 'sales_items' => $sale_items]);
    }

    public function submitSale(Request $request)
    {
        $is_sale = Sale::where('sale_code', $request->sale_code)->exists();

        if ($is_sale == false) {
            return response()->json(['status' => 0, 'message' => 'Please add products']);
        } else {
            $sale = Sale::where('sale_code', $request->sale_code)->first();
            $sale->status = 1;
            $sale->sale_total = $request->total_price;
            $sale->update();

            return response()->json(['status' => 1, 'message' => 'Sale added successfully']);
        }
    }

    public function sales()
    {
        $sales = Sale::where('status', '!=', 0)->orderBy('id', 'DESC')->get();
        return view('admin.pages.sales.index', compact('sales'));
    }

    public function salesView($id)
    {
        $sale = Sale::find($id);
        if ($sale->customers_id == null) {
            $customer = 'Unknown';
            $customer_contact_no = 'N/A';
        } else {
            $customer_data = DB::table('customers')
                ->where('id', $sale->customers_id)
                ->first();
            $customer = $customer_data->customer_name;
            $customer_contact_no = $customer_data->phone;
        }

        //get all sales items
        $sale_items = SaleItem::where('status', 1)
            ->selectRaw('sum(order_qty) as total_qty, items_id , MAX(sell_price) as sell_price')
            ->where('sales_id', $sale->id)
            ->groupBy('items_id')
            ->get();

        foreach ($sale_items as $item) {
            $item_product = Item::find($item->items_id);
            $products[$item->items_id] = $item_product->item_name;
        }

        return view('admin.pages.sales.view', compact('products', 'sale_items','sale','customer_contact_no','customer'));
    }
}
