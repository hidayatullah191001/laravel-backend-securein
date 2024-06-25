<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\SecretInformation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

use function Ramsey\Uuid\v1;

class SecretInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function fetch(Request $request)
    {
        // $secretInformations = SecretInformation::all();

        // return ResponseFormatter::success($secretInformations, 'Data has been fetched');

        $id = $request->input('id');
        // $limit = $request->input('limit', );
        $title = $request->input('title');
        $category  = $request->input('category_id');

        if ($id) 
        {
            $secretInformation = SecretInformation::find($id);
            if ($secretInformation) {
                return ResponseFormatter::success($secretInformation, 'Data retrieved successfully');
            }else{
                return ResponseFormatter::error(null, 'Data not found', 404);
            }
        }

        $secretInformation = SecretInformation::where('user_id', Auth::user()->id);
        if ($title) {
            $secretInformation->where('title', 'like', '%'.$title.'%');
        }

        if ($category) {
            $secretInformation->where('category_id', $category);
        }
        
        return ResponseFormatter::success($secretInformation->get(), 'Data retrieved successfully');

    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'label_id' => 'required',
                'title' => 'required|string',
                'account' => 'required|string',
                'password' => 'required|string',
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return ResponseFormatter::error(['message' => 'Failed', 'error' => $errors], 'Something went wrong');
            }

            $encryptPassword = Crypt::encrypt($request->password);

            $data = SecretInformation::create([
                'user_id' => Auth::user()->id,
                'category_id' => $request->category_id,
                'label_id' => $request->label_id,
                'title' => $request->title,
                'account' => $request->account,
                'password' => $encryptPassword,
                'additional' => $request->additional,
            ]);

            return ResponseFormatter::success($data, 'Information has been safe');
            
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Server error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'label_id' => 'required',
                'title' => 'required|string',
                'account' => 'required|string',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return ResponseFormatter::error([
                    'message' => 'Failed updated data',
                    'error' => $errors->first(),
                ], 'Failed', 400);
            }

            $secretInformation = SecretInformation::find($id);
            $secretInformation->update($request->all());
            return ResponseFormatter::success($secretInformation, 'Data has been updated');

        } catch (Exception $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong!',
                'error'=> $e,
            ], 'Failed', 500);
        }
    }

    public function destroy($id)
    {
        $secretInformation = SecretInformation::find($id);

        if(!$secretInformation){
            return ResponseFormatter::error([
                'message' => 'Data not found',
            ], 'Failed', 404);
        }

        $secretInformation->delete();

        return ResponseFormatter::success([], 'Data successfully deleted');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
