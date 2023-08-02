
<div class="modal-body">
    <div class="card mb-2">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table datatable">
                    <tbody>
                        @foreach ($plans as $plan)
                        <tr>
                            <td>
                                <h6>{{ $plan->name }} {{ (!empty(env('CURRENCY_SYMBOL')) ? env('CURRENCY_SYMBOL') : '$') . $plan->price }}
                                    {{ ' / ' . $plan->duration }}</h6>
                            </td>
                            <td>{{ __('Users') }} : {{ $plan->max_users }}</td>
                            <td>{{ __('Employees') }} : {{ $plan->max_employees }}</td>


                            <td class="Action">
                                <span>
                                    @if ($user->plan == $plan->id)

                                        <div class="badge bg-success p-2 px-3 rounded"><i class="ti ti-checks"></i></div>

                                        @else

                                        <a href="{{ route('plan.active', [$user->id, $plan->id]) }}"
                                            class="badge bg-info p-2 px-3 rounded"
                                            title="{{ __('Click to Upgrade Plan') }}"><i class="ti ti-shopping-cart-plus"></i></a>


                                        @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
