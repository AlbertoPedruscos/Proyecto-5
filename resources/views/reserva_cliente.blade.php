<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la reserva #{{ $reserva_cliente->id }}</title>
    {{-- FUENTE --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    {{-- ICONOS --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    {{-- BOOSTRAPP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/info_reserva.css') }}">
    {{-- TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Reserva núm. #{{ $reserva_cliente->id }}</a>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <a class="navbar-brand" href="logout" class="dropdown-item" style="color: black;">Cerrar sesión</a>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="reserva">
        <div class="info">
            <p class="d-inline-flex gap-1">
                <a class="btn btn-dark" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    {{ $reserva_cliente->matricula }}
                </a>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{ $reserva_cliente->nom_cliente }}</li>
                        <li class="list-group-item">{{ $reserva_cliente->marca }} {{ $reserva_cliente->modelo }}</li>
                        <li class="list-group-item">{{ $reserva_cliente->num_telf }}</li>
                        <li class="list-group-item">{{ $reserva_cliente->email }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="registros">
            <div class="entrada">
                <div class="reg_entr">
                    <p>Registro de entrada</p>
                    <p>{{ $reserva_cliente->fecha_entrada }}</p>
                    <p>{{ $reserva_cliente->ubicacion_entrada }}</p>
                </div>
                <div class="check_entr" onclick="window.location.href = '/cambio'">
                    @if($reserva_cliente->firma_entrada === null)
                        <span class="material-symbols-outlined"> 
                        check_circle
                        </span>
                    @else 
                    <span class="material-symbols-outlined">
                        done
                        </span>
                    @endif
                </div>
            </div>
            <div class="salida">
                <div class="reg_sal">
                    <p>Registro de salida</p>
                    <p>{{ $reserva_cliente->fecha_salida }}</p>
                    <p>{{ $reserva_cliente->ubicacion_salida }}</p>
                </div>
                <div class="check_sal">
                    @if($reserva_cliente->firma_salida === null)
                        <span class="material-symbols-outlined">
                            door_open
                        </span>
                    @else 
                        <span class="material-symbols-outlined">
                            door_back
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="imagenes">
            <div class="display-cover">
                <video autoplay></video>
                <canvas class="d-none"></canvas>
            
                <div class="video-options">
                    <select name="" id="" class="custom-select">
                        <option value="">Select camera</option>
                    </select>
                </div>
            
                <img class="screenshot-image d-none" alt="">
            
                <div class="controls">
                    <button class="btn btn-danger play" title="Play"><i data-feather="play-circle"></i></button>
                    <button class="btn btn-info pause d-none" title="Pause"><i data-feather="pause"></i></button>
                    <button class="btn btn-outline-success screenshot d-none" title="ScreenShot"><i data-feather="image"></i></button>
                </div>
            </div>
        </div>
        <div class="desplazamientos">

        </div>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js'></script>
    <script type="text/javascript">
    feather.replace();

const controls = document.querySelector('.controls');
const cameraOptions = document.querySelector('.video-options>select');
const video = document.querySelector('video');
const canvas = document.querySelector('canvas');
const screenshotImage = document.querySelector('img');
const buttons = [...controls.querySelectorAll('button')];
let streamStarted = false;

const [play, pause, screenshot] = buttons;

const constraints = {
  video: {
    width: {
      min: 1280,
      ideal: 1920,
      max: 2560,
    },
    height: {
      min: 720,
      ideal: 1080,
      max: 1440
    },
  }
};

cameraOptions.onchange = () => {
  const updatedConstraints = {
    ...constraints,
    deviceId: {
      exact: cameraOptions.value
    }
  };

  startStream(updatedConstraints);
};

play.onclick = () => {
  if (streamStarted) {
    video.play();
    play.classList.add('d-none');
    pause.classList.remove('d-none');
    return;
  }
  if ('mediaDevices' in navigator && navigator.mediaDevices.getUserMedia) {
    const updatedConstraints = {
      ...constraints,
      deviceId: {
        exact: cameraOptions.value
      }
    };
    startStream(updatedConstraints);
  }
};

const pauseStream = () => {
  video.pause();
  play.classList.remove('d-none');
  pause.classList.add('d-none');
};

const doScreenshot = () => {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);
  screenshotImage.src = canvas.toDataURL('image/webp');
  screenshotImage.classList.remove('d-none');
};

pause.onclick = pauseStream;
screenshot.onclick = doScreenshot;

const startStream = async (constraints) => {
  const stream = await navigator.mediaDevices.getUserMedia(constraints);
  handleStream(stream);
};


const handleStream = (stream) => {
  video.srcObject = stream;
  play.classList.add('d-none');
  pause.classList.remove('d-none');
  screenshot.classList.remove('d-none');

};


const getCameraSelection = async () => {
  const devices = await navigator.mediaDevices.enumerateDevices();
  const videoDevices = devices.filter(device => device.kind === 'videoinput');
  const options = videoDevices.map(videoDevice => {
    return `<option value="${videoDevice.deviceId}">${videoDevice.label}</option>`;
  });
  cameraOptions.innerHTML = options.join('');
};

getCameraSelection();
</script>
</body>
</html>
