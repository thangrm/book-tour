<?php

namespace App\Traits;

/**
 * Trait get list for model
 *
 * @method latest()
 */
trait GetListLatest
{
    /**
     * Get latest destination list
     *
     * @return mixed
     */
    public function getListLatest()
    {
        return $this->latest()->get();
    }
}
