<?php
// app/Http/Controllers/LocationController.php
namespace App\Http\Controllers;

use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;
use Nnjeim\World\Models\City;

class LocationController extends Controller
{
    public function countries()
    {
        return response()->json(
            Country::orderBy('name')->get(['id', 'name'])
        );
    }

    public function states($countryId)
    {
        return response()->json(
            State::where('country_id', $countryId)->orderBy('name')->get(['id', 'name'])
        );
    }

    public function cities($stateId)
    {
        return response()->json(
            City::where('state_id', $stateId)->orderBy('name')->get(['id', 'name'])
        );
    }
}