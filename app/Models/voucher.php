<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'voucher';

    /**
     * Primary key dari tabel.
     *
     * @var string
     */
    protected $primaryKey = 'voucher_id';

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
        'voucher_id',
        'discount',
        'expiration_date',
    ];

    /**
     * Casting atribut ke tipe data yang sesuai.
     *
     * @var array
     */
    // protected $casts = [
}