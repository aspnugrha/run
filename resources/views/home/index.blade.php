@extends('layouts.app')

@section('content')
<div class="conatiner bg-light p-3">
    <div class="card p-3">
        <h4 class="mb-4">Live Results</h4>
        
        <div class="row" id="div-events">
            {{-- @foreach ($events as $item)
            <div class="col-12 col-md-4 mb-4">
                <div class="card card-custom shadow-sm">
                    <img src="https://via.assets.so/img.jpg?w=400&h=200&bg=e5e7eb&text=+&f=png" class="card-img-top" alt="Gambar contoh">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item['name'] }}</h5>
                        <p class="card-text">{{ date('d F Y', strtotime($item['date'])) }}</p>
                        <a href="{{ route('result', ['id' => $item['id']]) }}" class="btn btn-outline-dark btn-sm">Result</a>
                    </div>
                </div>
            </div>
            @endforeach --}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    loadEvents()
})

function loadEvents(){
    $('#div-events').html(`<div class="col-12 d-flex justify-content-center align-content-center"><p class="p-0 m-0 text-muted">Loading get data...</p></div>`)
    fetch('https://api.noufar.com/event')
        .then(res => res.json())
        .then(data => {
            let new_data = []
            if(data.data){
                new_data = [
                    ...new Map(
                        data.data.flat().map(item => [item.event_id, item])
                    ).values()
                ];
            }
            
            let html = ``
            if(new_data){
                new_data.forEach(item => {
                    html += `
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card card-custom shadow-sm">
                                <img src="https://via.assets.so/img.jpg?w=400&h=200&bg=e5e7eb&text=+&f=png" class="card-img-top" alt="Gambar Event ${item.nama_event}">
                                <div class="card-body">
                                    <h5 class="card-title">${item.nama_event}</h5>
                                    <p class="card-text">${formatTanggal(item.start_time)}</p>
                                    <a href="{{ url('/result') }}/${item.event_id}" class="btn btn-outline-dark btn-sm">Result</a>
                                </div>
                            </div>
                        </div>
                    `
                });
            }else{
                html += `<div class="col-12 d-flex justify-content-center align-content-center"><5 class="p-0 m-0 text-muted">No Events Available</h5></div>`
            }
            $('#div-events').html(html)
        })
        .catch(err => console.error(err));
}

function formatTanggal(isoString){
    const date = new Date(isoString.replace(' ', 'T')); // ubah ke format ISO

    const bulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    return `${date.getDate()} ${bulan[date.getMonth()]} ${date.getFullYear()}`;
}

function formatTanggalIndo(isoString) {
  const date = new Date(isoString);
  
  const options = {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    timeZone: 'Asia/Jakarta'
  };

  // Format tanggal ke Indonesia
  let formatted = date.toLocaleString('id-ID', options);

  // Hilangkan kata 'pukul' jika muncul dan ubah titik menjadi titik dua
  formatted = formatted.replace(' pukul', '').replace(/\./g, ':');

  return formatted.trim();
}

function formatWaktuLengkap(isoString) {
  const date = new Date(isoString);

  const namaBulan = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];

  const tanggal = String(date.getDate()).padStart(2, '0');
  const bulan_raw = String(date.getMonth()).padStart(2, '0');
  const bulan = namaBulan[date.getMonth()];
  const tahun = date.getFullYear();

  const jam = String(date.getHours()).padStart(2, '0');
  const menit = String(date.getMinutes()).padStart(2, '0');
  const detik = String(date.getSeconds()).padStart(2, '0');

  return `${tanggal}-${bulan_raw}-${tahun} ${jam}:${menit}:${detik}`;
}
</script>
@endsection