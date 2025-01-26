<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\M_Queue_Visus;
use App\Http\Controllers\Controller;

class ApiQueueController extends Controller
{
    public function called()
    {
        $number = request('number');

        // Rubah is_called menjadi Y
        $queue = M_Queue_Visus::where('queue_no', $number);
        $queue->update(['is_called' => 'Y']);

        return $queue;
    }
}