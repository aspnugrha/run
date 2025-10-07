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
    {{-- image --}}
    {{-- <div id="capture">
        <div class="isi">
            <p class="name" style="margin-top: 160px;font-size: 25px;color: rgb(204, 0, 0);">{{ $request->name }}</p>
            <p class="category-time" style="margin-top: 44px;font-size: 20px;color: white;">{{ $request->kategori.' '.$time }}</p>
        </div>
        <img src="{{ (@$event['template_sertifikat'] ? 'data:image/png;base64,'.$template_sertifikat : '') }}" alt="Sertifikat" class="fullscreen-img">
    </div> --}}

    {{-- pdf --}}
    <div id="capture">
        <div class="isi">
            <p class="name" style="margin-top: {{ $event['s_nama'] }}x;font-size: 27px;color: rgb(204, 0, 0);">{{ $request->name }}</p>
            <p class="category-time" style="margin-top: {{ $event['s_kategori'] }}px;font-size: 25px;color: white;">{{ $request->kategori.' '.$time }}</p>
        </div>
        <img src="{{ ($request->sertifikat ? $request->sertifikat : '') }}" alt="Sertifikat" class="fullscreen-img">
    </div>
    {{-- <script>
        window.print()
    </script> --}}

    {{-- <br><button class="btn btn-5 hover-border-11" id="downloadBtn">Download Sertifikat</button> --}}
    <!-- html2canvas CDN -->
{{-- <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script>
document.getElementById('downloadBtn').addEventListener('click', async function() {
  const el = document.getElementById('capture');

  // opsi: scale untuk hasil lebih tajam
  const canvas = await html2canvas(el, { scale: 2, useCORS: true, backgroundColor: null });
  canvas.toBlob(function(blob) {
    const filename = 'snapshot-' + new Date().toISOString().replace(/[:.]/g,'-') + '.png';
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    link.remove();
  }, 'image/png');
});

document.getElementById('previewBtn').addEventListener('click', async function() {
  const el = document.getElementById('capture');
  const canvas = await html2canvas(el, { scale: 2, useCORS: true, backgroundColor: null });
  const dataUrl = canvas.toDataURL('image/png');
  window.open(dataUrl, '_blank');
});
</script> --}}
</body>
</html>
