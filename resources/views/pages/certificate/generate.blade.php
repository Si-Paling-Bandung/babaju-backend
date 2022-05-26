<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <title>Generate certificate</title>
</head>

<body>
    <canvas id="canvas" width="1440px" height="1000px"></canvas>
    {{-- <p class="text-lg"></p> --}}
    <!-- javascript generate certificate -->
    <script>
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const downloadBtn = document.getElementById('download-btn')

        const image = new Image()
        image.src = "{{ asset('template/1790547123a8fea4e42795b3760474c6.png') }}"
        image.onload = () => {
            drawImage();
            download();
        }

        const drawImage = () => {
            ctx.drawImage(image, 0, 0, canvas.width, canvas.height)
            ctx.font = "Bold 50px Poppins";
            ctx.textAlign = "center"
            ctx.fillText('{{ Auth::user()->name }}', 720, 370)
            ctx.font = "Bold 30px Poppins";
            ctx.fillText('{{ $topic->title }}', 720, 530)
            ctx.font = "20px Poppins";
            ctx.fillText('{{ $date }}', 720, 720)
            console.log('print draw image')
        }

        function convert() {
            var dataURL = canvas.toDataURL();
            return dataURL;
        }


        function download() {
            console.log('print ajax')
            $.ajax({
                type: "POST",
                url: "/your-url-here",
                data: {
                    imgBase64: convert(),
                    "_token": "{{ csrf_token() }}",
                }
            }).done(function(o) {
                console.log('saved');
                console.log(o);

                // Do here whatever you want.
            });
        }
    </script>
</body>

</html>
