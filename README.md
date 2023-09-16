# PKL SIA UNMUH JEMBER

---

# Dosen Pembimbing Lapangan
- Ari Eko Wardhoyo, S.T., M.Kom
___
# Anggota PKL

- 2010651148_FAHMI AKBAR RAFSANJANI
- 2010651166_AULIA MUHAMMAD FERNANDA
- 2010651181_FREGI OKTA PRADANA
- 2010651182_GALIH ADITYA PRAKOSA
- 2010651164_MOH. MAULANA WISNU
- 2010651170_Achmad Naji

---

# hal yang harus di lakukan

1. clone repo
```bash
gh repo clone IndoproGMR/PKL_SIA_UNMUH_JEMBER
```
2. lalu install menggunakan bash file
```bash
bash installapp
```
3. isi .env
```
harus di isi:
SUPERKEY,
DATABASE,
logo qr,
api version,
ENVIRONMENT di set ke development

optional:
SESSION
```

4. lalu jalankan server local php
```bash
php spark serve
```
5. lalu buka browser
```url
localhost:8080/
```
6. Update
```bash
git pull
```
7. 
```
copy file enkripsi_libary kedalam App\Libraries
```

---
## Version: (terakhir update)
- codeigniter = 4.3.7 (next 4.4.1)
- dompdf = 2.0.3
- endroid/qr-code = 4.8.2
- khaled.alshamaa/ar-php = 6.3.4
- mpdf/mpdf = 8.1.6
- tinymce = 6.6.2 (next = 6.7.0)
- instascan = 1.0.0
- html5-qrcode = 2.3.8
- php = +8.0 (next +8.1)
___

