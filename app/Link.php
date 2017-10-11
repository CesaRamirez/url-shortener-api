<?php

namespace App;

use App\Exceptions\CodeGenerationException;
use App\Helpers\Math;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'original_url',
        'code',
        'requested_count',
        'used_count',
    ];

    /**
     * Generation Code for Link.
     */
    public function getCode()
    {
        if ($this->id === null) {
            throw new CodeGenerationException();
        }

        return (new Math())->toBase($this->id);
    }

    /**
     * Get Link model by Code.
     *
     * @param string $code
     */
    public function byCode($code)
    {
        return $this->where('code', $code);
    }

    /**
     * Generate shortened URL from code.
     *
     * @return string
     */
    public function shortenedUrl()
    {
        if (! $this->code) {
            return;
        }

        return env('CLIENT_URL').'/'.$this->code;
    }
}
