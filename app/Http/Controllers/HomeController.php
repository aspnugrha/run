<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $events = System::getEvents();
        
        return view('home.index', compact('events'));
    }

    public function result($id_event){
        $event = System::getEvent($id_event);

        return view('result.index', compact('event'));
    }

    public function sertifikat(Request $request){
        // dd(
        //     $request->id_event,
        //     $request->bib_number,
        //     $request->gender,
        //     $request->kategori,
        //     $request->name,
        // );

        $menit = $request->chip_time;
        $detik = 0;
        if(str_contains($request->chip_time, '.')){
            $pisah_time = explode('.', $request->chip_time);
            $menit = $pisah_time[0];
            $detik = $pisah_time[1];
        }
        $time = $this->convertToHMS($menit, $detik);

        $event = System::getEvent($request->id_event);

        return view('result.sertifikat', compact('event', 'request', 'time'));
    }

    function convertToHMS($minutes, $seconds) {
        // total detik
        $totalSeconds = ($minutes * 60) + $seconds;

        // hitung jam, menit, detik
        $hours   = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        // format dengan leading zero
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }
}
