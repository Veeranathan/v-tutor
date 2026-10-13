<?php
use Illuminate\Support\Str;

if (!function_exists('public_asset')) {
    function public_asset($path)
    {
        if (app()->environment('local')) {
            return asset($path);
        }
        return url('public/' . $path);
    }
}

if (!function_exists('secure_shuffle')) {
    function secure_shuffle(string $input): string {
        $chars = preg_split('//u', $input, -1, PREG_SPLIT_NO_EMPTY);
        $n = count($chars);
        for ($i = $n - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$chars[$i], $chars[$j]] = [$chars[$j], $chars[$i]];
        }
        return implode('', $chars);
    }
}

if (!function_exists('generateGJRandomPassword')) {
    function generateGJRandomPassword($length = 8) {
        $upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower   = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $special = '!@#$%^&*()-_=+<>?';

        $password = '';
        $password .= $upper[random_int(0, strlen($upper) - 1)];
        $password .= $lower[random_int(0, strlen($lower) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $special[random_int(0, strlen($special) - 1)];

        $all = $upper . $lower . $numbers . $special;
        for ($i = strlen($password); $i < $length; $i++) {
            $password .= $all[random_int(0, strlen($all) - 1)];
        }

        return secure_shuffle($password);
    }

    if (!function_exists('getShortState')) {
        function getShortState(string $fullStateName): ?string  {
            $states = config('tutor_form.australian_states_timezone');

            foreach ($states as $state) {
                if (strcasecmp($state['state'], trim($fullStateName)) === 0) {
                    return $state['sht_state'];
                }
            }

            return $fullStateName;
        }
    }

}