<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Profile/Index', [
            'cards' => Card::where('user_id', $request->user()->id)->get()
        ]);
    }
}
