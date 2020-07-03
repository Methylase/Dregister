<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{csrf_token()}}">    
  <meta name="author" content="">

  <title>The Register - Setting Privilege</title>

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
         $('#privilege').on('click', function(){
            
            $('.yesPrivilege').on('click', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            var privilege = $('#privilegeType').val();
            var staffEmail= $('#staffName').val();
            var values = {
             "privilege" : privilege,
             "staffEmail": staffEmail,
             "_token": token,
            }
            $.ajax({
               type: "POST",
               url: "/Dregister/privilege",
               data: values,
            }).done(function(result){
              if (result.success=='success'){
                $('#privilegeRegister').hide('fast');
                $("#update-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
               setTimeout(function(){
                location.reload();
               }, 6000);
              }else if(result.success=='danger'){
                $('#privilegeRegister').hide('fast');
                $("#update-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
               setTimeout(function(){
                location.reload();
               }, 6000);               
              }
            });
          })      
        })       
          $('.setRead').on('change', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            var read;
            if ($(this).prop("checked")== true) {
                  read = $(this).val();
               if ( $('.setRead').attr('data-target') =="#enable") {
                  $('.setRead').attr('data-target','#disable');
               }
               
               $('.disable').on('click', function(){
                  
                  var values = {
                   "read" : read,
                   "_token": token,
                  }
                  
                  $.ajax({
                     type: "POST",
                     url: "/Dregister/Enable/settings-information",
                     data: values,
                  }).done(function(result){
                    if (result.success=='success'){
                     $('#disable').hide('fast')
                      $("#update-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
                     setTimeout(function(){
                      location.reload();
                     }, 6000);
                    }else if(result.success=='danger'){
                     $('#disable').hide('fast')
                      $("#update-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
                     setTimeout(function(){
                      location.reload();
                     }, 6000);               
                    }
                  });
               });
            }else if($(this).prop("checked")== false){
               if ( $('.setRead').attr('data-target') =="#disable") {
                  $('.setRead').attr('data-target','#enable');
               }
               $('.enable').on('click', function(){  
                  read ="off";
                  var values = {
                   "read" : read,
                   "_token": token,
                  }
                  $.ajax({
                     type: "POST",
                     url: "/Dregister/Enable/settings-information",
                     data: values,
                  }).done(function(result){
                    if (result.success=='success'){
                    $('#enable').hide('fast');
                      $("#update-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
                     setTimeout(function(){
                      location.reload();
                     }, 6000);
                    }else if(result.success=='danger'){
                      $('#enable').hide('fast')
                      $("#update-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
                     setTimeout(function(){
                      location.reload();
                     }, 6000);               
                    }
                  });
               });
            }
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
      th{
      border-top: 6px solid #36b9cc !important;
      border-bottom: 2px solid #36b9cc !important;
      font-weight: 600 !important;
      text-align:center;
      }
      td{
         font-size: .85rem !important;
      }
      tr:hover{
        color: #36b9cc;
      }      
      .table-redesign{
        border-radius: 20px !important;
        border-bottom: 2px solid #36b9cc !important;
      }
     .paginate-btn{
        margin: 2px;
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
            <h1 class="h3 mb-0 text-gray-800"> Setting Privilege</h1>

            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-danger"> Setting Privilege </h6>
                  <div class="float-right text-danger " id="updateToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="update-body">
                   <div class='offset-md-1 col-md-10 offset-sm-1 col-sm-10'>
                     <h6 class="m-0 text-danger"> Setting privilege and access </h6>                     
                     <form class="form">
                     {{csrf_field()}}
                     @if(isset($schoolInformation->school_enable) && $schoolInformation->school_enable !='' || $schoolInformation->school_enable !=null)
                        @php $checked ="checked";$dataTarget ="#enable";  
                        @endphp
                     @else
                        @php $checked =""; $dataTarget ="#disable";
                        @endphp                           
                     @endif                     
                     <div class="row">
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label for="privilege-type" class="label-control text-info">Privilege Type:</label>
                              <select class="form-control" id="privilegeType" name="privilegeType">
                                  <option value="none">Select-Privilege-Type</option>
                                  <option value="access">Access</option>  
                                  <option value="onhold">On Hold</option>
                                  <option value="remove">Remove</option>   
                              </select>
                           </div>                              
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label for="staff-name" class="label-control text-info">Staff Name</label>
                              <select class="form-control" id="staffName" name="staffName">
                                  <option value="none">Select-Staff-Name</option>
                                    @foreach($staffInformation as $staff)
                                         @if($staff->staff_email != null)
                                          <option value="{{$staff->staff_email}}">{{ucfirst($staff->staff_firstname).' '.ucfirst($staff->staff_lastname)}}</option>
                                          @endif
                                    @endforeach
                              </select>
                           </div>                                  
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">                      
                              <label for="gender" class="checkbox-inline text-info">Enabled Settings  <input type="checkbox"  class="setRead" data-title="Setting Information" data-toggle="modal" data-target="{{$dataTarget}}"  name="read" {{$checked}} style="margin-left:10px"></label>
                              <button type="button" id="privilege" class="btn btn-success form-control" data-title="Register" data-toggle="modal" data-target="#privilegeRegister"><i class="fa fa-save"></i> Set Previlege</button>
                           </div>
                        </div>                           
                        <hr>   
                     </div>
                     </form>
                   </div>                     
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

   <!-- modal for mark register -->
    <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="privilegeRegister" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">                  
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title text-info" id="Heading">Set privilege</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to set this privilege?</div>
          </div>
          <div class="modal-footer">
            <button  class="btn btn-success yesPrivilege"><span class="fa fa-check-circle"></span> Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
          </div>
        </div>
      </div>
    </div>
     <!-- end of modal for register  -->
   <!-- modal for enabling information settings -->
    <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="enable" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">                  
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title text-info" id="Heading"> Enable Information Settings </h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to set all Information settings to enable?</div>
          </div>
          <div class="modal-footer">
            <button  class="btn btn-success enable"><span class="fa fa-check-circle"></span> Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
          </div>
        </div>
      </div>
    </div>
     <!-- end of modal for enabling information settings -->
   <!-- modal for disabling information settings -->
    <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="disable" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">                  
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title text-info" id="Heading">Disable Information settings</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to set all information settings to Disable?</div>
          </div>
          <div class="modal-footer">
            <button  class="btn btn-success disable"><span class="fa fa-check-circle"></span> Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
          </div>
        </div>
      </div>
    </div>
     <!-- end of modal for disabling information settings -->       
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
  <script src="{{asset('my-register/vendor/jquery/jquery.min.js')}}"></script>     
    <form id='logout-form' action="{{url('/Dregister/logout')}}"
    method="POST" style='display:none'>
        {{csrf_field()}}
    </form>
</body>

</html>
