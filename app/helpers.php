<?php

if (! function_exists('convertToHoursMins')) {
    function convertToHoursMins($mins) {
        if ($mins < 1) {
            return;
        }
        $hours = floor($mins / 60);
        $minutes = ($mins % 60);
        return sprintf('%02d hour/s %02d minutes', $hours, $minutes);
    }
}