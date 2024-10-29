@component('mail::message')
# Proposal Update Notification

Proposal with No CR: {{ $proposal->no_transaksi }} has been updated.

User Request: {{ $proposal->user_request }}

Department: {{ $proposal->departement }}

No Handphone: {{ $proposal->ext_phone }}

Status Barang: {{ $proposal->status_barang }}

Facility: {{ $proposal->facility }}

User Note: {{ $proposal->user_note }}

Estimated Date: {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('Y-m-d H:i:s') }}

CR will be processed by the IT team. Please be patient, and if you do not receive news soon, feel free to follow up using this CR number. Thank you for your understanding!

Thank you for using our application!

Regards,<br>
PT Dharma Polimetal Tbk
@endcomponent
