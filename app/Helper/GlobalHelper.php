<?php

if (!function_exists('base_url')) {
    function base_url(): string
    {
        return app()->environment('local')
            ? 'https://www.yousee-indonesia.com/'
            : 'https://www.yousee-indonesia.com/';
    }
}
