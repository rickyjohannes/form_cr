@component('mail::message')
# CR DELAY Notification

Proposal with No CR: {{ $proposal->no_transaksi }} CR is late in completing the work estimate!

User Request: {{ $proposal->user_request }}

Department: {{ $proposal->departement }}

No Handphone: {{ $proposal->ext_phone }}

Status Barang: {{ $proposal->status_barang }}

Facility: {{ $proposal->facility }}

User Note: {{ $proposal->user_note }}

Estimated Date: {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('Y-m-d H:i:s') }}

Regards,<br>
PT Dharma Polimetal Tbk
@endcomponent
