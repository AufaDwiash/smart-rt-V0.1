@extends('layouts.app')

@section('title', 'Layanan Pengajuan Surat')

@section('content')
<div class="space-y-6">
    <!-- Top Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Menunggu (Pending)</span>
                <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $countPending }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Sedang Diproses</span>
                <span class="text-2xl font-extrabold text-blue-600 mt-1 block">{{ $countDiproses }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                <i class="fas fa-spinner"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-400 font-semibold block uppercase">Disetujui / Selesai</span>
                <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $countSelesai }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fas fa-circle-check"></i>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900">
                    {{ Auth::user()->isPengurus() ? 'Daftar Pengajuan Surat Warga RT 03' : 'Pengajuan Surat Saya' }}
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">Pengurusan surat pengantar, domisili, SKCK, dan surat keterangan resmi lainnya.</p>
            </div>
            <a href="{{ route('surat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-md inline-flex items-center gap-2 self-start md:self-auto">
                <i class="fas fa-plus-circle"></i> Ajukan Surat Baru
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <form method="GET" action="{{ route('surat.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
            @if(Auth::user()->isPengurus())
            <div>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK pemohon..."
                        class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                </div>
            </div>
            @endif

            <div>
                <select name="status" class="w-full py-2 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div>
                <select name="surat_template_id" class="w-full py-2 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Semua Jenis Surat --</option>
                    @foreach($templates as $tpl)
                    <option value="{{ $tpl->id }}" {{ request('surat_template_id') == $tpl->id ? 'selected' : '' }}>
                        {{ $tpl->nama_surat }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-3 rounded-xl text-xs transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'surat_template_id']))
                <a href="{{ route('surat.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-3 rounded-xl text-xs transition flex items-center justify-center">
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
                        @if(Auth::user()->isPengurus())
                        <th class="py-3 px-4 rounded-l-xl">Warga Pemohon</th>
                        @else
                        <th class="py-3 px-4 rounded-l-xl">Jenis Surat</th>
                        @endif
                        <th class="py-3 px-4">{{ Auth::user()->isPengurus() ? 'Jenis Surat' : 'Keperluan' }}</th>
                        <th class="py-3 px-4">Nomor Surat</th>
                        <th class="py-3 px-4">Tanggal Pengajuan</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($suratList as $surat)
                    <tr class="hover:bg-gray-50/70 transition">
                        @if(Auth::user()->isPengurus())
                        <td class="py-3.5 px-4 font-semibold text-gray-900">
                            {{ $surat->user->nama_lengkap }}
                            <span class="block text-xs font-normal text-gray-400 font-mono">NIK: {{ $surat->user->nik }}</span>
                        </td>
                        <td class="py-3.5 px-4 text-gray-700 font-medium">
                            {{ $surat->suratTemplate->nama_surat }}
                            <span class="block text-xs text-gray-400 truncate max-w-[220px]">{{ $surat->keperluan }}</span>
                        </td>
                        @else
                        <td class="py-3.5 px-4 font-semibold text-gray-900">
                            {{ $surat->suratTemplate->nama_surat }}
                        </td>
                        <td class="py-3.5 px-4 text-gray-600 text-xs max-w-[250px] truncate">
                            {{ $surat->keperluan }}
                        </td>
                        @endif

                        <td class="py-3.5 px-4 text-xs font-mono text-gray-600">
                            {{ $surat->nomor_surat ?? '(Belum Terbit)' }}
                        </td>
                        <td class="py-3.5 px-4 text-xs text-gray-500">
                            {{ $surat->tanggal_pengajuan ? $surat->tanggal_pengajuan->format('d M Y H:i') : '-' }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-block text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $surat->status_badge }}">
                                {{ ucfirst($surat->status) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('surat.show', $surat->id) }}" class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 font-bold px-3 py-1.5 rounded-lg transition" title="Detail / Verifikasi">
                                    {{ Auth::user()->isPengurus() ? 'Periksa' : 'Lihat' }}
                                </a>

                                @if(in_array($surat->status, ['disetujui', 'selesai']))
                                <a href="{{ route('surat.cetak', $surat->id) }}" target="_blank" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded-lg transition inline-flex items-center gap-1 shadow-sm" title="Cetak Surat PDF">
                                    <i class="fas fa-file-pdf"></i> Cetak
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 text-xs">
                            <i class="fas fa-folder-open text-3xl block mb-2 text-gray-300"></i>
                            Belum ada permohonan surat yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $suratList->links() }}
        </div>
    </div>
</div>
@endsection
