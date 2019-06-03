<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NotesController extends Controller
{

    public function all($store_id,$week_id)
    {
        $store_week = DB::table('store_week')
            ->where('store_id',$store_id)
            ->where('week_id',$week_id)
            ->first();

        $notes = DB::table('notes')
            ->where('store_week_id',$store_week->id)
            ->first();

        if($notes)
            return response()->json(['notes' => $notes->text], 200);
        else
            return response()->json(['notes' => ''], 200);
    }

    public function update(Request $request,$store_id,$week_id)
    {

        $v = Validator::make($request->all(), [
            'text' => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
       }

        $store_week = DB::table('store_week')
            ->where('store_id',$store_id)
            ->where('week_id',$week_id)
            ->first();

        $note = Note::where('store_week_id',$store_week->id)->first();

        if($note)
        {
            $note->text = $request->text;
            $note->update();
            return response()->json(['status' => 'success'], 200);
        }

        $note = new Note();

        $note->store_week_id = $store_week->id;
        $note->text = $request->text;
        $note->save();

        return response()->json(['status' => 'success'], 200);
    }
}
