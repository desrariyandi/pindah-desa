<x-filament-panels::page>
    @php
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    @endphp
    <div class="container mx-auto p-4 bg-white shadow-sm rounded-md mt-8 h-full overflow-y-auto">
        <form id="filter-form" action="{{ route('cetak') }}" method="GET" target="pdf-frame" class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700">Bulan:</label>
                <select name="month" id="month" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Semua Bulan</option>
                    @foreach ($months as $key => $month)
                        <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Tahun:</label>
                <select name="year" id="year" class="mt-1 block w-full py-2 px-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @for ($i = 2024; $i <= 2030; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="sm:col-span-2">
                <button type="submit" class="mt-1 block w-full py-2 px-3 bg-white hover:bg-gray-100 text-gray-800 py-2 px-4 border border-gray-400 rounded shadow">
                    Rekap Laporan
                </button>
            </div>
        </form>

        <iframe id="pdf-frame" name="pdf-frame" class="w-full h-screen border" style="margin-top: 20px;"></iframe>
    </div>
</x-filament::page>