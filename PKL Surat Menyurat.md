dassurat menyurat dimana mahasiswa bisa meminta surat dimana dekan bisa mencentang lalu menandatangini surat lalu surat sudah di setujui

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

menggunakan qrcode

akun mahasiswa
akun level
___

### tugas 2 : (quary filter)
**dasboard**
dosen ingin melihat data mahasiswa
contoh melihat masasiswa TI status aktif lulus maka dia akan keluar semua
tapi pasti akan keluar semua dosen mau spesific kaya anggatan berapa

akun dosen
akun pengajaran
___

### tugas 3 : (mengarsipkan surat)
mengarsipkans surat memasukan nomer surat dan kapan dan dari mana lalu scan surat
terus bisa di filter seperti dari kaya meminta filter dari surat air

akun dosen
akun level
___


### Perlu
format auth untuk login?\n
framework nya pakai apa ? CodeIgnater4\n
hardware nya apa aja ? computer untuk cleint\n
plugin untuk memasukan ke sia ? \n
desain website ?\n
database sia ?\n
MOU ?\n

___

### LVL: ada 4 lvl
| Nama       | lvl |
| ---------- | --- |
| Mahasiswa  | 1   |
| Dosen      | 2   |
| Dekan      | 3   |
| Pengajaran | 4   |


### Lvl Perm:
| fungsi              | lvl |
| ------------------- | --- |
| UI permintaan surat | 1   |
| UI tandatangan      | 3   |
| UI Quary            | 2,3 |
| UI Arsip            | 2   |
| UI Quary Arsip      | 2,3 |

### Tabel Surat:
| Id_Surat | nomer | tgl  | Id_MHS_fk | ttd_oleh_fk | ttd_done | kapan_diTTD | jenis surat |
| -------- | ----- | ---- | --------- | ----------- | -------- | ----------- | ----------- |
| int      | int   | date | int       | int         | boolean  | date        | varchar     |


### Table Arsip:
| id_Arsip | darimana | no_surat | time_stamp | jenis surat | kode surat | penerima surat | tdd oleh |
| -------- | -------- | -------- | ---------- | ----------- | ---------- | -------------- | -------- |
| int      | varchar  | varchar  | timestamp  | varchar     | varchar    | varchar        | varchar  |

___
KRS
| idKRS | idMHS | idMK | nilai T1 | nilai T2 | nilai T3 | UAS | UTS |
| ----- | ----- | ---- | -------- | -------- | -------- | --- | --- |
| 1     | 201   | A01  | 90       | 30       | 80       | 50  | 10  |
| 2     | 201   | A03  | 30       | 50       | 60       | 10  | 90  |
| 3     | 202   | A01  | 90       | 90       | 100      | 10  | 50  |
| 4     | 201   | A02  | 10       | 40       | 60       | 80  | 90  |  

MK
| idMK | NamaMK |
| ---- | ------ |
| A01  | DB1    |
| A02  | BD2    |
| A03  | AI     |

MHS
| idMHS | namaMHS |
| ----- | ------- |
| 201   | bob1    |
| 202   | bob2    |

DB_PenandaTangan
| idPT | idPengajaran/idDosen/IdDekan | UUID |
| ---- | ---------------------------- | ---- |
| P01  | D03                          | fw2  |
| P02  | D04                          | frt3 |
| P03  | D05                          | ger3 |

DB_Suratmasuk
| idSuratMasuk | idMHS | idPT | jenisSurat | NOSurat | Done  | Hash   | timestamp |
| ------------ | ----- | ---- | ---------- | ------- | ----- | ------ | --------- |
| 1            | 201   | P01  | test1      | N0543   | true  | wefwad | unixtime  |
| 2            | 201   | P02  | test1      | N0543   | false | null   | null      |
| 3            | 202   | P01  | test2      | N0645   | false | null   | null      |
| 4            | 201   | P03  | test1      | N0808   | false | null   | null      |




### UI Penanda Tangan (login sebagai D03 == P01)
#### yang perlu di TTD
No Surat N0645 (201(Bob1))
#### Semua TTD
No Surat N0543 (Sudah TTD)
No Surat N0645 (belum TTD)

### UI Mahasiswa (login sebagai Bob1 == 201)
#### yang surat yang belum di TTD
Nomer surat N0543 (D04)
Nomer surat N0808 (D05)
#### yang sudah di TTD
Nomer surat N0543 (D01)

### UI Mahasiswa (login sebagai Bob2 == 202)
#### yang surat yang belum di TTD
Nomer surat N0645 (D03)
#### yang sudah di TTD
(Belum ada surat yang di TTD)




### Apakah TTD Valid ? (untuk validasi ttd 1 1)
key 2way NoSurat_UUID_idpengajaran_idMHS

nomersurat untuk mendapatkan detail surat (idpengajaran,idmhs,unixtime)
Idpengajaran untuk mendapatkan siapa nama penandatangan
idmhs untuk mendapatkan nama mahasiswa
unixtime untuk memberitahu kapan di ttd kan
uuid dan RandomNumber untuk menambah total komplexsitas encripsi


