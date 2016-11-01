@extends('layouts/app')
	@section('content')
		<div class="row " >
			<div class="col-md-12 col-sm-12 col-xs-12" ng-controller="content">
                <h2>Reserve your stand for {{$stand->event->name}}</h2>
                <div class="col-sm-8 col-md-6">
                    <div class="alert <% msgCls %>" data-ng-show="msg" data-ng-bind="msg"></div>
                   <form class="form-horizontal" ng-submit="submitForm(frmRegister.$valid)" name="frmRegister" id="frmRegister" method="POST" novalidate
                   enctype="multipart/form-data">
                        <input type="hidden" name="standId" value = "{{$stand->id}}">
                        <input type="hidden" name="eventId" value = "{{$stand->event_id}}">
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Stand</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" value="{{$stand->name}}" readonly>
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-offset-6 col-sm-6 text-left"><strong>Company Detail</strong></label>
                        </div>
                        
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Company Name</label>
                          <div class="col-sm-6">
                            <input type="text" name="companyName" class="form-control"  placeholder="Company Name"
                            ng-model="register.companyName" required>
                            <span ng-show="frmRegister.companyName.$invalid && frmRegister.$submitted" class="help-block validationError">required.</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Company Email</label>
                          <div class="col-sm-6">
                            <input type="email" name="companyEmail" class="form-control"  placeholder="Company Email" ng-model="register.companyEmail" required>
                            <span ng-show="frmRegister.companyEmail.$invalid && frmRegister.$submitted" class="help-block validationError">required.</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Company Admin Name</label>
                          <div class="col-sm-6">
                            <input type="text"  name="companyAdminName" class="form-control"  placeholder="Company Admin Name" ng-model="register.companyAdminName" required>
                            <span ng-show="frmRegister.companyAdminName.$invalid && frmRegister.$submitted" class="help-block validationError">required.</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Company Address</label>
                          <div class="col-sm-6">
                            <textarea class="form-control"  name="companyAddress" placeholder="Company Address" ng-model="register.companyAddress" required></textarea>
                             <span ng-show="frmRegister.companyAddress.$invalid && frmRegister.$submitted" class="help-block validationError">required.</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Upload Company Logo</label>
                          <div class="col-sm-6">
                            <input type="file" name="companyLogo" accept="image/*" file-upload>
						</span>
                          </div>
                        </div>    
                        <div class="form-group">
                          <label  class="col-sm-offset-6 col-sm-6 text-left"><strong>Marketing Document</strong></label>
                        </div>
                        
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Upload Marketing Document 1</label>
                          <div class="col-sm-6">
                            <input type="file" name="marketingDoc[]"
                             onchange="angular.element(this).scope().setFile(this, 1)" file-upload>
                                <%theFile1.name%>
                                <%FileMessage1%>
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Upload Marketing Document 2</label>
                          <div class="col-sm-6">
                            <input type="file" name="marketingDoc[]"
                             onchange="angular.element(this).scope().setFile(this, 2)" file-upload>
                                <%theFile2.name%>
                                <%FileMessage2%>
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Upload Marketing Document 3</label>
                          <div class="col-sm-6">
                            <input type="file" name="marketingDoc[]"
                             onchange="angular.element(this).scope().setFile(this, 3)" file-upload>
                                <%theFile3.name%>
                                <%FileMessage3%>
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-offset-6 col-sm-6 text-left"><strong>Contact Detail</strong></label>
                        </div>
                            
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Contact Full Name</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control"  placeholder="Full Name" name="contactName" ng-model="register.contactName" required>
                            <span ng-show="frmRegister.contactName.$invalid && frmRegister.$submitted" class="help-block validationError">required.</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-6 control-label">Contact Email</label>
                          <div class="col-sm-6">
                            <input type="email" class="form-control"  placeholder="Email" name="contactEmail" ng-model="register.contactEmail" required>
                            <span ng-show="frmRegister.contactEmail.$invalid && (frmRegister.contactEmail.$dirty || frmRegister.$submitted)" class="help-block validationError">Enter valid email.</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-offset-6 col-sm-6">
                            <input ng-show="!frmRegisterLoading" type="submit" name="save" value="Register" class="btn btn-primary">
                            <span   ng-show="frmRegisterLoading">Loading...</span>                                
                            <a href="{{route('event', $stand->event_id)}}"><button type="button" class="btn btn-default">Cancel</button>
                                </a>
                          </div>
                        </div>
                      </form>
                </div>
            </div>
		</div>
    @endsection
    @section('jsSection')
        
<script>
        ngApp.controller('content', function ($scope, $http, $compile, $filter) {
        
            $scope.eventId  =   '{{$stand->event_id}}';
            $scope.msg = "";
			$scope.frmRegisterLoading = false;
            //file upload validation
			$scope.setFile = function(element, num) {
                    $scope.$apply(function($scope) {
                        $scope['theFile'+num] = element.files[0];
                        $scope['FileMessage'+num] = '';
                        var filename = element.files[0].name;//$scope.theFile.name;
                        var index = filename.lastIndexOf(".");
                        var strsubstring = filename.substring(index, filename.length);
                        if (strsubstring == '.pdf' || strsubstring == '.doc' || strsubstring == '.xls' || strsubstring == '.png' || strsubstring == '.jpeg' || strsubstring == '.png' || strsubstring == '.gif' || strsubstring == '.jpg')
                        {
                          //  console.log('File Uploaded sucessfully');
                        }
                        else {
                            $scope['theFile'+num] = '';
                            $scope['FileMessage'+num] = 'please upload correct File Name, File extension should be .pdf, .doc or .xls or image file';
                        }

                    });
                };
                
             //an array of files selected
            $scope.files = [];
		
            //listen for the file selected event
            $scope.$on("fileSelected", function (event, args) {
                    $scope.$apply(function () {
                    //add the file object to the scope's files collection
                    $scope.files.push(args.file);
                    });
            });
        
			$scope.submitForm = function(isValid) {
				$scope.msg = "";
                $scope.msgCls = ' alert-warning';
				// check to make sure the form is completely valid
				if (isValid) {
					//call ajax
					$scope.frmRegisterLoading = true;
					var dataObj = {};
					$.each($("#frmRegister").serializeArray(), function(k,v) {
						dataObj[v.name] = v.value;
					});
        
					$scope.postedData = dataObj;
				    $http.post(routeUrl+'/register', { postedData: $scope.postedData, files: $scope.files }
						, {
							headers: {'Content-Type': undefined},//dont use false
							transformRequest: function (data) {
                                return setUploadedFilesRequest(data, 'frmRegister');
							}
						}
					)
					.success(function(data){
						if (data.success) {
							//redirect to event hall page
                            location.href = routeUrl+'/event/'+$scope.eventId;
						} else {
							//display error
							$scope.msg = "Error : "+data.error;
                            $scope.frmRegisterLoading = false;
						}
						
					});
				}
			};
        
    });

</script>
@stop