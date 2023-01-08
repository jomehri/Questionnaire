<?php

return [

    /**
     * |--------------------------------------------------------------------------
     * | Token expiry minutes
     * |--------------------------------------------------------------------------
     * |
     * | How many minutes a token (sent to user notification through SMS) must be valid before its expiry
     * |
     */

    'token_expiry_minutes' => 2,

    /**
     * Number of results per page for index pages
     */
    'per_page' => env('RESULTS_PER_PAGE', 10),

    /**
     * Current SMS panel
     */
    'notification_channel' => env('NOTIFICATION_CHANNEL'),
];
