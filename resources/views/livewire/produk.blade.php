<!-- resources/views/livewire/produk-table.blade.php -->
<div class="px-4 py-6 bg-gray-100 min-h-screen y-32">
    <div class="bg-white p-6 shadow-xl rounded-lg">
        <input wire:model.debounce.300ms="search" class="border border-gray-300 p-2 mb-4" placeholder="Search...">

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2">No</th>
                        <th class="border border-gray-300 p-2">Kode Produk</th>
                        <th class="border border-gray-300 p-2">Deskripsi</th>
                        <th class="border border-gray-300 p-2">Speed</th>
                        <th class="border border-gray-300 p-2">Isi Dus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $index => $item)
                        <tr wire:key="{{ $item->kd_material }}">
                            <td class="border border-gray-300 p-2">{{ $produk->firstItem() + $index }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->kd_produk }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->deskripsi }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->speed }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->isi_dus }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($produk->hasPages())
            <div class="px-4 py-3 bg-white border-t border-gray-200">
                {{ $produk->links() }}
            </div>
        @endif
    </div>
</div>
