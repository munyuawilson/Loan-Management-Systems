<?php
// app/Models/Loan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'customer_id',
        'amount',
        'balance',
        'description',
        'status',
    ];

    // Relationships
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Calculate total payments
    public function totalPaid()
    {
        return $this->payments()->sum('amount_paid');
    }

    // Update balance and status
    public function updateBalance()
    {
        $totalPaid = $this->totalPaid();
        $this->balance = $this->amount - $totalPaid;
        
        if ($this->balance <= 0) {
            $this->balance = 0;
            $this->status = 'cleared';
        } else {
            $this->status = 'running';
        }
        
        $this->save();
    }
}