@extends('layouts.app')

@section('style')
    <style>
        input,
        .StripeElement {
        height: 40px;
        padding: 10px 12px;

        color: #32325d;
        background-color: white;
        border: 1px solid transparent;
        border-radius: 4px;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
        }

        input:focus,
        .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
        border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <form action="/charge" method="post" id="payment-form">
                @csrf
                <div class="r">
                  <input type="hidden" name="amount" value="{{$amount}}">
                  <label for="card-element">
                    Credit or debit card
                  </label>
                  <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                  </div>
              
                  <!-- Used to display form errors. -->
                  <div id="card-errors" role="alert">

                  </div>
                </div>
              
                <button class="btn btn-primary mt-3">Submit Payment</button>
                <p id="loading" style="display: none">payment in process, please wait...</p>
              </form>
        </div>
        <div class="col-md-4">


        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>
    window.onload =function(){
        var stripe = Stripe('pk_test_51H4EBLK9HHEezaUR8pG4r48sC3zOtrVU2R25ium3ATANBUpvNgyO8aKYLLhUiTI2vxNiATaNhOVtGqBeUUCjCAJQ00nAf2hAzS');
        var elements = stripe.elements();
        //style for cart
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        // Create an instance of the iban Element.
        var card = elements.create('card', {style: style});
        // Add an instance of the iban Element into the `iban-element` <div>.
        card.mount('#card-element');
        // Handle real-time validation errors from the card Element.
        card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
         } else {
            displayError.textContent = '';
           }
        });
        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
            } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
            }
        });
      });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        var loading =document.getElementById('loading');
        loading.style.display='block';

        // Submit the form
        form.submit();
        }
    }
</script>
@endsection