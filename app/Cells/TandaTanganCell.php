<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class TandaTanganCell extends Cell
{
    //

    protected $time;
    protected $foto;

    protected $jabatan;
    protected $nama;

    protected $nomer;
    protected $nip = true;

    public function mount()
    {
    }

    public function getTimeProperty()
    {
        return $this->time;
    }
    public function getFotoProperty()
    {
        return $this->foto;
    }


    public function getJabatanProperty()
    {
        return $this->jabatan;
    }
    public function getNamaProperty()
    {
        return $this->nama;
    }


    public function getNomerProperty()
    {
        return $this->nomer;
    }
    public function getNipProperty()
    {
        return $this->nip;
    }
}
