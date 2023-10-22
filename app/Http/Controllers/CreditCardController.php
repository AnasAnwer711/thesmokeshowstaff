<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditCardRequest;
use App\Http\Traits\StripePayment;
use App\Models\PaymentConfiguration;
use App\Models\User;
use App\Models\UserCard;
use App\Models\UserTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditCardController extends Controller
{
    use StripePayment;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.credit-card.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreditCardRequest $request)
    {
        try {
            // dd($request->all());
            $pc = PaymentConfiguration::first();
            if($pc){
                if(!$pc->secret_key)
                   return response()->json(['message'=>'Stripe payment keys not configured.'], 422);
            } else {
                return response()->json(['message'=>'Stripe payment not configured.'], 422);
            }
            
            $user = User::find(auth()->user()->id);
            $expiry = explode("/",$request->expiry);
            if(!isset($expiry[1])){
                return response()->json(['message'=>'Expiry year field is requied'], 422);
            }
            $month = trim($expiry[0], " ");
            $year = trim($expiry[1], " ");

            $data['card'] = [
                'name' => $request->name,
                'number' => str_replace(' ', '', $request->number),
                'exp_month' => $month,
                'exp_year' => $year,
                'cvc' => $request->cvc,
            ];
            DB::beginTransaction();
            $ucd = $user->addCardDetail($data);
            if($ucd['success']){
                // Charge $1 on card
                $card = UserCard::where('stripe_card_id', $ucd['card_id'])->first();
                if($card){

                    $card->makeCardAndCharge(1, 'Verification fee');

                }
                $uc = UserCard::where('user_id', auth()->user()->id)->get();
                DB::commit();
                return response()->json(['success'=>true, 'data'=>$uc]);
                
            } else {
                DB::rollBack();
                return response()->json(['message'=>$ucd['message']], 422);

            }
        // $this->postPaymentStripe($request->all());
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cards_count = UserCard::where('user_id', auth()->user()->id)->count();
            if($cards_count <= 1){
                return response()->json(['message'=>'You need to have at least one card'], 422);
            }
            $uc = UserCard::where('id', $id)->delete();
            return response()->json(['success'=>true]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function get_cards()
    {
        $cards = UserCard::where('user_id', auth()->user()->id)->get();
        return response()->json(['success'=>true, 'data'=>$cards]);

    }
}