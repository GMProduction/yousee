<?php

if (!function_exists('base_url')) {
    function base_url(): string
    {
        return app()->environment('local')
            ? 'http://127.0.0.1:8000/'
            : 'https://www.yousee-indonesia.com/';
    }
}
