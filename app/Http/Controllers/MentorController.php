<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{

    public function index()
    {
        $mentors = Mentor::all();
        return response()->json([
            'status' => 'success',
            'data' => $mentors
        ]);
    }

    public function show($id)
    {
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    public function create(Request $request)
    {
        // rules
        $rules = [
            'name' => 'required|string',
            'profile' => 'required|url',
            'profession' => 'required|string',
            'email' => 'required|email'
        ];

        // ambil data di body
        $data = $request->all();

        // validasi
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // create di database
        $mentor = Mentor::create($data);

        return response()->json(['status' => 'success', 'data' => $mentor]);
    }

    public function update(Request $request, $id)
    {
        // rules
        $rules = [
            'name' => 'string',
            'profile' => 'url',
            'profession' => 'string',
            'email' => 'email'
        ];

        // ambil data di body
        $data = $request->all();

        // validasi
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // cari mentor by id
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }

        // update di database
        $mentor->fill($data);

        $mentor->save();
        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    public function delete($id)
    {
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }

        $mentor->delete();

        return response()->json([
            'status'=>'success',
            'message'=>'success delete mentor'
        ]);
    }
}
