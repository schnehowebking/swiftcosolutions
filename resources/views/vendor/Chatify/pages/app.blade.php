@extends('layouts.admin')
@push('css-page')
@include('Chatify::layouts.headLinks')

<style>
    .cards{
        background-color: #fff;
        padding: 25px 25px;
    }
    .card-body{
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        
    }
    

.dropdown-menu {
    padding: 15px 0;
    box-shadow: 0 4px 24px 0 rgb(62 57 107 / 18%);
    border: none;
}

.dropdown-menu {
    z-index: 1000;
    min-width: 12rem;
    margin: 0;
    font-size: 0.875rem;
    color: #293240;
    text-align: left;
    background-clip: padding-box;
    border-radius: 10px;
}


</style>
@endpush
@php
$profile=\App\Models\Utility::get_file('uploads/'.config('chatify.user_avatar.folder'));  
$setting = App\Models\Utility::colorset();
$color = (!empty($setting['theme_color'])) ? $setting['theme_color'] : 'theme-3';

@endphp
@section('page-title') {{ __('Messenger') }} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Messenger') }}</li>
@endsection

@section('content')


        <div class="cards rounded-12 mt-4 p-0">
            <div class="card-body">
                <div class="messenger rounded min-h-750 overflow-hidden">
                    {{-- ----------------------Users/Groups lists side---------------------- --}}
                    <div class="messenger-listView">
                        {{-- Header and search bar --}}
                        <div class="m-header">
                            <nav>
                                <nav class="m-header-right">
                                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                                </nav>
                            </nav>
                            {{-- Search input --}}
                            <input type="text" class="messenger-search" placeholder="{{__('Search')}}" />
                            {{-- Tabs --}}
                            <div class="messenger-listView-tabs">
                                <a href="#" @if($route == 'user') class="active-tab" @endif data-view="users">
                                    <span class="fas fa-clock" title="{{__('Recent')}}"></span>
                                </a>
                                <a href="#" @if($route == 'group') class="active-tab" @endif data-view="groups">
                                    <span class="fas fa-users" title="{{__('Members')}}"></span></a>
                            </div>
                        </div>
                        {{-- tabs and lists --}}
                        <div class="m-body">
                        {{-- Lists [Users/Group] --}}
                        {{-- ---------------- [ User Tab ] ---------------- --}}
                        <div class="@if($route == 'user') show @endif messenger-tab app-scroll" data-view="users">

                            {{-- Favorites --}}
                                <p class="messenger-title">Favorites</p>
                                <div class="messenger-favorites app-scroll-thin"></div>

                            {{-- Saved Messages --}}
                            {!! view('Chatify::layouts.listItem', ['get' => 'saved','id' => $id])->render() !!}

                            {{-- Contact --}}
                            <div class="listOfContacts" style="width: 100%;height: calc(100% - 200px);position: relative;"></div>

                        </div>

                        {{-- ---------------- [ Group Tab ] ---------------- --}}
                        <div class="all_members @if($route == 'group') show @endif messenger-tab app-scroll" data-view="groups">
                                    <p style="text-align: center;color:grey;">{{__('Soon will be available')}}</p>
                                </div>

                            {{-- ---------------- [ Search Tab ] ---------------- --}}
                        <div class="messenger-tab app-scroll" data-view="search">
                                {{-- items --}}
                                <p class="messenger-title">{{__('Search')}}</p>
                                <div class="search-records">
                                    <p class="message-hint center-el"><span>{{__('Type to search..')}}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ----------------------Messaging side---------------------- --}}
                    <div class="messenger-messagingView">
                        {{-- header title [conversation name] amd buttons --}}
                        <div class="m-header m-header-messaging">
                            <nav class="d-flex a;align-items-center justify-content-between">
                                {{-- header back button, avatar and user name --}}
                                <div style="display: flex;">
                                        <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i> </a>
                                    @if(!empty($user->avatar))
                                        <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;background-image: url('{{ asset('/storage/avatars/'.$user->avatar) }}');"></div>
                                    @else
                                        <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;background-image: url('{{ asset('/storage/avatars/avatar.png') }}');"></div>
                                    @endif
                                        <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                                    </div>
                                {{-- header buttons --}}
                                <nav class="m-header-right">
                                    <a href="#" class="add-to-favorite my-lg-1 my-xl-1 mx-lg-1 mx-xl-1"><i class="fas fa-star"></i></a>
                                    <a href="#" class="show-infoSide my-lg-1 my-xl-1 mx-lg-1 mx-xl-2"><i class="fas fa-info-circle"></i></a>
                                </nav>
                            </nav>
                        </div>
                        {{-- Internet connection --}}
                        <div class="internet-connection">
                            <span class="ic-connected">{{__('Connected')}}</span>
                            <span class="ic-connecting">{{__('Connecting...')}}</span>
                            <span class="ic-noInternet">{{__('Please add pusher settings for using messenger.')}}</span>
                        </div>
                        {{-- Messaging area --}}
                        <div class="m-body app-scroll">
                            <div class="messages">
                                <p class="message-hint" style="margin-top: calc(30% - 126.2px);"><span>{{__('Please select a chat to start messaging')}}</span></p>
                            </div>
                            {{-- Typing indicator --}}
                            <div class="typing-indicator">
                                <div class="message-card typing">
                                    <p>
                                        <span class="typing-dots">
                                            <span class="dot dot-1"></span>
                                            <span class="dot dot-2"></span>
                                            <span class="dot dot-3"></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            {{-- Send Message Form --}}
                            @include('Chatify::layouts.sendForm')
                        </div>
                    </div>
                    {{-- ---------------------- Info side ---------------------- --}}
                    <div class="messenger-infoView app-scroll text-center">
                        {{-- nav actions --}}
                        <nav class="text-center">
                            <a href="#"><i class="fas fa-times"></i></a>
                        </nav>
                        {!! view('Chatify::layouts.info')->render() !!}
                    </div>
                </div>
            </div>
        </div>



