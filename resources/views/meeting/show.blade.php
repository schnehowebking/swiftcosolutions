<div class="col-xl-12 col-lg-12 col-md-12">
    <div class="card">
        <div class="tab-content tab-bordered">
            <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="">
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4"><span class="h6 text-sm mb-0">Date:</span>
                                    </dt>
                                    <dd class="col-sm-8"><span class="text-sm">{{ $meetings->date }}</span>
                                    </dd>
                                    <dt class="col-sm-4"><span class="h6 text-sm mb-0">Time:</span>
                                    </dt>
                                    <dd class="col-sm-8"><span class="text-sm">{{ $meetings->time }}</span>
                                    </dd>
                                    {{-- <dt class="col-sm-4"><span class="h6 text-sm mb-0">Note:</span></dt>
                                    <dd class="col-sm-8"><span class="text-sm">{{ $meetings->note }}</span></dd> --}}
                                </dl>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
