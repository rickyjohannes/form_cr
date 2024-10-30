@component('mail::message')
# CR Updated Notification

**Attention:** IT has updated the work estimate for the following CR.

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

CR will be processed by the IT team. Please be patient, and if you do not receive news soon, feel free to follow up using this CR number. Thank you for your understanding!

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
