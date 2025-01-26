<?php

namespace App\Http\Controllers\Api;

use App\Models\M_Dokter;
use App\Http\Controllers\Controller;

class ApiDocterController extends Controller
{
    public function getDocter()
    {
        $date = request('date');

        $data = M_Dokter::with('toScheduleDay.toBookingTime')->whereHas('toScheduleDay', function($query) use($date) {
            $day = date('D', strtotime($date));
            $query->where('day', strtoupper($day));
        })->get();

        return response()->json($data);
    }

    public function getSchedule()
    {
        $code_docter = request('code_docter');
        $date = request('date');

        $data = M_Dokter::with('toScheduleDay.toBookingTime')->whereHas('toScheduleDay', function($query) use($date) {
            $day = date('D', strtotime($date));
            $query->where('day', strtoupper($day));
        })->where('code_docter', $code_docter)->first();

        return response()->json($data['toScheduleDay'][0]['toBookingTime']);
    }
}
