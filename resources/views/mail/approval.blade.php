@component('mail::message')
# CR Approval DeptHead Notification

**Attention:** Please approve/reject the CR by clicking the button below...

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

<!-- - **File:** [Download File]({{ $proposal->file }}) -->

---

### Action:
<div style="text-align: center; margin-top: 20px;">
    <div style="display: flex; flex-direction: column; align-items: center;">
        <a href="{{ $approvalLink }}" style="background-color: #4CAF50; color: white; padding: 15px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 100%; max-width: 200px; margin: 5px;">Approve CR</a>
        <a href="{{ $rejectedLink }}" style="background-color: #dc3545; color: white; padding: 15px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 100%; max-width: 200px; margin: 5px;">Reject CR</a>
    </div>
</div>

---

Thank you for your attention to this matter. If you have any questions, please do not hesitate to reach out.

**Regards,**  
PT Dharma Polimetal Tbk
@endcomponent
