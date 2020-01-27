<style>

[data-overlay="5"]::before {
        background-color: #FFF !important;
}



</style>


<div class="col-md-6 col-lg-7 col-xl-8 d-none d-md-block bg-img overlay-darker"
     style="background-image: url('{{asset('assets/images/backgrounds/login.jpg')}}')" data-overlay="5">

    <div class="row">
        <div class="col-md-12 col-lg-12 align-self-end">
            <a href="{{route('index')}}">
                <img class="img-fluid" id="logo" src="{{asset('assets/images/logo/logo-current.png')}}" width="380">
            </a>
            <br><br>
        </div>
        <div class="col-md-12 col-lg-12 align-self-end">
            <a href="{{route('index')}}">
                <!--<h4 class="text-white">Datascale</h4>-->
            </a>
            <br><br>
        </div>
    </div>
</div>

<script>

$(function(){
    
   var largura = $('.row').find('img.img-fluid').width();
   var altura = $('.row').find('img.img-fluid').height();

   
   $('.row').find('img.img-fluid').css('position', 'absolute');
   
   $('.row').find('img.img-fluid').css('left', 50+'%').css('margin-left', -(largura/2));
   
   $('.row').find('img.img-fluid').css('top', 50+'%').css('margin-top', (altura/2));
   
    
})



</script>


