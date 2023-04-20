<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class AccountController extends Controller
{
  //create account
  public function createAccount(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255|unique:users',
      'first_name' => 'required|string|min:2|max:255',
      'last_name' => 'required|string|min:2|max:255',
      'role' => 'required|integer',
      'address' => 'string|min:2|max:255',
      'phone_number' => 'string|min:2|max:255',
      'password' => 'required|string|min:6|confirmed',
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    $account = User::create([
      'email' => $request->email,
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'role' => $request->role,
      'address' => $request->address,
      'phone_number' => $request->phone_number,
      'password' => Hash::make($request->password),
    ]);
    RoleUser::create([
      'user_id' => $account->id,
      'role_id' => $request->role
    ]);
    return response()->json([
      'statusCode' => 201,
      'message' => 'Account created successfully!',
      'content' => $account
    ]);
  }
  // get account by id
  public function getAccountById(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'accountId' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    $accountInfo = DB::table('users')
      ->join('role_user', 'users.id', '=', 'role_user.user_id')
      ->join('roles', 'roles.id', '=', 'role_user.role_id')
      ->where('users.id', $request->accountId)
      ->get();
    if ($accountInfo->isEmpty()) {
      return response()->json([
        'statusCode' => 404,
        'message' => 'Not found!',
      ]);
    }
    return response()->json([
      'statusCode' => 200,
      'message' => 'Get account info successfully!',
      'content' => $accountInfo[0]
    ]);
  }
  // update account 
  public function updateAccount(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255',
      'first_name' => 'required|string|min:2|max:255',
      'last_name' => 'required|string|min:2|max:255',
      'role' => 'required|integer',
      'address' => 'string|min:2|max:255',
      'phone_number' => 'string|min:2|max:255',
      'account_id' => 'required|integer',
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    $checkAccount = User::where('id', $request->account_id)->first();
    if ($checkAccount) {
      User::where('id', $request->account_id)->update([
        'email' => $request->email,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'address' => $request->address,
        'phone_number' => $request->phone_number,
      ]);
      RoleUser::where('user_id', $request->account_id)->update([
        'role_id' => $request->role
      ]);
      return response()->json([
        'statusCode' => 200,
        'message' => 'Campaign updated successfully!',
      ]);
    } else {
      return response()->json([
        "status" => 404,
        "message" => "Can't find the account you want to update"
      ]);
    }
  }
  // soft delete account
  public function softDeleteAccount(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'account_id' => 'required|integer',
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    $accounnt = User::find($request->account_id);
    if ($accounnt) {
      User::where('id', $request->account_id)->update([
        'is_deleted' => 1,
      ]);
      return response()->json([
        'statusCode' => 200,
        'message' => 'Soft deleted successfully!',
      ]);
    } else {
      return response()->json([
        "status" => 404,
        "message" => "Can't find the account you want to delete"
      ]);
    }
  }
  // hard delete account
  public function deleteAccount(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'account_id' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    $checkAccount = User::where('id', $request->account_id)->first();
    if ($checkAccount) {
      User::where('id', $request->account_id)->delete();
      return response()->json([
        'statusCode' => 200,
        'message' => 'Deleted successfully!',
      ]);
    } else {
      return response()->json([
        "status" => 404,
        "message" => "Can't find the account you want to delete"
      ]);
    }
  }
  // get account by search + pagination
  public function getAccountsSearchPagination(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'page_number' => 'required|integer',
      'number_of_element' => 'required|integer'
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    if ($request->key_word === null) {
      $key_word = '';
    } else {
      $key_word = $request->key_word;
    }
    $limit = $request->number_of_element;
    $offset = ($request->page_number - 1) * $limit;
    $accounts = User::where("first_name", "like", "%" . $key_word . "%")
      ->orWhere("last_name", "like", "%" . $key_word . "%")
      ->limit($limit)->offset($offset)->get();
    return response()->json([
      "status" => 200,
      "content" => $accounts
    ]);
  }
}


