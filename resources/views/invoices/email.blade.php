@component('mail::message')
# Notifikasi

Kepada Yth. **{{ $invoice['projects']['customers']['customer_name'] }}**,

Semoga kabar baik-baik saja. Saya menuliskan email ini untuk memberi tahu bahwa invoice dengan no <strong>{{ $invoice['invoice_no'] }}</strong> dengan total Rp {{ number_format($invoice['last_result'], 0, NULL, '.') }} sudah saya kirimkan dua minggu lalu dan jatuh tempo di hari ini ({{ (new \DateTime($invoice['due_date']))->format('d-m-Y') }}). 
Saya ingin mengingatkan Bapak/Ibu untuk melakukan pembayaran sesuai dengan perjanjian di awal, yaitu pada hari ini. 
Kalau ada pertanyaan lanjut seputar pembayaran, saya bisa dihubungi di kontak yang tertera di bawah.


Thanks,<br>
{{ __('HITCorporation') }}
@endcomponent
