<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PreviewSertifikatController extends Controller
{
    public function previewSertifikat(){
        return view('preview.index');
    }

    public function previewSertifikatDetail($id_event){
        $response = Http::get('https://api.noufar.com/event');
        $result = $response->json();

        $event = null;
        if($result['data']){
            $filtered = array_filter($result['data'], fn($item) => $item['event_id'] == $id_event);
            $event = ($filtered ? collect($filtered)->first() : null);
        }

        return view('preview.detail', compact('event'));
    }
}
