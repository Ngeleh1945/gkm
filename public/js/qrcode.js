import { Html5QrcodeScanner } from "html5-qrcode";

const qrCodeScanner = new Html5QrcodeScanner(
    "qr-code-full-region", 
    { fps: 10, qrbox: { width: 150, height: 100 } });

qrCodeScanner.render(
    (decodedText, decodedResult) => {
        console.log(`Code scanned = ${decodedText}`);
    },
    (errorMessage) => {
        console.log(`Error scanning = ${errorMessage}`);
    }
);
