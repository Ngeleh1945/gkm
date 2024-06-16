import './bootstrap';

import { Html5QrcodeScanner } from "html5-qrcode";

document.addEventListener("DOMContentLoaded", function() {
    const qrCodeScanner = new Html5QrcodeScanner(
        "qr-code-full-region", 
        { fps: 10, qrbox: { width: 150, height: 100 } }  // Adjust the size as needed
    );

    qrCodeScanner.render(
        (decodedText, decodedResult) => {
            console.log(`Code scanned = ${decodedText}`);
        },
        (errorMessage) => {
            console.log(`Error scanning = ${errorMessage}`);
        }
    );
});

