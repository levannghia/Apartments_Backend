<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{
    public function selectState(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'Fails'
                ]);
            }

            $state = DB::table('quan_huyen')->where('matp', $request->input('id'))->get();

            return response()->json([
                'data' => $state,
            ], 201);

        } catch (\Exception $e) {
            Log::error("message: " . $e->getMessage() . ' ---- line: ' . $e->getLine());
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Register error!'
            ], 500);
        }
    }

    public function selectStreet(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'Fails'
                ]);
            }

            $state = DB::table('xa_phuong_thi_tran')->where('maqh', $request->input('id'))->get();

            return response()->json([
                'data' => $state,
            ], 201);

        } catch (\Exception $e) {
            Log::error("message: " . $e->getMessage() . ' ---- line: ' . $e->getLine());
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Register error!'
            ], 500);
        }
    }
}
