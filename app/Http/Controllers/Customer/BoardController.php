<?php
// app/Http/Controllers/Customer/BoardController.php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BoardItem;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function toggle(Request $request)
    {
        $data = $request->validate([
            'artist_id' => 'required|exists:users,id',
            'image'     => 'required|string',
        ]);

        $customer = $request->user();

        $existing = $customer->boardItems()->where('image_path', $data['image'])->first();

        if ($existing) {
            $existing->delete();
            $saved = false;
        } else {
            $customer->boardItems()->create([
                'artist_id'  => $data['artist_id'],
                'image_path' => $data['image'],
            ]);
            $saved = true;
        }

        return response()->json(['saved' => $saved]);
    }
}