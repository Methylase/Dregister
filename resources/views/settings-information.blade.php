<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>The Register - Information Update</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('my-register/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{asset('my-register/img/The-Register.jpg')}}"  sizes ="25x25"> 
  <!-- Custom styles for this template-->
  <link href="{{asset('my-register/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <script src="{{asset('my-register/vendor/jquery/jquery.min.js')}}"></script>  
   <script>
      function dateTime(){
        var date = new Date();
        var h = date.getHours();
        var m = date.getMinutes();
        if (h > 12) {
          h -= 12;
        }else if (h ===0){
          h = 12
        }
        var s =date.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        var  result = h+':'+ m +':'+s;
        document.getElementById('time').innerHTML = result;
        var t =setTimeout(dateTime,1000);
      }
      function checkTime(i) {
        if (i < 10) {
           i = "0" + i;
        }
        return i;
      }     
      $(document).ready(function(){
       //updateToggle
       $('#updateToggle').click(function(){
         $('#update-body').toggle();
       });
        // json to get state and local government to fill state and local goverment dropdown
        $.getJSON("{{asset('states-localgovts/states-localgovts.json')}}",function(states){
          $.each(states.states, function(key, value){
            $('#state').append($("<option></option>").attr('value', states.states[key].state).text(value.state));
            $('#state').on('change', function(){
              var state =$(this).val();
              if (states.states[key].state == state){
                //$('#state').find("option:gt(0)").remove();
                $('#localG').children("option").not(':first').remove();
                $.each(states.states[key].local, function(key, value){
                  $('#localG').append($("<option></option>").attr('value', value).text(value));
                });
              }
            })
          });                
        });
   }); 
  </script>
    <style>
     i#close, #time{
      display: inline-block;
      border-radius: 60px;
      box-shadow: 1px 1px 1px #888;
      padding: 0.5em 0.6em;
     }
     label, btn{
      display: inline-block;
      border-radius: 6px;
      box-shadow: 1px 1px rgb(0, 0, 0, 0.1);
      padding: 0.5em 0.6em;
     }     
    </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
   <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/Dregister/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-smile"></i>
        </div>
        <div class="sidebar-brand-text mx-3"> Register </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/Dregister/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSchool" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog fa-spin text-gray-400"></i>
          <span>School Settings</span>
        </a>
        <div id="collapseSchool" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">School Settings:</h6>
            <a class="collapse-item" href="/Dregister/info-settings">Information Update</a>
            <a class="collapse-item" href="/Dregister/profile">Profile</a>                  
            <a class="collapse-item" href="/Dregister/priv-settings">Privilege</a>           
            <a class="collapse-item" href="cards.html">Send Memo</a>
            <a class="collapse-item" href="cards.html">View Memo Replys</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaff" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Staffs</span>
        </a>
        <div id="collapseStaff" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Staffs:</h6>
            <a class="collapse-item" href="/Dregister/add-staff">Add New Staff</a>
            <a class="collapse-item" href="/Dregister/view-staffs">View Staffs Table</a>
            <a class="collapse-item" href="/Dregister/staff-register"> Staffs Register</a>       
          </div>
        </div>
      </li>
  <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeachers" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Teachers</span>
        </a>
        <div id="collapseTeachers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Teachers</h6>
            <a class="collapse-item" href="login.html">Add New Teacher</a>          
            <a class="collapse-item" href="forgot-password.html">View Teacher Table</a>
            <a class="collapse-item" href="register.html"> Teachers Register</a>              
            <a class="collapse-item" href="forgot-password.html">Assign Books</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Others:</h6>
            <a class="collapse-item" href="404.html">Add Non-Teaching Staffs</a>
            <a class="collapse-item" href="blank.html">View Non-Teaching Staffs</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParents" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa fa-handshake text-gray-400"></i>
          <span>Parents</span>
        </a>
        <div id="collapseParents" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Parents</h6>
            <a class="collapse-item" href="login.html">Add New Parent</a>          
            <a class="collapse-item" href="forgot-password.html">View Parent Table</a>
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseStudents" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Students</span>
        </a>
        <div id="collpaseStudents" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Students:</h6>
            <a class="collapse-item" href="register.html"> Add New Student</a>
            <a class="collapse-item" href="register.html"> Add Student Result</a>            
            <a class="collapse-item" href="forgot-password.html">View Students Table</a>
            <a class="collapse-item" href="register.html"> Students Register</a>              
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Others:</h6>
            <a class="collapse-item" href="404.html">Assign Book</a>
            <a class="collapse-item" href="blank.html">Book Assign To Students</a>
          </div>
        </div>
      </li>
      
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinances" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-credit-card text-gray-400"></i>
          <span>Revenue</span>
        </a>
        <div id="collapseFinances" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Revenue:</h6>
            <a class="collapse-item" href="buttons.html">Daily Revenue</a>
            <a class="collapse-item" href="cards.html">Monthly Revenue</a>
            <a class="collapse-item" href="cards.html">Other Finances</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayment" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-credit-card text-gray-400"></i>
          <span>Make Payment</span>
        </a>
        <div id="collapsePayment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Make Payment:</h6>
            <a class="collapse-item" href="buttons.html"> School Fees</a>
            <a class="collapse-item" href="cards.html">School Bus</a>
            <a class="collapse-item" href="cards.html">Stationaries</a>
            <a class="collapse-item" href="cards.html">Party And Excusion</a>
            <a class="collapse-item" href="cards.html">View Payment Table</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubject" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book text-gray-400"></i>
          <span>General Settings</span>
        </a>
        <div id="collapseSubject" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">General Settings:</h6>
            <a class="collapse-item" href="/Dregister/general-settings">General Settings</a>
            <a class="collapse-item" href="cards.html">Assign Subject</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLibrary" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-building text-gray-400"></i>
          <span>Library</span>
        </a>
        <div id="collapseLibrary" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Library:</h6>
            <a class="collapse-item" href="buttons.html">Add New books</a>
            <a class="collapse-item" href="cards.html">View Books</a>
            <a class="collapse-item" href="cards.html"> Assign Book</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKitchen" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-briefcase text-gray-400"></i>
          <span>Others</span>
        </a>
        <div id="collapseKitchen" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Kitchen:</h6>
            <a class="collapse-item" href="buttons.html">Add Material</a>
            <a class="collapse-item" href="cards.html">View Material</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Equipment:</h6>
            <a class="collapse-item" href="404.html">Add Equipment</a>
            <a class="collapse-item" href="blank.html">View Equipment</a>         
          </div>
        </div>
      </li>            
      <!-- Nav Item - Charts -->
      <!--<li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>-->

      <!-- Nav Item - Tables -->
      <!--<li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>-->
      <li class="nav-item">
        <a class="nav-link" href="{{url('/Dregister/logout')}}" onclick="event.preventDefault();
       document.getElementById('logout-form').submit()">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          <span>Logout</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <span class="bg-danger" id="time" style="padding:8px;color:white;border-radius:3px"></span>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{$schoolInformation->school_name !== null || $schoolInformation->school_name != '' ? ucfirst($schoolInformation->school_name) : ucfirst($userEmail) }}</span>
                  
                <img class="img-profile rounded-circle" src="{{$schoolInformation->school_profile_image !== null || $schoolInformation->school_profile_image !='' ? url('uploads/'.$schoolInformation->school_profile_image) : asset('my-register/img/The-Register.jpg') }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/Dregister/profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="/Dregister/info-settings">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('/Dregister/logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Information - Update</h1>

            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-danger">Information Update </h6>
                  <div class="float-right text-danger " id="updateToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="update-body">
                    @if(!isset( $schoolInformation->id))
                    <form class="form" action="/Dregister/add-info-settings" enctype="multipart/form-data" method="POST">
                     @else
                        <form class="form" action="/Dregister/update-info-settings" enctype="multipart/form-data" method="POST">   
                        {{method_field('PUT')}}
                        @if($schoolInformation->school_enable !='' || $schoolInformation->school_enable !=null)
                           @php $readOnly =$schoolInformation->school_enable; $disabled ="disabled";
                           @endphp
                        @else
                           @php $readOnly =$schoolInformation->school_enable; $disabled ="";
                           @endphp                           
                        @endif
                     @endif

                     {{csrf_field()}}
                     <input type="hidden" name="id" value="{{old('id', $schoolInformation->id)}}">
                     <input type="hidden" name="userId" value="{{$schoolInformation->corox_model_id ? old('id', $schoolInformation->corox_model_id) : $userId}}">
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="school-profile-image" class="control-label text-info"> Profile Image</label>                        
                            <input type="file" id="profileImage" name="profileImage" class="form-control" {{$disabled}}>
                        </div>
                      </div>                       
                    </div>
                     <hr>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 ">
                        <div class="form-group">
                          <label for="school-name" class="control-label text-info"> Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter School Name" value="{{$schoolInformation->school_name !== null ? $schoolInformation->school_name :old('name', $schoolInformation->school_name) }}" {{$readOnly}}>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="school-email" class="control-label text-info"> Email</label>
                             <input type="email" id="email" name="email" class="form-control" placeholder="Enter School Email" value="{{$schoolInformation->school_email !== null ? $schoolInformation->school_email :old('email',  $userEmail) }}" {{$readOnly}}>
                        </div>
                      </div>                        
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="phone-number" class="control-label text-info"> Phone Number 1</label>
                            <input type="text" id="phone1" name="phone1" class="form-control" placeholder="Enter School Phone Number" value="{{$schoolInformation->school_phone1 !== null ? $schoolInformation->school_phone1 :old('phone1', $schoolInformation->school_phone1) }}" {{$readOnly}}>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="school-email" class="control-label text-info" > Phone Number 2</label>
                             <input type="text" id="phone2" name="phone2" class="form-control" placeholder="Enter School Phone Number" value="{{$schoolInformation->school_phone2 !== null ? $schoolInformation->school_phone2 :old('phone2', $schoolInformation->school_phone2) }}" {{$readOnly}}>
                        </div>
                      </div>                        
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="school-address" class="control-label text-info"> Address</label>
                            <textarea  id="address" name="address" class="form-control" placeholder="Enter School Address" {{$readOnly}}>{{$schoolInformation->school_address !== null ? $schoolInformation->school_address :old('address', $schoolInformation->school_address) }}</textarea>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="license" class="control-label text-info" > License</label>
                             <select class="form-control" id="license" name="license" {{$disabled}}>
                              @if($schoolInformation->school_license ==="none" || $schoolInformation->school_license ===NULL)
                                 <option value="{{$schoolInformation->school_license !== null ? $schoolInformation->school_license :old('license', $schoolInformation->school_license) }}">Select-License-Status</option>
                                 <option value="approved">Approved</option>
                                 <option value="unapprove">Unapproved</option>
                              @elseif($schoolInformation->school_license ==="approved")
                                 <option value="none">Select-License-Status</option>
                                 <option value="{{$schoolInformation->school_license !== null ? $schoolInformation->school_license :old('license', $schoolInformation->school_license) }}" selected>Approved</option>
                                 <option value="unapprove">Unapproved</option>
                              @else
                                 <option value="none">Select-License-Status</option>
                                 <option value="approved">Approved</option>
                                 <option value="{{$schoolInformation->school_license !== null ? $schoolInformation->school_license :old('license', $schoolInformation->school_license) }}" selected>Unapproved</option> 
                              @endif
                             </select>
                        </div>
                      </div>                        
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="city" class="control-label text-info"> City</label>
                            <input type="text" id="city" name="city" class="form-control" placeholder="Enter City" value="{{$schoolInformation->school_city !== null ? $schoolInformation->school_city :old('city', $schoolInformation->school_city) }}" {{$readOnly}}>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="social-media" class="control-label text-info" >Social Media Handle</label>
                             <input type="text" id="social" name="social" class="form-control" placeholder="Enter Social Medial Handle" value="{{$schoolInformation->school_social_media !== null ? $schoolInformation->school_social_media :old('social', $schoolInformation->school_social_media) }}" {{$readOnly}}>
                        </div>
                      </div>                        
                    </div>                        
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="state" class="control-label text-info"> State</label>
                            <select class="form-control" id="state" name="state" {{$disabled}}>
                              @if($schoolInformation->school_state ==="none" || $schoolInformation->school_state === null)
                                 <option value="none">Select State</option>
                              @else($schoolInformation->school_state !=="none" || $schoolInformation->school_state !== null)
                                 <option value="{{$schoolInformation->school_state !== null ? $schoolInformation->school_state :old('state', $schoolInformation->school_state) }}" selected>{{$schoolInformation->school_state}}</option>
                              @endif   
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="local-government" class="control-label text-info" > Local-Govt</label>
                             <select class="form-control" id="localG" name="localG" {{$disabled}}>
                              @if($schoolInformation->school_localG ==="none" || $schoolInformation->school_localG === null)
                                 <option value="none">Select Local-Govt</option>
                              @else($schoolInformation->school_localG !=="none" || $schoolInformation->school_localG !== null)
                                 <option value="{{$schoolInformation->school_localG !== null ? $schoolInformation->school_localG :old('localG', $schoolInformation->school_localG) }}" selected>{{$schoolInformation->school_localG}}</option>
                              @endif   
                             </select>
                        </div>
                      </div>                        
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="number-of-staff" class="control-label text-info"> Number Of Staffs</label>
                            <input type="number" id="numberStaff" name="numberStaff" class="form-control" placeholder="Present Number Of Staff" value="{{ isset($numberOfStaffs) && $numberOfStaffs !== '' ? $numberOfStaffs :old('numberStaff', $schoolInformation->school_number_of_staffs)}}" {{$disabled}}>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="school-email" class="control-label text-info" > Description Of The School</label>
                             <textarea type="email" id="description" name="description" class="form-control" placeholder="Enter Short Description Of School" {{$readOnly}}>{{$schoolInformation->school_description !== null ? $schoolInformation->school_description :old('description', $schoolInformation->school_description) }}</textarea>
                        </div>
                      </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 ">
                        <div class="form-group">
                           <label for="lincense" id="services" class="control-label text-info" > Educational Services</label>
                             <select class="form-control" name="services[]" multiple {{$disabled}}>
                              @if($schoolInformation->school_services ==="none" || $schoolInformation->school_services ===NULL)
                                 <option none="none">Select-Educational-Services</option>
                                 <option value="creche/playgroup">Creche/Play-Group</option>
                                 <option value="nursery">Nursery</option>
                                 <option value="primary/basic">Primary/Basic</option>
                                 <option value="secondary">Secondary</option>
                              @else($schoolInformation->school_services !=="none")
                                 <option none="none">Select-Educational-Services</option>
                                 @foreach($services as $key => $value)
                                    @if($services[$key]=="creche/playgroup")
                                       <option value="{{$services[$key]}}" selected>Creche/Play-Group</option>
                                    @elseif($services[$key]=="nursery")
                                       <option value="{{$services[$key]}}" selected>Nursery</option>
                                    @elseif($services[$key]=="primary/basic")
                                       <option value="{{$services[$key]}}" selected>Primary/Basic</option>
                                    @elseif($services[$key]=="secondary")
                                       <option value="{{$services[$key]}}" selected>Secondary</option>                                
                                    @endif   
                                 @endforeach
                                 @foreach($schoolServices as $key => $value)
                                    @if($schoolServices[$key] =="creche/playgroup")
                                       <option value="{{$schoolServices[$key]}}" >Creche/Play-Group</option>
                                    @elseif($schoolServices[$key] =="nursery")
                                       <option value="{{$schoolServices[$key]}}" >Nursery</option>
                                    @elseif($schoolServices[$key] =="primary/basic")
                                       <option value="{{$schoolServices[$key]}}" >Primary/Basic</option>
                                    @elseif($schoolServices[$key] =="secondary")
                                       <option value="{{$schoolServices[$key]}}">Secondary</option>                                
                                    @endif   
                                 @endforeach                                                                    
                              @endif      
                             </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="date" id="date" class="control-label text-info">Established Date</label>
                            <input type="date" name="date" class="form-control" value="{{$schoolInformation->school_establish_date !== null ? $schoolInformation->school_establish_date :old('date',date('m/d/y',strtotime($schoolInformation->school_establish_date))) }}" {{$disabled}}>
                        </div>
                      </div>                        
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="license-number" class="control-label text-info" > License Number</label>
                            <input type="text" id="license" name="licenseNumber" class="form-control" placeholder="Enter License Number" value="{{$schoolInformation->school_license_number !== null ? $schoolInformation->school_license_number :old('licenseNumber', $schoolInformation->school_license_number) }}" {{$readOnly}}>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="postal-address" class="control-label text-info" >Postal Address</label>
                             <input type="text" id="postalCode" name="postalAddress" class="form-control" placeholder="Enter Postal Code" value="{{$schoolInformation->school_postal_address !== null ? $schoolInformation->school_postal_address :old('postalAddress', $schoolInformation->school_postal_address) }}" {{$readOnly}}>
                        </div>
                      </div>                        
                    </div>
                    <div class="row">
                      <div class="col-md-6 offset-sm-6 col-sm-6">
                        <div class="form-group">
                           <button type="submit"  id="updateInformation"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; The Register {{$date}}</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <script>
      window.onload=dateTime(); 
   </script>  
  <!-- Bootstrap core JavaScript-->

  <script src="{{asset('my-register/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('my-register/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('my-register/js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->
  <script src="{{asset('my-register/vendor/chart.js/Chart.min.js')}}"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('my-register/js/demo/chart-area-demo.js')}}"></script>
  <script src="{{asset('my-register/js/demo/chart-pie-demo.js')}}"></script>
    <form id='logout-form' action="{{url('/Dregister/logout')}}"
    method="POST" style='display:none'>
        {{csrf_field()}}
    </form>
</body>

</html>
