<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
                $this->teamsError($e->getMessage());

        });
    }

    public function teamsError($error)
    {
        try {
            $user = Auth::user();

            $client = new Client();

            $response = $client->post('https://ontourmedia.webhook.office.com/webhookb2/198a1ab4-67a6-4c32-b403-b7c42322e805@ec6de3af-6f83-40e0-a7fd-91412aeaa222/IncomingWebhook/9ab5bf1e63ce4b90b2886c15def3f66e/6501bdec-e4ad-403b-b9ef-407caed792b1', [
                'json' => [
                    'text' => "Neuer Fehler: " . $error . "  \n \n" . ($user ? $user->name : 'Unknown User')
                ]
            ]);
        } catch (Exception $ex) {
            // You might want to log any exceptions when trying to report to Teams
            \Log::error('Failed to send error to Microsoft Teams: ' . $ex->getMessage());
        }
    }
}
