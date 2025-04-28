<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\ReferralBonus;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
class PaymentCallbackController extends Controller
{
    public function callback(Request $request)
    {
        // Step 1: Ambil signature dari Tripay dan generate ulang pakai private key
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $privateKey = config('tripay.private_key');
        $generatedSignature = hash_hmac('sha256', $json, $privateKey);

        if ($callbackSignature !== $generatedSignature) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid signature',
            ], 403);
        }

        // Step 2: Cek event dari header, hanya proses event payment_status
        if ($request->server('HTTP_X_CALLBACK_EVENT') !== 'payment_status') {
            return Response::json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ], 400);
        }

        // Step 3: Decode JSON body
        $data = json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid JSON payload',
            ], 400);
        }

        // Step 4: Ambil data utama dari callback
        $merchantRef     = $data->merchant_ref ?? null;
        $tripayReference = $data->reference ?? null;
        $status          = strtoupper($data->status ?? '');
        $isClosedPayment = $data->is_closed_payment ?? false;

        if (! $merchantRef || ! $tripayReference) {
            return Response::json([
                'success' => false,
                'message' => 'Missing merchant_ref or reference',
            ], 400);
        }

        // Step 5: Proses jika metode pembayaran sudah ditutup (closed)
        if ($isClosedPayment) {
            $transaction = Transaction::where('merchant_ref', $merchantRef)
                ->where('reference', $tripayReference)
                ->first();
            if (! $transaction) {
                return Response::json([
                    'success' => false,
                    'message' => 'Transaction not found',
                ], 404);
            }

            // Hanya proses jika sebelumnya statusnya masih UNPAID
            if ($transaction->status !== 'UNPAID') {
                return Response::json([
                    'success' => false,
                    'message' => 'Transaction already processed',
                ]);
            }

            // Step 6: Update status berdasarkan dari callback Tripay
            switch ($status) {
                case 'PAID':
                    $transaction->update([
                        'status' => 'PAID'
                    ]);
                    License::create([
                        'transaction_id' => $transaction->id,
                        'user_id' => $transaction->user_id,
                        'product_id' => $transaction->product_id,
                        'license_code' => strtoupper(Str::uuid()),
                        'valid_until' => now()->addMonths($transaction->product->duration_days)->endOfDay()
                    ]);

                    $yangDapatBonus = User::where('referral_code', $transaction->user->referred_by)->first();
                    if ($yangDapatBonus) {
                        ReferralBonus::create([
                            'transaction_id' => $transaction->id,
                            'user_id' => $yangDapatBonus->id,
                            'referred_user_id' => $transaction->user_id,
                            'amount' => $transaction->amount * 0.10
                        ]);
                    }
                    break;

                case 'EXPIRED':
                    $transaction->update(['status' => 'EXPIRED']);
                    break;

                case 'FAILED':
                    $transaction->update(['status' => 'FAILED']);
                    break;
                case 'UNPAID':
                    // Bisa di-skip atau log aja
                    break;

                default:
                    return Response::json([
                        'success' => false,
                        'message' => 'Unrecognized payment status',
                    ], 400);
            }

            return Response::json([
                'success' => true,
                'message' => 'Callback processed successfully',
            ]);
        }

        // Kalau bukan closed payment
        return Response::json([
            'success' => false,
            'message' => 'Not a closed payment transaction',
        ], 400);
    }
}
