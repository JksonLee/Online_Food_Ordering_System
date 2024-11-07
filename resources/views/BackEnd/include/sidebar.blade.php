@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
@endphp


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{asset('/home')}}" class="brand-link">
    
      <span class="brand-text font-weight-light" >    Num Num Restaurant</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('/BackEndSourceFile')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> {{ session('admin_name') ?? 'Admin' }} <!-- Display the admin name if available --></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <!-- ======================Category Start=======================         -->
          <li class="nav-item has-treeview {{ ($prefix=='/category')?'menu-open':''}}">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
               Category
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">

                  
                  

              <a href="{{ route('category_add') }}" class="nav-link {{ ($route == 'category_add') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('manage_cate') }}" class="nav-link {{($route=='manage_cate')?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Category</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- ======================Category End=======================         -->
          
          <!-- ======================Delivery Start=======================         -->
              <li class="nav-item {{ ($prefix=='/delivery_boy')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Delivery Boy
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('deliveryBoy_add')}} " class="nav-link {{ ($route == 'deliveryBoy_add') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Delivery Boy</p>
                </a>
              </li>
              <li class="nav-item">
                  <a href=" {{ route('delivery_boy_manage')}} " class="nav-link {{ ($route == 'delivery_boy_manage') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Delivery Boy</p>
                </a>
              </li>
            </ul>
          </li> 
          <!-- ======================Delivery End=======================         -->
          
         <!-- ======================Coupon Start=======================         --> 
              <li class="nav-item {{ ($prefix=='/coupon')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
             Coupon Code
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('coupon_add')}} " class="nav-link {{ ($route == 'coupon_add') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Coupon Code</p>
                </a>
              </li>
              <li class="nav-item">
                  <a href=" {{ route('coupon_manage')}} " class="nav-link {{ ($route == 'coupon_manage') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Coupon Code</p>
                </a>
              </li>
            </ul>
          </li> 
          <!-- ======================Coupon End=======================         -->
          
     
<!-- ======================Dish Start=======================         -->
                <li class="nav-item {{ ($prefix=='/dish')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Dish
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('add_dish')}} " class="nav-link {{ ($route == 'add_dish') ? 'active' : '' }}">
                     <i class="far fa-circle nav-icon"></i>
                  <p>Generate Dish</p>
                </a>
              </li>
              <li class="nav-item">
                  <a href=" {{ route('manage_dish')}} " class="nav-link {{ ($route == 'manage_dish') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                  <p>Manage Dish</p>
                </a>
              </li>
            </ul>
          </li> 
 <!-- ======================Dish End=======================         -->         
          
 
 <!-- ======================Order Start=======================         -->
                <li class="nav-item {{ ($prefix=='/order')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Order
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('manage_order')}} " class="nav-link {{ ($route == 'manage_dish') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
            <p>Manage Order</p>
                </a>
              </li>
            </ul>
          </li> 
        <!-- ======================Order End=======================         -->
 
 
        <!-- ======================Review and Rating Start======================= -->
<li class="nav-item {{ ($prefix=='/review_rating')?'menu-open':''}}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
        Review and Rating
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('review_manage')}} " class="nav-link {{ ($route == 'review_manage') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>View Reviews </p>
            </a>
        </li>
        
        <!-- Average Rating Link -->
<li class="nav-item">
    <a href="{{ route('average_rating') }}" class="nav-link {{ ($route == 'average_rating') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Average Rating</p>
    </a>
</li>
  </ul>
          </li>
<!-- ======================Review and Rating End======================= -->

<!-- ======================XML Start======================= -->
<li class="nav-item {{ ($prefix=='/xml') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file-code"></i>
        <p>
            XML Data Management
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
  
        <li class="nav-item">
            <a href="{{ route('xml_order') }}" class="nav-link {{ ($route == 'xml_order') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Orders(XML)</p>
            </a>
        </li>
    <li class="nav-item">
            <a href="{{ route('xml_customer') }}" class="nav-link {{ ($route == 'xml_customer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Customers(XML)</p>
            </a>
        </li>
         <li class="nav-item">
            <a href="{{ route('xml_rating') }}" class="nav-link {{ ($route == 'xml_rating') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Rating(XML)</p>
            </a>
        </li>
           <li class="nav-item">
            <a href="{{route('xml_menu')}}" class="nav-link {{ ($route == 'xml_menu') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu(XML)</p>
            </a>
        </li>
        
          <li class="nav-item">
            <a href="{{ route('xml_payment') }}" class="nav-link {{ ($route == 'xml_payment') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Payments(XML)</p>
            </a>
        </li>
    </ul>
</li>


<!-- ======================XML End======================= -->
     

<!-- ======================XML Download Start======================= -->
<li class="nav-item {{ ($prefix=='/download_xml') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file-code"></i>
        <p>
            XML File Download
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <!-- Orders XML Download -->
        <li class="nav-item">
            <a href="{{ route('download_order_xml') }}" class="nav-link {{ ($route == 'download_order_xml') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Download Orders(XML)</p>
            </a>
        </li>
        <!-- Customers XML Download -->
        <li class="nav-item">
            <a href="{{ route('download_customer_xml') }}" class="nav-link {{ ($route == 'download_customer_xml') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Download Customers(XML)</p>
            </a>
        </li>
        <!-- Ratings XML Download -->
        <li class="nav-item">
            <a href="{{ route('download_rating_xml') }}" class="nav-link {{ ($route == 'download_rating_xml') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Download Ratings(XML)</p>
            </a>
        </li>
        <!-- Menu XML Download -->
        <li class="nav-item">
            <a href="{{ route('download_menu_xml') }}" class="nav-link {{ ($route == 'download_menu_xml') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Download Menu(XML)</p>
            </a>
        </li>
        <!-- Payments XML Download -->
        <li class="nav-item">
            <a href="{{ route('download_payment_xml') }}" class="nav-link {{ ($route == 'download_payment_xml') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Download Payments(XML)</p>
            </a>
        </li>
    </ul>
</li>
<!-- ======================XML Download End======================= -->


<!-- ======================XSLT Start======================= -->
<li class="nav-item {{ ($prefix=='/xslt') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
            XSLT Transformations
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
   
        <li class="nav-item">
            <a href="{{ route('xslt_order') }}" class="nav-link {{ ($route == 'xslt_order') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Transform Orders(XSLT)</p>
            </a>
        </li>
     
        <li class="nav-item">
            <a href="{{ route('xslt_customer') }}" class="nav-link {{ ($route == 'xslt_customer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Transform Customers(XSLT)</p>
            </a>
        </li>
        
          <li class="nav-item">
            <a href="{{ route('xslt_rating') }}" class="nav-link {{ ($route == 'xslt_rating') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Transform Rating(XSLT)</p>
            </a>
        </li>
           <li class="nav-item">
            <a href="{{route('xslt_menu')}}" class="nav-link {{ ($route == 'xslt_menu') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Transform Menu(XSLT)</p>
            </a>
        </li>
        
         <li class="nav-item">
            <a href="{{ route('xslt_payment') }}" class="nav-link {{ ($route == 'xslt_payment') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Transform Payments(XSLT)</p>
            </a>
        </li>
       
<!-- ======================XSLT End======================= -->



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
