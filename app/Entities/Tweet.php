<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Tweet extends Entity
{
    public function getCreatedAt(string $format = 'd-m-Y')
    {
        $this->attributes['created_at'] = $this->mutateDate($this->attributes['created_at']);
        $timezone = $this->timezone ?? app_timezone();
        $this->attributes['created_at']->setTimezone($timezone);
        return $this->attributes['created_at']->format($format);
    }
}