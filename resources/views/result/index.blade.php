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
                        <th>Gun Time</th>
                        <th>Pace</th>
                        <th>Rank Kat</th>
                        <th>Rank Sub</th>
                        <th>Rank Sub2</th>
                        <th>Rank Gen</th>
                        {{-- <th>Start</th>
                        <th>Finish</th> --}}
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

<div class="modal fade" id="modalDetailResult" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Result</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-4">
            <h3 class="text-center">{{ $event['nama_event'] }}</h3>
        </div>
        <div class="card p-3">
            <div class="mb-4 text-center">
                <h3 class="text-center mb-0" id="text-bib-number"></h3>
                <h5 class="text-center"><span class="badge bg-primary" id="text-badge-kategori"></span></h5>
    
                <div class="profile my-3">
                    <img id="image-profile-user" src="" alt="Profile User" style="width: 100px;height: 100px;object-fit: cover;border-radius: 100%;border: 1px solid #ddd;">
                </div>
    
                <h3 class="text-center" id="text-user-name"></h3>
                <h5 class="text-center" id="text-kategori-subkategori-gender"></h5>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="card rounded-lg h-100 p-3">
                            <b class="text-muted">OVERALL</b>
                            <h5 class="text-info" id="text-overall"></h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card rounded-lg h-100 p-3">
                            <b class="text-muted">CATEGORY</b>
                            <h5 class="text-info" id="text-kategori"></h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card rounded-lg h-100 p-3">
                            <b class="text-muted">GENDER</b>
                            <h5 class="text-info" id="text-gender"></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card rounded-lg h-100 p-3">
                            <div class="d-flex justify-content-between">
                                <b>GUN TIME</b>
                                <small class="text-muted">Average Pace <span class="text-average-pace"></span></small>
                            </div>
                            <h3 class="" id="text-gun-time"></h3>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card rounded-lg h-100 p-3">
                            <div class="d-flex justify-content-between">
                                <b>NET TIME</b>
                                <small class="text-muted">Average Pace <span class="text-average-pace"></span></small>
                            </div>
                            <h3 class="" id="text-net-time"></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="card rounded-lg h-100 p-3">
                            <b class="text-muted">START</b>
                            <h5 class="" id="text-start-time"></h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card rounded-lg h-100 p-3">
                            <b class="text-muted">FINISH</b>
                            <h5 class="" id="text-finish-time"></h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card rounded-lg h-100 p-3">
                            <b class="text-muted">STATUS</b>
                            <h4 class="text-success" id="text-status"></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <h5 class="mt-4 mb-2">SPLITS</h5>
                <div class="card rounded-lg p-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">KM</th>
                                <th scope="col">Split Time</th>
                                <th scope="col">Race Time</th>
                                <th scope="col">Pace</th>
                                <th scope="col">Overall</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Gender</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-splits">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('sertifikat') }}" id="formSertifikat" method="POST" target="_blank">
            @csrf
            <input type="hidden" name="id_event" id="id_event_sert" value="{{ $event['event_id'] }}">
            <input type="hidden" name="nama_event" id="nama_event_sert" value="{{ $event['nama_event'] }}">
            <input type="hidden" name="bib_number" id="bib_number_sert" value="">
            <input type="hidden" name="gender" id="gender_sert" value="">
            <input type="hidden" name="kategori" id="kategori_sert" value="">
            <input type="hidden" name="chip_time" id="chip_time_sert" value="">
            <input type="hidden" name="sub_kategori" id="sub_kategori_sert" value="">
            <input type="hidden" name="sub_sub_kategori" id="sub_sub_kategori_sert" value="">
            <input type="hidden" name="name" id="name_sert" value="">
            <input type="hidden" name="sertifikat" id="sertifikat_sert" value="{{ $event['certificate_url'] }}">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="$('#formSertifikat').submit();" id="btn-download-sertifikat">Download Sertifikat</button>
      </div>
    </div>
  </div>
