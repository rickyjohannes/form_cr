@component('mail::message')
# CR Updated Notification

**Attention:** IT has updated the work estimate for the following CR.

---

### CR Details:
- **No CR:** {{ $proposal->no_transaksi }}
- **User Request:** {{ $proposal->user_request }}
- **Position:** {{ $proposal->user_status }}
- **Department:** {{ $proposal->departement }}
- **No Handphone:** {{ $proposal->ext_phone }}
- **Jenis Permintaan:** {{ $proposal->status_barang }}
- **Kategori:** {{ $proposal->kategori }}
- **Facility:** {{ $proposal->facility }}
@if (in_array($proposal->status_barang, ['Peminjaman', 'Pergantian']))
- **No Asset User:** {{ $proposal->no_asset_user }}
@endif
- **File:**
    @if (!empty($proposal->file) && file_exists(public_path('uploads/' . $proposal->file)))
        [Download File]({{ url('uploads/' . $proposal->file) }})
    @else
        <span style="color: red;">File Not Found!</span>
    @endif

---

### **User Note:**
@if (!empty($proposal->user_note))
    @php
        // Membersihkan tag HTML yang tidak diinginkan dan mengonversi baris baru menjadi <br />
        $cleanedNote = strip_tags($proposal->user_note, '<br>');  // Hanya biarkan <br> tag
        $cleanedNote = nl2br($cleanedNote);  // Ubah newline menjadi <br />
    @endphp
    {!! $cleanedNote !!}
@else
    <span style="color: red;">User Note not available!</span>
@endif

---

### CR Details From IT:
- **Estimated Date:** {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-y | h:i:s') }}
- **IT User:** {{ $proposal->it_user }}

---

CR will be processed by the IT team. Please be patient, and if you do not receive updates soon, feel free to follow up using this CR number. Thank you for your understanding!

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
