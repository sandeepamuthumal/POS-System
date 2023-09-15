<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function AllSuppliers()
    {
        $active_suppliers = Supplier::where('status',1)->count();
        $deactive_suppliers = Supplier::where('status',0)->count();

        return view('admin.pages.suppliers.suppliers',compact('active_suppliers', 'deactive_suppliers'));
    }

    public function LoadAllSuppliers()
    {

        $suppliers = Supplier::orderBy('id', 'DESC')->get();

        $data = [];
        $count = 0;

        foreach ($suppliers as $row) {

            if($row->status == 1)
            {
                $status = '<span class="badge badge-md light badge-success" style="">Active</span>';
                $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Deactive" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';
            }
            else
            {
                $status = '<span class="badge badge-md light badge-danger">Deactive</span>';
                $delete = ' <button type="button" class="btn btn-xs btn-success show_confirm" data-toggle="tooltip" title="Active" onclick="activateData(' . $row->id . ')"><i class="fa-solid fa-repeat"></i></button>';
            }

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
            $count++;

            array_push($data, [
                'count' => $count,
                'full_name' => $row->supplier_name,
                'email' => $row->email,
                'contact_no' => $row->phone,
                'status' => $status,
                'action' => $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }



    public function SupplierStore(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required',
            'contact' => 'required',
            'address' => 'required',
        ]);


        //save supplier
        $supplier = new Supplier();
        $supplier->supplier_name = $request->input('full_name');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('contact');
        $supplier->address = $request->input('address');
        $supplier->status = "1";
        $supplier->save();

        return response()->json([
            'code' => 200, 'message' => 'Supplier Added Successfully',
        ], 200);
    }


    public function edit(Request $request)
    {
        $id = $request->id;
        $supplier = Supplier::find($id);

        return response()->json(['supplier' => $supplier, 'code' => 200], 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required',
            'contact' => 'required',
            'address' => 'required'
        ]);

        $supplier_id =  $request->input('supplier_id');

        $supplier = Supplier::find($supplier_id);
        $supplier->supplier_name = $request->input('full_name');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('contact');
        $supplier->address = $request->input('address');
        $supplier->update();

        return response()->json(['code' => 200, 'message' => 'Supplier Updated Successfully'], 200);
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier->status == "1") {
            $supplier->status = "0";
            $supplier->update();
        } else {
            $supplier->status = "1";
            $supplier->update();
        }

        return response()->json(['code' => 200, 'message' => 'Supplier Status Changed Successfully'], 200);
    }

}
