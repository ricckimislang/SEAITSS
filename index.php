<?php include 'includes/header.php';
$office_id = $_GET['office'] ?? '';
?>
<link rel="stylesheet" href="css/index-card.css">
<script src="js/html5-qrcode.min.js"></script>

<div class="container mt-5">
    <div class="row justify-content-center">
        <form id="officeForm"> <!-- Give the form an ID -->
            <div class="e-card playing">
                <div class="background-image" style="background-image: url(assets/image/seait.jpg)">
                </div>
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="infotop">
                    <input type="hidden" value="<?php echo $office_id; ?>" name="officeID" id="officeID">
                    <img class="seait-logo" src="assets/image/logo.png" alt="SEAIT Logo"><br>
                    WELCOME TO SEAIT SATISFACTION SURVEY
                    <br>
                    <div class="name">SOUTH EAST ASIAN INSTITUTE OF TECHNOLOGY</div>
                    <br>

                    <button type="button" class="btn btn-next btn-primary" id="startScanButton">Start Scanning</button>
                    <button type="button" class="btn btn-next btn-primary" id="proceedButton">Proceed</button>
                </div>
                <div id="qr-reader" style="width: 300px; display: none;"></div>
                <div id="qr-reader-results"></div>
            </div>
        </form>
    </div>
</div>

<script>
    const qrCodeReader = new Html5Qrcode("qr-reader");
    let scannedQRCode = '';

    document.getElementById('startScanButton').addEventListener('click', function () {
        // Show the QR reader div
        document.getElementById('qr-reader').style.display = 'block';

        // Start scanning
        qrCodeReader.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 250
            },
            (decodedText, decodedResult) => {
                scannedQRCode = decodedText;
                document.getElementById('qr-reader-results').innerText = "Scanned QR Code: " + scannedQRCode;
                qrCodeReader.stop(); // Stop scanning after a successful scan
            },
            (errorMessage) => {
                // Optional: handle errors
            }
        ).catch(err => {
            console.error(err);
        });
    });

    document.getElementById('proceedButton').addEventListener('click', function () {
        const selectedOffice = document.getElementById('officeID').value;
        window.location.href = 'form.php?office=' + selectedOffice + '&scannedQRCode=' + encodeURIComponent(scannedQRCode);
    });
</script>
<?php include 'includes/footer.php'; ?>