@endsection

@push('scripts')
@include('Chatify::layouts.modals')

@endpush

@if(env('SITE_RTL')=='on')
<style type="text/css">
    body {
   
    text-align: right !important;
   }
</style>
@endif
@if($color == "theme-1")
<style type="text/css">
    .m-list-active, .m-list-active:hover, .m-list-active:focus {
    background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
}
.mc-sender p {
    background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
}

.messenger-favorites div.avatar {
    box-shadow: 0px 0px 0px 2px #51459d !important;
}
.messenger-listView-tabs a, .messenger-listView-tabs a:hover, .messenger-listView-tabs a:focus {
    color: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
}
.m-header svg {
    color: #51459d !important;
}
.active-tab {
    border-bottom: 2px solid #51459d !important;
}
.messenger-infoView nav a {
  
    color: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
}
.lastMessageIndicator {
    color: #51459d !important;
}

.messenger-list-item td span .lastMessageIndicator {

    color: #51459d !important;
    font-weight: bold;
}
.messenger-sendCard button svg {
     color: #51459d !important;
}
.messenger-list-item.m-list-active td span .lastMessageIndicator{
    color: #fff !important;
}
</style>
@endif


@if($color == "theme-2")
<style type="text/css">
    .m-list-active, .m-list-active:hover, .m-list-active:focus {
    background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, #4ebbd3 99.86%), #1f3996 !important;
}
.mc-sender p {
    background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, #4ebbd3 99.86%), #1f3996 !important;
}

.messenger-favorites div.avatar {
    box-shadow: 0px 0px 0px 2px #1f3996 !important;
}
.messenger-listView-tabs a, .messenger-listView-tabs a:hover, .messenger-listView-tabs a:focus {
    color: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, #4ebbd3 99.86%), #1f3996 !important;
}
.m-header svg {
    color: #1f3996 !important;
}
.active-tab {
    border-bottom: 2px solid #1f3996 !important;
}
.messenger-infoView nav a {
  
    color: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, #4ebbd3 99.86%), #1f3996 !important;
}
.lastMessageIndicator {
    color: #1f3996 !important;
}

.messenger-list-item td span .lastMessageIndicator {

    color: #1f3996 !important;
    font-weight: bold;
}
.messenger-sendCard button svg {
     color: #1f3996 !important;
}
.messenger-list-item.m-list-active td span .lastMessageIndicator{
    color: #fff !important;
}
</style>
@endif


@if($color == "theme-3")
<style type="text/css">
    .m-list-active, .m-list-active:hover, .m-list-active:focus {
    background: linear-gradient(141.55deg, #6fd943 3.46%, #6fd943 99.86%), #6fd943 !important;
}
.mc-sender p {
    background: linear-gradient(141.55deg, #6fd943 3.46%, #6fd943 99.86%), #6fd943 !important;
}

.messenger-favorites div.avatar {
    box-shadow: 0px 0px 0px 2px #6fd943 !important;
}
.messenger-listView-tabs a, .messenger-listView-tabs a:hover, .messenger-listView-tabs a:focus {
    color: linear-gradient(141.55deg, #6fd943 3.46%, #6fd943 99.86%), #6fd943 !important;
}
.m-header svg {
    color: #6fd943 !important;
}
.active-tab {
    border-bottom: 2px solid #6fd943 !important;
}
.messenger-infoView nav a {
  
    color: linear-gradient(141.55deg, #6fd943 3.46%, #6fd943 99.86%), #6fd943 !important;
}
.lastMessageIndicator {
    color: #6fd943 !important;
}

.messenger-list-item td span .lastMessageIndicator {

    color:#6fd943 !important;
    font-weight: bold;
}
.messenger-sendCard button svg {
     color: #6fd943 !important;
}
.messenger-list-item.m-list-active td span .lastMessageIndicator{
    color: #fff !important;
}
</style>
@endif


@if($color == "theme-4")
<style type="text/css">
    .m-list-active, .m-list-active:hover, .m-list-active:focus {
    background:linear-gradient(141.55deg, rgba(104, 94, 229, 0) 3.46%, #685ee5 99.86%), #584ed2 !important;
}
.mc-sender p {
    background: linear-gradient(141.55deg, rgba(104, 94, 229, 0) 3.46%, #685ee5 99.86%), #584ed2 !important;
}

.messenger-favorites div.avatar {
    box-shadow: 0px 0px 0px 2px #584ed2 !important;
}
.messenger-listView-tabs a, .messenger-listView-tabs a:hover, .messenger-listView-tabs a:focus {
    color: linear-gradient(141.55deg, rgba(104, 94, 229, 0) 3.46%, #685ee5 99.86%), #584ed2 !important;
}
.m-header svg {
    color: #584ed2 !important;
}
.active-tab {
    border-bottom: 2px solid  #584ed2 !important;
}
.messenger-infoView nav a {
  
    color: linear-gradient(141.55deg, rgba(104, 94, 229, 0) 3.46%, #685ee5 99.86%), #584ed2 !important;
}
.lastMessageIndicator {
    color: #584ed2 !important;
}

.messenger-list-item td span .lastMessageIndicator {

    color: #584ed2 !important;
    font-weight: bold;
}
.messenger-sendCard button svg {
     color: #584ed2 !important;
}
.messenger-list-item.m-list-active td span .lastMessageIndicator{
    color: #fff !important;
}
</style>
@endif