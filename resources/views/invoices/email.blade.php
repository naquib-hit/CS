@component('mail::message')
# Introduction

Kepada Bapak/Ibu X dari Perusahaan Y,

Semoga kabar baik-baik saja. Saya menuliskan email ini untuk memberi tahu bahwa invoice #1234 dengan total Rp 5.000.000 (lima juta rupiah) sudah saya kirimkan dua minggu lalu dan jatuh tempo di hari ini (27 Agustus 2020). 

Saya ingin mengingatkan Bapak/Ibu X untuk melakukan pembayaran sesuai dengan perjanjian di awal, yaitu pada hari ini. 

Kalau ada pertanyaan lanjut seputar pembayaran, saya bisa dihubungi di kontak yang tertera di bawah.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
