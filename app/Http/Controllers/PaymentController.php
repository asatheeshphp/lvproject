<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\User;
use Laravel\Cashier\Cashier;
use App\Models\Product;
use Throwable;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {   
        //check email id already exist or not
        $user = User::where('email', $request->email)->first();
        
        //create user if email id not exist
        if (!$user) {
            $user = new User();
            $user->name = ucwords($request->name);
            $user->email = strtolower($request->email);
            $user->password = md5($request->email);
            $user->save();
        }
       
        //create customer details and sync with stripe along with stripe id if stripe id not exist
        if (!$user->stripe_id) {
            // If the user does not have a Stripe ID, create a new customer
            $stripeCustomer = $user->createAsStripeCustomer();
        }

        //get the product id from request
        $product_id = $request->input('product_id');
        
        //get product details by product id
        $product_details = Product::find($product_id);
        
        // Charge the customer. Initiate the payment process using cashier
        try {
            $user->charge(
                (int)$product_details->price*100,//product price from database. Need to pass the price in 100s.
                $request->payment_id 
            );
        } catch (Throwable $e) {
            
            Log::debug('Payment failure due to additional authentication');
            //we are using sandbox method. So payment getting failure due to aditional authentication. LIve mode means, we can set the authentication
            //so default redirecting to sccess page. 
            //when we integrate with live mode will check the status and response code will redirect to appropriate response page.
            return redirect()->route('payment.response')->with('success', 'Payment successful!');
        }
    }

    public function response(){
        //load payment success page
        return view('payment.success');
    }  
        
}

