import './bootstrap';

function submitForm() {
    let formData = {
        barcode: document.getElementById('barcode').value,
        kd_material: document.getElementById('kd_material').value,
        po: document.getElementById('po').value,
        tanggal: document.getElementById('tanggal').value,
        batch: document.getElementById('batch').value,
        nik: document.getElementById('nik').value,
        nama: document.getElementById('nama').value,
        weight: document.getElementById('weight').value,
        dibuat: document.getElementById('dibuat').value,
    };

    fetch('/submit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        let weightUnitElement = document.getElementById('weightUnit');

        if (data.status === 'success') {
            weightUnitElement.classList.remove('bg-red-500');
            weightUnitElement.classList.add('bg-lime-300');
        } else {
            weightUnitElement.classList.remove('bg-lime-300');
            weightUnitElement.classList.add('bg-red-500');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        let weightUnitElement = document.getElementById('weightUnit');
        weightUnitElement.classList.remove('bg-lime-300');
        weightUnitElement.classList.add('bg-red-500');
    });
}

let lastWeight = null;
let lastUpdatedTime = Date.now();

function fetchWeightData() {
    fetch('http://10.130.25.140:5000/get-weight')
        .then(response => response.json())
        .then(data => {
            if (data.weight !== undefined && data.weight !== null) {
                let currentWeight = data.weight;
                let weightElement = document.getElementById('weight');
                let weightUnitElement = document.getElementById('weightUnit');

                weightElement.value = currentWeight;

                if (lastWeight === null || lastWeight !== currentWeight) {
                    lastWeight = currentWeight;
                    lastUpdatedTime = Date.now();
                    weightUnitElement.classList.remove('bg-lime-300');
                    weightUnitElement.classList.add('bg-red-500');
                } else {
                    let currentTime = Date.now();
                    if (currentTime - lastUpdatedTime >= 3000) {
                        weightUnitElement.classList.remove('bg-red-500');
                        weightUnitElement.classList.add('bg-lime-300');
                    }
                }
            } else {
                document.getElementById('weight').value = 'No data available';
                document.getElementById('weightUnit').classList.remove('bg-lime-300', 'bg-red-500');
                lastWeight = null;
            }
        })
        .catch(error => {
            document.getElementById('weight').value = 'Timbangan OFF';
            document.getElementById('weightUnit').classList.remove('bg-lime-300', 'bg-red-500');
            lastWeight = null;
        });
}

setInterval(fetchWeightData, 50);
fetchWeightData();
