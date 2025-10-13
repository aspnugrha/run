@extends('layouts.app')

@section('content')
<div class="conatiner bg-light p-3">
    <div class="card p-3">
        <h4 class="mb-4">Live Results</h4>

        <table class="w-100 mb-4">
            <tr>
                <td style="width: 100px;">Event</td>
                <td style="width: 10px;">:</td>
                <td>{{ $event['nama_event'] }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>:</td>
                <td>{{ date('d F Y', strtotime($event['start_time'])) }}</td>
            </tr>
        </table>

        <form class="card px-3 py-2 rounded-0 mb-4">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="mb-3">
                        <label class="form-label text-muted">Category</label>
                        <select name="category" id="category" class="form-control" onchange="reloadTable()">
                            @foreach ($category as $item)
                                <option value="{{ $item['kategori'] }}">{{ $item['kategori'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="mb-3">
                        <label class="form-label text-muted">Sub Category</label>
                        <select name="sub_kategori" id="sub_kategori" class="form-control" onchange="reloadTable()">
                            <option value="">Select Sub Category</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="mb-3">
                        <label class="form-label text-muted">Sub Sub Category</label>
                        <select name="sub_sub_kategori" id="sub_sub_kategori" class="form-control" onchange="reloadTable()">
                            <option value="">Select Sub Sub Category</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="mb-3">
                        <label class="form-label text-muted">Gender</label>
                        <select name="gender" id="gender" class="form-control" onchange="reloadTable()">
                            <option value="">Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="col-6 col-md-3">
                    <div class="mb-3">
                        <label class="form-label text-muted">Ranking</label>
                        <select name="ranking" id="ranking" class="form-control" onchange="reloadTable()">
                            <option value="">Select Ranking</option>
                            <option value="dense">Dense</option>
                            <option value="competition">Competition</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="mb-3">
                        <label class="form-label text-muted">Order</label>
                        <select name="order" id="order" class="form-control" onchange="reloadTable()">
                            <option value="">Select Order</option>
                            <option value="chip_time_desc">Newest</option>
                            <option value="chip_time_asc">Oldest</option>
                        </select>
                    </div>
                </div> --}}
            </div>
        </form>

        <div class="table-responsive">
            <table id="table-data" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>BIB</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Sub Sub Category</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Chip Time</th>
                        <th>Pace</th>
                        <th>Rank Kat</th>
                        <th>Rank Sub</th>
                        <th>Rank Sub2</th>
                        <th>Rank Gen</th>
                        <th>Start</th>
                        <th>Finish</th>
                        <th>Action</th>
                    </tr>
                </thead>
                {{-- <tfoot>
                    <tr>
                        <th>#</th>
                        <th>BIB</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Chip Time</th>
                        <th>Pace</th>
                        <th>Rank Kat</th>
                        <th>Rank Sub</th>
                        <th>Rank Sub2</th>
                        <th>Rank Gen</th>
                        <th>Start</th>
                        <th>Finish</th>
                        <th>Action</th>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
</div>
<form action="{{ route('sertifikat') }}" id="formSertifikat" method="POST" target="_blank">
    @csrf
    <input type="hidden" name="id_event" id="id_event_sert">
    <input type="hidden" name="nama_event" id="nama_event_sert">
    <input type="hidden" name="bib_number" id="bib_number_sert">
    <input type="hidden" name="gender" id="gender_sert">
    <input type="hidden" name="kategori" id="kategori_sert">
    <input type="hidden" name="chip_time" id="chip_time_sert">
    <input type="hidden" name="sub_kategori" id="sub_kategori_sert">
    <input type="hidden" name="sub_sub_kategori" id="sub_sub_kategori_sert">
    <input type="hidden" name="name" id="name_sert">
    <input type="hidden" name="sertifikat" id="sertifikat_sert">
</form>
@endsection

@section('scripts')
<script>
let table = ''
let sub_kategori = []
let sub_sub_kategori = []

$(document).ready(function() {
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            // url: "http://194.233.67.199:2222/results", // API eksternal
            url: "https://terserah.my.id/results", // API eksternal
            type: "GET",
            data: function (d) {
                let data = {
                    event_id: "{{ $event['event_id'] }}", 
                    kategori: $('#category').val(),
                    gender: $('#gender').val(),
                    // ranking_mode: $('#ranking').val(),
                    // ordering: $('#order').val(),
                    page_size: d.length,
                    page: (d.start / d.length) + 1,
                    search: d.search.value,
                };

                if($('#sub_kategori').val()) data.sub_kategori = $('#sub_kategori').val()
                if($('#sub_sub_kategori').val()) data.sub_sub_kategori = $('#sub_sub_kategori').val()

                return data
            },
            // dataFilter: function(response) {
            //     let json = JSON.parse(response);

            //     const data = JSON.stringify({
            //         draw: json.draw || 1, // kalau API tidak kirim draw, fallback ke 1
            //         recordsTotal: json.pagination ? json.pagination.total : json.items.length,
            //         recordsFiltered: json.pagination ? json.pagination.total : json.items.length,
            //         data: json.items || []
            //     });

            //     console.log('dataSrc', json, data);
                
            //     return data
            // }
            dataSrc: function (json) {
                console.log('data', json, sub_kategori, sub_sub_kategori);
                
                if(json.items){
                    let new_sub_kategori = [...new Set(json.items.map(item => item.sub_kategori))];
                    let new_sub_sub_kategori = [...new Set(json.items.map(item => item.sub_sub_kategori))];
                    
                    new_sub_kategori = new_sub_kategori.filter(v => v !== '' && v !== null && v !== undefined)
                    new_sub_sub_kategori = new_sub_sub_kategori.filter(v => v !== '' && v !== null && v !== undefined)
                    // console.log('unik', new_sub_kategori, new_sub_sub_kategori)

                    new_sub_kategori = [...new Set([...new_sub_kategori, ...sub_kategori])];
                    new_sub_sub_kategori = [...new Set([...new_sub_sub_kategori, ...sub_sub_kategori])];

                    sub_kategori = new_sub_kategori
                    sub_sub_kategori = new_sub_sub_kategori
                }
                // console.log('data new', sub_kategori, sub_sub_kategori);

                loadSubKategori('sub', sub_kategori)
                loadSubKategori('sub_sub', sub_sub_kategori)
                
                json.recordsTotal = json.pagination.total;
                json.recordsFiltered = json.pagination.total;

                return json.items;
            }
        },
        columns: [
            {
                data: null,
                sortable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1
                }
            },
            { data: 'bib_number' },
            { data: 'nama' },
            { data: 'kategori' },
            { data: 'sub_kategori' },
            { data: 'sub_sub_kategori' },
            { data: 'gender' },
            { data: 'status' },
            {
                data: 'chip_time',
                render: function(data, type, row, meta) {
                    let result = ''
                    if(row.chip_time && row.chip_time != '-'){
                        const pisah = row.chip_time.split('.');
                        const detik = (parseInt(pisah[0]) * 60) + parseInt(pisah[1])
                        result = formatWaktu(detik)
                    }
                    // console.log('chip', row.chip_time, result);
                    
                    return result
                }
            },
            { data: 'pace_finish' },
            { data: 'ranking_kategori' },
            { data: 'ranking_sub_kategori' },
            { data: 'ranking_sub_sub_kategori' },
            { data: 'ranking_gender' },
            {
                data: 'start_time',
                render: function(data, type, row, meta) {
                    let result = ''
                    if(row.status == 'FINISH' && row.start_time){
                        result = formatWaktuLengkap(row.start_time)
                    }
                    // console.log('start', row.start_time, result);
                    
                    return result;
                }
            },
            {
                data: 'finish_time',
                render: function(data, type, row, meta) {
                    let result = ''
                    if(row.status == 'FINISH' && row.finish_time){
                        result = formatWaktuLengkap(row.finish_time)
                    }
                    // console.log('finish', row.finish_time, result);
                    
                    return result;
                }
            },
            {
                data: "finish_time",
                name: "finish_time",
                render: function(data, type, row, meta) {
                    const sert_time = "{{ $event && $event['certificate_time'] ? $event['certificate_time'] : '' }}"
                    let status_sert_time = false;

                    if(sert_time){
                        const inputDate = new Date(sert_time);
                        const now = new Date();

                        console.log(inputDate, now, inputDate <= now);
                        
    
                        if (inputDate <= now) {
                            status_sert_time = true;
                        }
                    }

                    let action = ``
                    if(row.status == 'FINISH' && status_sert_time){
                        action += `<button 
                            id="btn-sertifikat-${row.id}"
                            data-user-name="${row.nama}"
                            onclick="downloadSertifikat('{{ $event['event_id'] }}', '{{ $event['nama_event'] }}', '${row.id}', '${row.bib_number}', '${row.gender}', '${row.kategori}', '${row.chip_time}', '${row.sub_kategori ? row.sub_kategori : ''}', '${row.sub_sub_kategori ? row.sub_sub_kategori : ''}', '{{ $event['certificate_url'] }}')"
                            class="btn btn-sm btn-outline-success" target="_blank">
                            Download Sertifikat</button>`
                    }
                    return action
                }
            },
        ]
    });
});

