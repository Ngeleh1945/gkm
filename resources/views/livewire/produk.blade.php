<!-- resources/views/livewire/produk-table.blade.php -->
<div class="px-4 py-20 bg-gray-100 min-h-screen">
    <div class="bg-white p-6 shadow-xl rounded-lg">
        <input wire:model.live.debounce.300ms="search" class="border border-gray-300 p-2 mb-4" placeholder="Search...">

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-separate border-spacing-2 border border-slate-400">
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
                            <td class="border border-gray-300 p-2 text-center">{{ $produk->firstItem() + $index }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->kd_produk }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->deskripsi }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $item->speed }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $item->isi_dus }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($produk->hasPages())
            <div class="px-4 py-3">
                <div class="flex space-x-4 items-center mb-3">
                    <label>Page</label>
                    <select wire:model.live="pages">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
            <div class="px-4 py-3 bg-white border-t border-gray-200">
                {{ $produk->links() }}
            </div>
        @endif
    </div>
</div>
<script>
    document.getElementById('search').addEventListener('keyup', function() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById('search');
        filter = input.value.toLowerCase();
        table = document.getElementById('produkTable');
        tr = table.getElementsByTagName('tr');

        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = 'none';

            td = tr[i].getElementsByTagName('td');
            for (j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                        break;
                    }
                }
            }
        }
    });
</script>
