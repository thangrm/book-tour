<?php

namespace App\Traits;

/**
 * Trait get list for model
 *
 * @method latest()
 */
trait GetListData
{
    /**
     * Get list latest
     *
     * @return mixed
     */
    public function getListLatest()
    {
        return $this->latest()->get();
    }

    /**
     * Get list active
     *
     * @return mixed
     */
    public function getListActive(int $limit = 0)
    {
        $query = $this->where('status', 1)->latest();
        if ($limit != 0) {
            $query->limit($limit);
        }

        return $query->get();
    }
}
