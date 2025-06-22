<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'customer';

    /**
     * Primary key dari tabel.
     *
     * @var string
     */
    protected $primaryKey = 'customer_id';

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
        'customer_id',
        'full_name',
        'email',
        'phone_number',
        'password',
        'customer_address',
        'username_customer',
    ];

    /**
     * Casting atribut ke tipe data yang sesuai.
     *
     * @var array
     */
    // protected $casts = [
}
