<?php

namespace Managefaster\Database\Traits;

use Illuminate\Support\Str;

trait SlugTrait
{
    protected string $slugKey = '';
    protected string $slugTakeValue = '';

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        if(!empty($this->slugKey) && !empty($this->slugTakeValue)) {
            static::creating(function ($model) {
                $slug = Str::slug($model[$this->slugTakeValue]);
                $model[$this->slugKey] = self::generateUniqueSlug($slug);
            });

            static::updating(function ($model) {
                if($model->isDirty($this->slugTakeValue)) {
                    $slug = Str::slug($model->name);
                    $model->slug = self::generateUniqueSlug($slug, $model->id);
                }
            });
        }
    }

    /**
     * Generate a unique slug.
     *
     * @param string $slug
     * @param int|null $id
     * @return string
     */
    protected static function generateUniqueSlug($slug, $id = null)
    {
        $originalSlug = $slug;
        $index = 1;

        while (static::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $index++;
        }

        return $slug;
    }
}