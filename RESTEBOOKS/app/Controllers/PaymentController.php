<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Payment;
use App\Models\Subscription;

class PaymentController extends Controller
{
    private array $appConfig;

    public function __construct()
    {
        $this->appConfig = require BASE_PATH . '/config/app.php';
    }

    public function pricing(): void
    {
        $this->view('pricing/index', [
            'title' => 'Pricing — RESTEBOOKS',
            'price' => $this->appConfig['subscription_price_ngn'],
            'book' => $this->input('book'),
        ]);
    }

    /** Kicks off checkout: creates a pending payment row + redirects to gateway (or stub). */
    public function initialize(): void
    {
        if (!Auth::checkUser()) {
            $this->redirect('/login');
            return;
        }

        $user = Auth::user();
        $reference = 'RB_' . strtoupper(bin2hex(random_bytes(8)));
        $amount = $this->appConfig['subscription_price_ngn'];

        Payment::insert([
            'user_id' => $user['id'],
            'reference' => $reference,
            'gateway' => 'paystack',
            'amount' => $amount,
            'currency' => 'NGN',
            'status' => 'pending',
        ]);

        if ($this->appConfig['paystack']['mode'] === 'stub') {
            // No real keys configured yet — go straight to the verify step,
            // which simulates a successful gateway callback.
            $this->redirect('/payment/verify?reference=' . $reference . '&stub=1');
            return;
        }

        $response = $this->callPaystackInitialize($user, $reference, $amount);

        if (!$response || empty($response['status'])) {
            $this->flash('error', 'Could not start payment. Please try again.');
            $this->redirect('/pricing');
            return;
        }

        $this->redirect($response['data']['authorization_url']);
    }

    /** Handles both the gateway redirect-back and the stubbed local flow. */
    public function verify(): void
    {
        $reference = (string) $this->input('reference', '');
        $isStub = $this->input('stub') === '1';
        $payment = Payment::findByReference($reference);

        if (!$payment) {
            $this->flash('error', 'We could not find that transaction.');
            $this->redirect('/pricing');
            return;
        }

        $verifiedSuccess = $isStub ? true : $this->callPaystackVerify($reference);

        if (!$verifiedSuccess) {
            Payment::update($payment['id'], ['status' => 'failed']);
            $this->flash('error', 'Payment could not be verified. You have not been charged, or the charge will be reversed.');
            $this->redirect('/pricing');
            return;
        }

        $subscriptionId = Subscription::activate(
            (int) $payment['user_id'],
            $this->appConfig['subscription_duration_days']
        );

        Payment::update($payment['id'], [
            'status' => 'success',
            'subscription_id' => $subscriptionId,
            'paid_at' => date('Y-m-d H:i:s'),
            'gateway_response' => $isStub ? 'stub_mode_auto_success' : 'verified_via_paystack_api',
        ]);

        $this->flash('success', 'Payment successful — your Premium subscription is now active!');
        $this->redirect('/dashboard/subscription');
    }

    private function callPaystackInitialize(array $user, string $reference, float $amount): ?array
    {
        $secretKey = $this->appConfig['paystack']['secret_key'];
        $url = 'https://api.paystack.co/transaction/initialize';

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $secretKey,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'email' => $user['email'],
                'amount' => $amount * 100, // kobo
                'reference' => $reference,
                'callback_url' => rtrim($this->appConfig['url'], '/') . '/payment/verify',
            ]),
        ]);

        $raw = curl_exec($ch);
        curl_close($ch);

        return $raw ? json_decode($raw, true) : null;
    }

    private function callPaystackVerify(string $reference): bool
    {
        $secretKey = $this->appConfig['paystack']['secret_key'];
        $url = 'https://api.paystack.co/transaction/verify/' . rawurlencode($reference);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $secretKey],
        ]);

        $raw = curl_exec($ch);
        curl_close($ch);
        $result = $raw ? json_decode($raw, true) : null;

        return $result && ($result['data']['status'] ?? '') === 'success';
    }
}
