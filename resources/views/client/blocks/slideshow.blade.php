<div class="col-12">
    <div class="banner_slider slider_two">
        <div class="slider_active owl-carousel">
            @foreach ($slide_show as $key => $slideshow)
                <div class="single_slider" style="background-image: url({{asset('public/uploads/admin/slideshow/'. $slideshow->slidequangcao_anh)}})">
                    <div class="slider_content">
                        <div class="slider_content_inner">
                            <h1>{{ $slideshow->slidequangcao_tieu_de }}</h1>
                            <p>{{ $slideshow->slidequangcao_noi_dung }}</p>
                            <a href="#">shop now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
