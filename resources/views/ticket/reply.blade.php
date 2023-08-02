@extends('layouts.admin')

@section('page-title')
   {{ __('Ticket Reply') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ url('ticket') }}">{{ __('Ticket') }}</a></li>
    <li class="breadcrumb-item">{{ __('Ticket Reply') }}</li>
@endsection

@section('action-button')
@if (\Auth::user()->type == 'company' || $ticket->ticket_created == \Auth::user()->id)
        <a href="#" data-url="{{ URL::to('ticket/' . $ticket->id . '/edit') }}" data-ajax-popup="true"
            data-title="{{ __('Edit Ticket') }}" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-info" data-bs-original-title="{{ __('Edit') }}">
            <i class="ti ti-pencil"></i>
        </a>
        @endif
@endsection


@section('content')
    <div class="col-md-6">
        @foreach ($ticketreply as $reply)
            <div class="card">
                <ul class="list-group team-msg">
                    <div class="card-header d-flex justify-content-between">
                        <h5> {{ !empty(\Auth::user()->getUser($reply->created_by)) ? \Auth::user()->getUser($reply->created_by)->name : '' }}
                        </h5>
                        <span>{{ $reply->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="card-body">
                        <p>{{ $reply->description }} </p>
                    </div>

                </ul>
            </div>
        @endforeach
    </div>
    @if ($ticket->status == 'open')
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5> {{ __('Support Reply') }}</h5>
                </div>
                {{ Form::open(['url' => 'ticket/changereply', 'method' => 'post']) }}
                <li class="list-group-item border-0 d-flex align-items-center">
                    <div class="avatar me-3">
                        @if (Auth::user()->avatar == '')
                            <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="kal" class="img-user">
                        @endif
                    </div>
                    <input type="hidden" value="{{ $ticket->id }}" name="ticket_id">
                    <div class="form-group mb-0 form-send w-100">
                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Ticket Reply')]) }}
                        <button class="btn btn-send" type="submit"><i
                                class="f-16 text-primary ti ti-brand-telegram"></i></button>
                    </div>
                </li>
                {{ Form::close() }}
            </div>
        </div>
    @endif
@endsection
