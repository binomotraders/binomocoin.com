<!--**********************************
    Nav header start
***********************************-->
<div class="nav-header">
    <a href="{{ route('home') }}" class="brand-logo">
        <img class="logo-abbr" src="{{ asset('wallet/images/favicon.png') }}" alt="">
        <img class="logo-compact" src="{{ asset('wallet/images/binomo-text-dark.png') }}" alt="">
        <img class="brand-title" src="{{ asset('wallet/images/binomo-text-dark.png') }}" alt="">
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<!--**********************************
    Nav header end
***********************************-->



<!--**********************************
    Header start
***********************************-->
<div class="header">
	<div class="header-content">
		<nav class="navbar navbar-expand">
			<div class="collapse navbar-collapse justify-content-between">
				<div class="header-left">
					{{-- <div class="dashboard_bar"> Dashboard </div> --}}
				</div>
				<ul class="navbar-nav header-right">
					<li class="nav-item dropdown header-profile">
						<a class="nav-link" href="javascript:void()" role="button" data-toggle="dropdown">
							<div class="header-info"> <span class="text-black">Hello, <strong>{{ Auth::user()->name }}</strong></span>
								<p class="fs-12 mb-0">{{ Auth::user()->email }}</p>
              </div> <img src="{{ asset('wallet/images/avatar/avatar-1.png') }}" width="20" alt="" />
            </a>
						<div class="dropdown-menu dropdown-menu-right">
							<a href="{{ route('profile') }}" class="dropdown-item ai-icon">
                <i class="flaticon-381-user"></i> <span class="ml-2">Profile </span> 
              </a>
							<a href="{{ route('change-password') }}" class="dropdown-item ai-icon">
                <i class="fa fa-unlock-alt" aria-hidden="true"></i> <span class="ml-2">Change Password </span> 
              </a>
							<a  href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item ai-icon">
                <i class="fa fa-sign-out" aria-hidden="true"></i> <span class="ml-2">Logout </span> 
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</div>
<!--**********************************
    Header end ti-comment-alt
***********************************-->

<!--**********************************
    Sidebar start
***********************************-->
<div class="deznav">
  <div class="deznav-scroll">
    <ul class="metismenu" id="menu">
      <li>
        <a href="{{ route('home') }}">
          <i class="flaticon-381-networking"></i>
          <span class="nav-text">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="{{ route('transfer') }}">
          <i class="flaticon-381-internet"></i>
          <span class="nav-text">Transfer</span>
        </a>
      </li>
      <li>
        <a href="{{ route('withdraw') }}">
          <i class="flaticon-381-layer-1"></i>
          <span class="nav-text">Withdraw</span>
        </a>
      </li>
      <li>
        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
          <i class="flaticon-381-notepad"></i>
          <span class="nav-text">Transaction History</span>
        </a>
        <ul aria-expanded="false">
          <li><a href="{{ route('purchase/history') }}">Purchase History</a></li>
          <li><a href="{{ route('transfer/history') }}">Transfer History</a></li>
        </ul>
      </li>
      <li>
        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
          <i class="flaticon-381-settings-2"></i>
          <span class="nav-text">Settings</span>
        </a>
        <ul aria-expanded="false">
          <li><a href="{{ route('profile') }}">Profile</a></li>
          <li><a href="{{ route('change-password') }}">Change Password</a></li>
          <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </ul>
      </li>
    </ul>
  </div>
</div>
<!--**********************************
    Sidebar end
***********************************-->