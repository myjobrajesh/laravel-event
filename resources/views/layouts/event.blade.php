@extends('layouts/app')
	@section('content')
		<div class="row " >
			<div class="col-md-12 col-sm-12 col-xs-12" ng-controller="content">
                <h2>{{$event->name}}</h2>
                <div class="pull-left"><a href="{{route('eventover', $event->id)}}">Event Over</a> ( for Admin use)<br><br></div>
                <div class="hallMap col-sm-12 col-md-12">
                   <table class="hallTable" style="width:100%">
                        <tr>
                        @foreach($event->stands as $k=>$stand)
                            @if($k%4==0 && $k!=0)
                                </tr><tr><td colspan="4" class="centerPath">&nbsp;</td></tr><tr>
                            @endif
                            <td class="hallBlock {{($stand->booking) ? 'hallBooked' : ''}}" style="width:25%">
                                @if($stand->booking)
                                <p class="hallCompany">
                                    @if($stand->booking->company_logopath)
                                    <span><img src="{{$stand->booking->company_logopath}}" width="50px" class="img-responsive"></span><br>
                                    @endif
                                    @if($stand->booking->documents)
                                    <span>
                                        @foreach($stand->booking->documents as $doc)
                                            <a href="{{$doc->filepath}}" target="_blank" download>Download Document</a><br>
                                        @endforeach
                                    </span>
                                    @endif
                                    <span>
                                    Contact info:<br>
                                    Company Name : {{$stand->booking->company_name}}<br>
                                    Company Email : {{$stand->booking->company_email}}<br>
                                    Contact Name : {{$stand->booking->contact_name}}<br>
                                    Contact Email : {{$stand->booking->contact_email}}<br>
                                    </span>
                                </p>
                                @else
                                    <a href="#" class="openStand" ng-click="openStandModal({{$stand->toJson()}})">
                                    <p>{{config('app.currencySymbol').$stand->price}}</p>
                                @endif
                                <p>
                                {{$stand->name}}
                                </p>
                                @if($stand->booking)
                                    <p style="font-size:15px;">BOOKED</p>
                                @else
                                    </a>
                                @endif
                            </td>
                        @endforeach
                        </tr>    
                    </table>
                        
                </div>
            
                <div class="modal fade"  role="dialog" id="standModal">
                    <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" ng-click="reserveBtn()">Reserve</button>
                        </div>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
            </div>
                
		</div>
    @endsection
    @section('jsSection')
        
<script>
    ngApp.controller('content', function ($scope, $http, $compile, $filter) {
        console.log("content loaded");
        
        $scope.currentStand = 0;
        $scope.openStandModal = function (standObj) {
            $scope.currentStand =   standObj.id;
            
            modalObj = angular.element('#standModal');
            
            //set content for the modal
            var content = '';
            if(standObj.description) {
                content += '<p>' + standObj.description+'</p>';
            }
            if(standObj.filepath) {
                content += '<p><img src="'+standObj.filepath+'" border="0" width="100px"></p>';
            }
            content += '<p>Price : $' + standObj.price+'</p>';
            
            modalObj.find('.modal-title').html(standObj.name);
            
            modalObj.find('.modal-body').html(content);
            
            modalObj.modal('show');
        }
        
        $scope.reserveBtn = function () {
            //redirect to register page with stand id and store this in sessin
            location.href = routeUrl+'/register/'+$scope.currentStand;
            //console.log($scope.currentStand);
        }
    });

</script>
@stop