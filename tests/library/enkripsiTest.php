<?php

use App\Libraries\enkripsi_library;
use CodeIgniter\Test\CIUnitTestCase;

final class enkripsiTest extends CIUnitTestCase
{
    public function testGet_TwoWayEncryption()
    {
        $enkripsi = new enkripsi_library();

        // $payload = 'Ini adalah test';
        $payload = 0;

        $hash = $enkripsi->get_TwoWayEncryption('enkripsi', $payload);
        $this->assertSame(
            $payload,
            $enkripsi->get_TwoWayEncryption('dekripsi', $hash),
            'Enkripsi gagal'
        );
    }

    public function testGet_hashTTD()
    {
        $enkripsi = new enkripsi_library();

        $payload['noSurat'] = 'NoSurat 12345';
        $payload['idmhs'] = 'idmhs 12345';
        $payload['idPenandaTangan'] = 'idPenandaTangan 12345';
        $payload['NamaTTD'] = 'NamaTTD 12345';

        // enkripsi tanda tangan
        $hash = $enkripsi->get_EnkripsiTTD(
            $payload['noSurat'],
            $payload['idmhs'],
            $payload['idPenandaTangan'],
            $payload['NamaTTD']
        );
        // dekripsi tanda tangan kembali
        $dekrisi = $enkripsi->get_DekripsiTTD($hash);

        // test
        $this->assertSame(
            $payload['noSurat'],
            $dekrisi[0],
            'Nomer Surat tidak sama'
        );

        $this->assertSame(
            $payload['idPenandaTangan'],
            $dekrisi[2],
            'idPenandaTangan tidak sama'
        );

        $this->assertSame(
            $payload['idmhs'],
            $dekrisi[3],
            'idmhs tidak sama'
        );
    }
}
