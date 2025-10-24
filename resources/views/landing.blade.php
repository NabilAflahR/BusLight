@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    <h1 class="text-4xl font-bold text-center text-blue-700 mb-6">Cari & Pesan Tiket Bus</h1>

    {{-- Filter Form --}}
    <div class="bg-white p-6 rounded shadow mb-8 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Bus Type --}}
            <div>
                <label class="block font-semibold mb-1">Jenis Bus</label>
                <select id="bus_type" class="border w-full p-2 rounded">
                    <option value="">Pilih Jenis Bus</option>
                    @foreach($busTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Origin --}}
            <div>
                <label class="block font-semibold mb-1">Dari</label>
                <select id="origin" class="border w-full p-2 rounded" disabled>
                    <option value="">Pilih Asal</option>
                </select>
            </div>

            {{-- Destination --}}
            <div>
                <label class="block font-semibold mb-1">Ke</label>
                <select id="destination" class="border w-full p-2 rounded" disabled>
                    <option value="">Pilih Tujuan</option>
                </select>
            </div>

            {{-- Date --}}
            <div>
                <label class="block font-semibold mb-1">Tanggal</label>
                <input type="date" id="date" value="{{ now()->format('Y-m-d') }}" class="border w-full p-2 rounded" disabled>
            </div>
        </div>

        <div class="text-right">
            <button id="searchBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" disabled>
                Cari Jadwal
            </button>
        </div>
    </div>

    {{-- Schedule Table --}}
    <div id="scheduleContainer" class="bg-white rounded shadow p-6 hidden">
        <h2 class="text-2xl font-bold mb-4 text-gray-700">Jadwal Keberangkatan</h2>

        <table class="min-w-full border rounded">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-2 px-4 text-left">Bus</th>
                    <th class="py-2 px-4 text-left">Rute</th>
                    <th class="py-2 px-4 text-left">Waktu</th>
                    <th class="py-2 px-4 text-left">Harga</th>
                    <th class="py-2 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="scheduleBody"></tbody>
        </table>
    </div>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const busType = document.getElementById('bus_type');
    const origin = document.getElementById('origin');
    const destination = document.getElementById('destination');
    const date = document.getElementById('date');
    const searchBtn = document.getElementById('searchBtn');
    const scheduleContainer = document.getElementById('scheduleContainer');
    const scheduleBody = document.getElementById('scheduleBody');

    busType.addEventListener('change', async () => {
        const type = busType.value;
        if (!type) return;

        origin.disabled = true;
        destination.disabled = true;
        date.disabled = true;
        searchBtn.disabled = true;

        const res = await fetch(`/filter-schedules?bus_type=${type}`);
        const data = await res.json();

        const origins = [...new Set(data.stops.map(s => s.origin))];
        const destinations = [...new Set(data.stops.map(s => s.destination))];

        origin.innerHTML = `<option value="">Pilih Asal</option>` + origins.map(o => `<option value="${o}">${o}</option>`).join('');
        destination.innerHTML = `<option value="">Pilih Tujuan</option>` + destinations.map(d => `<option value="${d}">${d}</option>`).join('');

        origin.disabled = false;
        destination.disabled = false;
        date.disabled = false;
        searchBtn.disabled = false;
    });

    searchBtn.addEventListener('click', async () => {
        const params = new URLSearchParams({
            bus_type: busType.value,
            origin: origin.value,
            destination: destination.value,
            date: date.value
        });

        const res = await fetch(`/filter-schedules?${params.toString()}`);
        const data = await res.json();

        if (data.error) {
            alert(data.error);
            return;
        }

        scheduleBody.innerHTML = data.schedules.length ? data.schedules.map(s => `
            <tr class="border-t">
                <td class="py-2 px-4">${s.bus.name} (${s.bus.type})</td>
                <td class="py-2 px-4">${s.route.origin} → ${s.route.destination}</td>
                <td class="py-2 px-4">${new Date(s.departure_time).toLocaleTimeString()}</td>
                <td class="py-2 px-4">Rp ${Number(s.price).toLocaleString('id-ID')}</td>
                <td class="py-2 px-4 text-center">
                    <a href="/user/booking/${s.id}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                        Pesan
                    </a>
                </td>
            </tr>

            ${s.bus.type === 'Busway' ? `
                <tr class="bg-gray-50 border-t">
                    <td colspan="5" class="px-6 py-3 text-sm text-gray-600">
                        <strong>Pemberhentian:</strong> ${s.stops.join(' → ')}
                    </td>
                </tr>` : ''}

            ${s.bus.type === 'Antar Pulau' ? `
                <tr class="bg-gray-50 border-t">
                    <td colspan="5" class="px-6 py-3 text-sm text-gray-600">
                        <strong>Kelas:</strong> ${s.class} <br>
                        <strong>Arah Tujuan:</strong> ${s.long_route}
                    </td>
                </tr>` : ''}
        `).join('') : `<tr><td colspan="5" class="text-center py-4 text-gray-500">Tidak ada jadwal ditemukan.</td></tr>`;

        scheduleContainer.classList.remove('hidden');
    });
});
</script>
@endsection
