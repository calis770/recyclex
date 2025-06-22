<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exchange_item extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'exchange_item';

    /**
     * Primary key dari tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id_item';

    /**
     * Primary key bukan auto-increment dan bukan integer.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Tipe data primary key (karena char, maka string).
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Kolom-kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'id_item',
        'item_name',
        'location',
        'item_quantity',
    ];

    /**
     * Casting atribut ke tipe data yang sesuai.
     *
     * @var array
     */
    // protected $casts = [
}