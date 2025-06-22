<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'cart';

    /**
     * Primary key dari tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id_cart';

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
        'id_cart',
        'quantity',
        'total_price',
    ];

    /**
     * Casting atribut ke tipe data yang sesuai.
     *
     * @var array
     */
    // protected $casts = [
}