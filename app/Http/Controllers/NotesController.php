<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NotesController extends Controller
{

    public function all($store_id,$week_id,$year)
    {
        $store_week = DB::table('store_week')
            ->where('store_id',$store_id)
            ->where('week_id',$week_id)
            ->first();

        $notes = DB::table('notes')
            ->where('store_week_id',$store_week->id)
            ->where('year',$year)
            ->get();

        $years = DB::table('notes')
        ->select('notes.year')
        ->groupBy('year')
        ->orderBy('year','desc')
        ->get();

        $result = array();

        $oldNotes = array();

        foreach($years as $y)
        {
            if($y->year!=$year)
            {
                $oldYearData = array();
                $yearOldNotes = DB::table('notes')
                ->where('store_week_id',$store_week->id)
                ->where('year',$y->year)
                ->get();

                $oldYearData['year'] = $y->year;
                $oldYearData['yearOldNotes'] = $yearOldNotes;

                $oldNotes[] = $oldYearData;
            }
        }

        if($notes || $oldNotes)
        {
            $result['noteYearSelected'] = $notes;
            $result['oldNotes'] = $oldNotes;
            return response()->json(['result' => $result], 200);
        }
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

    public function delete($note_id)
    {
        $note = Note::findOrFail($note_id);
        $note->delete();

        return response()->json(['status' => 'success'], 200);
    }

    public function create(Request $request)
    {

        $v = Validator::make($request->all(), [
            'text' => 'required',
            'store_id' => 'required',
            'week_id' => 'required',
            'year' => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
       }

        $store_week = DB::table('store_week')
            ->where('store_id',$request->store_id)
            ->where('week_id',$request->week_id)
            ->first();

        $note = new Note();

        $note->store_week_id = $store_week->id;
        $note->text = $request->text;
        $note->year = $request->year;
        $note->save();

        return response()->json(['status' => 'success'], 200);
    }
}
