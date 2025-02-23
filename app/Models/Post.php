<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    // use HasFactory;
    // jika nama tbale tidak sama gunakan protected --------------------------------
    // protected $table = 'blog_posts';
    // ------------------------------------------------------------

    // fillable agar bisa mengisi data secara manual lewat tinker
    protected $fillable = ['title', 'author', 'slug', 'body'];
    protected $with = ['category', 'author'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        // if(isset($filters) ? $filters['search'] : false){
        //     $query->where('title', 'like', '%' . request('search') . '%');
        // }

        // bisa menggunakan when untuk flexible
        $query->when(
            $filters['search'] ??= false,
            fn ($query, $search) =>
            $query->where('title', 'like', '%' . $search . '%')
        );

        $query->when(
            $filters['category'] ??= false,
            fn ($query, $category) =>
            $query->whereHas('category', fn($query)=>$query->where('slug', $category))
        );

        $query->when(
            $filters['author'] ??= false,
            fn ($query, $author) =>
            $query->whereHas('author', fn($query)=>$query->where('username', $author))
        );
    }
}
