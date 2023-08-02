
{{-- <div class='row'> --}}
 <div class="col-5  text-end" style="margin-left: 51px;">
     <h5>{{__('Indicator')}}</h5>
 </div>
 <div class="col-4  text-end">
    <h5>{{__('Appraisal')}}</h5>
</div>
@foreach ($performance_types as $performance_type)
<div class="col-md-12 mt-3">
    <h6>{{ $performance_type->name }}</h6>
    <hr class="mt-0">
</div>

@foreach ($performance_type->types as $types)
    <div class="col-4">
        {{ $types->name }}
    </div>
    <div class="col-4">
        
            <fieldset id='demo' class="rate">
                <input class="stars" type="radio" id="technical-5*-{{ $types->id }}"
                    name="ratings[{{ $types->id }}]" value="5"
                    {{ isset($ratings[$types->id]) && $ratings[$types->id] == 5 ? 'checked' : '' }} disabled>
                <label class="full" for="technical-5*-{{ $types->id }}"
                    title="Awesome - 5 stars"></label>
                <input class="stars" type="radio" id="technical-4*-{{ $types->id }}"
                    name="ratings[{{ $types->id }}]" value="4"
                    {{ isset($ratings[$types->id]) && $ratings[$types->id] == 4 ? 'checked' : '' }} disabled>
                <label class="full" for="technical-4*-{{ $types->id }}"
                    title="Pretty good - 4 stars"></label>
                <input class="stars" type="radio" id="technical-3*-{{ $types->id }}"
                    name="ratings[{{ $types->id }}]" value="3"
                    {{ isset($ratings[$types->id]) && $ratings[$types->id] == 3 ? 'checked' : '' }} disabled>
                <label class="full" for="technical-3*-{{ $types->id }}"
                    title="Meh - 3 stars"></label>
                <input class="stars" type="radio" id="technical-2*-{{ $types->id }}"
                    name="ratings[{{ $types->id }}]" value="2"
                    {{ isset($ratings[$types->id]) && $ratings[$types->id] == 2 ? 'checked' : '' }} disabled>
                <label class="full" for="technical-2*-{{ $types->id }}"
                    title="Kinda bad - 2 stars"></label>
                <input class="stars" type="radio" id="technical-1*-{{ $types->id }}"
                    name="ratings[{{ $types->id }}]" value="1"
                    {{ isset($ratings[$types->id]) && $ratings[$types->id] == 1 ? 'checked' : '' }} disabled>
                <label class="full" for="technical-1*-{{ $types->id }}"
                    title="Sucks big time - 1 star"></label>
            </fieldset>
    </div>
    <div class="col-4">
        <fieldset id='demo1' class="rate">
            <input class="stars" type="radio" id="technical-5-{{ $types->id }}"
                name="rating[{{ $types->id }}]" value="5" />
            <label class="full" for="technical-5-{{ $types->id }}"
                title="Awesome - 5 stars"></label>
            <input class="stars" type="radio" id="technical-4-{{ $types->id }}"
                name="rating[{{ $types->id }}]" value="4" />
            <label class="full" for="technical-4-{{ $types->id }}"
                title="Pretty good - 4 stars"></label>
            <input class="stars" type="radio" id="technical-3-{{ $types->id }}"
                name="rating[{{ $types->id }}]" value="3" />
            <label class="full" for="technical-3-{{ $types->id }}"
                title="Meh - 3 stars"></label>
            <input class="stars" type="radio" id="technical-2-{{ $types->id }}"
                name="rating[{{ $types->id }}]" value="2" />
            <label class="full" for="technical-2-{{ $types->id }}"
                title="Kinda bad - 2 stars"></label>
            <input class="stars" type="radio" id="technical-1-{{ $types->id }}"
                name="rating[{{ $types->id }}]" value="1" />
            <label class="full" for="technical-1-{{ $types->id }}"
                title="Sucks big time - 1 star"></label>
        </fieldset>
       
</div>

@endforeach
@endforeach