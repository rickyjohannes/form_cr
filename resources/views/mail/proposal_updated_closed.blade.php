@component('mail::message')
# CR Close Notification

**Attention:** CR has been closed with IT. Please close the CR in the website by clicking the "Closed All" button.

---

### CR Details:
- **Date of Submission:** {{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y | H:i:s') }}
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
@if (in_array($proposal->status_barang, ['Peminjaman']))
- **Estimated Start Date:** {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}
@endif
@if (in_array($proposal->status_barang, ['Change Request', 'Peminjaman']))
- **Estimated Completion Date:** {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}
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
        $cleanedNote = strip_tags($proposal->user_note, '<br>'); 
        $cleanedNote = nl2br($cleanedNote); 
    @endphp
    {!! $cleanedNote !!}
@else
    <span style="color: red;">User Note not available!</span>
@endif

---

### **CR Details From IT:**
- **IT Processing Date:** {{ \Carbon\Carbon::parse($proposal->action_it_date)->format('d-m-Y | H:i:s') }}
- **IT CR Closure Date:** {{ \Carbon\Carbon::parse($proposal->close_date)->format('d-m-Y | H:i:s') }}
- **IT User:** {{ $proposal->it_user }}
@if (in_array($proposal->status_barang, ['Peminjaman', 'Pergantian']))
- **No Asset User:** {{ $proposal->no_asset }}
@endif
- **File IT:**
    @if (!empty($proposal->file_it) && file_exists(public_path('uploads/' . $proposal->file_it)))
        [Download File]({{ url('uploads/' . $proposal->file_it) }})
    @else
        <span style="color: red;">File Tidak Ditemukan!</span>
    @endif

---

### **IT Note:**
@if (!empty($proposal->it_analys))
    @php
        $cleanedNote = strip_tags($proposal->it_analys, '<br>');
        $cleanedNote = nl2br($cleanedNote); 
    @endphp
    {!! $cleanedNote !!}
@else
    <span style="color: red;">IT Note not available!</span>
@endif

---

Thank you for your attention to this matter. If you have any questions, please do not hesitate to reach out.

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
