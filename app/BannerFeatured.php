<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerFeatured extends Model
{
    public const CODDING = 1;
    public const GAMES = 2;
    public const WEB_DEVELOPMENT = 3;
    public const DIGITAL_DESIGN = 4;
    public const ROBOTIC = 5;

    protected static array $DATA = [
        self::CODDING => 'Programación',
        self::GAMES => 'Videojuegos',
        self::WEB_DEVELOPMENT => 'Audiovisual',
        self::DIGITAL_DESIGN => 'Influencers y RRSS',
        self::ROBOTIC => 'Robótica',
    ];

    public $timestamps = false;
    protected $table = 'banner_featured';

    public function getDescription(): string
    {
        return self::$DATA[ $this->category_id ];
    }
}
