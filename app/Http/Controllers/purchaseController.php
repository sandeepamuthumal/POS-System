<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class purchaseController extends Controller
{
    public function purchases()
    {
        $purchase_code = Helper::IDGenerator(new Purchase, 'purchase_code', 4, 'GRN');
        $products = Item::where('status', 1)->get();
        $suppliers = Supplier::where('status', 1)->get();

        return view('admin.pages.purchases.index', compact('products', 'purchase_code', 'suppliers'));
    }

    public function loadPurchaseActive()
    {
        $purchases = Purchase::leftJoin('suppliers', 'suppliers.id', '=', 'purchases.suppliers_id')
            ->where('purchases.status','!=', '0')
            ->select('purchases.*','suppliers.supplier_name')
            ->get();
        $data = [];

        foreach ($purchases as $row) {
            if ($row->status == 1) {
                $status = '<span class="badge badge-md light badge-success" style="">Completed</span>';
            }
            $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Delete" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
            $view =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-warning view" data-toggle="tooltip" title="View Items"><i class="fa fa-eye"></i></a>';
            $product_count = PurchaseItem::where('purchases_id',$row->id)->where('status','!=', '0')->count();

            array_push($data, [
                'code' => $row->purchase_code,
                'date' => Carbon::parse($row->purchase_date)->format('d/m/Y'),
                'supplier' => $row->supplier_name,
                'count' => $product_count,
                'status' => $status,
                'edit_button' => $view . ' ' . $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }

    public function addPurchaseItem(Request $request)
    {
        $request->validate([
            'quantity' => 'required|string',
            'supplier' => 'required',
            'product_name' => 'required',
            'purchase_price' => 'required',
        ]);

        $purchase_code = $request->purchase_code;

        //check existing purchase
        $is_purchase = Purchase::where('purchase_code', $purchase_code)->where('status', 1)->exists();

        if ($is_purchase == false) {
            $purchase = new Purchase;
            $purchase->purchase_code = $request->purchase_code;
            $purchase->purchase_date = $request->mdate;
            $purchase->suppliers_id = $request->supplier;
            $purchase->log_user_id = Session::get('pos_log_user');
            $purchase->status = 1;
            $purchase->save();
        } else {
            $purchase = Purchase::where('purchase_code', $purchase_code)->where('status', 1)->first();
        }

        //add product to purchase
        $is_product = PurchaseItem::where('purchases_id', $purchase->id)->where('items_id', $request->product_name)->where('status', 1)->exists();

        if ($is_product == false) {
            $product = new PurchaseItem();
            $product->purchases_id = $purchase->id;
            $product->items_id = $request->product_name;
            $product->qty = $request->quantity;
            $product->available_qty = $request->quantity;
            $product->purchase_price = $request->purchase_price;
            $product->status = 1;
            $product->save();
        } else {
            $product = PurchaseItem::where('purchases_id', $purchase->id)->where('items_id', $request->product_name)->where('status', 1)->first();
            $product->qty = $request->quantity;
            $product->available_qty = $request->quantity;
            $product->purchase_price = $request->purchase_price;
            $product->status = 1;
            $product->update();
        }

        //update product available quantity and price
        $item = Item::find($product->items_id);
        $item->available_stock = $item->available_stock + $request->quantity;
        $item->update();

        return response()->json(['success' => true, 'purchase_id' => $purchase->id]);
    }

    public function loadPurchaseItems(Request $request)
    {
        $purchase_items = PurchaseItem::leftJoin('items', 'items.id', '=', 'purchase_has_items.items_id')
            ->where('purchase_has_items.purchases_id', $request->purchase_id)
            ->where('purchase_has_items.status', 1)
            ->select('purchase_has_items.*', 'items.item_code', 'items.item_name')
            ->get();

        return response()->json(['success' => true, 'purchase_items' => $purchase_items]);
    }

    public function deletePurchaseItem(Request $request)
    {
        $product = PurchaseItem::find($request->item_id);
        $product->status = 0;
        $product->update();

        return response()->json(['success' => true,'purchase_id' => $product->purchases_id]);
    }

    public function loadPurchaseCode()
    {
        $purchase_code = Helper::IDGenerator(new Purchase, 'purchase_code', 4, 'GRN');

        return response()->json(['success' => true, 'code' => $purchase_code]);
    }

    public function storePurchases(Request $request)
    {
        $request->validate([
            'supplier' => 'required',
        ]);

        $purchase_code = $request->purchase_code;

        //check existing purchase
        $is_purchase = Purchase::where('purchase_code', $purchase_code)->where('status', 1)->exists();

        if ($is_purchase == false) {
            $purchase = new Purchase;
            $purchase->purchase_code = $request->purchase_code;
            $purchase->purchase_date = $request->mdate;
            $purchase->suppliers_id = $request->supplier;
            $purchase->log_user_id = Session::get('pos_log_user');
            $purchase->status = 1;
            $purchase->save();
        } else {
            $purchase = Purchase::where('purchase_code', $purchase_code)->where('status', 1)->first();
            $purchase->purchase_date = $request->mdate;
            $purchase->suppliers_id = $request->supplier;
            $purchase->status = 1;
            $purchase->update();
        }

        return response()->json(['success' => true,]);
    }

    public function editPurchase(Request $request)
    {
        $purchase = Purchase::find($request->id);

        return response()->json(['success' => true, 'purchase' => $purchase]);
    }

    public function delete($id)
    {
        $product = Purchase::find($id);
        $product->status = 0;
        $product->update();

        return response()->json(['success' => true]);
    }
}
