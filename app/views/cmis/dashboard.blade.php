@extends('master1')
@section('content')

<div class="wrapper">
    

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                           
        <li class="dropdown mega-dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">SECTORS<span class="caret"></span></a>
             <ul class="dropdown-menu mega-dropdown-menu">
              <li class="col-sm-2">
                <ul >
                  <li class="dropdown-header">MCHN</li>
                       <li><a href="{{URL::to('mother_child')}}" >MCP-Child </a></li>
                       <li><a href="{{URL::to('mother_preg')}}" >MCP-Pregnant</a></li>
                       <li><a href="{{URL::to('mother_verification')}}" >MCP-Verifications</a></li>
                       <li><a href="{{URL::to('mother_verification')}}" >ACLAN</a></li>
                       <li><a href="{{URL::to('mother_verification')}}" >ANCC</a></li>
                       <li><a href="{{URL::to('mother_verification')}}" >VNCC</a></li>
                  </li>
  
                   <li class="dropdown-header">Caregroup</li>
                        <li><a href="{{URL::to('mother_childCluster')}}" >MCHN-CG Registration</a></li>     
                    <li class="dropdown-header">CCFLS</li>                  
                        <li><a href="{{URL::to('mother_childCCFLS')}}" >CCFLS - Child</a></li>
                        <li><a href="{{URL::to('mother_childCCFLSpreg')}}" >CCFLS - Pregnant and Lactating</a></li>
                </ul>
              </li>
              
               <li class="col-sm-2">
                  <ul>
                       <li class="dropdown-header">AGRICULTURE AND NRM</li>
                              <li><a href="{{URL::to('/diner')}}" >DiNER Fairs Register</a></li>
                              <li><a href="{{URL::to('/demoplot')}}" >Demo Plot</a></li>
                              <li><a href="{{URL::to('/spanel')}}" >Stakeholder Panel</a></li>
                              <li><a href="{{URL::to('/farmerLearn')}}" >Farmers Learning Center</a></li>
                              <li><a href="{{URL::to('/seedMult')}}" >Seed Multipication Group</a></li>


                  </ul>
               </li>
               
                  
               
                
                <li class="col-sm-3">
                  <ul>
                       <li class="dropdown-header">SILC AND AGRI BUSINESS</li>
                             <li><a href="{{URL::to('/silc')}}" >SILC Group Member Register</a></li>
                             <li><a href="{{URL::to('/marketclub')}}" >Marketing Club Member Register</a></li>

                  </ul>
               </li>
         
      
            
             <li class="col-sm-2">
                  <ul>
                       <li class="dropdown-header">COMMODITY</li>
                              <li><a href="{{URL::to('commodityHome')}}">Commodities</a></li>

                              <li class="divider"></li>
                              <li class="dropdown-header">Food For Assets (FFA)</li>
                              <li><a href="{{URL::to('ffa')}}" >FFA - Proposals</a></li>
                              <li><a href="{{URL::to('ffaproposals')}}" >FFA - Approved Proposals</a></li>
                              <li><a href="{{URL::to('ffaparticipants')}}" >FFA - Participants</a></li>
                              <li><a href="{{URL::to('ffaverifications')}}" >FFA - Verification</a></li>                       

                  </ul>
               </li>
             
             <li class="col-sm-2">
                  <ul>
                       <li class="dropdown-header">DRR AND CROSS CUTTING</li>
                              <li><a href="{{URL::to('drr')}}">DRR</a></li>
                           
                               <li><a href="{{URL::to('acpc')}}" >ACPC</a></li>
                               <li><a href="{{URL::to('vcpc')}}" >VCPC</a></li>
                               <li><a href="{{URL::to('vdc')}}" >VDC</a></li>
                               <li><a href="{{URL::to('vnrmc')}}" >VNRMC</a></li>
                               <li><a href="{{URL::to('youthClub')}}" >Youth Club Committee</a></li>
                              <li><a href="{{URL::to('adc')}}" >ADC</a></li>
                              
                   </ul>
               </li>
                  
                 
                      
            


                
                  
               
                
         
           
         
          
 
             
           

            
            
            
                
                  
                 
            
         
            </li> 
          </ul>
        </li>
         <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">TRAINING <span class="caret"></span></a>
          <ul class="dropdown-menu">
          
            <li><a href="{{URL::to('pmu_training')}}"> PMU/PVO Training</a></li>
            <li class="divider"></li>
            <li><a href="{{URL::to('sub_district')}}">TA/Sub District </a></li>
            <li class="divider"></li>
             <li><a href="{{URL::to('community')}}">Community Level</a></li>
             <li class="divider"></li>
             <li><a href="{{URL::to('community')}}">Training Titles - Print</a></li>
           
          </ul>
        </li> 
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">REPORTS  <span class="caret"></span></a>
          <ul class="dropdown-menu">
          @if($adminRole==1)
            <li><a href="{{URL::to('ITT')}}"> Indicator Tracking </a></li>
           <li class="divider"></li>
            <li><a href="{{URL::to('Participation')}}">Participation</a></li>
           
            <li class="divider"></li>
                 <li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Summary Reports </a>
                <ul class="dropdown-menu">
                  
                <li><a href="{{URL::to('content')}}">Commodities Reports</a></li>
                <li class="divider"></li>
                <li><a href="{{URL::to('purp1')}}" target="_blank">Purpose 1 Summary Reports</a></li>
                <li class="divider"></li>
                <li><a href="{{URL::to('purp2')}}" target="_blank">Purpose 2 Summary Reports</a></li>
                <li class="divider"></li>
                <li><a href="{{URL::to('purp3')}}" target="_blank">Purpose 3 Summary Reports</a></li>
                 <li class="divider"></li>
                 <li><a href="{{URL::to('reportico')}}">Configure Report</a>
              </ul>
            </li>

            </li>

            
                         
           @endif  
          </ul>
        </li> 
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">ADMIN  <span class="caret"></span></a>
          <ul class="dropdown-menu">
          @if($adminRole==1)
            <li><a href="{{URL::to('admin')}}"> User Admin</a></li>
           <li class="divider"></li>
            <li><a href="{{URL::to('codes')}}">Codes Admin</a></li>
            <li class="divider"></li>
            <li><a href="{{URL::to('export')}}">Export Data</a></li>
            <li class="divider"></li>
            <li><a href="{{URL::to('localization')}}">Locolization</a></li>

             
           @endif  
          </ul>
        </li> 
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">HOUSEHOLD<span class="caret"></span></a>
        <ul class="dropdown-menu">
                   <li><a href="{{URL::to('household')}}">Register</a></li>
                   <li class="divider"></li>
          <li><a href="{{URL::to('hhreport')}}">HouseHold Report</a></li>
        </ul>     
      </li>
          </ul>

      <ul class="nav navbar-nav navbar-right">
                <li><a href="https://github.com/fontenele/bootstrap-navbar-dropdowns" target="_blank">WELCOME:{{Str::upper($userName)}}</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url::to('logout')}}">LOGOUT </a></li>
      </ul>


                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">


           <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">MCHN Statistics</h4>
                                <p class="category">Last Campaign Performance</p>
                            </div>
                            <div class="content">
                                <div id="chartPreferences" class="ct-chart ct-perfect-fourth">
                                                       
                              
								
								<div id="my-dash2">
										
								</div>	
                                	{{Lava::render('DonutChart','myDash3','my-dash2')}}	
                                </div>

                               

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Bounce
                                        <i class="fa fa-circle text-warning"></i> Unsubscribe
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i> Campaign sent 2 days ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">HouseHold Listng Data</h4>
                                <p class="category">Listing Info Per Traditional Authority</p>
                            </div>
								<div class="content">
                                <div id="chartHours" class="ct-chart">
									 
                            	<div id="my-dash">
									<div id="chart"></div>
									<div id="control"></div>	
								</div>	
                                	{{Lava::render('Dashboard','myDash','my-dash')}}</div>
                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Click
                                        <i class="fa fa-circle text-warning"></i> Click Second Time
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated 3 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">2014 Sales</h4>
                                <p class="category">All products including Taxes</p>
                            </div>
                            <div class="content">
                                <div id="chartActivity" class="ct-chart"></div>

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Tesla Model S
                                        <i class="fa fa-circle text-danger"></i> BMW 5 Series
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-check"></i> Data information certified
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">Tasks</h4>
                                <p class="category">Backend development</p>
                            </div>
                            <div class="content">
                                <div class="table-full-width">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox">
                                                    </label>
                                                </td>
                                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox" checked="">
                                                    </label>
                                                </td>
                                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox" checked="">
                                                    </label>
                                                </td>
                                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox">
                                                    </label>
                                                </td>
                                                <td>Create 4 Invisible User Experiences you Never Knew About</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox">
                                                    </label>
                                                </td>
                                                <td>Read "Following makes Medium better"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox">
                                                    </label>
                                                </td>
                                                <td>Unfollow 5 enemies from twitter</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated 3 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>

                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; 2017 <a href="http://www.ubale-cmis.com">UBALE MEAL</a>, developed by CRS MALAWI MEAL
                </p>
            </div>
        </footer>

    </div>
</div>




</div>

@stop