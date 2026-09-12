@extends('layouts.app')

@section('title', 'Buku Kas & Keuangan RT')

@section('content')
<div class="space-y-6">
    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Saldo Kas -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold block uppercase">Saldo Kas Saat Ini</span>
            <span class="text-2xl font-extrabold text-emerald-600 mt-1 block truncate">
                Rp {{ number_format($saldoKas, 0, ',', '.') }}
            </span>
            <span class="text-[11px] text-gray-400 mt-1 block">Saldo riil terkalkulasi otomatis</span>
        </div>

        <!-- Total Pemasukan -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold block uppercase">Total Pemasukan</span>
            <span class="text-2xl font-extrabold text-blue-600 mt-1 block truncate">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </span>
            <span class="text-[11px] text-gray-400 mt-1 block">Iuran & donasi warga</span>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold block uppercase">Total Pengeluaran</span>
            <span class="text-2xl font-extrabold text-rose-600 mt-1 block truncate">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
            </span>
            <span class="text-[11px] text-gray-400 mt-1 block">Operasional, ronda & fasilitas</span>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold block uppercase">Jumlah Transaksi</span>
            <span class="text-2xl font-extrabold text-gray-900 mt-1 block">
                {{ $totalTransaksi }} Catatan
            </span>
            <span class="text-[11px] text-gray-400 mt-1 block">Entri mutasi kas tercatat</span>
        </div>
    </div>

    <!-- Action & Filters Bar -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Buku Kas & Catatan Mutasi Keuangan RT 03</h3>
                <p class="text-xs text-gray-500 mt-0.5">Transparansi pemasukan iuran warga dan pengeluaran kegiatan lingkungan.</p>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ route('keuangan.cetak', request()->all()) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-4 rounded-xl text-xs transition flex items-center gap-1.5">
                    <i class="fas fa-file-pdf text-red-500"></i> Cetak Laporan PDF
                </a>
                <a href="{{ route('keuangan.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-md flex items-center gap-1.5">
                    <i class="fas fa-plus-circle"></i> Catat Transaksi Baru
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('keuangan.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-6">
            <div>
                <select name="jenis" class="w-full py-2 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Semua Jenis Transaksi --</option>
                    <option value="pemasukan" {{ request('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan Kas</option>
                    <option value="pengeluaran" {{ request('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran Kas</option>
                </select>
            </div>

            <div>
                <input type="text" name="kategori" value="{{ request('kategori') }}" placeholder="Filter kategori (misal: Ronda)..."
                    class="w-full py-2 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" title="Tanggal Mulai"
                    class="w-full py-2 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" title="Tanggal Selesai"
                    class="w-full py-2 px-3 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-3 rounded-xl text-xs transition">
                    Filter
                </button>
                @if(request()->hasAny(['jenis', 'kategori', 'tanggal_mulai', 'tanggal_selesai']))
                <a href="{{ route('keuangan.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-3 rounded-xl text-xs transition flex items-center justify-center">
                    Reset
                </a>
                @endif
            </div>
        </form>

        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4 rounded-l-xl">Kode & Tanggal</th>
                        <th class="py-3 px-4">Kategori & Keterangan</th>
                        <th class="py-3 px-4">Jenis</th>
                        <th class="py-3 px-4 text-right">Nominal (Rp)</th>
                        <th class="py-3 px-4">Dicatat Oleh</th>
                        <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksiList as $tx)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="py-3.5 px-4 font-mono text-xs">
                            <span class="font-bold text-gray-900 block">{{ $tx->kode_transaksi }}</span>
                            <span class="text-gray-400 font-sans">{{ $tx->tanggal_transaksi->format('d M Y') }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-gray-900 block text-sm">{{ $tx->kategori }}</span>
                            <span class="text-xs text-gray-500 block truncate max-w-[280px]">{{ $tx->keterangan ?? '-' }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-block text-[11px] font-bold px-2.5 py-0.5 rounded-full
                                {{ $tx->jenis === 'pemasukan' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ ucfirst($tx->jenis) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right font-extrabold text-sm
                            {{ $tx->jenis === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $tx->jenis === 'pemasukan' ? '+' : '-' }} {{ number_format($tx->nominal, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-xs text-gray-600">
                            {{ $tx->user->nama_lengkap ?? 'Bendahara' }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            @if(Auth::user()->isAdmin() || Auth::user()->isBendahara())
                            <form action="{{ route('keuangan.destroy', $tx->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus catatan mutasi kas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 p-1.5 rounded-lg transition" title="Hapus Mutasi">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </form>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 text-xs">
                            <i class="fas fa-receipt text-3xl block mb-2 text-gray-300"></i>
                            Belum ada riwayat transaksi kas yang sesuai kriteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $transaksiList->links() }}
        </div>
    </div>
</div>
@endsection
