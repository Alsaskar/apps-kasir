<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Code Scanner</title>
</head>
<body>

<button id="scan-button">Scan QR Code</button>
<video id="qr-video" width="100%" height="100%" playsinline></video>

<script src="https://cdn.rawgit.com/cozmo/jsQR/master/dist/jsQR.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const video = document.getElementById('qr-video');
    const scanButton = document.getElementById('scan-button');

    scanButton.addEventListener('click', () => {
      startQRScanner();
    });

    function startQRScanner() {
      navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
        .then((stream) => {
          video.srcObject = stream;
          video.play();
          scanQRCode();
        })
        .catch((error) => {
          console.error('Error accessing camera: ', error);
        });
    }

    function scanQRCode() {
      const canvas = document.createElement('canvas');
      const context = canvas.getContext('2d');

      function checkForQRCode() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, canvas.width, canvas.height);

        if (code) {
          const qrValue = code.data;
          alert('QR Code detected: ' + qrValue);
          // Jika Anda ingin melakukan sesuatu dengan nilai QR code, Anda dapat memanggil fungsi handleQRCode(qrValue);
        }

        requestAnimationFrame(checkForQRCode);
      }

      checkForQRCode();
    }
  });
</script>

</body>
</html>
