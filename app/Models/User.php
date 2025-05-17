namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'users_mysql';
    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password'];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}