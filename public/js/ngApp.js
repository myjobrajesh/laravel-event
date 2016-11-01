	//commoon for all the apps
	ngModules = [];
	if (typeof ngModuleArr != 'undefined') {
		$(ngModuleArr).each(function(k,v){
			ngModules.push(v);	
		});
	}
	ngApp = angular.module("eventApp", ngModules, function($interpolateProvider) {
		//change default symbol
		$interpolateProvider.startSymbol('<%');
		$interpolateProvider.endSymbol('%>');
	});
    
    ngApp.constant('routeUrl', routeUrl);

	ngApp.filter('nl2br', function($sce){
		return function(input) {
			return input ? $sce.trustAsHtml(input.replace(/\n/g, '<br/>')) : input;
		}
	});

	ngApp.filter('replace', function($sce){
		return function(input, replaceWith) {
			return input ? input.replace(input, replaceWith) : input;
		}
	});

	var compareTo = function() {
		return {
			require: "ngModel",
			scope: {
				otherModelValue: "=compareTo"
			},
			link: function(scope, element, attributes, ngModel) {
				ngModel.$validators.compareTo = function(modelValue) {
					return modelValue == scope.otherModelValue;
				};
				scope.$watch("otherModelValue", function() {
					ngModel.$validate();
				});
			}
		};
	};

	ngApp.directive("compareTo", compareTo);

	ngApp.directive('fileUpload', function () {
		return {
			scope: true,        //create a new scope
			link: function (scope, el, attrs) {
				el.bind('change', function (event) {
					var files = event.target.files;
					//iterate files since 'multiple' may be specified on the element
					for (var i = 0;i<files.length;i++) {
						//emit event upward
						scope.$emit("fileSelected", { file: files[i] });
					}                                       
				});
			}
		};
	});

function setUploadedFilesRequest(data, frmId) {
    var formData = new FormData();
		formData.append("postedData", angular.toJson(data.postedData));
		uploadedFiles = new Array();
        uploadedFieldNames = new Array();
        $("#"+frmId+" input[type='file']").each(function(k,v) {
            if ($(v).val()) {
                //store only filename
                value = $(v).val();
                value =  value.split("\\").pop();//for Chrome specific
                uploadedFiles.push(value);
                uploadedFieldNames[value] = v.name;
                }
            });
            counter = 0;
            $(data.files).each(function(k,v) {
                if ($.inArray(v.name, uploadedFiles)!=-1) {
                    v.fieldName = uploadedFieldNames[v.name];
                    formData.append("file[" + counter+"]", v);
                    formData.append("fileFieldName[" + counter+"]", uploadedFieldNames[v.name]);
                    counter++;
                }
			});
		return formData;
}