function loadSubKategori(condition, data){
    var html = `<option value="">`+(condition == 'sub' ? 'Select Sub Category' : 'Select Sub Sub Category')+`</option>`;
    if(data){
        data.forEach(item => {
            html += `<option value="${item}">${item}</option>`
        });
    }

    $('#'+(condition == 'sub' ? 'sub_kategori' : 'sub_sub_kategori')).html(html)
}

function reloadTable(){
    table.ajax.reload(null, false); 
}

function formatWaktu(totalDetik) {
    const jam = Math.floor(totalDetik / 3600);
    const menit = Math.floor((totalDetik % 3600) / 60);
    const detik = totalDetik % 60;

    return [jam, menit, detik]
        .map(v => v.toString().padStart(2, '0'))
        .join(':');
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


function downloadSertifikat(id_event, nama_event, id, bib_number, gender, kategori, chip_time, sub_kategori, sub_sub_kategori, sertifikat){
    const name = $('#btn-sertifikat-'+id).data('user-name')
    
    console.log('sert', id_event, nama_event, bib_number, name, gender, kategori, chip_time, sub_kategori, sub_sub_kategori, sertifikat);
    
    $('#id_event_sert').val(id_event)
    $('#nama_event_sert').val(nama_event)
    $('#bib_number_sert').val(bib_number)
    $('#gender_sert').val(gender)
    $('#kategori_sert').val(kategori)
    $('#name_sert').val(name)
    $('#chip_time_sert').val(chip_time)
    $('#sub_kategori_sert').val((sub_kategori ? sub_kategori : ''))
    $('#sub_sub_kategori_sert').val((sub_sub_kategori ? sub_sub_kategori : ''))
    $('#sertifikat_sert').val(sertifikat)

    $('#formSertifikat').submit()
}
</script>
@endsection