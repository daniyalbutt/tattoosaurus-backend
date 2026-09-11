<?php
// app/Models/ArtistProfile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;
use Nnjeim\World\Models\City;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArtistProfile extends Model
{
    protected $fillable = [
        'user_id','country_id','state_id','city_id','bio','avatar','portfolio_images',
        'social_links','availability','response_time','hourly_rate','faqs','styles',
        'is_top', 'is_featured', 'shop_name', 'flash_images', 'featured_source', 'featured_portfolio_index', 'slug'
    ];

    protected $casts = [
        'portfolio_images' => 'array',
        'social_links' => 'array',
        'faqs' => 'array',
        'styles' => 'array',
        'is_top' => 'boolean',
        'is_featured' => 'boolean',
        'flash_images' => 'array',
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
            $this->shop_name,
            $this->country_id,
            $this->availability,
            $this->response_time,
            $this->hourly_rate,
            !empty($this->social_links),
            !empty($this->faqs),
            !empty($this->styles),
            !empty($this->portfolio_images),
            !empty($this->flash_images),
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

    public function getDisplayImageAttribute(): ?string
    {
        foreach ([$this->featured_image, $this->avatar] as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                return asset('storage/' . $path);
            }
        }
        return null; // let the view pick the placeholder
    }

    public static function generateUniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = Str::slug($base) ?: 'artist';
        $original = $slug;
        $i = 1;

        while (self::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()) {
            $slug = $original . '-' . $i++;
        }
        return $slug;
    }

    public function getDisplayAvatarAttribute(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&size=80';
    }

    public function getLocationAttribute(): string
    {
        return collect([$this->city?->name, $this->country?->name])
            ->filter()
            ->implode(', ');
    }
}