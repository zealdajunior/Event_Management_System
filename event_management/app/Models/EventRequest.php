namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRequest extends Model
{
    protected $table = 'event_requests';

    protected $fillable = [
        'user_id',
        'event_title',
        'event_description',
        'start_date',
        'end_date',
        'venue',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}