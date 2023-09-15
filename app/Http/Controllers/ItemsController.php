<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLevel;
use App\Models\Branches;
use App\Models\ItemCategories;
use App\Models\items;
use App\Models\BranchesHasItems;
use DB;
use Crypt;



class ItemsController extends Controller
{
    public function viewItem()
    {
        $user_types = UserLevel::all();
        $branches = Branches::all();
        $category = itemCategories::all();
        return view('admin.pages.items.items', compact('user_types','branches', 'category'));
    }

    public function storebranch(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string',
        ]);

        //save branch
        $branch = new Branches;
        $branch->name = strip_tags($request->input('branch_name'));
        $branch->save();

        return response()->json([
            'code' => 200, 'message' => 'Added Successfully',
        ], 200);
    }

    public function storecategorie(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'categories_name' => 'required|string',
        ]);

        //save categories
        $category = new ItemCategories;
        $category->category = strip_tags($request->input('categories_name'));
        $category->save();

        return response()->json([
            'code' => 200, 'message' => 'Added Successfully',
        ], 200);
    }

    public function showactiveitem(Request $request)
    {

        $activeitems = DB::table('items')
            ->leftjoin('branches_has_items', 'branches_has_items.items_id', 'items.id')
            ->leftjoin('branches', 'branches_has_items.branches_id', 'branches.id')
            ->leftjoin('item_categories', 'items.item_categories_id', 'item_categories.id')
            ->select('items.id', 'branches.name', 'items.item_name', 'branches_has_items.unit_price', 'items.status', 'item_categories.category')
            ->where('items.status', '1')
            ->orderBy('items.id', 'desc')->get();

        $data = [];
        foreach ($activeitems as $row) {

            $status = '<span class="badge badge-md light badge-success" style="">Active</span>';
            $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Deactive" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';

            array_push($data, [
                'item_name' => $row->item_name,
                'unit_price' => $row->unit_price,
                'category' => $row->category,
                'status' => $status,
                'edit_button' => $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }

    public function storeitem(Request $request)
    {
        $request->validate([
            'branch' => 'required',
            'item_catergory' => 'required',
            'item_name' => 'required|string',
            'item_price' => 'required|string',
        ]);

        //save items
        $item = new items;
        $item->item_name = strip_tags($request->input('item_name'));
        $item->item_categories_id = strip_tags($request->input('item_catergory'));
        $item->status = "1";
        $item->save();

        $itemhasbranch = new BranchesHasItems;
        $itemhasbranch->branches_id =strip_tags($request->input('branch'));
        $itemhasbranch->items_id = $item->id;
        $itemhasbranch->unit_price = strip_tags($request->input('item_price'));
        $itemhasbranch->save();

        return response()->json([
            'code' => 200, 'message' => 'Added Successfully',
        ], 200);
    }

    public function delete($id)
    {
        $item = items::find($id);
        if ($item->status == "1") {
            $item->status = "0";
            $item->update();
        } else {
            $item->status = "1";
            $item->update();
        }

        return response()->json(['code' => 200, 'message' => 'User Status Changed Successfully'], 200);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $item = items::find($id);
        $branchhasitem = BranchesHasItems::where('items_id', '=', $request->id)->first();

        return response()->json(['item' => $item, 'branchhasitem' => $branchhasitem, 'code' => 200,], 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'branch' => 'required',
            'category' => 'required',
            'item_name' => 'required',
            'item_price' => 'required',
        ]);

        $item_id =  $request->input('item_id');

        $item = items::find($item_id);
        $item->item_name = $request->input('item_name');
        $item->item_categories_id = $request->input('category');
        $item->update();

        $branchitem = BranchesHasItems::find($item->id);
        $branchitem->branches_id = $request->input('branch');
        $branchitem->items_id = $request->input('item_id');
        $branchitem->unit_price = $request->input('item_price');
        $branchitem->update();

        return response()->json(['code' => 200, 'message' => 'User Updated Successfully'], 200);
    }
}

