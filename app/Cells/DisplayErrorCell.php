<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class DisplayErrorCell extends Cell
{
    protected $dataterima;

    public function mount()
    {
        return $this->dataterima;
    }
    public function getDataterimaProperty()
    {
        return json_decode($this->dataterima, true);
    }
}
