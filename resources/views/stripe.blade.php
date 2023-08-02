@extends('layouts.admin')

@push('scripts')


    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script type="text/javascript">
        @if ($plan->price > 0.0 && $admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret']))
            var stripe = Stripe('{{ $admin_payment_setting['stripe_key'] }}');
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    // Add your base input styles here. For example:
                    fontSize: '14px',
                    color: '#32325d',
                },
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style
            });

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            var scrollSpy = new bootstrap.ScrollSpy(document.body, {
                target: '#useradd-sidenav',
                offset: 300
            })

            // Create a token or display an error when the form is submitted.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        $("#card-errors").html(result.error.message);
                        toastrs('Error', result.error.message, 'error');
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        @endif

        $(document).ready(function() {
            $(document).on('click', '.apply-coupon', function() {

                var ele = $(this);

                var coupon = ele.closest('.row').find('.coupon').val();

                $.ajax({
                    url: '{{ route('apply.coupon') }}',
                    datType: 'json',
                    data: {
                        plan_id: '{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}',
                        coupon: coupon
                    },
                    success: function(data) {

                        if (data != '') {
                            $('.final-price').text(data.final_price);
                            $('#stripe_coupon, #paypal_coupon').val(coupon);

                            if (data.is_success) {
                                show_toastr('Success', data.message, 'success');
                            } else {
                                show_toastr('Error', data.message, 'error');
                            }
                        } else {
                            show_toastr('Error', "{{ __('Coupon code required.') }}",
                                'error');
                        }
                    }
                })
            });
        });
    </script>

    @if (!empty($admin_payment_setting['is_paystack_enabled']) && isset($admin_payment_setting['is_paystack_enabled']) && $admin_payment_setting['is_paystack_enabled'] == 'on')
        <script>
            $(document).on("click", ".pay_with_paystack", function() {

                $('#paystack-payment-form').ajaxForm(function(res) {
                    if (res.flag == 1) {
                        var paystack_callback = "{{ url('/plan/paystack') }}";
                        var order_id = '{{ time() }}';
                        var coupon_id = res.coupon;
                        var handler = PaystackPop.setup({
                            key: '{{ $admin_payment_setting['paystack_public_key'] }}',
                            email: res.email,
                            amount: res.total_price * 100,
                            currency: res.currency,
                            ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                                1
                            ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                            metadata: {
                                custom_fields: [{
                                    display_name: "Email",
                                    variable_name: "email",
                                    value: res.email,
                                }]
                            },

                            callback: function(response) {
                                console.log(response.reference, order_id);
                                window.location.href = paystack_callback + '/' + response
                                    .reference + '/' + '{{ encrypt($plan->id) }}' +
                                    '?coupon_id=' +
                                    coupon_id
                            },
                            onClose: function() {
                                alert('window closed');
                            }
                        });
                        handler.openIframe();
                    } else if (res.flag == 2) {

                    } else {
                        show_toastr('Error', data.message, 'msg');
                    }

                }).submit();
            });
        </script>
    @endif
    <script>
        //    Flaterwave Payment
    </script>
    @if (!empty($admin_payment_setting['is_flutterwave_enabled']) && isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on')
        <script>
            $(document).on("click", "#pay_with_flaterwave", function() {

                $('#flaterwave-payment-form').ajaxForm(function(res) {
                    if (res.flag == 1) {
                        var coupon_id = res.coupon;
                        var API_publicKey = '{{ $admin_payment_setting['flutterwave_public_key'] }}';
                        var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                        var flutter_callback = "{{ url('/plan/flaterwave') }}";
                        var x = getpaidSetup({
                            PBFPubKey: API_publicKey,
                            customer_email: '{{ Auth::user()->email }}',
                            amount: res.total_price,
                            currency: '{{ env('CURRENCY') }}',

                            txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) +
                                'fluttpay_online-' + {{ date('Y-m-d') }},
                            meta: [{
                                metaname: "payment_id",
                                metavalue: "id"
                            }],
                            onclose: function() {},
                            callback: function(response) {
                                var txref = response.tx.txRef;
                                if (
                                    response.tx.chargeResponseCode == "00" ||
                                    response.tx.chargeResponseCode == "0"
                                ) {
                                    window.location.href = flutter_callback + '/' + txref + '/' +
                                        '{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}?coupon_id=' +
                                        coupon_id;
                                } else {
                                    // redirect to a failure page.
                                }
                                x.close(); // use this to close the modal immediately after payment.
                            }
                        });
                    } else if (res.flag == 2) {

                    } else {
                        show_toastr('Error', data.message, 'msg');
                    }

                }).submit();
            });
        </script>
    @endif
    <script>
        // Razorpay Payment
    </script>
    @if (!empty($admin_payment_setting['is_razorpay_enabled']) && isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on')
        <script>
            $(document).on("click", "#pay_with_razorpay", function() {
                $('#razorpay-payment-form').ajaxForm(function(res) {
                    if (res.flag == 1) {

                        var razorPay_callback = '{{ url('/plan/razorpay') }}';
                        var totalAmount = res.total_price * 100;
                        var coupon_id = res.coupon;
                        var options = {
                            "key": "{{ $admin_payment_setting['razorpay_public_key'] }}", // your Razorpay Key Id
                            "amount": totalAmount,
                            "name": 'Plan',
                            "currency": '{{ env('CURRENCY') }}',
                            "description": "",
                            "handler": function(response) {
                                window.location.href = razorPay_callback + '/' + response
                                    .razorpay_payment_id + '/' +
                                    '{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}?coupon_id=' +
                                    coupon_id;
                            },
                            "theme": {
                                "color": "#528FF0"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    } else if (res.flag == 2) {

                    } else {
                        show_toastr('Error', data.message, 'msg');
                    }

                }).submit();
            });
        </script>
    @endif
@endpush


@php
$dir = asset(Storage::url('uploads/plan'));
$dir_payment = asset(Storage::url('uploads/payments'));

@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">{{ __('Plans') }}</a></li>
    <li class="breadcrumb-item">{{ __('Order Summary') }}</li>
@endsection



@section('page-title')
    {{ __('Manage Order Summary') }}
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="sticky-top">
                        <div class="card">
                            <div class="list-group list-group-flush" id="useradd-sidenav">
                                @if ($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret']))
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#stripe-payment" role="tab" aria-controls="stripe"
                                        aria-selected="true">{{ __('Stripe') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if ($admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key']))
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#paypal-payment" role="tab" aria-controls="paypal"
                                        aria-selected="false">{{ __('Paypal') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if ($admin_payment_setting['is_paystack_enabled'] == 'on' && !empty($admin_payment_setting['paystack_public_key']) && !empty($admin_payment_setting['paystack_secret_key']))
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#paystack-payment" role="tab" aria-controls="paystack"
                                        aria-selected="false">{{ __('Paystack') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on')
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#flutterwave-payment" role="tab" aria-controls="flutterwave"
                                        aria-selected="false">{{ __('Flutterwave') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on')
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#razorpay-payment" role="tab" aria-controls="razorpay"
                                        aria-selected="false">{{ __('Razorpay') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on')
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#paytm-payment" role="tab" aria-controls="paytm"
                                        aria-selected="false">{{ __('Paytm') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payment_setting['is_mercado_enabled']) && $admin_payment_setting['is_mercado_enabled'] == 'on')
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#mercadopago-payment" role="tab" aria-controls="mercadopago"
                                        aria-selected="false">{{ __('Mercado Pago') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on')
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#mollie-payment" role="tab" aria-controls="mollie"
                                        aria-selected="false">{{ __('Mollie') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on')
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#skrill-payment" role="tab" aria-controls="skrill"
                                        aria-selected="false">{{ __('Skrill') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on')
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#coingate-payment" role="tab" aria-controls="coingate"
                                        aria-selected="false">{{ __('Coingate') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payment_setting['is_paymentwall_enabled']) && $admin_payment_setting['is_paymentwall_enabled'] == 'on')
                                    <a class="list-group-item list-group-item-action border-0" data-toggle="tab"
                                        href="#paymentwall-payment" role="tab" aria-controls="paymentwall"
                                        aria-selected="true">{{ __('Paymentwall') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif

                            </div>
                        </div>
                        <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s"
                            style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                            <div class="card-body">
                                <span class="price-badge bg-primary">{{ $plan->name }}</span>

                                <span
                                    class="mb-4 f-w-600 p-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}<small
                                        class="text-sm">/
                                        {{ \App\Models\Plan::$arrDuration[$plan->duration] }}</small></span>
                                <p class="mb-0">
                                    {{ $plan->name }} {{ __('Plan') }}
                                </p>
                                <p class="mb-0">
                                    {{ $plan->description }}
                                </p>

                                <ul class="list-unstyled my-4">
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        {{ $plan->max_users < 0 ? __('Unlimited') : $plan->max_users }}
                                        {{ __('Users') }}
                                    </li>
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        {{ $plan->max_employees == -1 ? __('Unlimited') : $plan->max_employees }}
                                        {{ __('Employees') }}
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-9">
                    @if ($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret']))
                        <div class="" id="stripe-payment">
                            <form role="form" action="{{ route('stripe.post') }}" method="post"
                                class="require-validation" id="payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using Stripe') }}</h5>
                                            </div>
                                            <div class="border p-3 mb-3 rounded stripe-payment-div">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="custom-radio">
                                                            <label
                                                                class="font-16 font-weight-bold">{{ __('Credit / Debit Card') }}</label>
                                                        </div>
                                                        <p class="mb-0 pt-1 text-sm">
                                                            {{ __('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.') }}
                                                        </p>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="card-name-on"
                                                                class="col-form-label text-dark">{{ __('Name on card') }}</label>
                                                            <input type="text" name="name" id="card-name-on"
                                                                class="form-control required"
                                                                placeholder="{{ \Auth::user()->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div id="card-element">
                                                            <!-- A Stripe Element will be inserted here. -->
                                                        </div>
                                                        <div id="card-errors" role="alert"></div>
                                                    </div>

                                                    <div class="form-group mt-3"><label
                                                            for="stripe_coupon">{{ __('Coupon') }}</label></div>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-11">

                                                            <div class="form-group">
                                                                <input type="text" id="stripe_coupon" name="coupon"
                                                                    class="form-control coupon"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group apply-stripe-btn-coupon">
                                                                <a href="#" data-from="stripe"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right stripe-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="stripe-coupon-price"></b>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="error" style="display: none;">
                                                            <div class='alert-danger alert'>
                                                                {{ __('Please correct the errors and try again.') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 my-2 px-2">
                                                <div class="text-sm-right text-end">
                                                    <input type="hidden" name="plan_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                    <input type="submit" value="{{ __('Pay Now') }}"
                                                        class="btn btn-xs btn-primary ">

                                                </div>
                                            </div>


                                            {{-- <div class="card-footer text-end">

                                                    <button class="btn btn-primary text-sm" type="submit">
                                                        <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                        (<span
                                                            class="paypal-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)
                                                    </button>
                                                </div> --}}

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if ($admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key']))
                        <div class="" id="paypal-payment">

                            <form role="form" action="{{ route('plan.pay.with.paypal') }}" method="post"
                                class="require-validation" id="payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using Paypal') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="paypal-payment-div">
                                                    <div class="form-group">
                                                        <label for="paypal_coupon"
                                                            class="form-control-label">{{ __('Coupon') }}</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-11">
                                                            <div class="form-group">

                                                                <input type="text" id="paypal_coupon" name="coupon"
                                                                    class="form-control coupon"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group apply-paypal-btn-coupon">
                                                                <a href="#" data-from="paypal"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right paypal-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="paypal-coupon-price"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                 <input type="hidden" id="paypal" value="paypal" name="payment_processor"
                                                    class="custom-control-input">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <button class="btn btn-primary text-sm" type="submit">
                                                    <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                    (<span
                                                        class="paypal-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    @endif

                    @if ($admin_payment_setting['is_paystack_enabled'] == 'on' && !empty($admin_payment_setting['paystack_public_key']) && !empty($admin_payment_setting['paystack_secret_key']))
                        <div class="" id="paystack-payment">

                            <form role="form" action="{{ route('plan.pay.with.paystack') }}" method="post"
                                class="require-validation" id="paystack-payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using Paystack') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="paystack-payment-div">
                                                    <div class="form-group">
                                                        <label for="paystack_coupon"
                                                            class="form-control-label">{{ __('Coupon') }}</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-11">
                                                            <div class="form-group">
                                                                <input type="text" id="paystack_coupon" name="coupon"
                                                                    class="form-control coupon" data-from="paystack"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <a href="#" data-from="paystack"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right paystack-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="paystack-coupon-price"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card-footer text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <button class="btn btn-primary pay_with_paystack" type="button" id="pay_with_paystack">
                                                    <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                    (<span
                                                        class="paystack-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    @endif

                    @if (isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on')
                        <div class="" id="flutterwave-payment">

                            <form role="form" action="{{ route('plan.pay.with.flaterwave') }}" method="post"
                                class="require-validation" id="flaterwave-payment-form">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using Flutterwave') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group"><label for="flaterwave_coupon"
                                                        class="form-control-label">{{ __('Coupon') }}</label></div>
                                                <div class="row align-items-center">
                                                    <div class="col-md-11">
                                                        <div class="form-group">
                                                            <input type="text" id="flaterwave_coupon" name="coupon"
                                                                class="form-control coupon" data-from="flaterwave"
                                                                placeholder="{{ __('Enter Coupon Code') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <a href="#" data-from="flaterwave"
                                                                class="btn btn-sm btn-primary apply-coupon"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ __('Apply') }}"><i
                                                                    class="ti ti-device-floppy"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-right flaterwave-coupon-tr"
                                                        style="display: none">
                                                        <b>{{ __('Coupon Discount') }}</b> : <b
                                                            class="flaterwave-coupon-price"></b>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="error" style="display: none;">
                                                            <div class='alert-danger alert'>
                                                                {{ __('Please correct the errors and try again.') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <button class="btn btn-primary" type="button" id="pay_with_flaterwave">
                                                    <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                    (<span
                                                        class="flaterwave-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif


                    @if (isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on')
                        <div class="" id="razorpay-payment">

                            <form role="form" action="{{ route('plan.pay.with.razorpay') }}" method="post"
                                class="require-validation" id="razorpay-payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using Razorpay') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="razorpay-payment-div">
                                                    <div class="form-group">
                                                        <label for="razorpay_coupon"
                                                            class="form-control-label text-dark">{{ __('Coupon') }}</label>
                                                    </div>
                                                    <div class="row align-items-center">

                                                        <div class="col-11">
                                                            <div class="form-group">

                                                                <input type="text" id="razorpay_coupon" name="coupon"
                                                                    class="form-control coupon" data-from="razorpay"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <a href="#" data-from="razorpay"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right razorpay-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="razorpay-coupon-price"></b>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="error" style="display: none;">
                                                                <div class='alert-danger alert'>
                                                                    {{ __('Please correct the errors and try again.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <button class="btn btn-primary" type="button" id="pay_with_razorpay">
                                                    <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                    (<span
                                                        class="razorpay-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if (isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on')
                        <div class="" id="paytm-payment">

                            <form role="form" action="{{ route('plan.pay.with.paytm') }}" method="post"
                                class="require-validation" id="paytm-payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using Paytm') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="paytm-payment-div">

                                                    <div class="row align-items-center">
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label for="paytm_coupon"
                                                                    class="form-control-label text-dark mb-4">{{ __('Mobile Number') }}</label>
                                                                <input type="text" id="mobile" name="mobile"
                                                                    class="form-control mobile" data-from="mobile"
                                                                    placeholder="{{ __('Enter Mobile Number') }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label for="paytm_coupon"
                                                                    class="form-control-label text-dark mb-4">{{ __('Coupon') }}</label>
                                                                <input type="text" id="paytm_coupon" name="coupon"
                                                                    class="form-control coupon" data-from="paytm"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 mt-5">
                                                            <div class="form-group">
                                                                <a href="#" data-from="paytm"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right paytm-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="paytm-coupon-price"></b>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="error" style="display: none;">
                                                                <div class='alert-danger alert'>
                                                                    {{ __('Please correct the errors and try again.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <button class="btn btn-primary" type="submit" id="pay_with_paytm">
                                                    <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                    (<span
                                                        class="paytm-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if (isset($admin_payment_setting['is_mercado_enabled']) && $admin_payment_setting['is_mercado_enabled'] == 'on')
                        <div class="" id="mercadopago-payment">

                            <form role="form" action="{{ route('plan.pay.with.mercado') }}" method="post"
                                class="require-validation" id="mercado-payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using Mercado') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mercado-payment-div">
                                                    <div class="form-group"><label for="mercado_coupon"
                                                            class="form-control-label">{{ __('Coupon') }}</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <div class="col-11">
                                                            <div class="form-group">

                                                                <input type="text" id="mercado_coupon" name="coupon"
                                                                    class="form-control coupon" data-from="mercado"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <a href="#" data-from="mercado"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right mercado-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="mercado-coupon-price"></b>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="error" style="display: none;">
                                                                <div class='alert-danger alert'>
                                                                    {{ __('Please correct the errors and try again.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card-footer text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <button class="btn btn-primary" type="submit" id="pay_with_paytm">
                                                    <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                    (<span
                                                        class="mercado-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if (isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on')
                        <div class="" id="mollie-payment">
                            <form role="form" action="{{ route('plan.pay.with.mollie') }}" method="post"
                                class="require-validation" id="mollie-payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using  Mollie') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mollie-payment-div">
                                                    <div class="form-group"><label for="mollie_coupon"
                                                            class="form-control-label text-dark">{{ __('Coupon') }}</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <div class="col-11">
                                                            <div class="form-group">
                                                                <input type="text" id="mollie_coupon" name="coupon"
                                                                    class="form-control coupon" data-from="mollie"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <a href="#" data-from="mollie"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right mollie-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="mollie-coupon-price"></b>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="error" style="display: none;">
                                                                <div class='alert-danger alert'>
                                                                    {{ __('Please correct the errors and try again.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <button class="btn btn-primary" type="submit" id="pay_with_mollie">
                                                    <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                    (<span
                                                        class="mollie-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if (isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on')
                        <div class="" id="skrill-payment">
                            <form role="form" action="{{ route('plan.pay.with.skrill') }}" method="post"
                                class="require-validation" id="skrill-payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using Skrill ') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="skrill-payment-div">
                                                    <div class="form-group"><label for="skrill_coupon"
                                                            class="form-control-label text-dark">{{ __('Coupon') }}</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <div class="col-11">
                                                            <div class="form-group">

                                                                <input type="text" id="skrill_coupon" name="coupon"
                                                                    class="form-control coupon" data-from="skrill"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <a href="#" data-from="skrill"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right skrill-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="skrill-coupon-price"></b>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $skrill_data = [
                                                            'transaction_id' => md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id'),
                                                            'user_id' => 'user_id',
                                                            'amount' => 'amount',
                                                            'currency' => 'currency',
                                                        ];
                                                        session()->put('skrill_data', $skrill_data);
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="error" style="display: none;">
                                                                <div class='alert-danger alert'>
                                                                    {{ __('Please correct the errors and try again.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <button class="btn btn-primary" type="submit" id="pay_with_skrill">
                                                    <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                    (<span
                                                        class="skrill-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if (isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on')
                        <div class="" id="coingate-payment">
                            <form role="form" action="{{ route('plan.pay.with.coingate') }}" method="post"
                                class="require-validation" id="coingate-payment-form">
                                @csrf
                                <div class="coingate-payment-div">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>{{ __('Pay Using Coingate') }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="coingate_coupon"
                                                            class="form-control-label text-dark">{{ __('Coupon') }}</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <div class="form-group">

                                                                <input type="text" id="coingate_coupon" name="coupon"
                                                                    class="form-control coupon" data-from="coingate"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <a href="#" data-from="coingate"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right coingate-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="coingate-coupon-price"></b>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="error" style="display: none;">
                                                                <div class='alert-danger alert'>
                                                                    {{ __('Please correct the errors and try again.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="card-footer text-end">
                                                    <input type="hidden" name="plan_id"
                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                    <button class="btn btn-primary" type="submit" id="pay_with_coingate">
                                                        <i class="mdi mdi-cash-multiple mr-1"></i>
                                                        {{ __('Pay Now') }} (<span
                                                            class="coingate-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if (isset($admin_payment_setting['is_paymentwall_enabled']) && $admin_payment_setting['is_paymentwall_enabled'] == 'on')
                        <div class="" id="paymentwall-payment">
                            <form role="form" action="{{ route('paymentwall') }}" method="post"
                                class="require-validation" id="paymentwall-payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Pay Using Paymentwall') }}</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="py-3 paymentwall-payment-div">
                                                    <div class="form-group"><label for="payementwall_coupon"
                                                            class="form-control-label text-dark">{{ __('Coupon') }}</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-11">
                                                            <div class="form-group">

                                                                <input type="text" id="paymentwall_coupon" name="coupon"
                                                                    class="form-control coupon" data-from="paymentwall"
                                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <a href="#" data-from="paymentwall" data-from="coingate"
                                                                    class="btn btn-sm btn-primary apply-coupon"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Apply') }}"><i
                                                                        class="ti ti-device-floppy"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-right paymentwall-coupon-tr"
                                                            style="display: none">
                                                            <b>{{ __('Coupon Discount') }}</b> : <b
                                                                class="paymentwall-coupon-price"></b>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="error" style="display: none;">
                                                                <div class='alert-danger alert'>
                                                                    {{ __('Please correct the errors and try again.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <button class="btn btn-primary" type="submit" id="pay_with_paymentwall">
                                                    <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                    (<span
                                                        class="paystack-final-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ $plan->price }}</span>)</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
