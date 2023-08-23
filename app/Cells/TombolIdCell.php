<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class TombolIdCell extends Cell
{
    // !form
    protected $link;
    protected $method;

    protected $target;
    protected $formclass;

    // !input
    protected $nameinput;
    protected $valueinput;

    // !tombol
    protected $textsubmit;
    protected $tombolsubmitclass;

    // !jsconfirm
    protected $textConfirm;
    protected $confirmdialog;


    public function mount()
    {
    }

    // !form ===================================================================
    public function getLinkProperty()
    {
        return $this->link;
    }

    public function getMethodProperty()
    {
        if (isset($this->method)) {
            return $this->method;
        }
        return 'POST';
    }

    public function getTargetProperty()
    {
        if (isset($this->target)) {
            return $this->target;
        }
        return '_self';
    }

    public function getFormclassProperty()
    {
        if (isset($this->method)) {
            return $this->method;
        }
        return '';
    }
    // ! =======================================================================

    // ! data yang dikirim =====================================================
    public function getNameinputProperty()
    {
        if (isset($this->nameinput)) {
            return $this->nameinput;
        }
        return 'id';
    }

    public function getValueinputProperty()
    {
        return $this->valueinput;
    }
    // ! =======================================================================

    // ! data yang dikirim =====================================================
    public function getTextsubmitProperty()
    {
        if (isset($this->textsubmit)) {
            return $this->textsubmit;
        }
        return 'submit';
    }

    public function getTombolsubmitclassProperty()
    {
        if (isset($this->tombolsubmitclass)) {
            return $this->tombolsubmitclass;
        }
        return '';
    }
    // ! =======================================================================

    // ! data yang dikirim =====================================================
    public function getTextConfirmProperty()
    {
        if (isset($this->textConfirm)) {
            return $this->textConfirm;
        }
        return 'Apakah Anda Yakin?';
    }

    public function getConfirmdialogProperty()
    {
        if (isset($this->confirmdialog)) {
            return $this->confirmdialog;
        }
        return false;
    }
    // ! =======================================================================
}
