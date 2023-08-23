<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class SidebarLinkNotifCell extends Cell
{
    protected $link;
    protected $linktext;
    protected $imagelink;
    protected $notif;


    public function mount()
    {
    }

    public function getLinkProperty()
    {
        return $this->link;
    }

    public function getLinktextProperty()
    {
        if (isset($this->linktext)) {
            return $this->linktext;
        }
        return 'Link';
    }

    public function getImagelinkProperty()
    {
        if (isset($this->imagelink)) {
            return $this->imagelink;
        }
        return 'asset/svg/home.svg';
    }

    public function getNotifProperty()
    {
        if (isset($this->notif)) {
            return $this->notif;
        }
        return 0;
    }
}
