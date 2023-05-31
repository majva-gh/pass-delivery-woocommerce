<?php
return [
    /**
     * API Token Key (string)
     * Accepted value:
     * https://passdelivery.readme.io/reference/get-api-token
     */

    'api_key' => env('PASS_DELIVERY_API_KEY'),


    /**
     * API Token Key (string)
     * Accepted value:
     * Test Token: https://passdelivery.readme.io/reference/sandbox-enviroment
     */
    'test_api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI3IiwianRpIjoiMjU0NjAyODg0ZDA2ZTIxYjJjMzliZTJmODE5NTg0YThhMGMyYzIxZmNjNzA1MDc5YzMzOThlNzYyMTAwY2IxNTdhMzBlOTI1NjY1MjVjZjAiLCJpYXQiOjE2NzcwNzgyMjAuMDY0ODIyLCJuYmYiOjE2NzcwNzgyMjAuMDY0ODI1LCJleHAiOjE3MDg2MTQyMjAuMDYwNzAxLCJzdWIiOiI3MzY3Iiwic2NvcGVzIjpbXX0.bvb0SusKmr_dAHRG0Zj2GBC9R53mhD-5a-HyAvoJfRbz422hjenNRzTB3BO6x76O1xF9yZ-B15BeWdCzJd_7Dx13SZkaHpflN8iGoYWzuK09vYXSNjhxVKggBBmDocrzhreRCwA9PUKQ6ePDhdNuAIcvAnlOE3BT4DFnHVhLzIwR2fBaFnxsF6vbL9Z_RblBwXkQ8w-OxC6AMI4nhFTLdctz1RUrtd2ONhFKZNlYzzo2FvRla_1qJUHbZ01EYvSWVQnTR3wS_ihClvWN3laDb2Ps7epjDW9MqTaKTGhHLTbWSlRMn2e1hqQxtpGd-28y2EQK_gZuiGvmQ4drJAuf6JqgJHA7wDPPYdlylg4pPza2ehv4HL-BCmewpL7qEwbadUcsJiuuOPz1yZZmodp8t9FMB5T5P1ivraCQKvKJqdRDpksj_L1RgK5Ew8rHA6ya0M9f_h7lSyKOPqppiXA9rbPvuLT1mJzSJutgDAK05hatfMc5VuTXw330EfxpiNI4x9_xivm22zXStvxS3Vi_iPeI-AY8zYI4kMFtR620XKUMnjOZR7EIGnjb3hp9s-enlTSJyo-DkNB2jX7ggXF5YKrMkMkZ4Ic26017aarh3bvy_DX4zs6UGowkGGNx8x7bsR4Y7AhcGPFac4gSNLtD73CcTFjuytp1J_UJZV05LXM',

    /**
     * Test Mode (boolean)
     * Accepted value: true for the test mode or false for the live mode
     */
    'test_mode' => env('PASS_DELIVERY_TEST_MODE',true),
];