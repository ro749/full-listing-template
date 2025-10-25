<!DOCTYPE html>
<html lang="zxx">

@include('head')

<body>

    <div id="wrapper">

        <div class="float-text show-on-scroll">
            <span><a href="#">Scroll to top</a></span>
        </div>
        <div class="scrollbar-v show-on-scroll"></div>
        
        @include('header')
                @if(isset($imp))
                    <div id="image-map-pro"></div>
                @else
                    <div style="display: flex; flex-direction: row; justify-content: center;">
                        <img src="https://propstudios.mx/img/{{ $unit->unit }}.">
                    </div>
                @endif
                <section id="unit-info" class=" section-dark text-light" 
                style = "background-color: rgb(172, 102, 69);
                @if(empty($unit))
                display: none;
                @endif
                "
                >
                    <div class="container">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-4">
                                <div class="pe-lg-3">
                                    <h1 class="wow fadeInUp" data-wow-delay=".4s"><x-f-text id="unit" :unit="$unit"></x-f-text></h1>
                                    <div class="d-flex justify-content-left align-items-left">
                                         <img src="images/svg/size.svg" class="w-30px me-3" alt=""><div class=""><x-f-text id="m2_departamento" :unit="$unit"></x-f-text> m² Departamento</div>
                                    </div><br>
                                    <x-f-conditional :unit="$unit" id="m2_techados_terraza" >
                                        <div class="d-flex justify-content-left align-items-left">
                                            <img src="images/svg/size.svg" class="w-30px me-3" alt=""><div class=""><x-f-text id="m2_techados_terraza" :unit="$unit"></x-f-text> m² Terraza techada</div>
                                        </div>
                                         <br>
                                    </x-f-conditional>
                                    <x-f-conditional :unit="$unit" id="m2_sin_techar">
                                        <div class="d-flex justify-content-left align-items-left">
                                            <img src="images/svg/size.svg" class="w-30px me-3" alt=""><div class=""><x-f-text id="m2_sin_techar" :unit="$unit"></x-f-text> m² Terraza sin techar</div>
                                        </div>
                                        <br>
                                    </x-f-conditional>
                                    <div class="d-flex justify-content-left align-items-left">
                                         <img src="images/svg/size.svg" class="w-30px me-3" alt=""><div class=""><x-f-text id="m2_totales" :unit="$unit"></x-f-text> m² Totales</div>
                                    </div><br>
                                    <p class="wow fadeInUp" data-wow-delay=".6s" style="margin-bottom: 1rem !important;">
                                        Un modelo de departamento que promueve independencia y estilo, perfecto para quienes desean reconectar y disfrutar la ciudad al máximo, inspirado en la autenticidad y la identidad de Guadalajara.
                                    </p>           
                            <br>
                                                                
                                                                
                                </div>
                            </div>
                            
                                             
                            <div class="col-lg-8">
                                <x-f-image :unit="$unit" id="iso" data="modelo" src="https://propstudios.mx/img//Modelos/" ext="." class="w-100 wow fadeInUp" data-wow-delay=".2s" alt=""></x-f-image>
                            </div>
                        </div>

                        <div class="spacer-double"></div>
                    </div>
                    @include('listing-utils::Plans.plans',['plans'=>$plans])
                    @if(isset($sender))
                    @include('listing-utils::Sender.sender-buttons',['sender'=>$sender])
                    @endif
                </section>
        @if(isset($asesor_area))
        @include('asesor-area')
        @endif
    </div>

    <!-- footer begin -->
    <footer class="section-dark" style="background-color:#ad6745 !important;">
        <div class="container">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center">
                        <img src="https://propstudios.mx/img/siomona/Logo/barragan-moreno-w.png" class="w-400px" alt="">
                        <div class="spacer-single"></div>
                        <div class="fs-16">
                            {{ $location }}
                        </div>
                    </div>
                </div>                
            </div>

            <div class="spacer-double"></div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 mb-sm-30">
                    <div class="d-flex justify-content-center" style="align-items: center; gap: 1rem;">
                        <i class="fs-30 id-color icon_phone" style="height: auto; "></i>
                        <h4 class="mb-0">Llámanos</h4>      
                    </div>
                    <p style="text-align: center">{{ $phone }}</p>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-sm-30">
                    <div class="d-flex justify-content-center" style="align-items: center; gap: 1rem;">
                        <i class="fs-30 id-color icon_clock" style="height: auto; "></i>
                        <h4 class="mb-0">Horario</h4>      
                    </div>
                    <p style="text-align: center">{{ $schedule }}</p>
                </div>
                    
                <div class="col-lg-4 col-md-6 mb-sm-30">
                    <div class="d-flex justify-content-center" style="align-items: center; gap: 1rem;">
                        <i class="fs-30 id-color icon_mail" style="height: auto; "></i>
                        <h4 class="mb-0">Email</h4>      
                    </div>
                    <p style="text-align: center">{{ $email }}</p>
                </div>              
            </div>

        </div>
        <div class="subfooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="text-align:center;">
                        <a href="https://propstudios.mx/">Sistema Desarrollado por PropStudios</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@push('scripts')
<script>
    
    window.addEventListener('resize', function() {
        $('body').css({
          width: '100%',
          height: '100%'
        });
    });
</script>
@endpush
@include('scripts')
</body>

</html>
