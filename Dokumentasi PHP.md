taro file di root lalu copy file public ke dalam html

set perm folder
```bash
sudo chmod -R writable/
sudo chmod -R html/

sudo chown -R www-data:www-data writable/
sudo chown -R www-data:www-data html/
```


ubah baseurl di **.env** menjadi url (\www.exemple.com)
ubah baseurl di **App/Config/App.php** menjadi url (\www.exemple.com)

ubah **App/Config/helpers/rendergambar_helper.php**
``` php
$mpdf = new \Mpdf\Mpdf();
// manjadi =>
$mpdf = new \Mpdf\Mpdf(['tempDir' => $setting['tempDir']]);
```


TODO:
- [ ] set lokasi simpan qr
- [x] set lokasi simpan PDF