<?php

namespace App\Http\Controllers;

use App\Package;
use App\Payment as PaymentModel;
use Illuminate\Http\Request;
use Shetabit\Payment\Exceptions\InvalidPaymentException;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Payment\Invoice;

class PaymentController extends Controller
{
	public function pay()
	{
		$package_id = 1;
		$user_id    = 1;
		$package    = Package::find($package_id);
		$extra      = [
			'package_id' => $package_id,
		];
		
		$pay = PaymentModel::create([
										'user_id' => $user_id,
										'amount'  => $package->price,
										'extra'   => serialize($extra),
									]);
		
		$invoice = new Invoice;
		
		$invoice->amount(100);
		//		$invoice->amount((int)$pay->amount);
		
		$invoice->detail(['name' => 'mohammad' , 'email' => 'mohammad@yahoo.com' , 'mobile' => '09352864812' ,'description' => 'درحال انجامه']);
		
		return Payment::purchase($invoice, function ($driver, $transactionId) use ($pay) {
			$pay->update([
							 'ref_id' => $transactionId,
						 ]);
		})->pay();
	}
	
	public function verify(Request $request)
	{
		$transaction_id = $request->get('Authority');
		$pay            = PaymentModel::where('ref_id', $transaction_id)->first();
		try {
			Payment::amount(100)->transactionId($transaction_id)->verify();
			//			Payment::amount((int)$pay->amount)->transactionId($transaction_id)->verify();
			
			$pay->update([
							 'status' => '1',
						 ]);
			
			return dd('pardakhht shod');
			
		} catch (InvalidPaymentException $exception) {
			
			/**
			 * when payment is not verified , it throw an exception.
			 * we can catch the excetion to handle invalid payments.
			 * getMessage method, returns a suitable message that can be used in user interface.
			 **/
			echo $exception->getMessage();
		}
	}
}
