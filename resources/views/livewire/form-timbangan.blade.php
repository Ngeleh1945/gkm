<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-3 shadow-xl rounded-lg">
        <h2 class="text-center text-2xl font-bold mb-6">Weighing Form</h2>

        @flasher_render
        <form class="space-y-4" wire:submit.prevent="submit">
            <div class="w-full mb-4">
                <input type="text" id="barcode" name="barcode" placeholder="Scan Barcode" wire:model.defer="barcode"
                    wire:keydown.enter="handleBarcodeEnter"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
                        <input type="text" id="nama" name="nama" wire:model.defer="nama"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rounded-l">
                        @error('nama')
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
                            <input type="text" id="weight" name="weight" wire:model.defer="weight"
                                class="form-control w-full py-1 px-3 text-gray-700 focus:outline-none focus:shadow-outline rounded-l"
                                readonly>
                            <div id="weightUnit"
                                class="flex items-center px-3 py-1 bg-lime-300 text-gray-700 border border-black rounded-r">
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
                <button type="klikSubmit"
                    class="bg-lime-300 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:shadow-outline"
                    type="button">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
