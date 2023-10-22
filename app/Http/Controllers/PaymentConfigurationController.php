<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentConfigurationRequest;
use App\Models\Currency;
use App\Models\PaymentConfiguration;
use Illuminate\Http\Request;

class PaymentConfigurationController extends Controller
{
    public function payment_configuration()
    {
        try {
            $payment_configuration = PaymentConfiguration::with(['currency'])->first();
            if($payment_configuration){
                return response()->json(['success'=>true, 'data'=>$payment_configuration]);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    public function getPaymentConfiguration() {
        $payment_configuration = PaymentConfiguration::first();

        return $this->sendResponse($payment_configuration);
    }

    public function store(PaymentConfigurationRequest $request) {
        $data = $request->all();

        $payment_configuration = PaymentConfiguration::first() ?? new PaymentConfiguration();

        $payment_configuration->fill($data);
        $payment_configuration->save();

        return $this->sendResponse($payment_configuration->refresh(), 'Payment Configuration saved sucessfully');
    }

    public function getCurrencies()
    {
        $currencies = Currency::get(['id', 'description', 'symbol', 'description']);

        return $this->sendResponse($currencies);
    }
}
