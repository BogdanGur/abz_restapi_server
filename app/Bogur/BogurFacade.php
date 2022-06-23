<?php
namespace App\Bogur;

use Illuminate\Support\Facades\Facade;

class BogurFacade extends Facade {
    public static function getFacadeAccessor() {
        return 'bogur';
    }
}
