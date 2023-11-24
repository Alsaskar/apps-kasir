<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barcode Scanner</title>
  <style>
    #video-container {
      position: relative;
    }

    #barcode-result {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div id="video-container">
    <video id="video" width="100%" height="100%" autoplay></video>
  </div>
  <div id="barcode-result"></div>

  <script>
    // Mendapatkan elemen video
    const video = document.getElementById('video');
    const barcodeResult = document.getElementById('barcode-result');

    // Meminta izin untuk mengakses kamera pengguna
    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
      .then((stream) => {
        video.srcObject = stream;

        // Menggunakan library Instascan untuk memindai barcode
        const scanner = new Instascan.Scanner({ video: video });
        scanner.addListener('scan', function (content) {
          barcodeResult.innerHTML = `Barcode yang terbaca: ${content}`;
        });

        Instascan.Camera.getCameras()
          .then(function (cameras) {
            if (cameras.length > 0) {
              scanner.start(cameras[0]);
            } else {
              console.error('Tidak ada kamera yang ditemukan.');
            }
          })
          .catch(function (error) {
            console.error(error);
          });
      })
      .catch((error) => {
        console.error(error);
      });
  </script>

  <!-- Memasukkan library Instascan -->
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</body>
</html>
