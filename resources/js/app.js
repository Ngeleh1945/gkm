import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('alpine:init', () => {
    Alpine.data('yourComponent', () => ({
        years: @json($years),
        calendar1: @json($calendar1),
        calendar2: @json($calendar2),
    }));
});

// function submitForm() {
//     let formData = {
//         barcode: document.getElementById('barcode').value,
//         kd_material: document.getElementById('kd_material').value,
//         po: document.getElementById('po').value,
//         tanggal: document.getElementById('tanggal').value,
//         batch: document.getElementById('batch').value,
//         nik: document.getElementById('nik').value,
//         nama: document.getElementById('nama').value,
//         weight: document.getElementById('weight').value,
//         dibuat: document.getElementById('dibuat').value,
//     };

//     fetch('/submit', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify(formData)
//     })
//     .then(response => response.json())
//     .then(data => {
//         let weightUnitElement = document.getElementById('weightUnit');

//         if (data.status === 'success') {
//             weightUnitElement.classList.remove('bg-red-500');
//             weightUnitElement.classList.add('bg-lime-300');
//         } else {
//             weightUnitElement.classList.remove('bg-lime-300');
//             weightUnitElement.classList.add('bg-red-500');
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);
//         let weightUnitElement = document.getElementById('weightUnit');
//         weightUnitElement.classList.remove('bg-lime-300');
//         weightUnitElement.classList.add('bg-red-500');
//     });
// }


