<?php

    namespace Sfavorite\Musketeers\Facade;

    use Illuminate\Support\Facades\Facade;

    class Musketeers extends Facade {
        protected static function getFacadeAccessor() {
            return 'musketeers';
        }
    }
