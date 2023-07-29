<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\User;
use Laravel\Cashier\Cashier;
use App\Models\Product;

class PaymentController extends Controller
{
    // public function index($id)
    // {
    //     return view('payment.index');
    // }

    public function processPayment(Request $request)
    {   
        
        //check emal id already exist or not
        $user = User::where('email', $request->email)->first();
        
        //create user
        if (!$user) {
            $user = new User();
            $user->name = ucwords($request->name);
            $user->email = strtolower($request->email);
            $user->password = md5($request->email);
            $user->save();
        }
       
        //create customer details
        if (!$user->stripe_id) {
            // If the user does not have a Stripe ID, create a new customer
            $stripeCustomer = $user->createAsStripeCustomer();
        }

        //product details
        $product_id = $request->input('product_id');
        
        //get product details by product id
        $product_details = Product::find($product_id);

        // Charge the customer
        // $user->charge(1000, 'eur');

       return redirect()->route('payment.create')->with('success', 'Payment successful!');
    }

    public function create(){
        return view('payment.success');
    }  
        
}

