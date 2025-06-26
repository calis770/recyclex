// app/Models/User.php
<?php
namespace App\Models;
// ...
class User extends Authenticatable
{
    // ...
    public function customer()
    {
        // Sesuaikan 'user_id' jika nama kolom di tabel 'customers' berbeda
        // Sesuaikan 'id' jika primary key tabel 'users' berbeda
        return $this->hasOne(Customer::class, 'user_id', 'id');
    }
}