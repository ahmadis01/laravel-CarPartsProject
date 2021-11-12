<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function GetUsers(){
        $users=User::all();
        return response()->json($users);
    }
    public function ChangeUserRole(request $request ,$id){
        $update=User::find($id)->update([
            'role_id' => $request->role_id,
        ]);
    }
}
