@extends('layouts/app')
	@section('content')
		<div class="row " >
			<div class="col-md-12 col-sm-12 col-xs-12" ng-controller="content">
				
                    <div id="map"></div>
                    <div id="eventLocation"></div>
                        
			</div>
		</div>
    @endsection
    
    @section('jsSection')
        <script src="http://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBQmCUkH_810-Fxq2WYzLtwFAhmzhmnMTo"></script>
      
<script>
	
    ngApp.controller('content', function ($scope, $http, $compile, $filter) {
        
        $scope.events  =   {!!$events->toJson()!!};
        $scope.cities = [];
        $scope.eventArr = [];
        angular.forEach($scope.events, function(value, key){
            cityObj = {
                        city    :   value.location.city_name,
                        desc    :   value.name,
                        lat     :   value.location.latitude,
                        long    :   value.location.longitude,
                        eventId  :   value.id
                       };
            $scope.cities.push(cityObj);
            $scope.eventArr[value.id] = value;
        });
            
            var mapOptions = {
                  zoom: 4,
                  center: {lat: 41.850033, lng: -87.6500523},
                  mapTypeId: google.maps.MapTypeId.ROADMAP
            }

            $scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);

            $scope.markers = [];
              
            var infoWindow = new google.maps.InfoWindow();
            var createMarker = function (info){
                  var marker = new google.maps.Marker({
                      map: $scope.map,
                      position: new google.maps.LatLng(info.lat, info.long),
                      title: info.city
                  });
                  marker.content = '<div class="infoWindowContent">' + info.desc + '</div>';
                  
                  google.maps.event.addListener(marker, 'click', function(){
                      //infoWindow.setContent('<h2>' + marker.title + '</h2>' + marker.content);
                      //infoWindow.open($scope.map, marker);
                      //display content
                      $scope.openEventDetail(info.eventId);
                  });
                  
                  $scope.markers.push(marker);
                  
              }  
              
              angular.forEach($scope.cities, function(obj, key) {
                  createMarker(obj);
              });

              $scope.openInfoWindow = function(e, selectedMarker){
                  e.preventDefault();
                  google.maps.event.trigger(selectedMarker, 'click');
              }
           
            $scope.getLocation = function(obj) {
                var ret = (obj.address) ? obj.address+"<br>" : '';
                ret += obj.city_name+', '+obj.state_name + ', ' + obj.country_name;
                ret += '<br>' + obj.zipcode;
                return ret;
            }
            
            /* convert to local date
            */
            $scope.convertToDate = function (stringDate){
                var dateOut = new Date(stringDate);
                dateOut.setDate(dateOut.getDate());// + 1);
                return dateOut;
            };
  
            $scope.setLocationDisp = function(event) {
                evStart = $scope.convertToDate(event.start_date);
                evStart = $filter('date')(evStart, 'MM-dd-yyyy @ h:mma');

                evEnd = $scope.convertToDate(event.end_date);
                evEnd = $filter('date')(evEnd, 'MM-dd-yyyy @ h:mma');

                var html = '';
                html    += '<div class="eventDispRow" ng-show="eventDetail_'+event.id+'">';
                html    += '<label id="names" >'+event.name+'</label><br>';
                html    += 'Location : '+$scope.getLocation(event.location)+'<br>';
                html    += 'Start Date : '+evStart+'<br>';
                html    += 'End Date : '+evEnd+'<br>';
                html    += '<a href="'+routeUrl+'/event/'+event.id+'"><button>Book your place</button></a>';
                html    += '</div>';
                return html;
            }
            
            $scope.openEventDetail = function (eventId) {
                 $scope.$apply(function(){
					$scope['eventDetail_'+eventId] = true;
                 });
                 var eventObj = $scope.eventArr[eventId];
                 angular.element("#eventLocation").html($scope.setLocationDisp(eventObj));
            }
    });

</script>
@stop