<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function AllCustomers()
    {
        $all_customer_count = Customer::orderBy('id', 'DESC')
            ->where('status', 1)
            ->count();

        return view('admin.pages.customers.all_customers', compact('all_customer_count'));
    }


    public function LoadAllCustomers()
    {

        $customers = Customer::orderBy('id', 'DESC')
            ->where('customers.status', 1)
            ->get();

        $data = [];
        $count = 0;

        foreach ($customers as $row) {

            $status = '<span class="badge badge-md light badge-success" style="">Active</span>';
            $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Deactive" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
            $count++;

            array_push($data, [
                'count' => $count,
                'full_name' => $row->customer_name,
                'nic' => $row->nic,
                'contact_no' => $row->phone,
                'status' => $status,
                'action' => $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }



    public function CustomerStore(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'nic' => 'required',
            'contact' => 'required',
            'address' => 'required',
        ]);


        //save customer
        $customer = new Customer();
        $customer->customer_name = $request->input('full_name');
        $customer->nic = $request->input('nic');
        $customer->phone = $request->input('contact');
        $customer->address = $request->input('address');
        $customer->status = "1";
        $customer->save();

        return response()->json([
            'code' => 200, 'message' => 'Customer Added Successfully',
        ], 200);
    }


    public function edit(Request $request)
    {
        $id = $request->id;
        $customer = Customer::find($id);

        return response()->json(['customer' => $customer, 'code' => 200], 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'nic' => 'required',
            'contact' => 'required',
            'address' => 'required'
        ]);

        $customer_id =  $request->input('customer_id');

        $customer = Customer::find($customer_id);
        $customer->customer_name = $request->input('full_name');
        $customer->nic = $request->input('nic');
        $customer->phone = $request->input('contact');
        $customer->address = $request->input('address');
        $customer->update();

        return response()->json(['code' => 200, 'message' => 'Customer Updated Successfully'], 200);
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer->status == "1") {
            $customer->status = "0";
            $customer->update();
        } else {
            $customer->status = "1";
            $customer->update();
        }

        return response()->json(['code' => 200, 'message' => 'Customer Status Changed Successfully'], 200);
    }

    public function DeactiveCustomers()
    {

        return view('admin.pages.customers.deactive');
    }

    public function showdeactive()
    {
        $customer = Customer::orderby('id', 'DESC')
            ->where('status', '0')
            ->get();

        $data = [];
        $count = 0;
        foreach ($customer as $row) {


            $status = '<span class="badge badge-md light badge-danger">Deactive</span>';
            $delete = ' <button type="button" class="btn btn-xs btn-success show_confirm" data-toggle="tooltip" title="Active" onclick="activateData(' . $row->id . ')"><i class="fa-solid fa-repeat"></i></button>';
            $count++;


            array_push($data, [
                'count' => $count,
                'full_name' => $row->customer_name,
                'nic' => $row->nic,
                'contact' => $row->phone,
                'status' => $status,
                'edit_button' => $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }
}
