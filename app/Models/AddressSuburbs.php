<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressSuburbs extends Model
{
    use HasFactory;

    protected $table = 'address_suburbs'; // Ensures the model uses the 'address_suburbs' table

    // If you ever need to mass assign properties (e.g., when seeding data),
    // you would uncomment and list them here. For fetching data as we are doing,
    // this property is not strictly necessary.
    // protected $fillable = ['state_id', 'suburb_name', 'pincode'];

    /**
     * Define the relationship to the State model.
     * A suburb belongs to one state.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}