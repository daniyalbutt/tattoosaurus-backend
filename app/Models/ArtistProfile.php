<?php
// app/Models/ArtistProfile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;
use Nnjeim\World\Models\City;

class ArtistProfile extends Model
{
    protected $fillable = [
        'user_id','country_id','state_id','city_id','bio','avatar','portfolio_images',
        'social_links','availability','response_time','hourly_rate','faqs','styles',
        'is_top', 'is_featured', 'shop_name', 'flash_images', 'featured_source', 'featured_portfolio_index'
    ];

    protected $casts = [
        'portfolio_images' => 'array',
        'social_links' => 'array',
        'faqs' => 'array',
        'styles' => 'array',
        'is_top' => 'boolean',
        'is_featured' => 'boolean',
        'flash_images' => 'array',
        'social_links' => 'array',
        'availability' => 'array', 
        'styles' => 'array'
    ];

    public function user()    { return $this->belongsTo(User::class); }

    public function country() { return $this->belongsTo(Country::class); }
    public function state()   { return $this->belongsTo(State::class); }
    public function city()    { return $this->belongsTo(City::class); }

    public function getCompletionAttribute(): int
    {
        $fields = [
            $this->bio,
            $this->avatar,
            $this->country_id,
            $this->availability,
            $this->response_time,
            $this->hourly_rate,
            !empty($this->social_links),
            !empty($this->faqs),
            !empty($this->styles),
            !empty($this->portfolio_images),
        ];

        $filled = collect($fields)->filter(fn ($v) => !empty($v))->count();
        return (int) round(($filled / count($fields)) * 100);
    }

    public function getFeaturedImageAttribute(): ?string
    {
        $source = $this->featured_source;
        $index  = $this->featured_portfolio_index;

        // pick the right gallery based on source
        if ($source === 'flash') {
            $images = $this->flash_images ?? [];
        } elseif ($source === 'portfolio') {
            $images = $this->portfolio_images ?? [];
        } else {
            $images = [];
        }

        // return the featured image if the index exists
        if ($index !== null && isset($images[$index])) {
            return $images[$index];
        }

        // fallback: first portfolio image, then avatar
        return ($this->portfolio_images[0] ?? null) ?: $this->avatar;
    }
}