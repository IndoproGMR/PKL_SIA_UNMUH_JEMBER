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
3. Install phpredis
```bash
sudo apt install php8.1-redis

curl -fsSL https://packages.redis.io/gpg | sudo gpg --dearmor -o /usr/share/keyrings/redis-archive-keyring.gpg

echo "deb [signed-by=/usr/share/keyrings/redis-archive-keyring.gpg] https://packages.redis.io/deb $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/redis.list

sudo apt-get update
sudo apt-get install redis
```

4. isi .env
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

5. lalu jalankan server local php
```bash
php spark serve
```
6. lalu buka browser
```url
localhost:8080/
```
7. Update
```bash
git pull
```
8. File Penting
```
copy file enkripsi_libary kedalam App\Libraries
```

Clean Redis
```bash
redis-cli flushall
```

upgrade/install
```
apache dari 2.4.18 (2016) ke yang terbaru
redis server
php 
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
- [x] permissions error
- [x] Validation error
- [x] succes fail massage

**Create_Read_Update_Delete_readPDF_MakeFile**
#### Surat Keluar (16/28)
##### Semua user
- [ ] cek QR (need:UI)
- [ ] liat surat dari server
- [ ] penambahan centang untuk cek manual
- [ ] bug pada auto detail
- [x] API baru untuk mencek apakah noSurat sudah ada di dalam database atau tidak?

##### Mahasiswa 
- [ ] Minta Surat (R) (need:UI)
- [ ] Minta Surat buat (C_R) (need:UI)
- [x] Semua Surat / Riwayat (R_PDF_MK)
- [x] Filter Berdasarkan Tgl,Jenis Surat
- [x] Melihat Status Surat (R)
- [x] Mendownload surat

##### PenandaTangan
- [x] Semua Yang belum di TandaTangan kan (R_PDF)
- [x] Filter Berdasarkan Tgl,Peminta,Jenis Surat
- [x] TandaTangan Preview (PDF)
- [x] TandaTangan (U_MK)
- [x] Semua Yang sudah di TandaTangan kan (R_PDF)
- [x] Filter Berdasarkan Tgl,Peminta,Jenis Surat

##### Pengajaran
- [ ] Master Surat Buat (C) (need:UI)
- [x] Master Surat semua (R_PDF) 
- [ ] Test Master Surat (R_PDF) (need:UI)
- [ ] Master Surat edit (R_U_D) (need:UI)
- [x] Master Surat Visiblity Toggle (U)
- [x] set NomerSurat semua (R_PDF)
- [x] Filter Berdasarkan Peminta,Jenis Surat
- [ ] set NomerSurat edit (R_U_D) (need:UI)

##### PDF Surat
- [ ] KOP Surat
- [ ] layout
- [x] tandatangan

#### Surat Masuk (1/7)
##### Pengajaran
- [x] SuratMasuk semua (R)
- [ ] Filter Berdasarkan Tgl,Jenis Surat
- [ ] SuratMasuk input (C_MK) (need:UI)
- [ ] SuratMasuk edit (U_D) (need:UI) (bug: tidak dapat reload saat update)
- [ ] SuratMasuk Preview (R_PDF) (need:UI)
- [ ] SuratMasuk jenis buat (C_R) (need:UI)
- [ ] SuratMasuk jenis edit (R_U_D) (need:UI)

#### Quary (0/?)
##### Pengajaran
- [ ] Informasi Tambahan
- [ ] Table (need:backend)

#### Admin Panel (2/?)
##### Akun
- [x] Login
- [x] Membuat akun baru
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

- [ ] Menambah fungsi Cache pada quary

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

### API
```php
$data = [
	'massage_status' => '1',
	'massage' => resMas('f.:.perm.n.valid')
];
return $this->respond($data, 401, 'access_denied');
```

```JSON
{
    "massage_status": "1",
    "massage": "Gagal : Permission tidak valid"
}

.then(function(response) {
	if (response.status != 200) {
	const data = {
		'massage_status': 1,
		'massage': response.statusText
	};
		return data;
	}
return response.json(); // Mengambil data JSON dari respons
})
```

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
