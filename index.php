<?php include 'includes/header.php';
$office_id = $_GET['office'] ?? '';
?>
<link rel="stylesheet" href="css/index-card.css">
<script src="js/html5-qrcode.min.js"></script>

<style>
    #qr-reader {
        width: 250px;
        height: 250px;
        border: 2px solid #007bff;
        border-radius: 30px;
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f9f9f9;
        margin: auto;
        overflow: hidden;
    }

    .btn-next {
        margin-top: 10px;
        width: 200px;
    }

    .infotop {
        text-align: center;
        color: #fff;
        padding: 20px;
    }

    .disclaimer {
        border-radius: 10px;

        text-align: center;
    }

    .disclaimer h3 {
        font-size: 22px;
    }

    .disclaimer p {
        font-size: 14px;
    }

    #proceedButton {
        display: none;
    }

    .container {
        height: 1500px !important;
    }

    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <form id="officeForm">
            <div class="e-card playing">
                <div class="background-image" style="background-image: url(assets/image/seait.jpg)"></div>
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="infotop">
                    <input type="hidden" value="<?php echo $office_id; ?>" name="officeID" id="officeID">
                    <img class="seait-logo" src="assets/image/logo.png" alt="SEAIT Logo"><br>
                    WELCOME TO SEAIT SATISFACTION SURVEY
                    <br>
                    <div class="name">SOUTH EAST ASIAN INSTITUTE OF TECHNOLOGY</div>
                    <br>

                    <div class="disclaimer">
                        <h3>Disclaimer</h3>
                        <p>
                            Please note that by scanning this QR code, you agree to participate in the SEAIT
                            satisfaction survey. Your responses will remain confidential.
                        </p>
                    </div>

                    <!-- QR Code Scanner -->
                    <div id="qr-reader"></div>
                    <div id="qr-reader-results"></div>

                    <!-- Proceed Button (hidden until QR code is scanned) -->
                    <div class="button-container">
                        <button type="button" class="btn btn-next btn-primary" id="proceedButton">Proceed</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const qrCodeReader = new Html5Qrcode("qr-reader");
    let scannedQRCode = '';

    async function requestCameraPermission() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: true
            });
            stream.getTracks().forEach(track => track.stop());
            return true;
        } catch (error) {
            //console.error("Error requesting camera permission:", error);
            return false;
        }
    }

    async function initializeScanner() {
        const permissionGranted = await requestCameraPermission();
        if (!permissionGranted) {
            document.getElementById('qr-reader-results').innerText = "Camera permission denied. Please allow access to the camera to scan the QR code.";
            return;
        }

        document.getElementById('qr-reader').style.display = 'block';
        //document.getElementById('qr-reader-results').innerText = "Initializing scanner...";

        qrCodeReader.start({
                facingMode: "environment"
            }, {
                fps: 10,
                qrbox: 220
            },
            (decodedText, decodedResult) => {
                scannedQRCode = decodedText;
                document.getElementById('qr-reader-results').innerText = "Scanned QR Code: " + scannedQRCode;
                qrCodeReader.stop();
                document.getElementById('qr-reader').style.display = 'none'; // Hide the QR reader div
                document.getElementById('proceedButton').style.display = 'block'; // Show the Proceed button
            },
            (errorMessage) => {
                //console.error("QR Code scanning error:", errorMessage);
                //document.getElementById('qr-reader-results').innerText = "Error scanning QR code. Please try again.";
            }
        ).catch(err => {
            //console.error("Failed to start scanner:", err);
            document.getElementById('qr-reader-results').innerText = "Failed to start scanner. Please ensure your device has a working camera.";
        });
    }

    initializeScanner(); // Automatically start scanning when the page loads

    document.getElementById('proceedButton').addEventListener('click', function() {
        window.location.href = 'homepage.php?scannedQRCode=' + encodeURIComponent(scannedQRCode);
    });
</script>
<script>

</script>

<?php include 'includes/footer.php'; ?>