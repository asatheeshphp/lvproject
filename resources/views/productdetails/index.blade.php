<!-- resources/views/products.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>{{ $product_details->name }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
   <style>
      input {
         width: 100%;
      }

      input.InputElement.is-empty.Input.Input--empty {
         border: 1px solid grey !important;
      }
      #card-errors{
         color: red;;
      }
      label.error {
         color: #dc3545;
         font-size: 14px;
    }
   </style>
</head>

<body>
    
    <div id="content" class="col" style="padding-top: 15px;">
        <div class="row mb-3">
            <div class="col-sm">
                <div class="image magnific-popup">
                    <a  href="javascript:;"
                        title="{{ $product_details->name }}"><img
                            src="{{ URL::to('/') }}/images/product.jpeg"                            
                            title="{{ $product_details->name }}" alt="{{ $product_details->name }}" style="padding: 100px 180px;" class="img-thumbnail mb-3"></a>

                </div>
            </div>
            <div class="col-sm">
                <h1>{{ $product_details->name }}</h1>
                <ul class="list-unstyled">
                    <li>{{ $product_details->description }}</li>
                    <li>Availability: Available</li>
                </ul>
                <ul class="list-unstyled">
                    <li>
                        <h2><span class="price-new">&euro; {{ $product_details->price }}</span></h2>
                    </li>
                    <!-- <li>Ex Tax: $500.00</li> -->
                </ul>
                  @if (Session::has('success'))
                           <div class="alert alert-success text-center">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                              <p>{{ Session::get('success') }}</p><br>
                           </div>
                     @endif
                     <br>

                     <form id="payment-form" name="payment-form" action="{{ route('payment.process') }}" method="post">
                           @csrf
                           <input type="hidden" name="payment_id" id="payment_id" value="">
                           <input type="hidden" name="product_id" id="product_id" value="{{ $product_details->id }}"
                              <label for="card-element">
                               <h4>Please enter the credit card details to proceed</h4>
                           </label>
                           <input id="card-holder-name" class="col-md-5" required placeholder="Card holder Name" name="name" type="text" style="margin-bottom: 10px;"><br>
                           <input id="email" class="col-md-5" required placeholder="Card holder Email ID" name="email" type="text" style="margin-bottom: 10px;">
                           <div id="card-element" style='height: 2.4em;border:1px solid grey;width:70%'>
                              <!-- Stripe card number, expiry, and cvc elements will be inserted here -->
                           </div>
                           <div id="card-errors" role="alert"></div>
                           <br>
                           <button type="submit" id="card-button" class="btn btn-primary btn-lg btn-block">Pay Now</button>
                     </form>
                  <br>
            </div>
        </div>


    </div>
    </div>
    </div>
</body>

<script src="https://js.stripe.com/v3/"></script>

<script>
     
        $(document).ready(function() {
            
            $("#payment-form").validate({
                rules: {
                    name: {
                    required:true,
                    minlength:3,
                    },
                    email: {
                    required:true,
                    email:true
                    },
                
                },
            });
            
        });
    </script>

<script>
    var public_key = '{{ env("STRIPE_PUBLIC_KEY") }}';
    const stripe = Stripe(public_key);
    
    const elements = stripe.elements();

    const cardElement = elements.create('card', {
        style: {
            base: {
                iconColor: '#666EE8',
                color: '#31325F',
                lineHeight: '40px',
                fontWeight: 300,
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSize: '18px',
                '::placeholder': {
                    color: '#CFD7E0',
                },
            },
        }
    });

    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    const cardErrors = document.getElementById('card-errors');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        const {
            token,
            error
        } = await stripe.createToken(cardElement);

        if (error) {
            // Display the error message to the user
            cardErrors.textContent = error.message;
        } else {
            // Add the token to the form and submit
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripe_token');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Now, proceed with form submission
            form.submit();
        }
    });

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    
    cardButton.addEventListener('click', async (e) => {
        const { paymentMethod, error } = await stripe.createPaymentMethod(
            'card', cardElement, {
                billing_details: { name: cardHolderName.value }
            }
        );
    
        if (error) {
            //error message to user if card details related issues
            //alert("Please enter valid card details to continue");
        } else {
            document.getElementById('payment_id').value = paymentMethod.id;
            document.getElementById('payment-form').submit();
            // The card has been verified successfully...
        }
    });
</script>
</html>
