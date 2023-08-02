{{-- @extends('layouts.admin')
@section('page-title')
    {{ __('Manage Plan') }}
@endsection

@section('action-button')
    @can('Create Plan')
        @if (!empty($admin_payment_setting) && (($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret'])) || ($admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key']))))
            <a href="#" data-url="{{ route('plans.create') }}"
                class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
                data-title="{{ __('Create New Plan') }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="{{ __('Create') }}">
                <i class=" ti ti-plus"></i>
            </a>
        @endif
    @endcan
@endsection

@section('content')
    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s" style="
                                visibility: visible;
                                animation-delay: 0.2s;
                                animation-name: fadeInUp;
                              ">
                    <div class="card-body text-center">
                        <span class="price-badge bg-primary">{{ $plan->name }}</span>
                        <h1 class="mb-4 f-w-600  ">
                            {{ (!empty(env('CURRENCY_SYMBOL')) ? env('CURRENCY_SYMBOL') : '$') . $plan->price }}<small
                                class="text-sm">/{{ __(\App\Models\Plan::$arrDuration[$plan->duration]) }}</small>
                        </h1>


                        <ul class="list-unstyled my-5">
                            <li class="d-flex">
                                <span class="theme-avtar">
                                    <i class="text-primary ti ti-circle-plus"></i></span>
                                <span class="plan_features">
                                    {{ $plan->max_users == -1 ? __('Unlimited') : $plan->max_users }} {{ __('Users') }}
                                </span>
                            </li>
                            <li class="d-flex">
                                <span class="theme-avtar">
                                    <i class="text-primary ti ti-circle-plus"></i></span>
                                <span class="plan_features">
                                    {{ $plan->max_employees == -1 ? __('Unlimited') : $plan->max_employees }}
                                    {{ __('Employees') }}
                                </span>
                            </li>
                        </ul>
                        @can('Edit Plan')
                            <div class="text-center">
                                <a href="#" class="btn btn-primary btn-icon m-1" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="" data-ajax-popup="true" data-size="lg"
                                    data-title="Edit Plan" data-url="{{ route('plans.edit', $plan->id) }}"
                                    data-bs-original-title="Edit Plan" aria-label="Edit Plan"><i
                                        class="ti ti-pencil text-white"></i></a>
                                @if ((!empty($admin_payment_setting) && ($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on' || $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on' || $admin_payment_setting['is_paytm_enabled'] == 'on' || $admin_payment_setting['is_mollie_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on')) || (!empty($admin_payment_setting) && $admin_payment_setting['is_paymentwall_enabled'] == 'on'))
                                    @can('Buy Plan')
                                        @if ($plan->id != \Auth::user()->plan && \Auth::user()->type != 'super admin')
                                            @if ($plan->price > 0)
                                                <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                    class="button text-xs">{{ __('Buy Plan') }}</a>
                                            @else
                                                <a href="#" class="button text-xs">{{ __('Free') }}</a>
                                            @endif
                                        @endif
                                    @endcan
                                @endif
                            </div>
                        @endcan
                    </div>
                </div>


            </div>
            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 mb-4">
                <div class="plan-3">
                    <h6>{{ $plan->name }}</h6>
                    <p class="price">
                        <sup>{{ (!empty(env('CURRENCY_SYMBOL')) ? env('CURRENCY_SYMBOL') : '$') . $plan->price }}</sup>

                        <sub>{{ __('Duration : ') . __(\App\Models\Plan::$arrDuration[$plan->duration]) }}</sub>
                    </p>
                    <p class="price-text"></p>
                    <ul class="plan-detail">
                        <li>{{ $plan->max_users == -1 ? __('Unlimited') : $plan->max_users }} {{ __('Users') }}</li>
                        <li>{{ $plan->max_employees == -1 ? __('Unlimited') : $plan->max_employees }}
                            {{ __('Employees') }}
                        </li>
                    </ul>
                    @can('Edit Plan')
                        <a title="{{ __('Edit Plan') }}" href="#" class="button text-xs"
                            data-url="{{ route('plans.edit', $plan->id) }}" data-ajax-popup="true"
                            data-title="{{ __('Edit Plan') }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="{{ __('Edit') }}">
                            <i class="far fa-edit"></i>
                        </a>
                    @endcan

                    @if ((!empty($admin_payment_setting) && ($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on' || $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on' || $admin_payment_setting['is_paytm_enabled'] == 'on' || $admin_payment_setting['is_mollie_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on')) || (!empty($admin_payment_setting) && $admin_payment_setting['is_paymentwall_enabled'] == 'on'))
                        @can('Buy Plan')
                            @if ($plan->id != \Auth::user()->plan && \Auth::user()->type != 'super admin')
                                @if ($plan->price > 0)
                                    <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                        class="button text-xs">{{ __('Buy Plan') }}</a>
                                @else
                                    <a href="#" class="button text-xs">{{ __('Free') }}</a>
                                @endif
                            @endif
                        @endcan
                    @endif

                    @if ($plan->id != 1 && \Auth::user()->type != 'super admin')
                        @if (\Auth::user()->requested_plan != $plan->id)
                            @if (\Auth::user()->plan == $plan->id)
                                <a href="#" class="badge badge-pill badge-success button">
                                    <span class="btn-inner--icon">Active</span>
                                </a>
                            @else
                                <a href="{{ route('plan_request', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                    class="badge badge-pill badge-success button">
                                    <span class="btn-inner--icon"><i class="fas fa-share"></i></span>
                                </a>
                            @endif
                        @else
                            @if (\Auth::user()->plan == $plan->id)
                                <a href="#" class="badge badge-pill badge-success button">
                                    <span class="btn-inner--icon">Active</span>
                                </a>
                            @else
                                {!! Form::open(['method' => 'DELETE', 'route' => ['plans.destroy', $plan->id], 'id' => 'delete-form-' . $plan->id]) !!}
                                <a href="#!"
                                    class="action-btn btn-danger me-1 btn btn-sm d-inline-flex align-items-center show_confirm"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Delete') }}">
                                    <i class="ti ti-trash"></i></a>
                                {!! Form::close() !!}
                            @endif
                        @endif
                    @endif

                    @php
                        $plan_expire_date = \Auth::user()->plan_expire_date;

                    @endphp
                    @if (\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id)
                        <p class="server-plan text-white mt-2">
                            {{ __('Plan Expired : ') }}
                            {{ !empty($plan_expire_date) ? \Auth::user()->dateFormat($plan_expire_date) : 'Unlimited' }}
                        </p>
                    @endif
                </div>



            </div>
        @endforeach
    </div>
@endsection --}}



