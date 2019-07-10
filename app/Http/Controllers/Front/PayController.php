<?php

namespace App\Http\Controllers\Front;

use App\Package;
use App\Payment as PaymentModel;
use App\User;
use App\UserPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Shetabit\Payment\Exceptions\InvalidPaymentException;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Payment\Invoice;

class PayController extends Controller
{
	public function index(Package $package)
	{
		$package_id = $package->id;
		$user       = \auth()->user();
		$user_id    = $user->id;
		$extra      = [
			'package_id' => $package_id,
		];
		
		$pay = PaymentModel::create([
										'user_id' => $user_id,
										'amount'  => $package->price,
										'extra'   => serialize($extra),
									]);
		
		$invoice = new Invoice;
		
		$invoice->amount((int) $pay->amount);
		
		$invoice->detail([
							 'name'        => $user->name,
							 'email'       => $user->email,
							 'mobile'      => $user->mobile,
							 'description' => "شماره سفارش $pay->id - کاربر $user->name - پکیج شماره $package_id",
						 ]);
		
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
		$extra          = unserialize($pay->extra);
		if (isset($extra['package_id'])) {
			$package = Package::where('id', $extra['package_id'])->first();
			
		}
		
		try {
			Payment::amount((int) $pay->amount)->transactionId($transaction_id)->verify();
			$user    = \auth()->user();
			$user_id = $user->id;
			$pay->update([
							 'status' => '1',
						 ]);
			if (isset($extra['package_id'])) {
				UserPackage::create([
										'user_id'    => $user_id,
										'package_id' => $extra['package_id'],
										'start_at'   => now(),
										'finish_at'  => date('Y-m-d H:i:s', strtotime('+' . $package->limit_days . ' day', time())),
									]);
				
				User::find($user_id)->first()->update([
														  'send_limit' => $user->send_limit + $package->send_limit,
													  ]);
			} elseif (isset($extra['credit'])) {
				User::find($user_id)->first()->update([
														  'send_limit' => $user->send_limit + $extra['credit'],
													  ]);
				return redirect()->route('credit-index');
			}
			
			return view('payments.verify', [ 'code' => 200, 'transaction_id' => $transaction_id ]);
			
		} catch (InvalidPaymentException $exception) {
			return view('payments.verify', [ 'code' => 400, 'exception' => $exception ]);
		}
	}
}
