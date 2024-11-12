@component('mail::message')
# CR Approval Notification

**Attention:** CR will be processed by the IT team. Please be patient, and if you do not receive any updates in the near future, feel free to follow up using this CR number. Thank you for your understanding.

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

Thank you for your attention to this matter. If you have any questions, please do not hesitate to reach out.

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
