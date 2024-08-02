<div class="px-4 py-20 bg-gray-100 min-h-screen">
    <div class="bg-white p-6 shadow-xl rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <input wire:model.live.debounce.100ms="search" class="border border-gray-300 p-2" placeholder="Search...">
            <div class="relative inline-block text-left" x-data="{ open: false, selectedReport: 'Choose Report', showSecondButton: false, secondButtonText: 'Choose Option' }">
                <div class="flex space-x-4">
                    <div class="relative">
                        <button @click="open = !open" type="button"
                            class="inline-flex justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            id="menu-button" aria-expanded="true" aria-haspopup="true">
                            <span x-text="selectedReport"></span>
                            <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="#" @click="selectedReport = 'Day'; open = false; showSecondButton = true"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-0">Day</a>
                                <a href="#"
                                    @click="selectedReport = 'Week'; open = false; showSecondButton = true"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-1">Week</a>
                                <a href="#"
                                    @click="selectedReport = 'Month'; open = false; showSecondButton = true"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-2">Month</a>
                                <a href="#"
                                    @click="selectedReport = 'Year'; open = false; showSecondButton = true"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-3">Year</a>
                            </div>
                        </div>
                    </div>
                    <template x-if="showSecondButton">
                        <div class="relative inline-block text-left" x-data="{ secondOpen: false }">
                            <div>
                                <button @click="secondOpen = !secondOpen" type="button"
                                    class="inline-flex justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                    id="second-menu-button" aria-expanded="true" aria-haspopup="true">
                                    <span x-text="secondButtonText"></span>
                                    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div x-show="secondOpen" @click.away="secondOpen = false"
                                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="second-menu-button"
                                tabindex="-1">
                                <div class="py-1" role="none">
                                    <a href="#" @click="secondButtonText = 'Operator'; secondOpen = false"
                                        class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                        id="second-menu-item-0">Operator</a>
                                    <a href="#" @click="secondButtonText = 'Mesin'; secondOpen = false"
                                        class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                        id="second-menu-item-1">Mesin</a>
                                    <a href="#" @click="secondButtonText = 'Flavour'; secondOpen = false"
                                        class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                        id="second-menu-item-2">Flavour</a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border border-slate-400">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2">No.</th>
                        <th class="border border-gray-300 p-2">Date<br>Input</th>
                        <th class="border border-gray-300 p-2">Batch</th>
                        <th class="border border-gray-300 p-2">Flavour</th>
                        <th class="border border-gray-300 p-2">Operator</th>
                        <th class="border border-gray-300 p-2">Weight<br>(KG)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datasGK as $index => $report)
                        @php
                            $dateUpdated = \Carbon\Carbon::parse($report->updated)->format('d-m-Y');
                        @endphp
                        <tr wire:key="{{ $report->id_form }}">
                            <td class="border border-gray-300 p-2 text-center">{{ $datasGK->firstItem() + $index }}
                            </td>
                            <td class="border border-gray-300 p-2 text-center">{{ $dateUpdated }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $report->batch }}</td>
                            <td class="border border-gray-300 p-2">{{ $report->kd_produk }}</td>
                            <td class="border border-gray-300 p-2">{{ $report->operator }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $report->weight }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($datasGK->hasPages())
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
                {{ $datasGK->links() }}
            </div>
        @endif
    </div>
</div>
