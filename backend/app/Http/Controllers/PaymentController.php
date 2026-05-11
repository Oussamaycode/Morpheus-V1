<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Payment;
use App\Models\Subscription;
use App\Http\Controllers\VirtualMachineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;


class PaymentController extends Controller
{
    // Step 1: User clicks "Buy Plan" → redirect to PayPal
public function checkout(Plan $plan)
{
    $token = $this->getAccessToken();

    $response = Http::withoutVerifying()
        ->withToken($token)
        ->post('https://api.sandbox.paypal.com/v2/checkout/orders', [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value'         => $plan->price,
                ],
            ]],
            'application_context' => [
                'return_url' => route('payment.success', [
                                'user_id' => auth()->id(),
                                'plan_id' => $plan->id,
                            ]),
                'cancel_url' => route('payment.cancel'),
            ],
        ]);

    $approvalUrl = collect($response->json('links'))
        ->firstWhere('rel', 'approve')['href'];

    // 👇 return the URL instead of redirecting
    return response()->json(['approval_url' => $approvalUrl]);
}

     
    public function success(Request $request)
    {
          

        $token   = $this->getAccessToken();
        $orderId = $request->query('token');

        $user = User::findOrFail($request->query('user_id'));
        $plan = Plan::findOrFail($request->query('plan_id'));
        

        // Charge the user
        $response = Http::withoutVerifying()->withToken($token)
            ->post("https://api.sandbox.paypal.com/v2/checkout/orders/{$orderId}/capture");

        // If payment failed, go back
        /*if ($response->json('status') !== 'COMPLETED') {
            return redirect('/plans')->with('error', 'Payment failed.');
        }
        */


        // Save the payment
        Payment::create([
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'paypal_order_id' => $orderId,
            'amount'          => $plan->price,
        ]);

        // Save the subscription
        Subscription::create([
            'user_id'  => $user->id,
            'plan_id'  => $plan->id,
            'status'   => 'active',
            'ends_at'  => now()->addMonth(),
        ]);

        app(VirtualMachineController::class)->provision($user->id,$plan->id);

        //return view('payment.success');
    }

    // User cancelled
    public function cancel()
    {
        return view('payment.cancel');
    }

    // Get PayPal access token
    private function getAccessToken(): string
    {
        $response = Http::withoutVerifying()->withBasicAuth(
            config('services.paypal.client_id'),
            config('services.paypal.secret')
        )->asForm()->post('https://api.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);

        return $response->json('access_token');
    }
}