<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZoneStoreRequest;
use App\Http\Requests\ZoneUpdateRequest;
use App\Http\Resources\ZoneCollection;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ZoneApiController extends Controller
{
    public function index(Request $request)
    {
        $zones = Zone::whereNull('deleted_on')->get();
		return response()->json($zones);
    }

    public function store(ZoneStoreRequest $request)
    {
		if($request->zone_id > 0)
		{
			$zone = new Zone();
			$zone->intitule = $request->intitule;
			$zone->niveau = $request->niveau;
			$zone->zone_id = $request->zone_id;
			$zone->save();
		}
		else
		{
			$zone = new Zone();
			$zone->intitule = $request->intitule;
			$zone->niveau = $request->niveau;
			$zone->save();
		
		}
		
		
		return $zone->id;

    }

    public function show(Request $request, Zone $zone)
    {
        return response()->json($zone);
    }

    public function update(ZoneUpdateRequest $request, Zone $zone)
    {
        $zone = Zone::find($request->id);
		$zone->intitule = $request->intitule;
		if($request->zone_id != null) 
			$zone->zone_id = $request->zone_id;
		$zone->save();
		return $zone->id;
		
    }

    public function destroy(Request $request, Zone $zone)
    {
        $zone->deleted_on = Carbon::now();
          $zone->save();

        return response()->noContent();
    }
	

}
