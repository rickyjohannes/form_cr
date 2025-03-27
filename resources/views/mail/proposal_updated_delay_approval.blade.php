@component('mail::message')
# DELAY Action Approval - Permintaan {{ $proposal->status_barang }}.

**Attention:** The following request is pending while awaiting approval.

---
### Status Approve:
- **Status:** {{ $proposal->status_apr }}

### Detail Permintaan:
- **Date of Submission:** {{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y | H:i:s') }}
- **No CR:** {{ $proposal->no_transaksi }}
- **Company Code:** {{ $proposal->company_code }}
- **User Request:** {{ $proposal->user_request }}
- **Position:** {{ $proposal->user_status }}
- **Department:** {{ $proposal->departement }}
- **No Handphone:** {{ $proposal->ext_phone }}
- **Jenis Permintaan:** {{ $proposal->status_barang }}
- **Kategori:** {{ $proposal->kategori }}
- **Fasilitas:** {{ $proposal->facility }}
@if (in_array($proposal->status_barang, ['Pergantian']))
- **No Asset User:** {{ $proposal->no_asset_user }}
@endif
@if (in_array($proposal->status_barang, ['Peminjaman']))
- **Estimated Start Date:** {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}
@endif
@if (in_array($proposal->status_barang, ['Change Request', 'Peminjaman']))
- **Request Completion Date:** {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}
@endif
- **File:**
    @if (!empty($proposal->file) && file_exists(public_path('uploads/' . $proposal->file)))
        [Download File]({{ url('uploads/' . $proposal->file) }})
    @else
        <span style="color: red;">File Not Found!</span>
    @endif

---

### User Note:
<div style="text-align: left; margin-top: 20px;">
@if (!empty($proposal->user_note))
    @php
        // Bersihkan tag HTML
        $cleanedNote = strip_tags($proposal->user_note);

        // Ganti Carriage Return + Newline menjadi hanya Newline
        $cleanedNote = str_replace("\r\n", "\n", $cleanedNote);

        // Terapkan nl2br untuk menampilkan baris baru
        $cleanedNote = nl2br(e($cleanedNote));
    @endphp
    {!! $cleanedNote !!}
@else
    <span style="color: red;">User Note not available!</span>
@endif
</div>

---

### Action:
<div style="text-align: center; margin-top: 20px;">
    <div style="display: flex; flex-direction: column; align-items: center;">
        <a href="{{ $approvalLink }}" style="background-color: #4CAF50; color: white; padding: 15px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 100%; max-width: 200px; margin: 5px;">
            Approve CR
            ({{ $approvalLink }})
        </a>
        <a href="{{ $rejectedLink }}" style="background-color: #dc3545; color: white; padding: 15px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 100%; max-width: 200px; margin: 5px;">
            Reject CR
            ({{ $rejectedLink }})
        </a>
    </div>
</div>

---

Thank you for your attention to this matter. If you have any questions, please do not hesitate to reach out.

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
