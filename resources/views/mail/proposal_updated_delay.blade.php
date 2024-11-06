@component('mail::message')
# CR DELAY Notification

**Attention:** The following CR has been delayed in completing the work estimate.

---

### CR Details:
- **No CR:** {{ $proposal->no_transaksi }}
- **User Request:** {{ $proposal->user_request }}
- **Position:** {{ $proposal->user_status }}
- **Department:** {{ $proposal->departement }}
- **No Handphone:** {{ $proposal->ext_phone }}
- **Jenis Permintaan:** {{ $proposal->status_barang }}
- **Category:** {{ $proposal->kategori }}
- **Facility:** {{ $proposal->facility }}
- **User Note:** {{ $proposal->user_note }}
- **No Asset User:** {{ $proposal->no_asset_user }}
- **File:**
    @if (!empty($proposal->file) && file_exists(public_path('uploads/' . $proposal->file)))
        [Download File]({{ url('uploads/' . $proposal->file) }})
    @else
        <span style="color: red;">File Not Found!</span>
    @endif

### CR Details From IT:
- **Estimated Date:** {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('Y-m-d H:i:s') }}
- **IT User:** {{ $proposal->it_user }}

---

Thank you for your attention to this matter. If you have any questions, please do not hesitate to reach out.

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
