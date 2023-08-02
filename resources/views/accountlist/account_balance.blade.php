@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Account Balances') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Account Balances') }}</li>
@endsection



@section('content')

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Account Name') }}</th>
                                <th width="200px">{{ __('Initial Balance') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalInitialBalance = 0; @endphp
                            @foreach ($accountLists as $accountlist)
                                @php
                                    $totalInitialBalance = $accountlist->initial_balance + $totalInitialBalance;
                                @endphp
                                <tr>
                                    <td>{{ $accountlist->account_name }}</td>
                                    <td>{{ \Auth::user()->priceFormat($accountlist->initial_balance) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-left text-dark">{{ __('Total') }}</td>
                                <td>{{ \Auth::user()->priceFormat($totalInitialBalance) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