@extends('layouts.admin')

@section('page-title')
   {{ __('Manage Plan') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Plan') }}</li>
@endsection

@section('action-button')
    @can('Create Plan')
        @if (!empty($admin_payment_setting) && (($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret'])) || ($admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key']))))
            <a href="#" data-url="{{ route('plans.create') }}" data-size="md" data-ajax-popup="true"
                data-title="{{ __('Create New Plan') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endif
    @endcan
@endsection

@section('content')
    @foreach ($plans as $plan)
        <div class="col-lg-3 col-md-4">
            <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s"
                style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="card-body">
                    <span class="price-badge bg-primary">{{ $plan->name }}</span>

                    <div class="d-flex flex-row-reverse m-0 p-0 ">
                        @can('Edit Plan')
                            <div class="action-btn bg-primary ms-2">
                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
                                   data-title="{{ __('Edit Plan') }}"
                                    data-url="{{ route('plans.edit', $plan->id) }}"  data-size="md" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"
                                    data-bs-placement="top"><span class="text-white"><i
                                            class="ti ti-pencil"></i></span></a>
                            </div>
                        @endcan

                        @if (\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id)
                            <span class="d-flex align-items-center ms-2">
                                <i class="f-10 lh-1 fas fa-circle text-success"></i>
                                <span class="ms-2">{{ __('Active') }}</span>
                            </span>
                        @endif
                    </div>


                    <span
                        class="mb-4 f-w-600 p-price">{{ env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$' }}{{ number_format($plan->price) }}<small
                            class="text-sm">/ {{ $plan->duration }}</small></span>
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
                            {{ $plan->max_users == -1 ? __('Unlimited') : $plan->max_users }} {{ __('Users') }}
                        </li>
                        <li>
                            <span class="theme-avtar">
                                <i class="text-primary ti ti-circle-plus"></i></span>
                            {{ $plan->max_employees == -1 ? __('Unlimited') : $plan->max_employees }}
                            {{ __('Employees') }}
                        </li>
                    </ul>
                    <div class="row d-flex justify-content-between">
                         @if ((!empty($admin_payment_setting) && ($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on' || $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on' || $admin_payment_setting['is_paytm_enabled'] == 'on' || $admin_payment_setting['is_mollie_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on')) || (!empty($admin_payment_setting) && $admin_payment_setting['is_paymentwall_enabled'] == 'on'))
                            @can('Buy Plan')
                                @if ($plan->id != \Auth::user()->plan && \Auth::user()->type != 'super admin')
                                    <div class="col-8">
                                        <div class="d-grid text-center">
                                            <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                class="btn btn-primary btn-sm d-flex justify-content-center align-items-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{ __('Subscribe') }}"
                                                title="{{ __('Subscribe') }}">{{ __('Subscribe') }}
                                                <i class="ti ti-arrow-narrow-right ms-1"></i></a>
                                            <p></p>
                                        </div>
                                    </div>
                                @endif
                            @endcan
                        @endif
                        @if (\Auth::user()->type == 'company' && \Auth::user()->plan != $plan->id)
                            @if ($plan->id != 1)
                                <div class="col-3">
                                    @if (\Auth::user()->requested_plan != $plan->id)
                                        <a href="{{ route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)]) }}"
                                            class="btn btn-primary btn-icon btn-sm" data-title="{{ __('Send Request') }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top"   data-bs-original-title="{{ __('Send Request') }}"
                                            title="{{ __('Send Request') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-arrow-forward-up"></i></span>
                                        </a>
                                    @else
                                        <a href="{{ route('request.cancel', \Auth::user()->id) }}"
                                            class="btn btn-danger btn-icon btn-sm"
                                            data-title="{{ __('Cancel Request') }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top"  data-bs-original-title="{{ __('Cancel Request') }}" title="{{ __('Cancel Request') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-shield-x"></i></span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endif

                        @php
                            $plan_expire_date = \Auth::user()->plan_expire_date;
                        @endphp

                            @if(\Auth::user()->type =='company' && \Auth::user()->plan == $plan->id)
                            <p class="mb-0">
                                {{__('Plan Expired : ') }} {{!empty($plan_expire_date) ? \Auth::user()->dateFormat($plan_expire_date):'Unlimited'}}
                            </p>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
