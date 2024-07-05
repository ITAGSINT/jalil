@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/yes.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/change.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/changetwo.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<style>
  .nextcontainer {
    display: flex;
    align-items: center;
    justify-content: center;
    height: max-content;
    background-color: #9FE870;
    border-radius: 10px;
    padding: 12px 24px 12px 24px;
  }
</style>
@endsection
@section('content')
<div class="container">
  <div class="row w-100">
    <div class="col-lg-6 col-md-12 row ">
      <div class="col-12  choose choose-right">
        <div class="row w-100 ">
          <div class="col-11 ">
            <p class="right">My Address</p>
          </div>
          <div class="col-1">
            <a href="{{route('website.addmyaddress')}}" class="btn d-flex align-items-center justify-content-center" style="width: 100%;background-color: #F8F9FA;">
              <i class="bi bi-plus" style="color: #9098A5; "></i>

              </i>
            </a>
          </div>
        </div>


        <div class="row w-100 justify-content-center pt-1 h-100  address">
          <div class="col-12">
            @foreach($address as $add)

            <div class="form-check mt-4" style="background-color: #FAFBFD;padding-left: 2rem;border-radius: 7px;">
              <div class="row w-100">
                <div class="col-8">
                  <p class="showroom">{{$add['name']}}</p>
                  <p class="showroom">{{$add['state']}}. {{$add['city']}}, {{$add['street']}}</p>
                </div>
                <div class="col-4 d-flex justify-content-end">
                  <label class="form-check-label w-100 px-2" for="flexRadioDefault{{$add['id']}}"></label>

                  <a href="{{route('website.addresses.editmyAddress',$add['id'])}}" style="color:black"> <i class="bi bi-pencil p-2"></i></a>
                  <form method="POST" action="{{route('website.addresses.deleteMyAddress')}}">
                    @csrf
                    <input type="text" value="{{$add['id']}}" name="id" hidden>
                    <button type="submit" style="border:none;background:transparent"> <i class="bi bi-trash p-2"></i></button>
                  </form>
                </div>
              </div>

            </div>
            @endforeach



          </div>


        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-12 row ">
    <div>
              <img src="{{asset('image/addressespic.png')}}" style="width: 100% ;height:100%;object-fit: cover;">
            </div>
    </div>


  </div>

  <div class="row w-100 d-flex align-items-end justify-content-end pt-5 ">
    <div class="col-4 greenbutton m-0">
    <form method="POST" action="{{route('website.storeAddressTimeInSession')}}">
        @csrf
        <input type="text" id="address_id"  name="address_id"  value="" hidden >
        <input type="text" id="time"  name="time"  value="" hidden>
        <input type="text" id="date"  name="date"   value="" hidden>
        <input type="text" id="time2"  name="time2"  value="" hidden>
        <input type="text" id="date2"  name="date2"   value="" hidden>
        
        
     
      </form>
      {{--<a class="btn next " href="{{route('website.change.two')}}" role="button">Next</a>--}}
    </div>
  </div>

</div>





@endsection
@section('additional_scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{URL::asset('js/changetwo.js') }}"></script>
<script>
  $(document).ready(function() {
    for (let i = 0; i < 24; i++) {
            var temp=i;
              $("#myUL").append(`<li class="my-1 text-center"><a  class="myli"data-time2="${i}:00 - ${temp+1}:00" data-time="${i}:00">${i}:00 - ${temp+1}:00</a></li>`);
          }
  })
function handleClick(myRadio) {
    $('#address_id').val(myRadio)
    
   
}
</script>
@endsection