@foreach($testimonials as $t)
    <div class="testimonial-box-wrapper">
        <div class="testimonial-box">
            <p>{{ $t->message }}</p>
            <div class="testimonial-image">
                <img src="{{ $t->image_url }}" alt="{{ $t->name }}">
                <h1>{{ $t->name }} <span>{{ $t->location }}</span></h1>
            </div>
        </div>
    </div>
@endforeach