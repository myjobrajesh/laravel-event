<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use Validator;
use Exception;

use App\Models\BookingDocument;

class UserController extends Controller
{
    
    
    /* show the register form for stand register
     * @param integer $standId
     * @return html view
     */
    public function registerStandShow(Request $request, $standId) {
        
        //get event name from standId
        $stand   =   \App\Models\EventStand::with(['event'])->find($standId);
        return view('layouts.register', compact('stand'));
    }
    
    
    /* save registration with booking information
     */
    public function saveRegistration(Request $request) {
            $postedData = (array) json_decode($request->get('postedData'));
            $rules  =   [
                     'companyName'  =>  'required',
                     'companyEmail' =>  'required|email',
                     'companyAdminName' =>  'required',
                     'companyAddress'   =>  'required',
                     'contactName'   =>  'required',
                     'contactEmail'  =>  'required|email',
                     'standId'  =>  'required|unique:event_bookings,stand_id',
                     'eventId'  =>  'required',
                     ];
			$validator = Validator::make($postedData, $rules);

            if ($validator->fails()) {
                foreach($validator->errors()->getMessages() as $msg) {
                    $msgArr[] = $msg[0];
                }
                $response = array("error" => implode("<br>", $msgArr));
            } else {
                //0. validate uploaded files
                $pathToSave = [];
                if(isset($request->file)) {
                    $filesArr   =   $request->file;
                    $fileFieldNames = $request->fileFieldName;
                    $maxSize = config('app.maxUploadSize');
                    //validation
                    foreach($filesArr as $k=>$file) {
						//$file =  $filesArr[0];
						$originalExt = strtolower($file->getClientOriginalExtension());
						$ext = (!$originalExt) ? strtolower($file->guessExtension()): $originalExt;
						$attachExt = (!$originalExt) ? ".".$ext : "";
                        if($fileFieldNames[$k] == "companyLogo") {
                            $validExt = array('jpg', 'jpeg', 'png', 'gif');    
                        } else {//for booking documents
                            $validExt = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx');
                        }
						
						if(!in_array($ext, $validExt)) {
							$response = array("error" => "Allowed filetypes : ".implode(',', $validExt));
							return Response::json($response);
						}
						//get size validation
						
						if($maxSize < $file->getSize()) {//bytes
							$response = array("error" => "Cannot upload large file");
							return Response::json($response);
						}
					}
                    //save to folder
                    
                    foreach($filesArr as $k=>$file) {
                        $fieldName = $fileFieldNames[$k];
                        try {
                            $path = \App\Models\FileUpload::uploadFile($file);    
                        } catch (Exception $e) {
                            $response = array("error" => "Cannot upload file");
							return Response::json($response);
                        }
                        
                        if($fieldName == "companyLogo") {
                            $pathToSave['companyLogo'] = $path;
                        } else {
                            $pathToSave['companyDocuments'][] = $path;
                        }
                    }
               }
               
               //1. save to booking table
                try {
                    $bookingObj                      =   app()->make('App\Models\EventBooking');
                    $bookingObj->stand_id            =   $postedData['standId'];
                    $bookingObj->event_id            =   $postedData['eventId'];
                    $bookingObj->company_name        =   isset($postedData['companyName']) ? $postedData['companyName'] : '';
                    $bookingObj->company_logopath    =   isset($pathToSave['companyLogo']) ? $pathToSave['companyLogo'] : '';
                    $bookingObj->company_admin_name  =   isset($postedData['companyAdminName']) ? $postedData['companyAdminName'] : '';
                    $bookingObj->company_email       =   isset($postedData['companyEmail']) ? $postedData['companyEmail'] : '';
                    $bookingObj->company_address     =   isset($postedData['companyAddress']) ? $postedData['companyAddress'] : '';
                    $bookingObj->contact_name        =   isset($postedData['contactName']) ? $postedData['contactName'] : '';
                    $bookingObj->contact_email       =   isset($postedData['contactEmail']) ? $postedData['contactEmail'] : '';
                    $bookingObj->created_at          =   date("Y-m-d H:i:s");
                    $bookingObj->save();
                    if($bookingId = $bookingObj->id) {
                        try {
                            //2. save to booking document
                            if(isset($pathToSave['companyDocuments'])) {
                                 $arr = [];
                                 foreach($pathToSave['companyDocuments'] as $doc) {
                                     $arr[] = [
                                               'booking_id'   =>  $bookingId,
                                               'name'        =>  'document',
                                               'filepath'    =>  $doc
                                               ];
                                 }
                                 BookingDocument::insert($arr);
                            }
                        } catch (Exception $e) {
                            echo $e->getMessage();
                            $response = array("error" => "Booking document save error");
                            return Response::json($response);
                        }
                        $response = ['success' => true];
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                    $response = array("error" => "Booking save error");
            		return Response::json($response);
                }
            }
        return Response::json($response);
        
    }
    
   
}
