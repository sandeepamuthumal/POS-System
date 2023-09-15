<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Crypt;
use DB;
use App\Models\UserType;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function ActiveUsers()
    {
        $user_types = UserType::all();

        return view('admin.pages.users.active', compact('user_types'));
    }

    public function DeactiveUsers()
    {

        $user_types = UserType::all();

        return view('admin.pages.users.deactive', compact('user_types'));
    }

    public function showactive()
    {
        $users = User::orderBy('id', 'DESC')
            ->leftjoin('user_types', 'user_types.id', 'users.user_types_id')
            ->select('user_types.type', 'users.*')
            ->where('users.status', '1')
            ->get();

        $data = [];
        foreach ($users as $row) {

            $status = '<span class="badge badge-md light badge-success" style="">Active</span>';
            $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Deactive" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';

            array_push($data, [
                'full_name' => $row->full_name,
                'user_name' => $row->user_name,
                'email' => $row->email,
                'type' => $row->type,
                'status' => $status,
                'edit_button' => $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }

    public function showdeactive()
    {
        $users = User::orderBy('id', 'DESC')
            ->leftjoin('user_types', 'user_types.id', 'users.user_types_id')
            ->select('user_types.type', 'users.*')
            ->where('users.status', '0')
            ->get();

        $data = [];
        foreach ($users as $row) {


            $status = '<span class="badge badge-md light badge-danger">Deactive</span>';
            $delete = ' <button type="button" class="btn btn-xs btn-success show_confirm" data-toggle="tooltip" title="Active" onclick="activateData(' . $row->id . ')"><i class="fa-solid fa-repeat"></i></button>';

            array_push($data, [
                'full_name' => $row->full_name,
                'user_name' => $row->user_name,
                'email' => $row->email,
                'type' => $row->type,
                'status' => $status,
                'edit_button' => $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'user_type' => 'required',
            'user_name' => 'required|unique:users,user_name',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm_password' => 'min:6|required_with:password|same:password',
        ]);

        //save user
        $user = new User;
        $user->full_name = strip_tags($request->input('full_name'));
        $user->password = Crypt::encryptString($request->get('password'));
        $user->status = "1";
        $user->email = $request->input('email');
        $user->user_types_id = $request->input('user_type');
        $user->user_name = $request->input('user_name');
        $user->save();

        return response()->json([
            'code' => 200, 'message' => 'User Added Successfully',
        ], 200);
    }



    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'user_type' => 'required',
            'user_name' => 'required',
            'email' => 'required|email',
        ]);

        $user_id =  $request->input('user_id');

        $user = User::find($user_id);
        $user->full_name = strip_tags($request->input('full_name'));
        $user->email = $request->input('email');
        $user->user_types_id = $request->input('user_type');
        $user->user_name = $request->input('user_name');
        $user->update();

        return response()->json(['code' => 200, 'message' => 'User Updated Successfully'], 200);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user->status == "1") {
            $user->status = "0";
            $user->update();
        } else {
            $user->status = "1";
            $user->update();
        }

        return response()->json(['code' => 200, 'message' => 'User Status Changed Successfully'], 200);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);

        $db_pwd = Crypt::decryptString($user->password);

        return response()->json(['user' => $user,'code' => 200, 'password' => $db_pwd], 200);
    }

    public function ChangePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
        ]);

        $user = User::where('id', '=', $request->id)->first();

        $user_password = Crypt::decryptString($user->password);
        $old_password = $request->old_password;
        $new_password = $request->new_password;

        if ($user_password == $old_password) {

            if ($new_password == $request->confirm_password) {
                DB::update('update users set password = ? where id =?', [Crypt::encryptString($new_password), $request->id]);

                return response()->json([
                    'status' => 200,
                    'msg' => 'Your password changed successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Password and Confirm password mismatch',
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Old password is wrong',
            ]);
        }
    }
}
