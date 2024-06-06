<?php

namespace App\Http\Controllers;

use App\Exports\HallExport;
use App\Http\Requests\Hall\CreateHallRequest;
use App\Http\Requests\Hall\UpdateHallRequest;
use App\Models\Hall;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HallController extends Controller
{
    public function index(){
        $columns = (new Hall())->getColumns();
        $data = Hall::filter()->paginate($request->perpage ?? 10)->withQueryString();
        return view('hall.index', compact('data', 'columns'));
    }

    public function show($id){
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }
        return response()->json($hall->load(['hotel']));
    }


    public function create(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $hotels = Hotel::all();
        return view('hall.create', compact('hotels'));
    }

    public function edit($id, Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }
        $hotels = Hotel::all();
        return view('hall.edit', compact('hall', 'hotels'));
    }


    public function store(CreateHallRequest $request){
        try {
            Hall::create($request->validated());
            return redirect()->back()->with('success', 'Hall Created Successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage())->withInput($request->all());
        }
    }


    public function update($id, UpdateHallRequest $request){
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }
        $hall->update($request->validated());
        return redirect()->back()->with('success', 'Hall Updated Successfully');
    }


    public function delete($id){
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }
        $hall->delete();

        return redirect()->back()->with('success', "Hall Deleted Successfully");
    }

    public function changeStatus($id){
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }

        $hall->status = !$hall->status;
        $hall->save();
        return redirect()->back()->with('success', "status successfully updated");
    }


    //for export to pdf and Excel file
    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new HallExport(), 'hall.xlsx');
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new HallExport(), 'hall.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}