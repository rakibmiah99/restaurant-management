<?php

namespace App\Http\Controllers;

use App\Exports\HotelExport;
use App\Http\Requests\Hotel\CreateHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HotelController extends Controller
{
    public function index(Request $request){
        $columns = (new Hotel())->getColumns();
        $data = Hotel::filter()->paginate($request->perpage ?? 10)->withQueryString();
        return view('hotel.index', compact('data', 'columns'));
    }

    public function show($id){
        $hotel = Hotel::find($id);
        if (!$hotel){
            abort(404);
        }
        return response()->json($hotel);
    }

    public function hotelWiseHalls($id){
        $hotel = Hotel::find($id);
        if (!$hotel){
            abort(404);
        }
        $halls = $hotel->halls;
        $htmls = '<select name="hall_id" required id="hall_id" class="form-control"><option value="">' . __('page.select') . '</option>';
        foreach ($halls as $hall) {
            $htmls .= "<option value='$hall->id'>$hall->name</option>";
        }
        $htmls .= '</select>';

        echo $htmls;
    }

    public function create(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('hotel.create');
    }

    public function edit($id, Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $hotel = Hotel::find($id);
        if (!$hotel){
            abort(404);
        }
        return view('hotel.edit', compact('hotel'));
    }


    public function store(CreateHotelRequest $request){
        try {
            Hotel::create($request->validated());
            return redirect()->back()->with('success', 'Hotel Created Successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage())->withInput($request->all());
        }
    }


    public function update($id, UpdateHotelRequest $request){
        $hotel = Hotel::find($id);
        if (!$hotel){
            abort(404);
        }
        $hotel->update($request->validated());
        return redirect()->back()->with('success', 'Hotel Updated Successfully');
    }


    public function delete($id){
        $hotel = Hotel::find($id);
        if (!$hotel){
            abort(404);
        }
        $hotel->delete();

        return redirect()->back()->with('success', "Hotel Deleted Successfully");
    }

    public function changeStatus($id){
        $hotel = Hotel::find($id);
        if (!$hotel){
            abort(404);
        }

        $hotel->status = !$hotel->status;
        $hotel->save();
        return redirect()->back()->with('success', "status successfully updated");
    }


    //for export to pdf and Excel file
    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new HotelExport(), 'hotel.xlsx');
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new HotelExport(), 'hotel.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
