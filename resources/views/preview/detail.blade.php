<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sertifikat</title>
    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Alan+Sans:wght@300..900&display=swap'); */
        @font-face {
            font-family: 'Alan Sans';
            src: url("{{ public_path('assets/fonts/AlanSans-VariableFont_wght.ttf') }}") format('truetype');
        }
        html, body {
            margin: 0;
            height: 60vh;
            font-family: "Alan Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 800;
            font-style: normal;
        }

        #capture {
            display: inline-block;   /* ikuti ukuran konten */
            position: relative;
        }

        .fullscreen-img {
            max-width: 1120px;   /* muat lebar layar */
            width: auto;        /* biarkan browser jaga rasio */
            height: auto;       /* biarkan browser jaga rasio */
            display: block;
            margin: auto;
        }

        .isi{
            position: absolute;
            width: 100%;
            height: 100%;
            margin: auto;
            /* display: flex;
            justify-content: center; */
        }

        .isi p{
            text-align: center;
        }

        .btn {
            position: relative;
            display: inline-block;
            width: auto; height: auto;
            background-color: transparent;
            border: none;
            cursor: pointer;
            margin: 25px 0;
            min-width: 150px;
        }

        .btn-5 {
            color: rgb(28, 31, 30);
            border: 2px solid rgb(20, 20, 20);
            transition: 0.2s;
        }
        .btn-5:hover {
            background-color: rgb(20, 20, 20);
            color: white;
        }
    </style>
</head>
<body>
    <div id="capture">
        <div class="isi">
            <p class="name" style="" id="text-nama">Nama Peserta</p>
            <p class="category-time" style="" id="text-kategori">Kategori & Time</p>
        </div>
        <img src="{{ ($event['certificate_url'] ? $event['certificate_url'] : '') }}" alt="Sertifikat" class="fullscreen-img">
    </div>

    <div style="width: 90%;padding: 10px 20px;">
        <div style="margin-bottom: 5px;">
            <label>Nama Peserta</label><br>
            <input type="text" id="nama" style="width: 100%;font-size: 18px;padding: 10px;">
        </div>
        <div style="margin-bottom: 5px;">
            <label>Kategori</label><br>
            <input type="text" id="kategori" style="width: 100%;font-size: 18px;padding: 10px;">
        </div>
        <div style="margin-bottom: 5px;">
            <label>Sub Kategori</label><br>
            <input type="text" id="sub_kategori" style="width: 100%;font-size: 18px;padding: 10px;">
        </div>
        <div style="margin-bottom: 5px;">
            <label>Sub Sub Kategori</label><br>
            <input type="text" id="sub_sub_kategori" style="width: 100%;font-size: 18px;padding: 10px;">
        </div>
        <div style="margin-bottom: 5px;">
            <label>Time</label><br>
            <input type="text" id="time" style="width: 100%;font-size: 18px;padding: 10px;" placeholder="01:15:20">
        </div>
        <div style="margin-bottom: 5px;">
            <label>Setting Style nama</label><br>
            <input type="text" id="setting_nama" style="width: 100%;font-size: 18px;padding: 10px;" value="{{ $event['s_nama'] ? $event['s_nama'] : '' }}">
        </div>
        <div style="margin-bottom: 5px;">
            <label>Setting Style Kategori Sub & Sub Sub Kategori dan Time</label><br>
            <input type="text" id="setting_kategori" style="width: 100%;font-size: 18px;padding: 10px;" value="{{ $event['s_kategori'] ? $event['s_kategori'] : '' }}">
        </div>
        <button style="padding: 10px 20px;margin-top: 20px;" onclick="setPreview()">Preview</button>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function()){
        setPreview()
    }
    function setPreview(){
        const nama = $('#nama').val();
        const kategori = $('#kategori').val();
        const sub_kategori = $('#sub_kategori').val();
        const sub_sub_kategori = $('#sub_sub_kategori').val();
        const time = $('#time').val();
        const setting_nama = $('#setting_nama').val();
        const setting_kategori = $('#setting_kategori').val();

        let text_kategori = '';
        if(kategori) text_kategori += kategori+' '
        if(sub_kategori) text_kategori += sub_kategori+' '
        if(sub_sub_kategori) text_kategori += sub_sub_kategori+' '
        if(time) text_kategori += time

        $('#text-nama').html(nama)
        $('#text-kategori').html(text_kategori)
        $('#text-nama').attr('style', setting_nama)
        $('#text-kategori').attr('style', setting_kategori)
    }
</script>
</body>
</html>
