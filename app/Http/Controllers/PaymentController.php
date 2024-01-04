<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout()
    {
        request()->user()
            ->newSubscription('default', request()->plan)
            ->create(request()->paymentMethod);
        // ->allowPromotionCodes()
        // ->checkout([
        //     'success_url' => route('payment-success'),
        //     'cancel_url' => route('payment-cancel'),
        // ]);
        Session::flash('status', 'Payment successfully');
        return redirect()->route('documents');
    }

    public function pay($plan)
    {
        if (auth()->user()->subscribed()) {
            return redirect()->route('profile');
        }
        $plan_desc = $plan == 'monthly' ? '$9 monthly' : '$89 yearly';
        $plan = $plan == 'monthly' ? 'price_1OULgeHFk0f5ieaWSmgNbwcC' : 'price_1OULh5HFk0f5ieaWUaxAgi89';
        return view('payment.subscription-paymentmethod', [
            'intent' => request()->user()->createSetupIntent(),
            'plan' => $plan,
            'plan_desc' => $plan_desc,
        ]);
    }
}
