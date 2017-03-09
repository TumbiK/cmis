@section('header')
    <nav class="navbar navbar-inverse">
 <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
        </button>
      
      <a class="navbar-brand active" href="/dashboard">Ubale</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        
         <li class="dropdown mega-dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">SECTORS <span class="caret"></span></a>
          <ul class="dropdown-menu mega-dropdown-menu">
            <li class="col-sm-2">
                <ul>
                  <li class="dropdown-header">MCHN</li>
                       <li><a href="{{URL::to('mother_child')}}" >MCP-Child </a></li>
                       <li><a href="{{URL::to('mother_preg')}}" >MCP-Pregnant</a></li>
                       <li><a href="{{URL::to('mother_verification')}}" >MCP-Verifications</a></li>
                       <li><a href="{{URL::to('mother_child')}}" >MCP-Exit Status</a></li>
                   <li class="dropdown-header">Caregroup</li>
                        <li><a href="{{URL::to('mother_childCluster')}}" >MCHN-CG Registration</a></li>     
                    <li class="dropdown-header">CCFLS</li>                  
                        <li><a href="{{URL::to('mother_childCCFLS')}}" >MCHN-CCFLS</a></li>
                </ul>
              </li>


            <li class="col-sm-2">
                  <ul>
                       <li class="dropdown-header">AGRICULTURE AND NRM</li>
                              <li><a href="{{URL::to('/diner')}}" >DiNER Fairs Register</a></li>
                              <li><a href="{{URL::to('/demoplot')}}" >Demo Plot</a></li>


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
            <li><a href="{{URL::to('reportico')}}">Summary Reports</a></li>
            
                         
           @endif  
          </ul>
        </li> 
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">ADMIN  <span class="caret"></span></a>
          <ul class="dropdown-menu">
             @if($adminRole==1)
            <li><a href="{{URL::to('admin')}}"> User Admin</a></li>
           
            <li><a href="{{URL::to('codes')}}">Codes Admin</a></li>
            <li><a href="{{URL::to('export')}}">Export Data</a></li>
             <li><a href="{{URL::to('transfers')}}">Transfers</a></li>
           @endif
          </ul>
        </li> 
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">HOUSEHOLD<span class="caret"></span></a>
        <ul class="dropdown-menu">
                   <li><a href="{{URL::to('household')}}">Register</a></li>
          <li><a href="{{URL::to('hhreport')}}">Report</a></li>
        </ul>     
      </li>

        

      </ul>


      <ul class="nav navbar-nav navbar-right">
                <li><a href="https://github.com/fontenele/bootstrap-navbar-dropdowns" target="_blank">WELCOME:</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url::to('logout')}}">LOGOUT </a></li>
      </ul>

    </div>
  </div>
</nav>
@show