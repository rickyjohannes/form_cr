@component('mail::message')
# CR Approval DivisiHead Notification

**Attention:** CR Will be Processed by IT Team. Please be patient, and if you do not receive any news in the near future, please follow up using this CR number. Thank you for your understanding.

---

### CR Details
- **Proposal No CR:** {{ $proposal->no_transaksi }}
- **User Request:** {{ $proposal->user_request }}
- **Department:** {{ $proposal->departement }}
- **No Handphone:** {{ $proposal->ext_phone }}
- **Status Barang:** {{ $proposal->status_barang }}
- **Facility:** {{ $proposal->facility }}
- **User Note:** {{ $proposal->user_note }}
- **File:**
    @if (!empty($proposal->file) && file_exists(public_path('uploads/' . $proposal->file)))
        [Download File]({{ url('uploads/' . $proposal->file) }})
    @else
        <span style="color: red;">File Tidak Ditemukan!</span>
    @endif

---

Thank you for your attention to this matter. If you have any questions, please do not hesitate to reach out.

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