2wayhash = Nosurat_UUID-RandomNumber_Idpengajaran_idMHS_unixtime

simpan 2wayhash di DB

#### QRCode
ambil 2wayhash dari db

TTD-oleh_NamaDosen_2wayhash
jadikan menjadi QRCode

dengan nama file idsuratmasuk.png

bila di scan akan menjadi
TTD-oleh_NamaDosen_2wayhash

pertama akan di expload "\_"
pada array 0 TTD-oleh
akan memberitahu bahwa ini adalah cek validasi TTD

pada array 2 akan di dekripsi menjadi
NoSurat_UUID-RandomNumber_Idpengajaran_idMHS_unixtime

pertama akan di expload "\_"
pada array 0 NoSurat akan mencari No Surat
lalu menyusaikan 2wayhash dengan yang di db
bila tidak sama
pada array 2,3,4 akan di cocokan 1 1
yang tidak cocok akan di beri tau kan


---

### DBSuratMasukDone
| idDBSurat | idMHS | hashFilePDF | hashFilesebelum | done | jenisSurat        | NoSurat | timeStamp |
| --------- | ----- | ----------- | --------------- | ---- | ----------------- | ------- | --------- |
| 0         | 201   | 12333       | 0000            | done | keterlambatan-SKS | 234     | UnixTime  |
| 1         | 201   | 346234      | 12333           | done | MOU               | 345     | UnixTime  |
| 2         | 202   | 26347       | 346234          | done | MOU               | 663     | UnixTime  |
| 3         | 201   | 143234      | 26347           | done | telat-bayar1      | 453     | UnixTime  |


### DBSuratMasukNot
| idDBSurat | idMHS | hash | done | jenisSurat   | NoSurat | lastHast |
| --------- | ----- | ---- | ---- | ------------ | ------- | -------- |
| 1         | 202   | NULL | not  | telat-bayar1 | 645     | 3        |
| 2         | 201   | NULL | not  | telat-bayar2 | 453     | 3        |




#### PDFDone
0_Dummy_000_234 (12333)
1_bob1_12333_345 (346234)
2_bob2_346234_663 (26347)
3_bob1_26347_453 (143234)

#### PDFTemp (ttd belum lengkap)
X1_bob2_3_143234_Temp_645 (1234345) (ttd 1)
OverWrite ->
X1_bob2_3_143234_Temp_645 (45567453) (ttd 2)

X2_bob2_3_143234_Temp_453 (20839853) (ttd 0)


key file enkripsi 2way (NoSurat_idMHS_hashFileTerakhir_)

### file download
bob2_Nime_JenisSurat_NoSurat


### apakah pdf ini valid ? (untuk validasi banyak file dengan cepat)
### real
didalam PDF ada Enkripsi key yang memberitaukan apakah file valid

##### input
no surat
key (NoSurat_hashFileTerakhir_idMHS)
file (optional)


### API untuk quick validasi chack (GStore)
app android
(link) jadi sekolah lain bisa di pakai di sekolah nya masing2
api/v1/(:qr)




### cara kerja permintaan ttd
mahasiswa meminta jenis surat

server akan membuatkan tamplate
server akan melihat siapa saja yang perlu ttd


bila mahasiswa yakin mau membuat maka

server akan menambahkan kedalam SuratMasukTemp karena surat belum di TTD
server akan membuatkan NoSurat
server akan save timestamp
server akan Menyimpan siapa yang membuatSurat
server akan akan Menyimpan jenissurat

mahasiswa akan melihat di daskboard bahwa surat belum di TTD berada di dalam DB_SuratMasuk_Temp
mahasiswa dapat menRefrash untuk melihat apakah semua TTD Sudah Di penuhi


server akan melihat DB_TTDSurat dimana NoSurat apakah flag done sudah tidak ada yang false bila sudah tidak ada maka cek apakah twowaykeyhash ada yang masi null bisa semua sudah terisi maka 

server akan membuat TTD qrcode dengan nama "NoSurat_IdPenandaTangan" dengan data twowakeyhash

server akan membuat qrcode dengan nama "HashFile_NoSurat" dengan data sha256 file sebelum nya

server akan menyimpan data2 di dalam DB_SuratMasuk
server akan menyimpan data id baru
server akan menyimpan siapa yang meminta
server akan menyimpan NoSurat
server akan jenisSurat

setelah semua TTD sudah dipenuhi
TTD qrcode akan di taruh di tempat nya
hashFile qrcode akan di taruh di tempat nya
makan file pdf akan disimpan dengan nama "JenisSurat_NoSurat_Mahasiswa"
setelah file sudah disimpan server akan mengambil hash sha256 file dan mengupdate db


**pada PenandaTangan (Dosen/Dekan/Pengajaran)**
melihat bahwa ada NoSurat TTD yang belum di flag Done masi false

pada detail TTD memberitau siapa yang meminta, jenisSurat, dan kapan

