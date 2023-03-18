surat menyurat dimana mahasiswa bisa meminta surat dimana dekan bisa mencentang lalu menandatangini surat lalu surat sudah di setujui

mahasiswa bisa mendownload surat menjadi pdf atau print
___

### tugas 0 : (database)
membuat relasi database

___

### tugas 1 : (meminta surat(surat keluar)) 
gambaran mahasiswa yang akan menginputkan data kedalam surat
meminta surat apa?

contoh meminta aktif kuliah > tandatangan dekan
disistem dekan akan ada notif meminta tandangan dekan

ada filter sudah tandatangain

status sudah ditanda dan belum

perlu tanda tangan manual(drawing tab)

akun mahasiswa
akun level
___

### tugas 2 : (quary filter)
**dasboard**
dosen ingin melihat data mahasiswa
contoh melihat masasiswa TI status aktif lulus maka dia akan keluar semua
tapi pasti akan keluar semua dosen mau spesific kaya anggatan berapa

akun dosen
___

### tugas 3 : (mengarsipkan surat)
mengarsipkans surat memasukan nomer surat dan kapan dan dari mana lalu scan surat
terus bisa di filter seperti dari kaya meminta filter dari surat air

akun dosen
akun level
___


### Perlu
format auth untuk login
framework nya pakai apa ? Natif
hardware nya apa aja ?
plugin untuk memasukan ke sia
desain website
database sia
MOU

___

### LVL: ada 3 lvl
| nama      | lvl |
| --------- | --- |
| mahasiswa | 1   |
| dosen     | 2   |
| dekan     | 3   |

### Lvl Perm:
| fungsi              | lvl |
| ------------------- | --- |
| UI permintaan surat | 1   |
| UI tandatangan      | 3   |
| UI Quary            | 2,3 |
| UI Arsip            | 2   |
| UI Quary Arsip      | 2,3 |

### Tabel Surat:
| Id_Surat | nomer | tgl  | Id_MHS_fk | ttd_oleh_fk | ttd_done |
| -------- | ----- | ---- | --------- | ----------- | -------- |
| int      | int   | date | int       | int         | boolean  |

### Table Arsip:
| id_Arsip | darimana | no_surat | time_stamp |
| -------- | -------- | -------- | ---------- |
| int      | varchar  | varchar  | timestamp  |
