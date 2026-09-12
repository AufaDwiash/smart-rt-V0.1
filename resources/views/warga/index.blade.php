@extends('layouts.app')

@section('title', 'Manajemen Data Warga')

@section('content')
<div class="space-y-6">
    <!-- Top Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold block uppercase">Total Warga</span>
            <span class="text-2xl font-extrabold text-gray-900 mt-1 block">{{ $totalWarga }}</span>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold block uppercase">Warga Tetap</span>
            <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $totalTetap }}</span>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold block uppercase">Warga Kontrak</span>
            <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $totalKontrak }}</span>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold block uppercase">Total KK</span>
            <span class="text-2xl font-extrabold text-blue-600 mt-1 block">{{ $totalKK }}</span>
        </div>
    </div>

    <!-- Filter & Action Bar -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Daftar Data Kependudukan RT 03</h3>
                <p class="text-xs text-gray-500 mt-0.5">Kelola data warga, kartu keluarga, dan hak akses sistem.</p>
            </div>
            <a href="{{ route('warga.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-md inline-flex items-center gap-2 self-start md:self-auto">
                <i class="fas fa-user-plus"></i> Tambah Warga Baru
            </a>
        </div>

        <!-- Search & Filters -->
        <form method="GET" action="{{ route('warga.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-6">
            <div class="lg:col-span-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIK, Nama, atau No. KK..."
                        class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                </div>
            </div>

            <div>
                <select name="status_warga" class="w-full py-2 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Status Warga --</option>
                    <option value="tetap" {{ request('status_warga') == 'tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="kontrak" {{ request('status_warga') == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                    <option value="pindah" {{ request('status_warga') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                </select>
            </div>

            <div>
                <select name="status_keluarga" class="w-full py-2 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Posisi Keluarga --</option>
                    <option value="Kepala Keluarga" {{ request('status_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                    <option value="Istri" {{ request('status_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                    <option value="Anak" {{ request('status_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                    <option value="Anggota Lain" {{ request('status_keluarga') == 'Anggota Lain' ? 'selected' : '' }}>Anggota Lain</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-3 rounded-xl text-xs transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status_warga', 'status_keluarga', 'jenis_kelamin', 'role']))
                <a href="{{ route('warga.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-3 rounded-xl text-xs transition flex items-center justify-center">
                    Reset
                </a>
                @endif
            </div>
        </form>

        <!-- Table Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4 rounded-l-xl">Nama & NIK</th>
                        <th class="py-3 px-4">No. KK</th>
                        <th class="py-3 px-4">L/P</th>
                        <th class="py-3 px-4">Alamat Domisili</th>
                        <th class="py-3 px-4">Status Warga</th>
                        <th class="py-3 px-4">Peran Sistem</th>
                        <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($wargaList as $warga)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="py-3 px-4 font-semibold text-gray-900">
                            <a href="{{ route('warga.show', $warga->id) }}" class="text-blue-600 hover:underline">
                                {{ $warga->nama_lengkap }}
                            </a>
                            <span class="block text-xs font-normal text-gray-400 font-mono">NIK: {{ $warga->nik }}</span>
                        </td>
                        <td class="py-3 px-4 text-xs font-mono text-gray-600">
                            {{ $warga->no_kk ?? '-' }}
                            @if($warga->status_keluarga)
                                <span class="block text-[10px] text-gray-400 font-sans">({{ $warga->status_keluarga }})</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-xs font-bold text-gray-700">
                            {{ $warga->jenis_kelamin }}
                        </td>
                        <td class="py-3 px-4 text-xs text-gray-600 max-w-[200px] truncate">
                            {{ $warga->alamat }} (RT {{ $warga->rt }}/RW {{ $warga->rw }})
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full
                                @if($warga->status_warga === 'tetap') bg-emerald-100 text-emerald-800
                                @elseif($warga->status_warga === 'kontrak') bg-amber-100 text-amber-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($warga->status_warga) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded-full
                                @if($warga->isAdmin()) bg-purple-100 text-purple-700
                                @elseif($warga->isSekretaris()) bg-indigo-100 text-indigo-700
                                @elseif($warga->isBendahara()) bg-emerald-100 text-emerald-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ $warga->role_label }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('warga.show', $warga->id) }}" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 p-1.5 rounded-lg transition" title="Lihat Profil">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('warga.edit', $warga->id) }}" class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 p-1.5 rounded-lg transition" title="Edit Data">
                                    <i class="fas fa-pen-to-square"></i>
                                </a>
                                @if($warga->id !== auth()->id())
                                <form action="{{ route('warga.destroy', $warga->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 p-1.5 rounded-lg transition" title="Hapus Data">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400 text-xs">
                            <i class="fas fa-users-slash text-3xl block mb-2 text-gray-300"></i>
                            Tidak ditemukan data warga yang cocok dengan kriteria pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $wargaList->links() }}
        </div>
    </div>
</div>
@endsection
