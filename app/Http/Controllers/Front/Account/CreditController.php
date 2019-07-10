<?php

namespace App\Http\Controllers\Front\Account;

use App\Http\Controllers\Controller;
use App\Payment as PaymentModel;
use Illuminate\Http\Request;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Payment\Invoice;

class CreditController extends Controller
{
	public function index()
	{
		
		return view('auth.account.credit.index');
	}
	
	public function pay(Request $request)
	{
		$user      = \auth()->user();
		$user_id   = $user->id;
		$sms_price = 120;
		$extra     = [
			'credit' => $request->get('credit'),
		];
		
		$pay = PaymentModel::create([
										'user_id' => $user_id,
										'amount'  => $sms_price * $request->get('credit'),
										'extra'   => serialize($extra),
									]);
		
		$invoice = new Invoice;
		
		$invoice->amount((int) $pay->amount);
		
		$invoice->detail([
							 'name'        => $user->name,
							 'email'       => $user->email,
							 'mobile'      => $user->mobile,
							 'description' => "شماره سفارش $pay->id - کاربر $user->name - افزایش اعتبار " . $request->get('credit'),
						 ]);
		
		return Payment::purchase($invoice, function ($driver, $transactionId) use ($pay) {
			$pay->update([
							 'ref_id' => $transactionId,
						 ]);
		})->pay();
	}
}
