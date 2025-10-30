<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service for sending emails via Brevo (formerly Sendinblue) API
 */
class BrevoMailService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $credentials = Setting::getBrevoApiCredentials();
        $this->apiKey = $credentials['key'];
        $this->baseUrl = $credentials['base_url'] ?? 'https://api.brevo.com';
        $this->baseUrl = rtrim($this->baseUrl, '/');
    }

    /**
     * Check if Brevo API is properly configured
     * 
     * @return bool
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Send a transactional email via Brevo API
     * 
     * @param array $data Email data
     * @return array Response with 'success' boolean and 'message' or 'data'
     */
    public function sendTransactionalEmail(array $data): array
    {
        if (!$this->isConfigured()) {
            Log::warning('Brevo API not configured. Email not sent.', ['to' => $data['to'] ?? 'unknown']);
            return [
                'success' => false,
                'message' => 'Brevo API is not configured. Please configure it in settings.',
            ];
        }

        try {
            $payload = [
                'sender' => [
                    'name' => $data['sender_name'] ?? config('mail.from.name', 'XtraXtra'),
                    'email' => $data['sender_email'] ?? config('mail.from.address', 'noreply@xtraxtra.com'),
                ],
                'to' => [
                    [
                        'email' => $data['to']['email'],
                        'name' => $data['to']['name'] ?? '',
                    ]
                ],
                'subject' => $data['subject'],
                'htmlContent' => $data['html_content'],
            ];

            // Optional: Add text content
            if (isset($data['text_content'])) {
                $payload['textContent'] = $data['text_content'];
            }

            // Optional: Add reply-to
            if (isset($data['reply_to'])) {
                $payload['replyTo'] = [
                    'email' => $data['reply_to']['email'],
                    'name' => $data['reply_to']['name'] ?? '',
                ];
            }

            // Optional: Add tags
            if (isset($data['tags'])) {
                $payload['tags'] = $data['tags'];
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'api-key' => $this->apiKey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/v3/smtp/email', $payload);

            if ($response->successful()) {
                Log::info('Email sent successfully via Brevo', [
                    'to' => $data['to']['email'],
                    'subject' => $data['subject'],
                    'message_id' => $response->json('messageId'),
                ]);

                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'Email sent successfully',
                ];
            }

            Log::error('Failed to send email via Brevo', [
                'status' => $response->status(),
                'response' => $response->json(),
                'to' => $data['to']['email'],
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send email: ' . ($response->json('message') ?? 'Unknown error'),
                'error' => $response->json(),
            ];

        } catch (\Exception $e) {
            Log::error('Exception while sending email via Brevo', [
                'exception' => $e->getMessage(),
                'to' => $data['to']['email'] ?? 'unknown',
            ]);

            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Send email using a Brevo template
     * 
     * @param array $data Email data with template_id
     * @return array Response with 'success' boolean and 'message' or 'data'
     */
    public function sendTemplateEmail(array $data): array
    {
        if (!$this->isConfigured()) {
            Log::warning('Brevo API not configured. Template email not sent.', ['to' => $data['to'] ?? 'unknown']);
            return [
                'success' => false,
                'message' => 'Brevo API is not configured. Please configure it in settings.',
            ];
        }

        try {
            $payload = [
                'templateId' => $data['template_id'],
                'to' => [
                    [
                        'email' => $data['to']['email'],
                        'name' => $data['to']['name'] ?? '',
                    ]
                ],
                'params' => $data['params'] ?? [],
            ];

            // Optional: Override sender
            if (isset($data['sender_name']) || isset($data['sender_email'])) {
                $payload['sender'] = [
                    'name' => $data['sender_name'] ?? config('mail.from.name', 'XtraXtra'),
                    'email' => $data['sender_email'] ?? config('mail.from.address', 'noreply@xtraxtra.com'),
                ];
            }

            // Optional: Add tags
            if (isset($data['tags'])) {
                $payload['tags'] = $data['tags'];
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'api-key' => $this->apiKey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/v3/smtp/email', $payload);

            if ($response->successful()) {
                Log::info('Template email sent successfully via Brevo', [
                    'to' => $data['to']['email'],
                    'template_id' => $data['template_id'],
                    'message_id' => $response->json('messageId'),
                ]);

                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'Template email sent successfully',
                ];
            }

            Log::error('Failed to send template email via Brevo', [
                'status' => $response->status(),
                'response' => $response->json(),
                'to' => $data['to']['email'],
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send template email: ' . ($response->json('message') ?? 'Unknown error'),
                'error' => $response->json(),
            ];

        } catch (\Exception $e) {
            Log::error('Exception while sending template email via Brevo', [
                'exception' => $e->getMessage(),
                'to' => $data['to']['email'] ?? 'unknown',
            ]);

            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Test the Brevo API connection
     * 
     * @return array Response with 'success' boolean and 'message' or 'data'
     */
    public function testConnection(): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Brevo API is not configured.',
            ];
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'api-key' => $this->apiKey,
                    'Accept' => 'application/json',
                ])
                ->get($this->baseUrl . '/v3/account');

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Brevo API connection successful',
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to connect to Brevo API: ' . ($response->json('message') ?? 'Unknown error'),
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }
}

