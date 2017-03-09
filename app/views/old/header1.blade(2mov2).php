@section('header')

  <div class="tabbable boxed parentTabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#househld">HOUSEHOLD</a>
        </li>
        <li><a href="#beneficiary">BENEFICIARY</a>
        </li>
        <li><a href="#ubale">UBALE</a>
        </li>
        <li><a href="#m_report">REPORT</a>
        </li>
        <li><a href="#admin">ADMIN</a>
        </li>
        <li><a href="{{URL::to('logout')}}">LOGOUT</a>
        </li>

    </ul>
    
    <div class="tab-content">
        <div class="tab-pane fade active in" id="househld">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#sub11">HouseHold Register</a>
                    </li>
                    <li><a href="#sub12">HouseHold Report</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="sub11">
                        <p>HouseHold Registration</p>
                    </div>
                    <div class="tab-pane fade" id="sub12">
                        <p>HouseHold Report</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="beneficiary">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#sub21">Register</a>
                    </li>
                    <li><a href="#sub22">Remove</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="sub21">
                        <p>Beneficiary Registration</p>
                    </div>
                    <div class="tab-pane fade" id="sub22">
                        <p>Remove Beneficiaryiary From Program</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="ubale">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#sub31">MCHN</a>
                    </li>
                    <li><a href="#sub32">AGRICULTURE AND NRM</a>
                    </li>
                    <li><a href="#sub33">VSL AND AGRI BUSINESS</a>
                    </li>
                    <li><a href="#sub34">COMMODITIES</a>
                    </li>
                    <li><a href="#sub35">DRR AND CROSS CUTTING</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="sub31">
                        <p>Martenal Child Health And Nutrition</p>
                    </div>
                    <div class="tab-pane fade" id="sub33">
                        <p>Village Savings and Agriculture Business</p>
                    </div>
                    <div class="tab-pane fade" id="sub34">
                        <p>Commodities</p>
                    </div>
                    <div class="tab-pane fade" id="sub35">
                        <p>Disater Risk Management</p>
                    </div>
                    <div class="tab-pane fade" id="sub32">
                        <p>Agricultur and Natural Resources Management</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="m_report">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#sub21">Tab 2.1</a>
                    </li>
                    <li><a href="#sub22">Tab 2.2</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="sub21">
                        <p>Tab 2.1</p>
                    </div>
                    <div class="tab-pane fade" id="sub22">
                        <p>Tab 2.2</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="admin">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#sub21">Tab 2.1</a>
                    </li>
                    <li><a href="#sub22">Tab 2.2</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="sub21">
                        <p>Tab 2.1</p>
                    </div>
                    <div class="tab-pane fade" id="sub22">
                        <p>Tab 2.2</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@show