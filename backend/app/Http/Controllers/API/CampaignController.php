<?php

namespace App\Http\Controllers\api;

use App\Exports\CampaignsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Validator;
use Maatwebsite\Excel\Concerns\FromCollection;

class CampaignController extends Controller
{
  //create campaigns
  public function createCampaign(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|min:2|max:255',
      'status' => 'required|integer',
      'start_time' => 'required',
      'end_time' => 'required|after:start_time',
      'budget' => 'required|integer',
      'bid_amount' => 'required|integer',
      'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'user_id' => 'required'
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    if ($request->has('banner')) {
      $image = $request->file('banner');
      $fileName = Str::random(5) . date('YmdHis') . '.' . $image->getClientOriginalExtension();
      $image->move('uploads/banner/', $fileName);
      $campaign = Campaign::create([
        'name' => $request->name,
        'status' => $request->status,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'budget' => $request->budget,
        'bid_amount' => $request->bid_amount,
        'title' => $request->title,
        'description' => $request->description,
        'banner' => $fileName,
        'final_url' => $request->final_url,
        'user_id' => $request->user_id
      ]);
      return response()->json([
        'statusCode' => 201,
        'message' => 'Campaign created successfully!',
        'content' => $campaign
      ]);
    }
    return response()->json('Please try again');
  }
  // get campaign by id
  public function getCampaignsById(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'campaignId' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    $campaign = Campaign::where('id', $request->campaignId)->first();
    if (!$campaign) {
      return response()->json([
        'statusCode' => 404,
        'message' => 'Not found!',
      ]);
    }
    return response()->json([
      'statusCode' => 200,
      'message' => 'Get campaign successfully!',
      'content' => $campaign
    ]);
  }
  public function updateCampaign(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'campaign_id' => 'required|integer',
      'user_id' => 'required|integer',
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    $checkCampaign = Campaign::where('id', $request->campaign_id)->first();
    $userRoles = User::find(auth()->user()->id)->roles()->get();
    $countRole = 0;
    for ($i = 0; $i < $userRoles->count(); $i++) {
      if ($userRoles[$i]->role_name === 'admin' || $userRoles[$i]->role_name === 'dac_member') {
        $countRole += 1;
      }
    }
    if ($checkCampaign) {
      $user_id_created_campaign = Campaign::where('id', $request->campaign_id)->value('user_id');
      if ($request->user_id == (string)$user_id_created_campaign || $countRole == 1 || $countRole == 2) {
        if ($request->file('banner') == null) {
          $validatorUpdate = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'status' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'budget' => 'required|integer',
            'bid_amount' => 'required|integer',
          ]);
          if ($validatorUpdate->fails()) {
            return response()->json([
              "status" => 400,
              "message" => "Validation update error",
              "errors" => $validatorUpdate->errors()
            ]);
          }
          $campaignUpdate = Campaign::find($request->campaign_id);
          if ($campaignUpdate) {
            $campaignUpdate->name = $request->name;
            $campaignUpdate->status = $request->status;
            $campaignUpdate->start_time = $request->start_time;
            $campaignUpdate->end_time = $request->end_time;
            $campaignUpdate->budget = $request->budget;
            $campaignUpdate->bid_amount = $request->bid_amount;
            $campaignUpdate->title = $request->title;
            $campaignUpdate->description = $request->description;
            $campaignUpdate->final_url = $request->final_url;
            $campaignUpdate->save();
            return response()->json([
              'statusCode' => 200,
              'message' => 'Campaign updated successfully!',
            ]);
          }
        }
        if ($request->hasFile('banner')) {
          $validatorUpdate = Validator::make($request->all(), [
            'campaign_id' => 'required',
            'name' => 'required|string|min:2|max:255',
            'status' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'budget' => 'required|integer',
            'bid_amount' => 'required|integer',
            'banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          ]);
          if ($validatorUpdate->fails()) {
            return response()->json([
              "statusCode" => 400,
              "message" => "Validation error!",
              "errors" => $validatorUpdate->errors()
            ]);
          }
          $destination = 'uploads/banner/' . $checkCampaign->banner;
          if (File::exists($destination)) {
            File::delete($destination);
          }
          $image = $request->file('banner');
          $fileName = Str::random(5) . date('YmdHis') . '.' . $image->getClientOriginalExtension();
          $image->move('uploads/banner/', $fileName);
          Campaign::where('id', $request->campaign_id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'budget' => $request->budget,
            'bid_amount' => $request->bid_amount,
            'title' => $request->title,
            'description' => $request->description,
            'banner' => $fileName,
            'final_url' => $request->final_url,
          ]);
          return response()->json([
            'statusCode' => 200,
            'message' => 'Campaign updated successfully!',
          ]);
        }
      } else {
        return response()->json([
          "statusCode" => 403,
          "message" => "You do not have permission to update this campaign",
        ]);
      };
    } else {
      return response()->json([
        "statusCode" => 404,
        "message" => "Can't find the campaign you want to update"
      ]);
    }
  }
  // soft delete campaign
  public function softDeleteCampaign(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'campaign_id' => 'required',
      'user_id' => 'required'
    ]);
    if ($validator->fails()) {
      return response()->json([
        "status" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    $userRoles = User::find(auth()->user()->id)->roles()->get();
    $countRole = 0;
    for ($i = 0; $i < $userRoles->count(); $i++) {
      if ($userRoles[$i]->role_name === 'admin' || $userRoles[$i]->role_name === 'dac_member') {
        $countRole += 1;
      }
    }
    $checkCampaign = Campaign::where('id', $request->campaign_id)->first();
    if ($checkCampaign) {
      $user_id_created_campaign = Campaign::where('id', $request->campaign_id)->value('user_id');
      if ($request->user_id == (string)$user_id_created_campaign || $countRole == 1 || $countRole == 2) {
        Campaign::where('id', $request->campaign_id)->update([
          'is_deleted' => 1,
        ]);
        return response()->json([
          'statusCode' => 200,
          'message' => 'Soft deleted successfully!',
        ]);
      } else {
        return response()->json([
          "statusCode" => 403,
          "message" => "You do not have permission to delete this campaign",
        ]);
      };
    } else {
      return response()->json([
        "statusCode" => 404,
        "message" => "Can't find the campaign you want to delete"
      ]);
    }
  }
  // hard delete campaign
  public function deleteCampaign(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'campaign_id' => 'required',
      'user_id' => 'required'
    ]);
    if ($validator->fails()) {
      return response()->json([
        "statusCode" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    $checkCampaign = Campaign::where('id', $request->campaign_id)->first();
    if ($checkCampaign) {
      $user_id_created_campaign = Campaign::where('id', $request->campaign_id)->value('user_id');
      if ($request->user_id == (string)$user_id_created_campaign) {
        Campaign::where('id', $request->campaign_id)->delete();
        return response()->json([
          'statusCode' => 200,
          'message' => 'Deleted successfully!',
        ]);
      } else {
        return response()->json([
          "statusCode" => 403,
          "message" => "You do not have permission to delete this campaign",
        ]);
      };
    } else {
      return response()->json([
        "status" => 404,
        "message" => "Can't find the campaign you want to delete"
      ]);
    }
  }
  public function checkRoleAdminAndDacMember()
  {
    $userRoles = User::find(auth()->user()->id)->roles()->get();
    $countRole = 0;
    for ($i = 0; $i < $userRoles->count(); $i++) {
      if ($userRoles[$i]->role_name === 'admin' || $userRoles[$i]->role_name === 'dac_member') {
        $countRole += 1;
      }
    }
    return $countRole;
  }
  // get campaign by search + pagination
  public function getCampaignsSearchPagination(Request $request)
  {
    $limitNumberRecords = 3;
    $offset = ($request->page_number - 1) * $limitNumberRecords;
    $validator = Validator::make($request->all(), [
      'page_number' => 'required|integer'
    ]);
    if ($validator->fails()) {
      return response()->json([
        "statusCode" => 400,
        "message" => "Validation error",
        "errors" => $validator->errors()
      ]);
    }
    if ($request->key_word === null) {
      $key_word = '';
    } else {
      $key_word = $request->key_word;
    }
    $campaigns = [];
    $countCampaigns = 0;
    if ($this->checkRoleAdminAndDacMember() == 1 || $this->checkRoleAdminAndDacMember() == 2) {
      if ($request->start_time === null && $request->end_time === null) {
        $campaigns = Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->limit($limitNumberRecords)->offset($offset)->orderBy('id', 'DESC')->get();
        $countCampaigns = count(Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->get());
      } else {
        if ($request->start_time === null && $request->end_time !== null) {
          $campaigns = Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->limit($limitNumberRecords)->offset($offset)->where('end_time', '<=', $request->end_time)->orderBy('id', 'DESC')->get();
          $countCampaigns = count(Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where('end_time', '<=', $request->end_time)->get());
        } else {
          if ($request->start_time !== null && $request->end_time === null) {
            $campaigns = Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->limit($limitNumberRecords)->offset($offset)->where('start_time', '>=', $request->start_time)->orderBy('id', 'DESC')->get();
            $countCampaigns = count(Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where('start_time', '>=', $request->start_time)->get());
          } else {
            $campaigns = Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->limit($limitNumberRecords)->offset($offset)->where('start_time', '>=', $request->start_time)->where('end_time', '<=', $request->end_time)->orderBy('id', 'DESC')->get();
            $countCampaigns = count(Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where('start_time', '>=', $request->start_time)->where('end_time', '<=', $request->end_time)->get());
          }
        }
      }
    } else {
      if ($request->start_time === null && $request->end_time === null) {
        $campaigns = Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where("user_id", auth()->user()->id)->limit($limitNumberRecords)->offset($offset)->orderBy('id', 'DESC')->get();
        $countCampaigns = count(Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where("user_id", auth()->user()->id)->get());
      } else {
        if ($request->start_time === null && $request->end_time !== null) {
          $campaigns = Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where("user_id", auth()->user()->id)->limit($limitNumberRecords)->offset($offset)->where('end_time', '<=', $request->end_time)->orderBy('id', 'DESC')->get();
          $countCampaigns = count(Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where("user_id", auth()->user()->id)->where('end_time', '<=', $request->end_time)->get());
        } else {
          if ($request->start_time !== null && $request->end_time === null) {
            $campaigns = Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where("user_id", auth()->user()->id)->limit($limitNumberRecords)->offset($offset)->where('start_time', '>=', $request->start_time)->orderBy('id', 'DESC')->get();
            $countCampaigns = count(Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where("user_id", auth()->user()->id)->where('start_time', '>=', $request->start_time)->get());
          } else {
            $campaigns = Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where("user_id", auth()->user()->id)->limit($limitNumberRecords)->offset($offset)->where('start_time', '>=', $request->start_time)->where('end_time', '<=', $request->end_time)->orderBy('id', 'DESC')->get();
            $countCampaigns = count(Campaign::where("name", "like", "%" . $key_word . "%")->where("is_deleted", 0)->where("user_id", auth()->user()->id)->where('start_time', '>=', $request->start_time)->where('end_time', '<=', $request->end_time)->get());
          }
        }
      }
    }
    return response()->json([
      "statusCode" => 200,
      "content" => $campaigns,
      "totalRecord" => $countCampaigns
    ]);
  }
  //export csv
  public function export()
  {
    return Excel::download(new CampaignsExport, 'campaigns.csv');
  }
}
