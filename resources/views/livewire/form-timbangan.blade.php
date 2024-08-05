<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-3 shadow-xl rounded-lg">
        <h2 class="text-center text-2xl font-bold mb-6">Weighing Form</h2>

        <form class="space-y-4" wire:submit.prevent="submit">
            <div class="w-full mb-4">
                <input type="text" id="barcode" name="barcode" placeholder="Scan Barcode" wire:model.defer="barcode"
                    wire:keydown.enter="handleBarcodeEnter"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('barcode')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <div class="mb-4">
                        <label for="tanggal" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                        <input type="text" id="tanggal" name="tanggal" wire:model.defer="tanggal"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                        @error('tanggal')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4 hidden">
                        <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">NIK:</label>
                        <input type="text" id="nik" name="nik" wire:model.defer="nik"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                    </div>
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                        <input type="text" id="nama" name="nama" wire:model.defer="name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                        @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4 hidden">
                        <label for="mesin" class="block text-gray-700 text-sm font-bold mb-2">Machine:</label>
                        <input type="text" id="mesin" name="mesin" wire:model.defer="mesin"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                        @error('mesin')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="po" class="block text-gray-700 text-sm font-bold mb-2">PO:</label>
                        <input type="text" id="po" name="po" wire:model.defer="po"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                        @error('po')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-1/2">
                    <div class="mb-4 hidden">
                        <label for="kd_material" class="block text-gray-700 text-sm font-bold mb-2">Material
                            Code:</label>
                        <input type="text" id="kd_material" name="kd_material" wire:model.defer="kd_material"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                    </div>
                    <div class="mb-4">
                        <label for="flavour" class="block text-gray-700 text-sm font-bold mb-2">Flavour:</label>
                        <input type="text" id="flavour" name="flavour" wire:model.defer="flavour"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                        @error('flavour')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="batch" class="block text-gray-700 text-sm font-bold mb-2">Batch:</label>
                        <input type="text" id="batch" name="batch" wire:model.defer="batch"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                        @error('batch')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="weight" class="block text-gray-700 text-sm font-bold mb-2">Weight:</label>
                        <div class="flex items-center">
                            <input type="text" id="weight" name="weight"
                                class="form-control w-full py-1 px-3 text-gray-700 focus:outline-none focus:shadow-outline rounded-l"
                                readonly wire:poll.50ms="fetchWeightData">

                            <div id="weightUnit"
                                class="flex items-center px-3 py-1 text-gray-700 border border-black rounded-r">
                                KG
                            </div>
                            @error('weight')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 hidden">
                        <label for="batch" class="block text-gray-700 text-sm font-bold mb-2">Dibuat:</label>
                        <input type="text" id="dibuat" name="dibuat" wire:model.defer="dibuat"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center mt-6">
                <button wire:click="submit"
                    class="bg-lime-300 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:shadow-outline"
                    type="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
    <div class="bg-white p-3 shadow-xl rounded-lg w-1/3 ml-8">
        <h2 class="text-center text-xl font-bold mb-4">Last 3 Updates</h2>
        <ul>
            @foreach ($lastUpdates as $update)
                <li class="mb-2 p-2 bg-gray-100 rounded">
                    <div class="grid grid-cols-[auto,auto,1fr] gap-4">
                        <p class="font-bold">Batch</p>
                        <p>:</p>
                        <p>{{ $update->batch }}</p>

                        <p class="font-bold">Weight</p>
                        <p>:</p>
                        <p>{{ number_format($update->weight, 1) }}</p>
                        <p class="font-bold">Updated At</p>
                        <p>:</p>
                        <p>{{ $update->updated_at }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script>
    let lastWeight = null;
    let lastUpdatedTime = Date.now();
    let lastColor = '#ef4444';

    function fetchWeightData() {
        fetch('http://10.126.25.119:5000/get-weight')
            .then(response => response.json())
            .then(data => {
                let currentWeight = data.weight;
                let weightElement = document.getElementById('weight');
                let weightUnitElement = document.getElementById('weightUnit');
                let currentTime = Date.now();

                if (currentWeight !== undefined && currentWeight !== null) {
                    if (currentWeight.indexOf('.') !== -1) {
                        currentWeight = parseFloat(currentWeight).toString();
                    }

                    weightElement.value = currentWeight;

                    if (lastWeight === null || lastWeight !== currentWeight) {
                        lastWeight = currentWeight;
                        lastUpdatedTime = currentTime;
                        lastColor = '#ef4444';
                        weightUnitElement.style.backgroundColor = lastColor;
                    } else if (currentTime - lastUpdatedTime >= 3000) {
                        lastColor = '#bef264';
                        weightUnitElement.style.backgroundColor = lastColor;
                    }

                } else {
                    weightElement.value = 'No data available';
                    lastColor = '#ef4444';
                    weightUnitElement.style.backgroundColor = lastColor;
                    lastWeight = null;
                }
            })
            .catch(error => {
                document.getElementById('weight').value = 'Timbangan OFF';
                lastColor = '#ef4444';
                document.getElementById('weightUnit').style.backgroundColor = lastColor;
                lastWeight = null;
                console.error('Error fetching weight data:', error);
            });
    }

    setInterval(fetchWeightData, 50);
    fetchWeightData();


    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
            event.preventDefault();
        });

        document.querySelector('form').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });
    });
    // Correctly select the button by its type or class
    // // document.addEventListener('DOMContentLoaded', function() {
    // //     document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
    // //         event.preventDefault(); // Prevent the default form submission

    // //         console.log('Submit button clicked');

    // //         const data = {
    // //             id_form: document.getElementById('barcode').value,
    // //             kd_material: document.getElementById('kd_material').value,
    // //             batch: document.getElementById('batch').value,
    // //             flavour: document.getElementById('flavour').value,
    // //             tanggal: document.getElementById('tanggal').value
    // //         };

    // //         console.log('Data to be sent:', data);

    // //         fetch('http://10.126.25.119:5000/print-barcode', {
    // //                 method: 'POST',
    // //                 headers: {
    // //                     'Content-Type': 'application/json'
    // //                 },
    // //                 body: JSON.stringify(data)
    // //             })
    // //             .then(response => response.json())
    // //             .then(responseData => {
    // //                 console.log('Response from server:', responseData);
    // //             })
    // //             .catch(error => {
    // //                 console.error('Error sending data to server:', error);
    // //             });
    // //     });

    // //     document.querySelector('form').addEventListener('keydown', function(event) {
    // //         if (event.key === 'Enter') {
    // //             event.preventDefault();
    // //         }
    // //     });
    // });
</script>
