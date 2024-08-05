<div class="px-4 py-20 bg-gray-100 min-h-screen">
    <div class="bg-white p-6 shadow-xl rounded-lg">
        <div class="flex items-center mb-4">
            <!-- Input pencarian dengan lebar yang lebih kecil -->
            <input wire:model.live.debounce.100ms="search" class="border border-gray-300 p-2 w-1/4"
                placeholder="Search...">

            <div class="flex space-x-4 ml-auto">
                <!-- Tombol pertama -->
                <div class="relative inline-block text-left" x-data="{ open: false, selectedDuration: 'Choose Duration', showDropdown: false, showDatepicker: false, selectedYear: @entangle('selectedYear') }">
                    <div class="relative">
                        <button @click="open = !open" type="button"
                            class="inline-flex justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            id="menu-button" aria-expanded="true" aria-haspopup="true">
                            <span x-text="selectedDuration"></span>
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
                                <a href="#"
                                    @click="selectedDuration = 'Day'; open = false; showDropdown = false; showDatepicker = true"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-0">Day</a>
                                <a href="#"
                                    @click="selectedDuration = 'Week'; open = false; showDropdown = true; showDatepicker = false"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-1">Week</a>
                                <a href="#"
                                    @click="selectedDuration = 'Month'; open = false; showDropdown = false; showDatepicker = false"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-2">Month</a>
                                <a href="#"
                                    @click="selectedDuration = 'Year'; open = false; showDropdown = true; showDatepicker = false"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-3">Year</a>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown tambahan untuk 'Year' -->
                    <div x-show="showDropdown">
                        <select
                            class="inline-flex justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            wire:model="selectedYear" wire:change="fetchCalendars">
                            <option value="">Select Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->year }}">{{ $year->year }}</option>
                            @endforeach
                        </select>
                        <select
                            class="inline-flex justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            wire:model="startWeek" wire:change="updateFinishCalendar">
                            <option value="">Start</option>
                            @foreach ($calendar1 as $date)
                                <option value="{{ $date->Week }}">{{ $date->Week }}</option>
                            @endforeach
                        </select>
                        <select
                            class="inline-flex justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            wire:model="finishWeek" wire:change="updateStartCalendar">
                            <option value="">End</option>
                            @foreach ($calendar2 as $date)
                                <option value="{{ $date->Week }}">{{ $date->Week }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Picker for 'Day' selection -->
                    <div x-show="showDatepicker" class="mt-4">
                        <div class="flex space-x-4">
                            <input type="text" id="start-date" wire:model="startDate"
                                class="border border-gray-300 p-2 rounded-md" placeholder="Start Date">
                            <input type="text" id="end-date" wire:model="endDate"
                                class="border border-gray-300 p-2 rounded-md" placeholder="End Date">
                        </div>
                    </div>
                </div>

                <!-- Tombol kedua -->
                <div class="relative inline-block text-left" x-data="{ open: false, selectedReport: 'Choose Report' }">
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
                                <a href="#" @click="selectedReport = 'Operator'; open = false"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-0">Operator</a>
                                <a href="#" @click="selectedReport = 'Machine'; open = false"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-1">Machine</a>
                                <a href="#" @click="selectedReport = 'Flavour'; open = false"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-2">Flavour</a>
                            </div>
                        </div>
                    </div>
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
                    @if ($datasGK->count())
                        @foreach ($datasGK as $index => $report)
                            @php
                                $dateUpdated = \Carbon\Carbon::parse($report->updated)->format('d-m-Y');
                            @endphp
                            <tr wire:key="{{ $report->id_form }}">
                                <td class="border border-gray-300 p-2 text-center">
                                    {{ $datasGK->firstItem() + $index }}
                                </td>
                                <td class="border border-gray-300 p-2 text-center">{{ $dateUpdated }}</td>
                                <td class="border border-gray-300 p-2 text-center">{{ $report->batch }}</td>
                                <td class="border border-gray-300 p-2">{{ $report->kd_produk }}</td>
                                <td class="border border-gray-300 p-2">{{ $report->operator }}</td>
                                <td class="border border-gray-300 p-2 text-center">{{ $report->weight }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="border border-gray-300 p-2 text-center">No reports found.
                            </td>
                        </tr>
                    @endif
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
