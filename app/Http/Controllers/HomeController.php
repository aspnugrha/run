<?php

namespace App\Http\Controllers;

use App\Models\System;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(){
        // $events = System::getEvents();
        
        return view('home.index');
    }

    public function result($id_event){
        // $event = System::getEvent($id_event);

        $response = Http::get('https://api.noufar.com/event');
        $result = $response->json();

        $event = null;
        $category = [];
        if($result['data']){
            $filtered = array_filter($result['data'], fn($item) => $item['event_id'] == $id_event);
            $event = ($filtered ? collect($filtered)->first() : null);
            $category = array_map(function($item) {
                return [
                    'kategori' => $item['kategori']
                ];
            }, $filtered);
        }

        return view('result.index', compact('event', 'category'));
    }

    public function sertifikat(Request $request){
        $menit = $request->chip_time;
        $detik = 0;
        if(str_contains($request->chip_time, '.')){
            $pisah_time = explode('.', $request->chip_time);
            $menit = $pisah_time[0];
            $detik = $pisah_time[1];
        }
        $time = $this->convertToHMS($menit, $detik);

        // $event = System::getEvent($request->id_event);

        $response = Http::get('https://api.noufar.com/event');
        $result = $response->json();

        $event = null;
        if($result['data']){
            $filtered = array_filter($result['data'], fn($item) => $item['event_id'] == $request->id_event);
            $event = ($filtered ? collect($filtered)->first() : null);
        }

        $pdf = Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ])->loadView('result.sertifikat', [
            'event' => $event,
            'request' => $request,
            'time' => $time,
            // 'template_sertifikat' => ($event['template_sertifikat'] ? base64_encode(file_get_contents(public_path('assets/images/sertifikat/template/'.$event['template_sertifikat']))) : null),
            'template_sertifikat' => ($request->sertifikat ? $request->sertifikat : null),
        ])->setPaper('a4', 'landscape');

        // tampilkan di browser tanpa download
        return $pdf->stream('sertifikat.pdf');

        // return view('result.sertifikat', compact('event', 'request', 'time'));
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
