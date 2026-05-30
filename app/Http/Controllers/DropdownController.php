<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Country, State, City};

class DropdownController extends Controller
{
    public function index()
    {
        $data['countries'] = Country::get(["name", "id"]);

        // Fetching data and using leftJoin just in case records have missing relational values
        $data['submitted_data'] = DB::table('dropdouns')
            ->leftJoin('countries', 'dropdouns.country_id', '=', 'countries.id')
            ->leftJoin('states', 'dropdouns.state_id', '=', 'states.id')
            ->leftJoin('cities', 'dropdouns.city_id', '=', 'cities.id')
            ->select('dropdouns.name as entry_name', 'countries.name as country_name', 'states.name as state_name', 'cities.name as city_name')
            ->orderBy('dropdouns.id', 'desc') 
            ->get();

        return view('welcome', $data);
    }

    public function fetchState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'country' => 'required',
            'state'   => 'required',
            'city'    => 'required',
        ]);

        DB::table('dropdouns')->insert([
            'name'       => $request->name,
            'country_id' => $request->country,
            'state_id'   => $request->state,
            'city_id'    => $request->city,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Data saved successfully!');
    }
}