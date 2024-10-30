@component('mail::message')
# CR Close Notification

**Attention:** CR has been closed With IT, Please Close CR in Website to click button Closed All.

---

### CR Details
- **Proposal No CR:** {{ $proposal->no_transaksi }}
- **User Request:** {{ $proposal->user_request }}
- **Department:** {{ $proposal->departement }}
- **No Handphone:** {{ $proposal->ext_phone }}
- **Status Barang:** {{ $proposal->status_barang }}
- **Facility:** {{ $proposal->facility }}
- **User Note:** {{ $proposal->user_note }}
- **Estimated Date:** {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('Y-m-d H:i:s') }}

---

Thank you!

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
