<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class SelectOptionCell extends Cell
{
    protected $options;
    protected $nameselect;
    protected $idselect;
    protected $selected;
    protected $firstoptions;
    protected $lastoptions;
    protected $onchange;

    public function mount()
    {
    }

    public function getOptionsProperty()
    {
        return $this->options;
    }

    public function getNameselectProperty()
    {
        return $this->nameselect;
    }

    public function getIdselectProperty()
    {
        return $this->idselect;
    }

    public function getSelectedProperty()
    {
        return $this->selected;
    }

    public function getFirstoptionsProperty()
    {
        return $this->firstoptions;
    }

    public function getLastoptionsProperty()
    {
        return $this->lastoptions;
    }

    public function getOnchangeProperty()
    {
        return $this->onchange;
    }
}
