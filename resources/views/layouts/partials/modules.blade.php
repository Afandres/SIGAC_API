<!-- ======= Services Section ======= -->
    <section id="modules" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Modulos</h2>
          <p>Aplicativos para las unidades productivas</p>
        </div>

        {{-- @foreach(getAppsArray() as $cod => $app)                    
                    <div class="puzzle" style="background-image:url('{{ asset('/general/images/puzzle'.$loop->iteration.'.png') }}');">
                    <span class="t" style="background-color: {{ getColorsArray($cod) }}"></span>
                    <span class="r" style="background-color: {{ getColorsArray($cod) }}"></span>
                    <span class="text"><a href="{{ getURLAppsArray($cod) }}"><i class="{{ getIconsArray($cod) }}" data-toggle="tooltip" data-placement="top" title="{{ $app }}"></i></a></span>
                    </div>
                  @endforeach  --}}

        <div class="row">
          @foreach(getAppsArray() as $cod => $app)
          <div class="col-xl-3 col-md-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100" style="padding: 1%;">
            <div class="icon-box">
              <div class="icon"><i class="{{ getIconsArray($cod) }}"></i></div>
              <h4><a href="{{ getURLAppsArray($cod) }}">{{ $app }}</a></h4>
              <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
            </div>
          </div>
          @endforeach
          

        </div>

      </div>
    </section><!-- End Services Section -->