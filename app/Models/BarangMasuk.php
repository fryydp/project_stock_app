<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangMasuk extends Model
{
    /**
     * Get the getSuplier that owns the BarangMasuk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getSuplier(): BelongsTo
    {
        return $this->belongsTo(suplier::class, 'suplier_id', 'id');
    }

    /**
     * Get the user that owns the BarangMasuk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getStok(): BelongsTo
    {
        return $this->belongsTo(stok::class, 'Nama_Barang_id', 'id');
    }

    /**
     * Get the Admin_id that owns the BarangMasuk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'Admin_id', 'id');
    }
}
