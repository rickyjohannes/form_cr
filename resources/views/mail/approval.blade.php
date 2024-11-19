@component('mail::message')
# CR Approval Notification

**Attention:** Please approve or reject the CR by clicking the button below.

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
@if (in_array($proposal->status_barang, ['Pergantian']))
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

### Action:
<div style="text-align: center; margin-top: 20px;">
    <div style="display: flex; flex-direction: column; align-items: center;">
        <a href="{{ $approvalLink }}" style="background-color: #4CAF50; color: white; padding: 15px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 100%; max-width: 200px; margin: 5px;">
            Approve CR
        </a>
        <a href="{{ $rejectedLink }}" style="background-color: #dc3545; color: white; padding: 15px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 100%; max-width: 200px; margin: 5px;">
            Reject CR
        </a>
    </div>
</div>

---

Thank you for your attention to this matter. If you have any questions, please do not hesitate to reach out.

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
