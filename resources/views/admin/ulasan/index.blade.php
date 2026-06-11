@extends('admin.layout')
@section('title', 'Kelola Ulasan')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
    <h1 style="font-size:1.4rem;font-weight:700;color:#1A3A2A">Kelola Ulasan Customer</h1>
</div>

@if(session('success'))
<div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem">{{ session('success') }}</div>
@endif

<div style="background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,.08);overflow:hidden">
    <table style="width:100%;border-collapse:collapse;font-size:.9rem">
        <thead style="background:#f8f9fa">
            <tr>
                <th style="padding:.75rem 1rem;text-align:left;color:#374151;font-weight:600">Produk</th>
                <th style="padding:.75rem 1rem;text-align:left;color:#374151;font-weight:600">Nama</th>
                <th style="padding:.75rem 1rem;text-align:left;color:#374151;font-weight:600">Rating</th>
                <th style="padding:.75rem 1rem;text-align:left;color:#374151;font-weight:600">Komentar</th>
                <th style="padding:.75rem 1rem;text-align:left;color:#374151;font-weight:600">Status</th>
                <th style="padding:.75rem 1rem;text-align:left;color:#374151;font-weight:600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
            <tr style="border-top:1px solid #f3f4f6">
                <td style="padding:.75rem 1rem;color:#374151">{{ $review->product->name ?? '-' }}</td>
                <td style="padding:.75rem 1rem;color:#374151">{{ $review->name }}</td>
                <td style="padding:.75rem 1rem">
                    @for($i=1;$i<=5;$i++)
                        <span style="color:{{ $i<=$review->rating ? '#f59e0b' : '#d1d5db' }}">★</span>
                    @endfor
                </td>
                <td style="padding:.75rem 1rem;color:#6b7280;max-width:220px">{{ Str::limit($review->comment, 80) }}</td>
                <td style="padding:.75rem 1rem">
                    @if($review->is_approved)
                        <span style="background:#d1fae5;color:#065f46;padding:.2rem .6rem;border-radius:20px;font-size:.78rem">Disetujui</span>
                    @else
                        <span style="background:#fef3c7;color:#92400e;padding:.2rem .6rem;border-radius:20px;font-size:.78rem">Pending</span>
                    @endif
                </td>
                <td style="padding:.75rem 1rem">
                    <div style="display:flex;gap:.4rem;flex-wrap:wrap">
                        @if(!$review->is_approved)
                        <form method="POST" action="{{ route('admin.ulasan.approve', $review) }}">
                            @csrf @method('PATCH')
                            <button style="background:#059669;color:white;border:none;padding:.3rem .7rem;border-radius:6px;cursor:pointer;font-size:.8rem">Setujui</button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('admin.ulasan.reject', $review) }}">
                            @csrf @method('PATCH')
                            <button style="background:#6b7280;color:white;border:none;padding:.3rem .7rem;border-radius:6px;cursor:pointer;font-size:.8rem">Tolak</button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.ulasan.destroy', $review) }}" onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf @method('DELETE')
                            <button style="background:#dc2626;color:white;border:none;padding:.3rem .7rem;border-radius:6px;cursor:pointer;font-size:.8rem">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="padding:2rem;text-align:center;color:#9ca3af">Belum ada ulasan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
