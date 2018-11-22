<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="/static/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{session('adminUser')->username}}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li @if(count($breadCrumb) == 1) class="active" @endif><a href="/"><i class="fa fa-book"></i> <span>首页</span></a></li>
        <li @if(in_array('会员管理',$breadCrumb)) class="active" @endif class="treeview">
            <a href="#">
                <i class="fa fa-files-o"></i>
                <span>会员管理</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li @if(in_array('会员列表',$breadCrumb)) class="active" @endif><a href="/member"><i class="fa fa-circle-o"></i> 会员列表</a></li>
            </ul>
        </li>
        <li @if(in_array('合作平台管理',$breadCrumb)) class="active" @endif class="treeview">
            <a href="#">
                <i class="fa fa-th"></i> <span>合作平台管理</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li @if(in_array('平台列表',$breadCrumb)) class="active" @endif><a href="/platform"><i class="fa fa-circle-o"></i> 平台列表</a></li>
            </ul>
        </li>
        {{--<li @if(in_array('结算',$breadCrumb)) class="active" @endif class="treeview">--}}
            {{--<a href="/static/pages/calendar.html">--}}
                {{--<i class="fa fa-calendar"></i> <span>结算</span>--}}
                {{--<span class="pull-right-container">--}}
              {{--<small class="label pull-right bg-red">3</small>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
                {{--<li><a href="/static/pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> 结算列表</a></li>--}}
                {{--<li>--}}
                    {{--<a href="/static/pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> 待处理--}}
                        {{--<span class="pull-right-container">--}}
                            {{--<small class="label pull-right bg-red">3</small>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}

        <li  class="treeview">
            <a href="#">
                <i class="fa fa-th"></i> <span>提现审核</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li @if(in_array('所有提现',$breadCrumb)) class="active" @endif>
                    <a href="/withdrawindex/3"><i class="fa fa-circle-o"></i> 所有提现</a>
                </li>
                <li @if(in_array('待处理',$breadCrumb)) class="active" @endif>
                    <a href="/withdrawindex/0"><i class="fa fa-circle-o"></i> 待处理</a>
                </li>
                <li @if(in_array('已通过',$breadCrumb)) class="active" @endif>
                    <a href="/withdrawindex/1"><i class="fa fa-circle-o"></i> 已通过</a>
                </li>
                <li @if(in_array('已拒绝',$breadCrumb)) class="active" @endif>
                    <a href="/withdrawindex/2"><i class="fa fa-circle-o"></i> 已拒绝</a>
                </li>
            </ul>
        </li>

        {{--<li @if(in_array('提现审核',$breadCrumb)) class="active" @endif class="treeview">--}}
            {{--<a href="#">--}}
                {{--<i class="fa fa-calendar"></i> <span>提现审核</span>--}}
                {{--<span class="pull-right-container">--}}
                  {{--<i class="fa fa-angle-left pull-right"></i>--}}
                {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
                {{--<li @if(in_array('所有提现',$breadCrumb)) class="active" @endif>--}}
                    {{--<a href="/withdrawindex/3"><i class="fa fa-circle-o"></i> 所有提现--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li @if(in_array('待处理',$breadCrumb)) class="active" @endif>--}}
                    {{--<a href="/withdrawindex/0"><i class="fa fa-circle-o"></i> 待处理--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li @if(in_array('已通过',$breadCrumb)) class="active" @endif>--}}
                    {{--<a href="/withdrawindex/1"><i class="fa fa-circle-o"></i> 已通过--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li @if(in_array('已拒绝',$breadCrumb)) class="active" @endif>--}}
                    {{--<a href="/withdrawindex/2"><i class="fa fa-circle-o"></i> 已拒绝--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        <li @if(in_array('设置',$breadCrumb)) class="active" @endif class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>设置</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="index.html"><i class="fa fa-circle-o"></i> 基础设置</a></li>
            </ul>
        </li>
        {{--<li class="header">LABELS</li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
    </ul>
</section>
<!-- /.sidebar -->