</div>


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
            // {
            //     data: 'chip_time',
            //     render: function(data, type, row, meta) {
            //         let result = ''
            //         if(row.chip_time && row.chip_time != '-'){
            //             const pisah = row.chip_time.split('.');
            //             const detik = (parseInt(pisah[0]) * 60) + parseInt(pisah[1])
            //             result = formatWaktu(detik)
            //         }
            //         // console.log('chip', row.chip_time, result);
                    
            //         return result
            //     }
            // },
            {
                data: 'guntime_time',
                render: function(data, type, row, meta) {
                    let result = ''
                    if(row.guntime_time && row.guntime_time != '-'){
                        const pisah = row.guntime_time.split('.');
                        const detik = (parseInt(pisah[0]) * 60) + parseInt(pisah[1])
                        result = formatWaktu(detik)
                    }
                    // console.log('chip', row.guntime_time, result);
                    
                    return result
                }
            },
            { data: 'pace_finish' },
            { data: 'ranking_kategori' },
            { data: 'ranking_sub_kategori' },
            { data: 'ranking_sub_sub_kategori' },
            { data: 'ranking_gender' },
            // {
            //     data: 'start_time',
            //     render: function(data, type, row, meta) {
            //         let result = ''
            //         if(row.status == 'FINISH' && row.start_time){
            //             result = formatWaktuLengkap(row.start_time)
            //         }
            //         // console.log('start', row.start_time, result);
                    
            //         return result;
            //     }
            // },
            // {
            //     data: 'finish_time',
            //     render: function(data, type, row, meta) {
            //         let result = ''
            //         if(row.status == 'FINISH' && row.finish_time){
            //             result = formatWaktuLengkap(row.finish_time)
            //         }
            //         // console.log('finish', row.finish_time, result);
                    
            //         return result;
            //     }
            // },
            {
                data: "finish_time",
                name: "finish_time",
                render: function(data, type, row, meta) {
                    const sert_time = "{{ $event && $event['certificate_time'] ? $event['certificate_time'] : '' }}"
                    let status_sert_time = false;

                    if(sert_time){
                        const inputDate = new Date(sert_time);
                        const now = new Date();

                        // console.log(inputDate, now, inputDate <= now);
    
                        if (inputDate <= now) {
                            status_sert_time = true;
                        }
                    }

                    let action = ``
                    let showDownloadSertifikat = false;
                    if(row.status == 'FINISH' && status_sert_time){
                        let showDownloadSertifikat = true;
                        // action += `<button 
                        //     id="btn-sertifikat-${row.id}"
                        //     data-user-name="${row.nama}"
                        //     onclick="downloadSertifikat('{{ $event['event_id'] }}', '{{ $event['nama_event'] }}', '${row.id}', '${row.bib_number}', '${row.gender}', '${row.kategori}', '${row.chip_time}', '${row.sub_kategori ? row.sub_kategori : ''}', '${row.sub_sub_kategori ? row.sub_sub_kategori : ''}', '{{ $event['certificate_url'] }}')"
                        //     class="btn btn-sm btn-outline-success" target="_blank">
                        //     Download Sertifikat</button>`
                    }

                    // console.log('row', row);
                    
                    if(row.status == 'FINISH'){
                        action += `<button
                                onclick="showDetailResult('${row.id}', '${row.kategori}', '${row.bib_number}')"
                                class="btn btn-sm btn-outline-success">
                                Detail</button>`
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

async function showDetailResult(id, kategori, bib_number){
    $('#loader').addClass('active')
    const p = new URLSearchParams({
      event_id: "{{ $event['event_id'] }}",
      kategori: kategori,
      include_dns:'true',
      include_dnf:'true',
      ranking_mode:'dense',
      ordering:'chip_time_asc',
      page:'1',
      page_size:'50',
      search: bib_number
    });
    
    getDataFromAPI("https://terserah.my.id/results?"+p.toString())
    .then(async function(data){
        // result = (data.items||[]).find(x=>x.bib_number===bib_number) || data.items?.[0] || null;
        result = data.items.find(item => item.bib_number == bib_number)
        // console.log('api', data, result, result2, bib_number);
    
        const totalKategori = data.pagination ? data.pagination.total : 0;
        let totalSub, totalGender;

        await new Promise(async resolve => {
            totalSub = result.sub_kategori ? await fetchTotal({sub_kategori: result.sub_kategori}, kategori) : 0;
            totalGender = result.gender ? await fetchTotal({gender: result.gender}, kategori) : 0;

            resolve()
        });

        // console.log("api total:", result, totalKategori, totalSub, totalGender);
    
        let guntime = ''
        if(result.guntime_time && result.guntime_time != '-'){
            const pisah_guntime = result.guntime_time.split('.');
            guntime = formatWaktu((parseInt(pisah_guntime[0]) * 60) + parseInt(pisah_guntime[1]))
        }
        
        let chip_time = ''
        if(result.chip_time && result.chip_time != '-'){
            const pisah_chip_time = result.chip_time.split('.');
            chip_time = formatWaktu((parseInt(pisah_chip_time[0]) * 60) + parseInt(pisah_chip_time[1]))
        }
    
        let start_time = ''
        if(result.start_time){
            start_time = formatWaktuLengkap(result.start_time)
        }
        
        let finish_time = ''
        if(result.finish_time){
            finish_time = formatWaktuLengkap(result.finish_time)
        }
    
        $('#text-bib-number').text(result.bib_number)
        $('#text-badge-kategori').text(result.kategori)
        $('#image-profile-user').attr('src', `https://placehold.co/600x400/000000/FFF?text=${getInitials(result.nama, "first-last")}`)
        $('#text-user-name').text(result.nama)
        $('#text-kategori-subkategori-gender').text(result.kategori+' . '+result.sub_kategori+' . '+result.gender)
        $('#text-overall').text(result.ranking_kategori + ' / ' + (result.kategori ? totalKategori : 0))
        $('#text-kategori').text(result.ranking_sub_kategori + ' / ' + (result.sub_kategori ? totalSub : 0))
        $('#text-gender').text(result.ranking_gender + ' / ' + (result.gender ? totalGender : 0))
        $('.text-average-pace').text(result.pace_finish)
        $('#text-gun-time').text(guntime)
        $('#text-net-time').text(chip_time)
        $('#text-start-time').text(start_time)
        $('#text-finish-time').text(finish_time)
        $('#text-status').text(result.status)

        var html_tbody = ``
        if(result.splits){
            result.splits.forEach(item => {
                const name = item.checkpoint_name || '';
                const km = Number(item.km || 0);

                if(name === 'START'){ startIso=item.waktu||null; prevIso=item.waktu||null; prevKm=0; return;}

                let tr = document.createElement('tr');

                if(item.waktu){
                    const cur = new Date(item.waktu);
                    const prev = prevIso ? new Date(prevIso) : null;
                    const st   = startIso ? new Date(startIso) : null;
                    const segSec  = (prev && cur)  ? Math.round((cur-prev)/1000)   : null;
                    const raceSec = (st   && cur)  ? Math.round((cur-st)/1000)     : null;
                    const dist    = km - prevKm;
                    const paceSec = (segSec!=null && dist>0) ? Math.round(segSec/dist) : null;
                    const paceStr = item.pace && item.pace!=='-' ? item.pace : mmss(paceSec);

                    html_tbody += `<tr>
                                        <td class="km">${km || '-'}</td>
                                        <td>${hhmmss(segSec)}</td>
                                        <td>${hhmmss(raceSec)}</td>
                                        <td>${paceStr || '-'}</td>
                                        <td>${item.ranking_cp_kategori}</td>
                                        <td>${item.ranking_cp_sub_kategori}</td>
                                        <td>${item.ranking_cp_gender}</td>
                                    </tr>`;
                    prevIso = item.waktu; prevKm = km;
                }else{
                    html_tbody += `<tr>
                                        <td class="km">${km || '-'}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>`;
                }
            });
        }

        $('#tbody-splits').html(html_tbody)

        // form
        $('#bib_number_sert').val((result ? result.bib_number : ''))
        $('#gender_sert').val((result ? result.gender : ''))
        $('#kategori_sert').val((result ? result.kategori : ''))
        $('#chip_time_sert').val((result ? result.chip_time : ''))
        $('#sub_kategori_sert').val((result ? result.sub_kategori : ''))
        $('#sub_sub_kategori_sert').val((result ? result.sub_sub_kategori : ''))
        $('#name_sert').val((result ? result.nama : ''))

        const sert_time = "{{ $event && $event['certificate_time'] ? $event['certificate_time'] : '' }}"
        let status_sert_time = false;

        if(sert_time){
            const inputDate = new Date(sert_time);
            const now = new Date();

            if (inputDate <= now) {
                status_sert_time = true;
            }
        }

        // if(status_sert_time){
            $('#btn-download-sertifikat').prop('disabled', false)
        // }else{
        //     $('#btn-download-sertifikat').prop('disabled', true)
        // }
        
        $('#modalDetailResult').modal('show')
        $('#loader').removeClass('active')
    });
}

function hhmmss(sec){
    if(sec==null) return '-';
    sec=Math.max(0,Math.round(sec));
    const h=Math.floor(sec/3600), m=Math.floor((sec%3600)/60), s=sec%60;
    const pad=n=>String(n).padStart(2,'0');
    return h>0? `${h}:${pad(m)}:${pad(s)}` : `${m}:${pad(s)}`;
}

function mmss(sec){
    if(sec==null) return '-';
    sec=Math.max(0,Math.round(sec));
    const m=Math.floor(sec/60), s=sec%60;
    return `${m}:${String(s).padStart(2,'0')}`;
}

async function getDataFromAPI(url) {
  try {
    const response = await fetch(url);

    // Cek apakah respons berhasil (status 200)
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Ubah hasil response menjadi JSON
    const data = await response.json();

    // Kembalikan data
    return data;
  } catch (error) {
    console.error("Gagal mengambil data:", error);
    return null;
  }
}

async function fetchDetail(kategori){
    const p = new URLSearchParams({
      event_id: "{{ $event['event_id'] }}",
      kategori: kategori,
      include_dns:'true',
      include_dnf:'true',
      ranking_mode:'dense',
      ordering:'chip_time_asc',
      page:'1',
      page_size:'50',
      search: ''
    });

    let result = null;
    
    getDataFromAPI("https://terserah.my.id/results?"+p.toString())
    .then(data => {
        result = (data.items||[]).find(x=>x.bib_number===bib_number) || data.items?.[0] || null;
        console.log('api detail', data, result);
    })

    return result;
}

async function fetchTotal(params, kategori){
    const p = new URLSearchParams({
        event_id: "{{ $event['event_id'] }}", 
        kategori: kategori,
        include_dns:'true',
        include_dnf:'true',
        ranking_mode:'dense',
        ordering:'chip_time_asc',
        page:'1',
        page_size:'1',
        ...params
    });

    let totalData = 0;
    
    await getDataFromAPI("https://terserah.my.id/results?"+p.toString())
    .then(data => {
        totalData = data.pagination ? data.pagination.total : 0;
        console.log('fetch total ', params, data)
    })

    return totalData;
}

function getInitials(name, mode = "all") {
  if (!name) return "";

  // Pisahkan berdasarkan spasi
  const words = name.trim().split(/\s+/).filter(Boolean);

  // Ambil huruf pertama dari tiap kata, abaikan tanda baca
  const initials = words.map(word => {
    // Hapus karakter non-huruf di awal (misal tanda petik atau strip)
    const cleanWord = word.replace(/^[^A-Za-zÀ-ÿ]+/, ""); 
    return cleanWord[0] ? cleanWord[0].toUpperCase() : "";
  }).filter(Boolean);

  if (mode === "first-last") {
    if (initials.length === 1) return initials[0];
    return `${initials[0]}${initials[initials.length - 1]}`;
  }

  if (mode === "two") {
    return initials.join("").slice(0, 2);
  }

  return initials.join("");
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