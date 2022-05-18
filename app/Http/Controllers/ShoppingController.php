<?php

namespace App\Http\Controllers;

use App\Models\Shopping;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShoppingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopping = Shopping::all();

        return response()->json([
            'status' => 200,
            'data' => $shopping,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'createddate' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ]);
        }

        $shopping = Shopping::create([
            'name' => $request->name,
            'createddate' => $request->createddate,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $shopping
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shopping = Shopping::where('id', $id)->first();

        return response()->json([
            'status' => 200,
            'data' => $shopping,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'createddate' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ]);
        }

        $shopping = Shopping::where('id', $id)->update([
            'name' => $request->name,
            'createddate' => $request->createddate,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Shopping::findOrFail($id)->delete();

        return response()->json(['success'=>'Data berhasil dihapus!']);
    }
}