### Link
[Desain UI/UX](https://www.figma.com/file/PSqK3nQi24n6Y7p7NvwzGQ/UI-SURAT-MENYURAT?type=design&node-id=0-1&t=ItdAVOX8ike9HtGa-0)\
[Standarisasi](#Standarisasi)

## TODO:
#### Help Dokumentasi
##### Staff
- [ ] Membuat Master Surat
##### Mahasiswa
- [ ] Meminta Surat

#### Error feedback
- [ ] Exceptions (need:UI)
- [ ] permissions error (need:UI)
- [x] Validation error
- [x] succes fail massage

**Create_Read_Update_Delete_readPDF_MakeFile**
#### Surat Keluar (8/18)
##### Semua user
- [ ] cek QR (need:UI)

##### Mahasiswa 
- [ ] Minta Surat (R) (need:UI)
- [ ] Minta Surat buat (C_R) (need:UI)
- [x] Semua Surat (R_PDF_MK)
- [x] Melihat Status Surat (R)
- [ ] Mendownload surat (bug: tidak dapat membuat file qr baru)

##### PenandaTangan
- [x] Semua Yang belum di TandaTangan kan (R_PDF)
- [x] TandaTangan Preview (PDF)
- [ ] TandaTangan (U_MK)
- [x] Semua Yang sudah di TandaTangan kan (R_PDF)

##### Pengajaran
- [ ] Master Surat Buat (C) (need:UI)
- [x] Master Surat semua (R_PDF) 
- [ ] Test Master Surat (R_PDF) (need:UI)
- [ ] Master Surat edit (R_U_D) (need:UI)
- [x] Master Surat Visiblity Toggle (U)
- [x] set NomerSurat semua (R_PDF) (need:UI)
- [ ] set NomerSurat edit (R_U_D) (need:UI)

##### PDF Surat
- [ ] KOP Surat
- [ ] layout
- [x] tandatangan

#### Surat Masuk (1/6)
##### Pengajaran
- [x] SuratMasuk semua (R)
- [ ] SuratMasuk input (C_MK) (need:UI)
- [ ] SuratMasuk edit (U_D) (need:UI) (bug: tidak dapat reload saat update)
- [ ] SuratMasuk Preview (R_PDF) (need:UI)
- [ ] SuratMasuk jenis buat (C_R) (need:UI)
- [ ] SuratMasuk jenis edit (R_U_D) (need:UI)

#### Quary (0/?)
##### Pengajaran
- [ ] Informasi Tambahan
- [ ] Table (need:backend)

#### Admin Panel (0/?)
##### Akun
- [x] Login
- [X] Membuat akun baru
- [ ] cek ke amanan
##### Admin
- [ ] Analastik storage server surat (R)
- [ ] Delete temp file (R_D)
- [ ] membuat zip backup (R_MK)

#### Typo dan error respon (Prioritas terakhir)
- [ ] API

- [ ] URL Surat Keluar
- [ ] URL Surat Masuk
- [ ] URL Query
- [ ] URL admin panel

- [ ] CRUD Surat Keluar
- [ ] CRUD Surat Masuk
- [ ] CRUD Query
- [ ] CRUD admin panel

- [ ] test Surat Keluar
- [ ] test Surat Masuk
- [ ] test Query
- [ ] test admin panel

---

- [x] framework
- [ ] Data flow
- [ ] Database
- [ ] Backend Login dan auth

- [x] UI Surat masuk
- [ ] Backend Surat masuk
- [x] DB Surat masuk
- [x] Enckripsi qrcode
- [x] Quary Filter
- [x] Quary Search
- [x] menyimpan namafile
- [x] render pdf
- [x] format nomersurat
- [ ] memasukan qr ke pdf
- [ ] memasukan nama penandatangan ke pdf
- [ ] memilih nip atau nik dari database ke pdf

- [ ] UI Archive
- [x] Backend Archive
- [x] DB Archive
- [x] menyimpan namafile
- [x] menampilkan Archive

- [ ] UI Quary archive
- [ ] Backend Quary archive

- [ ] UI Quary Mahasiswa
- [ ] Backend Quary
- [ ] Backend Quary Mahasiswa

- [ ] Dokumentasi PHP

- [x] cara men encripsi TTD
- [x] cara men decripsi TTD
- [ ] cara men encripsi file PDF
- [ ] cara men decripsi file PDF
- [x] membuat QrCode
- [x] mensave pdf

- [x] Membuat API validasi TTD dengan qrcode

___

### Extensions
- Auto Rename Tag
- advanced-new-file
- Better Comments
- GitHub Pull Requests and Issues
- GitLens — Git supercharged
- IntelliCode
- IntelliCode API Usage Examples
- PHP Debug
- PHP Intelephense
- PHP IntelliSense
- PHP Language Features
- Prettier - Code formatter
___


# Standarisasi
### Fungsi
menggunakan CamelCase

CRUD NAMA PROSES
contoh:
addMasterSuratIndex
addMasterSuratProses

### Varibale
menggunakan camelCase

NAMA URUTAN atau JENISVARIABLE
contoh:
file1
model2
dataArray
suratJson

### File
#### dev made
menggunakan Under_Score dan garis-tengah\

KELOMPOK-FUNGSI-NAMA_NAMA\
contoh:\
Mahasiswa-Index-Minta_Surat\
Mahasiswa-Input-Minta_Surat\
Pengajaran-Input-Master_Surat\
Pengajaran-Edit-Master_Surat\
Pengajaran-Detail-Master_Surat\
#### user made
menggunakan Under_Score dan garis-tengah


#### controllers proses
menggunakan CamelCase



### URL
menggunakan Under_Score dan garis-tengah dan Garis/Miring

KELOMPOK_KELOMPOK/FUNGSI_FUNGSI/NAMA-NAMA/{ID}\
contoh:\
Staff/Preview/Surat/TandaTangan\
Staff/Preview/Master_Surat/{Id}\

### Error massage
#### lvl 1 (kondisi)
E = ada yang bermasalah
S = sukses
F = gagal

#### lvl 2 (proses)
save = penyimpanan
update = update
edit = edit
delete = menghapus

#### lvl 3 (individu)
TTD = tanda tangan
Archive = Archive
validasi = validasi

#### lvl x (massage)
database = di database

exist = ada
valid = valid

yes = iya
no = tidak

? = Penyebab Tidak diketahui

#### contoh:
f.save.TTD\
gagal untuk menyimpan tanda tangan

f.save.Archive.no.valid\
gagal untuk menyimpan Archive karena tidak valid

f.save.Archive.exist.database\
gagal untuk menyimpan Archive karena ada di database

f.save.TTD.validasi.f\
gagal untuk menyimpan tanda tangan karena validasi gagal
