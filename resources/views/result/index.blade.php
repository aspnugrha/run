@extends('layouts.app')

@section('content')
<div class="conatiner bg-light p-3">
    <div class="card p-3">
        <h4 class="mb-4">Live Results</h4>

        <table class="w-100 mb-4">
            <tr>
                <td style="width: 100px;">Event</td>
                <td style="width: 10px;">:</td>
                <td>{{ $event['name'] }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>:</td>
                <td>{{ date('d F Y', strtotime($event['date'])) }}</td>
            </tr>
        </table>

        <form class="card px-3 py-2 rounded-0 mb-4">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="mb-3">
                        <label class="form-label text-muted">Category</label>
                        <select name="category" id="category" class="form-control" onchange="reloadTable()">
                            @foreach ($event['category'] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
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
                <div class="col-6 col-md-3">
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
                </div>
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
    <input type="hidden" name="bib_number" id="bib_number_sert">
    <input type="hidden" name="gender" id="gender_sert">
    <input type="hidden" name="kategori" id="kategori_sert">
    <input type="hidden" name="chip_time" id="chip_time_sert">
    <input type="hidden" name="name" id="name_sert">
</form>
@endsection

@section('scripts')
<script>
let table = ''
$(document).ready(function() {
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            // url: "http://194.233.67.199:2222/results", // API eksternal
            url: "https://terserah.my.id/results", // API eksternal
            type: "GET",
            data: function (d) {
                return {
                    event_id: "{{ $event['id'] }}", 
                    kategori: $('#category').val(),
                    gender: $('#gender').val(),
                    ranking_mode: $('#ranking').val(),
                    ordering: $('#order').val(),
                    page_size: d.length,
                    page: (d.start / d.length) + 1,
                    search: d.search.value,
                };
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
                console.log('data', json);
                
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
            { data: 'gender' },
            { data: 'status' },
            {
                data: 'chip_time',
                render: function(data, type, row, meta) {
                    let result = ''
                    if(row.chip_time){
                        const pisah = row.chip_time.split('.');
                        const detik = (parseInt(pisah[0]) * 60) + parseInt(pisah[1])
                        result = formatWaktu(detik)
                    }
                    console.log(row.chip_time, result);
                    
                    return result
                }
            },
            { data: 'pace_finish' },
            { data: 'ranking_kategori' },
            { data: 'ranking_sub_kategori' },
            { data: 'ranking_sub_sub_kategori' },
            { data: 'ranking_gender' },
            { data: 'start_time' },
            { data: 'finish_time' },
            {
                data: "finish_time",
                name: "finish_time",
                render: function(data, type, row, meta) {
                    let action = ``
                    if(row.status == 'FINISH'){
                        action += `<button 
                            onclick="downloadSertifikat('{{ $event['id'] }}', '${row.bib_number}', '${row.gender}', '${row.kategori}', '${row.nama}', '${row.chip_time}')"
                            class="btn btn-sm btn-outline-success" target="_blank">
                            Download Sertifikat</button>`
                    }
                    return action
                }
            },
        ]
    });
});

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

function downloadSertifikat(id_event, bib_number, gender, kategori, nama, chip_time){
    console.log('sert', id_event, bib_number, gender, kategori, nama, chip_time);
    
    $('#id_event_sert').val(id_event)
    $('#bib_number_sert').val(bib_number)
    $('#gender_sert').val(gender)
    $('#kategori_sert').val(kategori)
    $('#name_sert').val(nama)
    $('#chip_time_sert').val(chip_time)

    $('#formSertifikat').submit()
}
</script>
@endsection