<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Session\Handlers\FileHandler;

class AdtConfig extends BaseConfig
{
    private $categories = [
        'pendidikan', 
        'teknologi', 
        'pemrograman', 
        'hiburan', 
        'umum'
    ];

    public function getCategories()
    {
        $arr2D = [];
        foreach($this->categories as $cat){
            $arr2D[$cat] = ucwords(str_replace("_", " ", $cat));
        }
        return $arr2D;
    }
}