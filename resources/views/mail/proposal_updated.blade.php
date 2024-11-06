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

CR will be processed by the IT team. Please be patient, and if you do not receive updates soon, feel free to follow up using this CR number. Thank you for your understanding!

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
