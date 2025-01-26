<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoardingHouseController extends Controller
{
    public function findKos()
    {
        return view('pages.boarding_house.find');
    }
}