bila dosen menTTD maka
server akan menyimpan siapa yang meminta
server akan menyimpan siapa yang menTTD
server akan membuat UUID
server akan menyimpan penadatanganTTD
server akan menyimpan NoSurat
server akan menyimpan JenisSurat
server akan membuat dan Menyimpan twowaykeyhash
dan mengubah flag done menjadi true
server akan menyimpan waktu TTD











**pengajar**
| id  | pengajar |
| --- | -------- |
| 1   | budi     |
| 2   | bude     |
| 3   | joni     |
| 4   | jona     |


**penandatangan**
| id  | uuid     | pin_secure | diskripsi | id_pengajar |
| --- | -------- | ---------- | --------- | ----------- |
| 1   | {uuidv4} | {hash}     | baak      | 1           |
| 2   | {uuidv4} | {hash}     | baak2     | 2           |
| 3   | {uuidv4} | {hash}     | entah apa | 4           |


**jenis-surat**
| id  | nama_jenisSurat | diskripsi |
| --- | --------------- | --------- |
| 1   | MOU             | MOU       |
| 2   | MOU2            | MOU2      |
| 3   | joni            |           |
| 4   | jona            |           |


**isi surat**
| id  | isi-surat                    | diskripsi |
| --- | ---------------------------- | --------- |
| 1   | ini adalah surat mao         | surat mou |
| 2   | ini adalah surat cinta joini | surat     |


**ttd_surat_penanda**
| id_jenisSurat | id_PenandaTangan |
| ------------- | ---------------- |
| 1             | 1                |
| 1             | 2                |
| 2             | 3                |
| 2             | 2                |
| 1             | 3                |
| 2             | 1                |


**mahasiswa**
| idMHS | namaMHS |
| ----- | ------- |
| 201   | bob1    |
| 202   | bob2    |


**ttd-Surat-Masuk**
| id  | noSurat | timeStamp | id_mahasiswa | id_jenis-Surat |
| --- | ------- | --------- | ------------ | -------------- |
| 1   | 10021   | {waktu}   | 201          | 1              |
| 2   | 1314    | {waktuk}  | 201          | 2              |


**ttd**
| id  | id_ttd-surat-masuk | hash   | status | timestamp | id_ttd |
| --- | ------------------ | ------ | ------ | --------- | ------ |
| 1   | 1                  | null   | belum  | null      | 3      |
| 2   | 1                  | null   | bulum  | null      | 1      |
| 3   | 1                  | null   | belum  | null      | 2      |
| 4   | 2                  | {hash} | sudah  | {waktu}   | 1      |





### cara kerja permintaan ttd

**pengajar melihat siapa yang perlu ttd**
-> mengambil id_pengajar (242)
-> mengambil id_penandatangan (1)
-> mengambil semua id_ttdSurat dari id_penandtagan yang berstatus belum (1)
-> mengambil semua id_ttdSurat dari id_penandtagan yang berstatus sudah (2)

**pengajar menandatangani**
-> pengajar klik tandatanganin surat dengan id_ttdSurat
-> server akan mangambil data2 dari penandatangan
-> server akan mengambil id_mahasiswa
-> server akan membuat hash
-> server akan mengupdate di id_ttdSurat dengan hash,status,randomNumber,timestamp_ttd

**mahasiswa melihat surat yang di ttd**
-> mengambil id_mahasiswa (201)
-> mengambil noSurat dari id_mahasiswa (10021,1314)
-> mengambil 1 id_ttdSuratMasuk dari noSurat (10021)
-> mencek 1 id_ttdSuratMasuk berapa jumlah yang perlu ttd
-> mencek 1 id_ttdSuratMasuk berapa jumlah yang berstatus "sudah" (kurang 1)
-> karena kurang 1 jadi belum ada tombol download

-> bila sudah lengkap akan keluar tombol download
-> dari noSurat akan mengambil semua id_ttdSurat menggunakan id_ttdSuratMasuk
-> mengambil nama penandatangan dari id_penandatangan
-> ngeloop ttd untuk dimasukan kedalam pdf
-> dari id_jenis-Surat akan mengambil isi surat untuk dimasukan kedalam pdf

**mahasiswa meminta surat**
-> server akan mengambil pilihan jenis surat dari (db_jenis-surat)
-> mahasiswa memilih jenis surat
-> mahasiswa mengisi data tambahan {bila ada}
-> bila mahasiswa klik preview
-> dari id_jenis-Surat akan mengambil isi surat untuk dimasukan kedalam pdf
-> dari id_jenis-Surat akan mengambil id_penandaTangan untuk dimasukan kedalam pdf (ada 3 ttd) {forloop}
-> render pdf
-> bila mahasiswa klik minta surat

-> server akan membuat queue db_ttd yang di ambil dari db_ttd-surat-penanda {forloop}
-> server akan membuat noSurat dan di masukan ke db_surat-masuk


id berdasarkan
unixtime-randomnumber


isi Surat {{nama}} pada tgl {{tgl}}

test 1 uji coba





{{cop surat}}  
{{Isi surat}}  
{{Ttd1}}  
{{Ttd2}}  
Nanti ada tombol add ttd berubah select box  
Ttd1:\[nama] 
Cop surat juga berupa select box