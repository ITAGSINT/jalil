@extends('layouts.Dashboard.main')
@section('content')
<div class="content-wrapper  tab-one "  >
    

    <div class="row ">
                      <div class="col-12 grid-margin">
                        <div class="card" >
                          <div class="card-body">
                            <h4 class="card-title " >{{ __('dashboard/Reports.Reports') }}</h4>
                            <div class="table-responsive">
                              <table class="table">
                                <thead>
                                  <tr>
                                   
                                    <th>   {{ __('dashboard/Reports.Report_name') }} </th>
                                    <th>  {{ __('dashboard/Reports.Order_number') }} </th>
                                   
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    
                                    <td>
                                      <img src="{{asset('assets/images_d/faces/face1.jpg')}}" alt="image" />
                                      <span class="pl-2">Henry Klein</span>
                                    </td>
                                    <td> 02312 </td>
                                    
                                  </tr>
                                  <tr>
                                    
                                    <td>
                                      <img src="{{asset('assets/images_d/faces/face2.jpg')}}" alt="image" />
                                      <span class="pl-2">Estella Bryan</span>
                                    </td>
                                    <td> 02312 </td>
                                    
                                   
                                    
                                  </tr>
                                  <tr>
                                   
                                    <td>
                                      <img src="{{asset('assets/images_d/faces/face5.jpg')}}" alt="image" />
                                      <span class="pl-2">Lucy Abbott</span>
                                    </td>
                                    <td> 02312 </td>
                                   
                                   
                                    
                                  </tr>
                                  <tr>
                                    
                                    <td>
                                      <img src="{{asset('assets/images_d/faces/face3.jpg')}}" alt="image" />
                                      <span class="pl-2">Peter Gill</span>
                                    </td>
                                    <td> 02312 </td>
                                    
                                  </tr>
                                  <tr>
                                   
                                    <td>
                                      <img src="{{asset('assets/images_d/faces/face4.jpg')}}" alt="image" />
                                      <span class="pl-2">Sallie Reyes</span>
                                    </td>
                                    <td> 02312 </td>
                                   
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

   </div>

  @endsection
 
