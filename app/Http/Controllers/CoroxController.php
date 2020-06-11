<?php

namespace Corox\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Corox\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Corox\Http\Middleware\RevalidateBackHistory;
use Corox\Models\RegisterStaffTeacher;
use Corox\Models\RegisterPeriod;
use Corox\Models\RegisterClasses;
use Corox\Models\RegisterSubject;
use Corox\Models\Corox_model;
use Corox\Models\RegisterSchoolInformation;
use Corox\Models\RegisterStaffInformation;
use Corox\Models\Role;
use Corox\Models\Permit;
use Validator;
class CoroxController extends Controller
{
          public function __construct(){
                    $this->middleware('preventBackHistory');
          }
          //show login here
          public function index(){
                    return view('login');
            
          }
          //select all user detail here
          public function news(){
                    $results=Corox_model::all();
                    return view('news',['result'=>$results]);
          }
          // finding each of users record by their id here
          public function show(Request $request,$id){
                    $result=Corox_model::find($id)->first();
                    if($result){
                              return view('show',['result'=>$result]);
                    }else{
                              $request->session()->flash('message', 'no such records');
                              Auth::logout();
                              return redirect('/Dregister/');
                    }
          }
          // show info settings page
          public function registerInfoSettings(){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                              $services = array();
                              $schoolServices =array();
                              $result= explode('-',$schoolInformation->school_services);
                              foreach($result as $key => $value){
                                        $services[$value]= $value;    
                              }
                              $arrayServices= explode('-','creche/playgroup-nursery-primary/basic-secondary');
                              $arrayServices =array_diff($arrayServices, $services);
                              foreach($arrayServices as $key => $value){
                                        $schoolServices[$value]= $value;    
                              }
                    }else{
                              $services = array();
                              $schoolServices = array();
                              $schoolInformation= new RegisterSchoolInformation;     
                    }
                    $date = date('Y');
                    return view('settings-information',['date'=>$date, 'schoolInformation'=> $schoolInformation,'userId'=>$userId, 'userEmail'=>$adminEmail, 'services'=>$services, 'schoolServices'=>$schoolServices]);
          }
          // create record info settings page
          public function registerInfoSettingsAdd( Request $request ){
                    $data = array();
                    $image = $request->file('profileImage');
                    if($image ===NULL || $image ==='' ){
                             $data['school_profile_image']  = $image; 
                    }else{                    
                              Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                              $data['school_profile_image'] =$image->getFilename().'.'.$image->getClientOriginalExtension();
                    }
                    $data['school_name'] =$request->name;
                    $data['school_email'] =$request->email;
                    $data['school_phone1'] =$request->phone1;
                    $data['school_phone2'] =$request->phone2;
                    $data['school_address'] =$request->address;
                    $data['school_license'] =$request->license;
                    $data['school_city'] =$request->city;
                    $data['school_social_media'] =$request->social;
                    $data['school_state'] =$request->state;
                    $data['school_localG'] =$request->localG;
                    $data['school_number_of_staffs'] =$request->numberStaff > 0 ? $request->numberStaff  : 1 ;
                    $data['school_description'] =$request->description;
                    $data['school_services'] =$request->services !==null ? implode('-',$request->services) :$request->services;
                    $data['school_establish_date'] =$request->date;
                    $data['school_license_number'] =$request->licenseNumber;                    
                    $data['school_postal_address'] =$request->postalAddress;
                    $data['corox_model_id'] =$request->userId;
                    $schoolInformation= RegisterSchoolInformation::create($data);
                    $date = date('Y');
                    return redirect('/Dregister/info-settings');
          }
          // update record info settings page
          public function registerInfoSettingsUpdate( Request $request ){
                    $schoolInformation = RegisterSchoolInformation::find($request->id);
                    $image = $request->file('profileImage');
                    $FileSystem = new Filesystem();
                    $directory = public_path().'/uploads/';
                    if($image ===NULL || $image ==='' ){
                            if($schoolInformation->school_profile_image !=Null || $schoolInformation->school_profile_image !='' ){
                              
                            }else{
                                        $schoolInformation->school_profile_image = $image; 
                            }
                    }elseif($image->getFilename().'.'.$image->getClientOriginalExtension() != $schoolInformation->school_profile_image){
                              if($FileSystem->exists($directory.$image->getFilename().'.'.$image->getClientOriginalExtension())){
                                        unlink(public_path('uploads/'.$schoolInformation->school_profile_image));                              
                                        Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                                        $schoolInformation->school_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                              }
                              Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                              $schoolInformation->school_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
                    }else{
                              if($FileSystem->exists($directory.$schoolInformation->school_profile_image)){
                                        unlink(public_path('uploads/'.$schoolInformation->school_profile_image));                              
                                        Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                                        $schoolInformation->school_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                              }
                              Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                              $schoolInformation->school_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
                    }
                    $schoolInformation->school_name =$request->name;
                    $schoolInformation->school_email =$request->email;
                    $schoolInformation->school_phone1 =$request->phone1;
                    $schoolInformation->school_phone2 =$request->phone2;
                    $schoolInformation->school_address =$request->address;
                    $schoolInformation->school_license =$request->license;
                    $schoolInformation->school_city =$request->city;
                    $schoolInformation->school_social_media =$request->social;
                    $schoolInformation->school_state =$request->state;
                    $schoolInformation->school_localG =$request->localG;
                    $schoolInformation->school_number_of_staffs =$request->numberStaff > 0 ? $request->numberStaff  : 1 ;
                    $schoolInformation->school_description =$request->description;
                    $schoolInformation->school_services =$request->services !==null ? implode('-',$request->services) :$request->services ;
                    $schoolInformation->school_establish_date =$request->date;
                    $schoolInformation->school_license_number =$request->licenseNumber;
                    $schoolInformation->school_postal_address =$request->postalAddress;
                    $schoolInformation->corox_model_id =$request->userId;
                    $schoolInformation->save();
                    $date = date('Y');
                    return redirect('/Dregister/info-settings');
          }          
          // show contact here
          public function about(){
                    if(Auth::user()->isAdmin()){
                              return redirect('/Dregister/dashboard');
                    }else if(Auth::user()->isContributor()){
                              return redirect('/Dregister/dashboard');
                    }
                    if(Auth::user()->username){
                              $username=Auth::user()->username.'<br>';    
                              $email= Auth::user()->email;
                    }
                    return view('about',['username'=>$username,'email'=>$email]);
          }         
          //show register page here
          public function registerShowSignUp(){
                    return view('signup');
          }
          // show login here
           public function registerLogin(Request $request){
                    $email=$request->input('email');
                    $pass=$request->input('password');
                    $rules=array(
                                  'email'=>'required|email',
                                   'password'=>'required',
                                 );
                    $validator= Validator::make($request->all(),$rules);
                    if($validator->fails()){
                              //fail request
                              return redirect('/Dregister/')->withErrors($validator);
                    }else{
                              $email=$request->input('email');
                              $pass=$request->input('password');
                              $data=array('email'=>$email,'password'=>$pass);
                              if($request->input('remember_me')=='on'){
                                        $remember=true;
                              }else{
                                        $remember=false;
                              }
                              if(Auth::attempt($data,$remember)){
                                        return redirect('/Dregister/dashboard');
                              }else{
                                        return  back()->with('message', 'Your login detail is wrong');
                              }
                    }
          }
          //showing register dashboard here
          public function registerDashboard(){
                    if(Permit::where("corox_model_id",Auth::user()->id)->exists()){
                              $roleExist = Permit::where("corox_model_id",Auth::user()->id)->first();
                              if( $roleExist->role_id !=4){
                                        if(Auth::user()->isMember()){
                                                  $roleId =1;
                                                  $roleInformation = Permit::where("role_id",$roleId)->first();
                                                  $userId= $roleInformation->corox_model_id;
                                                  $date = date('Y');
                                                  $adminInformation = Corox_model::where("id",$userId)->first();
                                                  $adminEmail=$adminInformation->email;
                                                  //return redirect('/Dregister/dashboard');
                                        }                              
                              }else{
                                        return redirect('/Dregister/');                 
                              }
                    }else{
                              return redirect('/Dregister/');     
                    }
                    if(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
       
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{
                              $services = array();
                              $schoolServices = array();
                              $schoolInformation= new RegisterSchoolInformation;     
                    }                    
                    return view('dashboard',['userEmail'=>$adminEmail, 'date'=>$date, 'schoolInformation'=> $schoolInformation]);
          }
          // show register signup page here
          public function registerSignUp(Request $request){
                    $user= new Corox_model;
                    $email=$request->input('email');
                    $pass=Hash::make($request->input('password'));
                    $remember_token=$request->input('_token');
                    $admin="admin";
                    $rules=array(
                                  'email'=>'required|email|unique:corox_models,email',
                                   'password'=>'required',
                                 );
                    $validator= Validator::make($request->all(),$rules);
                    if($validator->fails()){
                              return redirect('signup')->withErrors($validator);
                    }else{
                              $role_id=DB::table('roles')->where('role',$admin)->first();
                              $reg_id=$result=DB::table('corox_models')->where('email',$email)->first();
                              $roleCheck=DB::table('corox_model_role')->where('role_id',$role_id)->where('corox_model_id',$reg_id);
                              if($roleCheck == null){
                                        $request->session()->flash('errorMessage', $email.' you can\'t register as an '.$admin );
                                        return  redirect('/Dregister/signup');
                              } 
                              $user->email=$email;
                              $user->password=$pass;
                              $user->remember_token=$remember_token;
                              if($user->save()){
                                        $reg_id=$result=DB::table('corox_models')->where('email',$email)->first();
                                        $role_id=DB::table('roles')->where('role',$admin)->first();
                                        $permit= new Permit;
                                        $permit->role_id=$role_id->id;
                                        $permit->corox_model_id=$reg_id->id;
                                        if($permit->save()){
                                                  $request->session()->flash('message', 'You have successfully registered '.$email.' as an admin');
                                                  return  redirect('/Dregister/signup');
                                        };
                              };
                    }
          }
          //showing the register profile page
          public function registerProfile(Request $request){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }                  

                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{
                              $schoolInformation= new RegisterSchoolInformation;     
                    }
                    
                    return view('profile',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId]);
          }                    
          //tracking page to show add staff page
          public function registerStaff(Request $request){
                    if(Auth::user()->isMember()){
                              return redirect('/Dregister/dashboard');
                    }
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }                  
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{

                              $schoolInformation= new RegisterSchoolInformation;     
                    }
                    return view('add-staff',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId]);
          }          
          //tracking page to post create staff details
          public function registerAddStaff(Request $request){
                    if(Auth::user()->email){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                    }
                    if(RegisterStaffInformation::where("staff_email",$request->email)->exists()){
                              $request->session()->flash('message', 'Please register this staff with another email, '.$request->email.' is not available');
                              return redirect('/Dregister/add-staff');
                    }                       
                    $data['staff_firstname']= $request->firstname;
                    $data['staff_middlename']= $request->middlename;
                    $data['staff_lastname']= $request->lastname;            
                    $data['staff_email']= $request->email;
                    $data['staff_marital_status']= $request->maritalStatus;
                    $data['staff_gender']= $request->gender;            
                    $data['staff_phone']= $request->phone;
                    $data['staff_dob']= $request->dob;
                    $data['staff_disability']= $request->disabilityStatus;
                    $data['staff_list_disability']= $request->listDisability;
                    $data['staff_hobbies']= $request->hobbies;
                    $data['staff_address']= $request->address;
                    $data['staff_city']= $request->city;
                    $data['staff_social_media']= $request->socialMedia;
                    $data['staff_state']= $request->state;
                    $data['staff_localG']= $request->localG;
                    $data['user_corox_model_id'] =0;
                    $data['corox_model_id'] =$request->userId;
                    $schoolInformation= RegisterStaffInformation::create($data);    
                    $request->session()->flash('messageSuccess', 'Staff with email, '.$request->email.' is successfully created');                              
                    return redirect('/Dregister/add-staff');
          }
          //tracking page to post update staff detail
          public function registerUpdateStaff(Request $request){
                    if(Auth::user()->isMember()){
                              return redirect('/Dregister/about');
                    }
                    if(Auth::user()->email){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                    }
                   if(Corox_model::where("email",$request->email)->exists()){
                              $request->session()->flash('message', 'Please register this staff with another email, '.$request->email.' is not available');
                              return redirect('/Dregister/add-staff');
                    }
                    if($id != null || $id != '' || is_nan($id)){
                              $request->session()->flash('message', 'You are not allowed to update this staff record');                                                           
                    }                    
                    $staffInformation = RegisterStaffInformation::find($request->id);  
                    $staffInformation->staff_firstname= $request->firstname;
                    $staffInformation->staff_middlename= $request->middlename;
                    $staffInformation->staff_lastname= $request->lastname;            
                    $staffInformation->staff_email= $request->email;
                    $staffInformation->staff_marital_status= $request->maritalStatus;
                    $staffInformation->staff_gender= $request->gender;            
                    $staffInformation->staff_phone= $request->phone;
                    $staffInformation->staff_dob= $request->dob;
                    $staffInformation->staff_disability= $request->disabilityStatus;
                    $staffInformation->staff_list_disability= $request->listDisability;
                    $staffInformation->staff_hobbies= $request->hobbies;
                    $staffInformation->staff_address= $request->address;
                    $staffInformation->staff_city= $request->city;
                    $staffInformation->staff_social_media= $request->socialMedia;
                    $staffInformation->staff_state= $request->state;
                    $staffInformation->staff_localG= $request->localG;
                    if($staffInformation->save()){
                              $request->session()->flash('messageSuccess', 'Staff with email, '.$request->email.' is successfully updated');                                                           
                    }else{
                              $request->session()->flash('message', 'Staff with email, '.$request->email.' is not successfully updated');                       
                    }
                    return back()->with($request->id);
          }
          //show privilege page here
          public function registerPrivilegeSettings(){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    } 
                    if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
                              $staffInformation = DB::table('register_staff_informations')->whereNotNull('staff_firstname')->whereNotNull('staff_lastname')->whereNotNull('staff_email')->whereNotNull('staff_gender')->whereNotNull('staff_marital_status')->whereNotNull('staff_phone')->get();
                    }else{
                              $staffInformation= new RegisterStaffInformation;     
                    }
                    if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
                              $staffPrivilegeInformation = DB::table('register_staff_informations')->whereNotNull('staff_firstname')->whereNotNull('staff_lastname')->whereNotNull('staff_email')->whereNotNull('staff_gender')->whereNotNull('staff_marital_status')->whereNotNull('staff_phone')->paginate(10);
                              $roleIdSInformation = Permit::all();
                    }else{
                              $staffPrivilegeInformation= new RegisterStaffInformation;
                              $roleIdSInformation = new Permit;
                    }                     
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                              $allSchoolInformation = Corox_model::all(); 
                    }else{
                              $schoolInformation= new RegisterSchoolInformation;
                              $allSchoolInformation = new Corox_model;
                    }                     
                    return view('settings-privilege',['date'=>$date,'schoolInformation'=> $schoolInformation, 'allSchoolInformation'=> $allSchoolInformation, 'userEmail'=>$adminEmail, 'staffInformation'=> $staffInformation, 'staffPrivilegeInformation'=> $staffPrivilegeInformation, 'roleIdSInformation'=>$roleIdSInformation, 'paginator'=> $staffPrivilegeInformation, 'userId'=>$userId]);
            
          }
          public function registerPrivilege(Request $request){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                    
                    if($request->privilege !="none" || $request->privilege !=null){
                             
                              if($request->privilege == "access"){
                                        $member ='member';
                                        if($request->staffEmail =="none" || $request->staffEmail ==null ){
                                                  return response()->json(['success'=>'danger','message'=>'Please select a staff']);            
                                        }else{
                                                  $reg_id=$result=DB::table('corox_models')->where('email',$request->staffEmail)->first();
                                                  if($reg_id !=null){
                                                            $role_id =4;
                                                            $checkRole = Permit::where(["role_id"=>$role_id, "corox_model_id"=>$reg_id->id])->first();
                                                            if($checkRole !== null){
                                                                      $role_id =2;
                                                                      $permit= $checkRole->update(['role_id'=>$role_id]);
                                                                      if($permit){
                                                                                return response()->json(['success'=>'success','message'=>'You have successfully re-assign staff with email '.$request->staffEmail.' an access privilege']);      
                                                                      }                  
                                                            }elseif($checkRole === null){
                                                                      $role_id =2;
                                                                      $checkRole = Permit::where(["role_id"=>$role_id, "corox_model_id"=>$reg_id->id])->first();
                                                                      if($checkRole === null){
                                                                               // dd($reg_id->id);
                                                                                $role_id =2;
                                                                                $permit= new Permit;
                                                                                $permit->role_id=$role_id;
                                                                                $permit->corox_model_id=$reg_id->id;
                                                                                if($permit->save()){
                                                                                          if(Corox_model::where("email",$request->staffEmail)->exists()){
                                                                                                    $userInformation = Corox_model::where("email",$request->staffEmail)->first();
                                                                                                    if(RegisterStaffInformation::where(["staff_email"=>$request->staffEmail, "corox_model_id"=>$userId])->exists()){
                                                                                                              $staffInformation = RegisterStaffInformation::where(["staff_email"=>$request->staffEmail, "corox_model_id"=>$userId])->first();
                                                                                                              $staffInformation= $staffInformation->update(['user_corox_model_id'=>$userInformation->id]);
                                                                                                              if($staffInformation){                                                                                          
                                                                                                                        return response()->json(['success'=>'success','message'=>'You have successfully assign staff with email '.$request->staffEmail.' an access privilege']);                                                            
                                                                                                              }else{
                                                                                                                        return response()->json(['success'=>'danger','message'=>'Problem assigning staff with email '.$request->staffEmail.' an access privilege']);                         
                                                                                                              }
                                                                                                    }else{
                                                                                                              return response()->json(['success'=>'danger','message'=>'staff with email '.$request->staffEmail.' can not be found']);                         
                                                                                                    }
                                                                                          }else{
                                                                                                    return response()->json(['success'=>'danger','message'=>'user with email '.$request->staffEmail.' can not be found']);                      
                                                                                          }
                                                                                }                 
                                                                      }else{
                                                                                return response()->json(['success'=>'danger','message'=>'The staff with email '.$request->staffEmail.' has already been assigned an access privilege']);        
                                                                      }                
                                                            }
                                                            return response()->json(['success'=>'danger','message'=>'The staff with email '.$request->staffEmail.' has already been assigned an access privilege']);        
                                                  }else{
                                                            $user = new Corox_model;
                                                            $user->email=$request->staffEmail;
                                                            $user->password=Hash::make('dlocenots');
                                                            $user->remember_token=$request->_token;
                                                            if($user->save()){          
                                                                      $role_id=DB::table('roles')->where('role',$member)->first();
                                                                      $permit= new Permit;
                                                                      $permit->role_id=$role_id->id;
                                                                      $permit->corox_model_id=$user->id;
                                                                      if($permit->save()){
                                                                                if(RegisterStaffInformation::where(["staff_email"=>$request->staffEmail, "corox_model_id"=>$userId])->exists()){
                                                                                          $staffInformation = RegisterStaffInformation::where(["staff_email"=>$request->staffEmail, "corox_model_id"=>$userId])->first();
                                                                                          $staffInformation= $staffInformation->update(['user_corox_model_id'=>$user->id]);
                                                                                          if($staffInformation){                                                                                          
                                                                                                    return response()->json(['success'=>'success','message'=>'You have successfully assign staff with email '.$request->staffEmail.' an access privilege']);                                                            
                                                                                          }else{
                                                                                                return response()->json(['success'=>'danger','message'=>'Problem assigning staff with email '.$request->staffEmail.' an access privilege']);                         
                                                                                          }
                                                                                }
                                                                                return response()->json(['success'=>'success','message'=>'You have successfully assign staff with email '.$request->staffEmail.' an access privilege']);                         
                                                                      }
                                                            }
                                                  }
                                        }  
                              }elseif($request->privilege == "onhold"){
                                        $role_id =4;
                                        $userId=Auth::user()->id;
                                        if($request->staffEmail =="none" || $request->staffEmail ==null ){
                                                  return response()->json(['success'=>'danger','message'=>'Please select a staff']);     
                                        }else{
                                                  $reg_id=$result=DB::table('corox_models')->where('email',$request->staffEmail)->first();
                                                  if($reg_id->id != null){
                                                            $role_id =2;
                                                            $checkRole = Permit::where(["role_id"=>$role_id, "corox_model_id"=>$reg_id->id])->first();
                                                            if($checkRole !== null){
                                                                      $role_id =4;
                                                                      $permit= $checkRole->update(['role_id'=>$role_id]);
                                                                      if($permit){
                                                                                return response()->json(['success'=>'success','message'=>'You have successfully put staff with email '.$request->staffEmail.' privilege on hold']);      
                                                                      }                  
                                                            }elseif($checkRole === null){
                                                                      $role_id =4;
                                                                      $checkRole = Permit::where(["role_id"=>$role_id, "corox_model_id"=>$reg_id->id])->first();                                                            
                                                                      if($checkRole === null){
                                                                                $role_id =4;
                                                                                $permit= new Permit;
                                                                                $permit->role_id=$role_id;
                                                                                $permit->corox_model_id=$reg_id->id;
                                                                                if($permit->save()){
                                                                                          if(Corox_model::where("email",$request->staffEmail)->exists()){
                                                                                                    $userInformation = Corox_model::where("email",$request->staffEmail)->first();
                                                                                                    if(RegisterStaffInformation::where(["staff_email"=>$request->staffEmail, "corox_model_id"=>$userId])->exists()){                                                                                                    
                                                                                                              $staffInformation = RegisterStaffInformation::where(["staff_email"=>$request->staffEmail,"corox_model_id"=>$userId])->first();
                                                                                                              $staffInformation = $staffInformation->update(['user_corox_model_id'=>$reg_id->id]);
                                                                                                              if($staffInformation){                                                                                          
                                                                                                                        return response()->json(['success'=>'success','message'=>'You have successfully assign staff with email '.$request->staffEmail.' an access privilege']);                                                            
                                                                                                              }else{
                                                                                                                        return response()->json(['success'=>'danger','message'=>'Problem assigning staff with email '.$request->staffEmail.' an access privilege']);                         
                                                                                                              }
                                                                                                    }else{
                                                                                                              return response()->json(['success'=>'danger','message'=>'staff with email '.$request->staffEmail.' can not be found']);                         
                                                                                                    }
                                                                                          }else{
                                                                                                    return response()->json(['success'=>'danger','message'=>'user with email '.$request->staffEmail.' can not be found']);                      
                                                                                          }                                                                                          
                                                                                }                 
                                                                      }else{
                                                                                return response()->json(['success'=>'danger','message'=>'The staff with an email '.$request->staffEmail.' privilege is already on hold contact the administrator']);  
                                                                      }                
                                                           }                                                            
                                                          return response()->json(['success'=>'danger','message'=>'The staff with an email '.$request->staffEmail.' privilege is on hold contact the administrator']);        
                                                  }else{
                                                            $user = new Corox_model;
                                                            $user->email=$request->staffEmail;
                                                            $user->password=Hash::make('dlocenots');
                                                            $user->remember_token=$request->_token;
                                                            if($user->save()){
                                                                      $permit= new Permit;
                                                                      $permit->role_id=$role_id;
                                                                      $permit->corox_model_id=$user->id;
                                                                      if($permit->save()){
                                                                                if(RegisterStaffInformation::where(["staff_email"=>$request->staffEmail, "corox_model_id"=>$userId])->exists()){
                                                                                          $staffInformation = RegisterStaffInformation::where(["staff_email"=>$request->staffEmail, "corox_model_id"=>$userId])->first();
                                                                                          $staffInformation= $staffInformation->update(['user_corox_model_id'=>$user->id]);
                                                                                          if($staffInformation){                                                                                          
                                                                                                    return response()->json(['success'=>'success','message'=>'The staff with an email '.$request->staffEmail.' privilege as been put onhold']);                                                            
                                                                                          }else{
                                                                                                return response()->json(['success'=>'danger','message'=>'Problem putting staff with email '.$request->staffEmail.' privilege onhold']);                         
                                                                                          }
                                                                                }                                                                      
                                                                      }
                                                            }
                                                  }                                                      
                                        }                                        
                              }elseif($request->privilege == "remove"){
                                        $userId=Auth::user()->id;
                                        if($request->staffEmail =="none" || $request->staffEmail ==null ){
                                                  return response()->json(['success'=>'danger','message'=>'Please select a staff']);     
                                        }else{
                                                  $reg_id=$result=DB::table('corox_models')->where('email',$request->staffEmail)->first();
                                                  if(Permit::where("corox_model_id",$reg_id->id)->exists()){
                                                            $remove = Permit::where("corox_model_id",$reg_id->id)->delete();
                                                            if($remove){
                                                                      return response()->json(['success'=>'success','message'=>'The staff with an email '.$request->staffEmail.' privilege as been deleted']);                             
                                                            }else{
                                                                      return response()->json(['success'=>'danger','message'=>'The staff with an email '.$request->staffEmail.' has no privilege']);                                                              
                                                            }  
                                                  }else{
                                                            return response()->json(['success'=>'danger','message'=>'The staff with an email '.$request->staffEmail.' has no privilege']);                                                                   
                                                  }                                                  
                                        }                                    
                              }else{
                                        return response()->json(['success'=>'danger','message'=>'you have no right to set privilege, please select privilege']);          
                              }
                     
                    }else{
                              return response()->json(['success'=>'danger','message'=>'Privilege is not selected']);     
                    }
            
          }        
          //show staffs here
          public function registerViewStaffs(){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{
                              $schoolInformation= new RegisterSchoolInformation;     
                    }
                    if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
                              $staffInformation = DB::table('register_staff_informations')->whereNotNull('staff_firstname')->whereNotNull('staff_lastname')->whereNotNull('staff_email')->whereNotNull('staff_gender')->whereNotNull('staff_marital_status')->whereNotNull('staff_phone')->paginate(10);    
                    }else{
                          $staffInformation= new RegisterStaffInformation;     
                    }                    
                    return  view('view-staffs-table',['date'=>$date,'schoolInformation'=> $schoolInformation,  'staffInformation'=> $staffInformation, 'paginator'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId]);
          }
          //show general page here
          public function registerGeneralSettings(){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{
                              $schoolInformation= new RegisterSchoolInformation;     
                    }
                    return  view('general-settings',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId]);
          }          
          //show edit staff here
          public function registerEditStaff(Request $request, $id){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{
                              $schoolInformation= new RegisterSchoolInformation;     
                    }
                    if($id == null || $id == '' || is_nan($id)){
                              $request->session()->flash('message', 'You are not allowed to edit this staff');                                                           
                    }             
                    if(RegisterStaffInformation::where(["corox_model_id"=>$userId, "id"=>$id])->exists()){
                              $staffInformation = RegisterStaffInformation::where(["corox_model_id"=>$userId, "id"=>$id])->first();
                    }else{
                              $staffInformation= new RegisterStaffInformation;     
                    }                    
                    return  view('edit-staff',['date'=>$date,'schoolInformation'=> $schoolInformation, 'staffInformation'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId]);
          }
          //show delete staff here
          public function registerDeleteStaff($id){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                    if($id == null || $id == '' || is_nan($id)){
                              return response()->json(['success'=>'fail','message'=>'You are not allowed to delete this staff']);                   
                    }
                    if(RegisterStaffInformation::where("id",$id)->exists()){
                              if(RegisterStaffInformation::where("id",$id)->exists()){
                                        $staffInformation = RegisterStaffInformation::where("id",$id)->first();
                                        if(Corox_model::where("id",$staffInformation->user_corox_model_id)->exists()){
                                                  if(Corox_model::where("id",$staffInformation->user_corox_model_id)->delete()){
                                                             if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->exists()){
                                                                      if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->delete()){
                                                                                if(RegisterStaffTeacher::where("staff_id",$id)->exists()){
                                                                                          if(RegisterStaffTeacher::where("staff_id",$id)->delete()){
                                                                                                    if(RegisterStaffInformation::find($id)->delete()){
                                                                                                              return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                                                    }
                                                                                          }                                
                                                                                }else{
                                                                                          if(RegisterStaffInformation::find($id)->delete()){
                                                                                                    return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                                          }                                                                      
                                                                                }
                                                              
                                                                      }                                                               
                                                             }else{
                                                                      if(RegisterStaffTeacher::where("staff_id",$id)->exists()){
                                                                                if(RegisterStaffTeacher::where("staff_id",$id)->delete()){
                                                                                          if(RegisterStaffInformation::find($id)->delete()){
                                                                                                    return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                                          }
                                                                                }                                
                                                                      }else{
                                                                                if(RegisterStaffInformation::find($id)->delete()){
                                                                                          return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                                }                                                                      
                                                                      }                                                            
                                                             }
          
                                                  }                                                  
                                        }else{
                                                  if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->exists()){
                                                           if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->delete()){
                                                                     if(RegisterStaffTeacher::where("staff_id",$id)->exists()){
                                                                               if(RegisterStaffTeacher::where("staff_id",$id)->delete()){
                                                                                         if(RegisterStaffInformation::find($id)->delete()){
                                                                                                   return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                                         }
                                                                               }                                
                                                                     }else{
                                                                               if(RegisterStaffInformation::find($id)->delete()){
                                                                                         return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                               }                                                                      
                                                                     }
                                                   
                                                           }                                                               
                                                  }else{
                                                           if(RegisterStaffTeacher::where("staff_id",$id)->exists()){
                                                                     if(RegisterStaffTeacher::where("staff_id",$id)->delete()){
                                                                               if(RegisterStaffInformation::find($id)->delete()){
                                                                                         return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                               }
                                                                     }                                
                                                           }else{
                                                                     if(RegisterStaffInformation::find($id)->delete()){
                                                                               return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                     }                                                                      
                                                           }                                                            
                                                  }                                                  
                                        }

                                       
                              }else{
                                        return response()->json(['success'=>'danger','message'=> 'No current staff record']);                                   
                              }                               

                              
                    }else{
                              return response()->json(['success'=>'danger','message'=> 'No current staff record']);                                   
                    } 

          }
          //create class for register ajax
          public function registerAddClass(Request $request){
                    $userId=Auth::user()->id;
                    $class= new RegisterClasses;
                    $class->class_name=$request->class;
                    $class->corox_model_id = $userId;
                    $class->class_date= $request->date;
                    if($class->save()){
                              return response()->json(['success'=>'success','message'=>'You have successfully created '.$request->class.' class']);      
                    }else{
                              return response()->json(['success'=>'danger','message'=> $request->class.' class not created, contact the administrator']);     
                    }
          }
          // create subject for register ajax
          public function registerAddSubject(Request $request){
                    $userId=Auth::user()->id;
                    $subject= new RegisterSubject;
                    $subject->subject_name=$request->subject;
                    $subject->corox_model_id = $userId;
                    $subject->subject_date= $request->date;
                    if($subject->save()){
                              return response()->json(['success'=>'success','message'=>'You have successfully created '.$request->subject.' subject']);      
                    }else{
                              return response()->json(['success'=>'danger','message'=> $request->subject.' subject not created, contact the administrator']);     
                    }
          }
          // create period for register ajax
          public function registerAddPeriod(Request $request){
                    $userId=Auth::user()->id;
                    $period= new RegisterPeriod;
                    $period->period_name=$request->period;
                    $period->corox_model_id = $userId;
                    $period->period_date= $request->date;
                    if($period->save()){
                              return response()->json(['success'=>'success','message'=>'You have successfully created '.$request->period.' period']);      
                    }else{
                              return response()->json(['success'=>'danger','message'=> $request->period.' period not created, contact the administrator']);     
                    }
          }
          // show page to assign subject
          public function registerAssignSubject(){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{
                              $schoolInformation= new RegisterSchoolInformation;     
                    }
                    return  view('assign-subject',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId]);
          }
          // show page to assign teacher
          public function registerTeacher(){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{
                              $schoolInformation= new RegisterSchoolInformation;     
                    }
                    if(RegisterClasses::where("corox_model_id",$userId)->exists()){
                              $classes = RegisterClasses::where("corox_model_id",$userId)->get();
                    }else{
                              $classes= new RegisterClasses;     
                    }
                    if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
                              $staffInformation = RegisterStaffInformation::where("corox_model_id",$userId)->get();
                    }else{
                              $staffInformation= new RegisterStaffInformation;     
                    }
                    if(RegisterStaffTeacher::where("corox_model_id",$userId)->exists()){
                              $informations =RegisterStaffTeacher::where("corox_model_id",$userId)->paginate(10);
                               $staffs =RegisterStaffInformation::where("corox_model_id",$userId)->get();
                               $classes =RegisterClasses::where("corox_model_id",$userId)->get();
                               $teacherInformation = array();
                              foreach($informations as $teacher){
                                        $class =RegisterClasses::where("id",$teacher->class_id)->first(); 
                                        $information =RegisterStaffInformation::where("id",$teacher->staff_id)->first();
                                        $teacherInformation[]=array('id'=>$information->id, 'staffName'=>$information->staff_firstname.' '.$information->staff_lastname, 'class_id'=>$class->id, 'className'=>$class->class_name, 'teacherRole'=>$teacher->teacher_role );
                                  
                              }
                             
                    }else{
                              $teacherInformation= '';
                              $informations = new RegisterStaffTeacher;
                              $staffs = new RegisterStaffInformation;
                              
                    }
                    
                    return  view('add-teacher',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'staffInformation'=>$staffInformation, 'classes'=>$classes, 'staffs' =>$staffs, 'teacherInformation'=>$teacherInformation, 'paginator'=>$informations, 'classes'=>$classes, 'userId'=>$userId]);
          }
          // create period for register ajax
          public function registerAddTeacher(Request $request){
                    if($request->staffId =='' || $request->staffId =='none' ){
                              return response()->json(['success'=>'danger','message'=> 'Please select staff name']);                                   
                    }elseif($request->teacherRole =='' || $request->teacherRole =='none'){
                              return response()->json(['success'=>'danger','message'=> 'Please select teacher\'s role']);                                                                 
                    }elseif($request->classId =='' || $request->classId =='none'){
                              return response()->json(['success'=>'danger','message'=> 'Please select a class']);                                                                 
                    }
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                    if(RegisterStaffTeacher::where(["class_id"=>$request->classId,"corox_model_id"=>$userId])->exists()){
                              $teacher =RegisterStaffTeacher::where("class_id",$request->classId)->first();
                              $staff =RegisterStaffInformation::where("id",$teacher->staff_id)->first();
                              $class =RegisterClasses::where("id",$request->classId)->first();
                              if(RegisterStaffTeacher::where(["class_id"=>$request->classId,"teacher_role"=>$request->teacherRole,"corox_model_id"=>$userId])->exists()){
                                                  //dd('dd');
                                        if($request->teacherRole[0] =="subjectteacher"){
                                                  $newTeacherRole = $request->teacherRole[0].','.$teacher->teacher_role;
                                                   $teacher=RegisterStaffTeacher::where(["class_id"=>$request->classId, "teacher_role"=>"classteacher","staff_id"=>$request->staffId])->first();
                                                  //$teacherRole =explode(',',$checkRole->teacher_role);
                                                  if( $teacher->teacher_role == "classteacher"){
                                                            if(RegisterStaffTeacher::where(["class_id"=>$request->classId, "teacher_role"=>"classteacher","staff_id"=>$request->staffId])->exists()){
                                                                     //dd('e');
                                                                      if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                                                                              
                                                                             //  dd($teacher->teacher_role);
                                                                                $class =RegisterClasses::where("id",$request->classId)->first();
                                                                                if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                                                                                         $teacherRole = $request->teacherRole[0]; 
                                                                                }
                                                                                $teacher= new RegisterStaffTeacher;
                                                                                $teacher->staff_id=$request->staffId;
                                                                                $teacher->class_id=$request->classId;
                                                                                $teacher->teacher_role= $teacherRole;                    
                                                                                $teacher->corox_model_id = $userId;
                                                                                if($teacher->save()){
                                                                                         if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                                                                                                   $teacherRole = $request->teacherRole[0];
                                                                                                    return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$teacherRole.' '.$class->class_name]);                                                      
                                                                                          }                     
                                                                  
                                                                                }
                                                                      }
                                                            }elseif(isset($request->teacherRole[1]) && $request->teacherRole[0].','.$request->teacherRole[1] == "subjectteacher,classteacher"){
                                                                                       
                                                                      return response()->json(['success'=>'danger','message'=> $request->staffName.' has already been assiged as a '.$request->teacherRole[0].' and as a '.$request->teacherRole[1].' to '.$class->class_name.' class']);                                                       
                                                            }                                                            
                                                            $teacherRole =explode(',',$teacher->teacher_role);
                                                            return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                                                  }elseif(isset($teacherRole[1]) && $request->teacheRole == $teacherRole[1]){
                                                            $teacherRole =explode(',',$teacher->teacher_role);
                                                            return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                                                  }
                                                  $checkRole = RegisterStaffTeacher::where(["staff_id"=>$request->staffId])->first();
                                                  if($checkRole->update(["teacher_role"=>$newTeacherRole])){
                                                           return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a'.$teacher->teacher_role. ' and  as a '.$request->teacherRole[0]]);      
                                                  }                                                   
                                        }                                                   
                                        return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);        
                              }elseif($request->classId == $class->id){
                                        if($request->teacherRole[0] =="subjectteacher"){
                                                  $newTeacherRole = $request->teacherRole[0].','.$teacher->teacher_role;
                                                  //$teacherRole =explode(',',$checkRole->teacher_role);
                                                  if( $teacher->teacher_role == "subjectteacher,classteacher"){
                                                            if(RegisterStaffTeacher::where(["class_id"=>$request->classId, "teacher_role"=>"subjectteacher,classteacher"])->exists()){
                                                                      if($request->teacherRole[0] == "subjectteacher"){
                                                                                $class =RegisterClasses::where("id",$request->classId)->first();
                                                                                if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                                                                                         $teacherRole = $request->teacherRole[0]; 
                                                                                }
                                                                                $teacher= new RegisterStaffTeacher;
                                                                                $teacher->staff_id=$request->staffId;
                                                                                $teacher->class_id=$request->classId;
                                                                                $teacher->teacher_role= $teacherRole;                    
                                                                                $teacher->corox_model_id = $userId;
                                                                                if($teacher->save()){
                                                                                         if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                                                                                                   $teacherRole = $request->teacherRole[0];
                                                                                                    return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$teacherRole.' '.$class->class_name]);                                                      
                                                                                          }                     
                                                                  
                                                                                }
                                                                      }
                                                            }                                                            
                                                            $teacherRole =explode(',',$teacher->teacher_role);
                                                            return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                                                  }elseif(isset($teacherRole[1]) && $request->teacheRole == $teacherRole[1]){
                                                            $teacherRole =explode(',',$teacher->teacher_role);
                                                            return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                                                  }
                                                  $checkRole = RegisterStaffTeacher::where(["staff_id"=>$request->staffId])->first();
                                                  if($checkRole->update(["teacher_role"=>$newTeacherRole])){
                                                           return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a'.$teacher->teacher_role. ' and  as a '.$request->teacherRole[0]]);      
                                                  }                                                   
                                        }elseif($request->teacherRole[0] =="classteacher"){
                                                  $newTeacherRole = $teacher->teacher_role.','.$request->teacherRole[0];
                                                  //$teacherRole =explode(',',$checkRole->teacher_role);
                                                  if( $teacher->teacher_role == "subjectteacher,classteacher"){
                                                            $teacherRole =explode(',',$teacher->teacher_role);
                                                            return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                                                  }elseif(isset($teacherRole[1]) && $request->teacheRole == $teacherRole[1]){
                                                            $teacherRole =explode(',',$teacher->teacher_role);
                                                            return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                                                  }elseif(RegisterStaffTeacher::where(["staff_id"=>$request->staffId])->exists()){
                                                            $newTeacherRole = $request->teacherRole[0].','.$teacher->teacher_role;
                                                            $checkRole = RegisterStaffTeacher::where(["staff_id"=>$request->staffId])->first();
                                                            if($checkRole->update(["teacher_role"=>$newTeacherRole])){
                                                                     return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a'.$teacher->teacher_role. ' and  as a '.$request->teacherRole[0]]);      
                                                            }
                                                  }
                                        }
                                                            
                                                                                    
                              }
                              //return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);       
                    }elseif(RegisterStaffTeacher::where(["staff_id"=>$request->staffId])->exists()){

                                $teacher =RegisterStaffTeacher::where("staff_id",$request->staffId)->first();
                                $teacherRole =explode(',',$teacher->teacher_role);
                                if(isset($request->teacherRole[1]) && $request->teacherRole[0].','.$request->teacherRole[1] ==  $teacherRole[0].','.$teacherRole[1]){
                                        // dd('12');
                                }elseif($request->teacherRole[0] == "classteacher"){
                                        //dd('1');
                                }
                    }elseif(RegisterStaffTeacher::where(["class_id"=>$request->classId, "teacher_role"=>$request->teacherRole])->exists()){
                                                  dd('r');
                     }
                    $class =RegisterClasses::where("id",$request->classId)->first();
                    if( $request->teacherRole[0] =="classteacher" && !isset($request->teacherRole[1])){
                           $teacherRole = $request->teacherRole[0];  
                    }elseif($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                             $teacherRole = $request->teacherRole[0]; 
                    }elseif( $request->teacherRole[0].','.$request->teacherRole[1] == "subjectteacher,classteacher"){
                                
                              $teacherRole = $request->teacherRole[0].','.$request->teacherRole[1]; 
                    }
                    $teacher= new RegisterStaffTeacher;
                    $teacher->staff_id=$request->staffId;
                    $teacher->class_id=$request->classId;
                    $teacher->teacher_role= $teacherRole;                    
                    $teacher->corox_model_id = $userId;
                    if($teacher->save()){
                             
                              if( $request->teacherRole[0] =="classteacher" && !isset($request->teacherRole[1])){
                                        $teacherRole = $request->teacherRole[0];
                                        return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$teacherRole.' '.$class->class_name]);                           
                              }elseif($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                                       $teacherRole = $request->teacherRole[0];
                                        return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$teacherRole.' '.$class->class_name]);                                                      
                              }elseif($request->teacherRole[0].','.$request->teacherRole[1] == "subjectteacher,classteacher"){
                                        $teacherRole = implode(',',$request->teacherRole);
                                        return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$request->teacherRole[0].' and as a '.$request->teacherRole[1].' to '.$class->class_name.' class']);                                                       
                              }                         
      
                    }else{
                              return response()->json(['success'=>'danger','message'=> ' Assigning staff with a name '.$request->staffName.' as a teacher is not successful']);     
                    }                  
          }
          //delete teacher register ajax
          public function registerDeleteTeacher($id){
                    if(RegisterStaffTeacher::where("staff_id",$id)->delete()){
                              return response()->json(['success'=>'success','message'=>'Teacher with an id '.$id.' has been deleted successfully']);
                    }        
          }
          //update teacher register ajax
          public function registerUpdateTeacher(Request $request){
                    if($request->staffId =='' || $request->staffId =='none' ){
                              return response()->json(['success'=>'danger','message'=> 'Please select staff name']);                                   
                    }elseif($request->teacherRole =='' || $request->teacherRole =='none'){
                              return response()->json(['success'=>'danger','message'=> 'Please select teacher\'s role']);                                                                 
                    }elseif($request->classId =='' || $request->classId =='none'){
                              return response()->json(['success'=>'danger','message'=> 'Please select a class']);                                                                 
                    }
                    $checkRole = RegisterStaffTeacher::where(["staff_id"=>$request->staffId])->first();
                    if(RegisterStaffTeacher::update("staff_id",$request->staffId)){
                              return response()->json(['success'=>'success','message'=>'Teacher with an id '.$id.' has been deleted successfully']);
                    }       
          }
           // show page to for staff register list for clock in
          public function registerStaffTimeRegister(){
                    if(Auth::user()->isMember()){
                              $roleId =1;
                              $roleInformation = Permit::where("role_id",$roleId)->first();
                              $userId= $roleInformation->corox_model_id;
                              $date = date('Y');
                              $adminInformation = Corox_model::where("id",$userId)->first();
                              $adminEmail=$adminInformation->email;
                              //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                              $email= Auth::user()->email;
                              $date = date('Y');
                              $userId=Auth::user()->id;
                              $adminEmail=Auth::user()->email;
                    }
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{
                              $schoolInformation= new RegisterSchoolInformation;     
                    }
                    if(RegisterClasses::where("corox_model_id",$userId)->exists()){
                              $classes = RegisterClasses::where("corox_model_id",$userId)->get();
                    }else{
                              $classes= new RegisterClasses;     
                    }
                    if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
                              $staffInformation = RegisterStaffInformation::where("corox_model_id",$userId)->get();
                    }else{
                              $staffInformation= new RegisterStaffInformation;     
                    }
                    if(RegisterStaffTeacher::where("corox_model_id",$userId)->exists()){
                              $informations =RegisterStaffTeacher::where("corox_model_id",$userId)->paginate(10);
                               $staffs =RegisterStaffInformation::where("corox_model_id",$userId)->get();
                               $classes =RegisterClasses::where("corox_model_id",$userId)->get();
                               $teacherInformation = array();
                              foreach($informations as $teacher){
                                        $class =RegisterClasses::where("id",$teacher->class_id)->first(); 
                                        $information =RegisterStaffInformation::where("id",$teacher->staff_id)->first();
                                        $teacherInformation[]=array('id'=>$information->id, 'staffName'=>$information->staff_firstname.' '.$information->staff_lastname, 'class_id'=>$class->id, 'className'=>$class->class_name, 'teacherRole'=>$teacher->teacher_role );
                                  
                              }
                             
                    }else{
                              $teacherInformation= '';
                              $informations = new RegisterStaffTeacher;
                              $staffs = new RegisterStaffInformation;
                              
                    }
                    
                    return  view('staff-register',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'staffInformation'=>$staffInformation, 'classes'=>$classes, 'staffs' =>$staffs, 'teacherInformation'=>$teacherInformation, 'paginator'=>$informations, 'classes'=>$classes, 'userId'=>$userId]);
          }         
          //sending mail
          public  function mailOut($id){
                    $user=Corox_model::find($id)->toArray();
                    $mail=  Mail::send('emails', $user, function($message) use ($user){
                              $message->to($user['email']);
                              $message->subject('Our Service');
                    });
                    if($mail){
                              $dd('Mail sent successfully');
                    }else{
                               $dd('Mail not delivered');
                    }
         }
          //logout here
          public  function registerError404(){
                    return view('404');
          }         
          //logout here
          public  function logout(){
                    Auth::logout();
                    Session::flush();
                    return redirect('/Dregister/');
          }
}
