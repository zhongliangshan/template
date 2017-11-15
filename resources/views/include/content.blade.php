<div class="page-content" style="min-height:823px !important">
    <div id="portlet-config" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button"></button>
            <h3>portlet Settings</h3>
        </div>
        <div class="modal-body">
            <p>Here will be a configuration form</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="color-panel hidden-phone">
            <div class="color-mode-icons icon-color"></div>
            <div class="color-mode-icons icon-color-close"></div>
            <div class="color-mode">
                <p>THEME COLOR</p>
                <ul class="inline">
                    <li class="color-black current color-default" data-style="default"></li>
                    <li class="color-blue" data-style="blue"></li>
                    <li class="color-brown" data-style="brown"></li>
                    <li class="color-purple" data-style="purple"></li>
                    <li class="color-grey" data-style="grey"></li>
                    <li class="color-white color-light" data-style="light"></li>
                </ul>
                <label>
                    <span>Layout</span>
                    <select class="layout-option m-wrap small">
                        <option value="fluid" selected="">Fluid</option>
                        <option value="boxed">Boxed</option>
                    </select>
                </label>
                <label>
                    <span>Header</span>
                    <select class="header-option m-wrap small">
                        <option value="fixed" selected="">Fixed</option>
                        <option value="default">Default</option>
                    </select>
                </label>
                <label>
                    <span>Sidebar</span>
                    <select class="sidebar-option m-wrap small">
                        <option value="fixed">Fixed</option>
                        <option value="default" selected="">Default</option>
                    </select>
                </label>
                <label>
                    <span>Footer</span>
                    <select class="footer-option m-wrap small">
                        <option value="fixed">Fixed</option>
                        <option value="default" selected="">Default</option>
                    </select>
                </label>
            </div>
        </div>

       <h3 class="page-title">
            {{ $title or ' NO TITLE'}}
            @if(isset($small_title))
                <small>{{ $small_title }}</small>
            @endif
        </h3>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home"></i>首页</a></li>
            @if(isset($breadcrumb))
                @if(is_array($breadcrumb))
                    @foreach($breadcrumb as $key => $value)
                        <li>
                            @if(is_numeric($key))
                                <i class="icon-angle-right"></i>{{ $value }}
                            @else
                                <a href="{{ $key }}"><i class="icon-angle-right"></i>{{ $value }}</a>
                            @endif
                        </li>
                    @endforeach
                @else
                    <li><i class="fa"></i>{{ $breadcrumb }}</li>
                @endif
            @endif
        </ul>
        @yield('content')
    </div>
</div>
