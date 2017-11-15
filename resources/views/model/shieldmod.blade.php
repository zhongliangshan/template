@section('css')
    <link rel="stylesheet" href="{{asset('adminlte/plugins/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/apps/css/select2.css')}}">
@stop
<div id='shieldCtlmod' name='shieldCtlmod' style='display:none'>
    <div class="col-md-12" style='height:35px;line-height:35px;margin-top:20px;margin-bottom:20px;'> 
        <div class="col-md-4" style='height:35px;text-align:right;line-height:35px;'> 模块ID &nbsp;<span style='color:red'>*</span></div>
        <div class="col-md-8" style='height:35px;line-height:35px;margin:0;padding:0'>
            <select id='shostmod' name='shostmod' class='form-control select2' style='height:35px;line-height:35px;width:280px;'>
            @foreach($data as $k=>$v)
                <option value='{{$k}}'>{{$v}}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-12" style='height:35px;line-height:35px;margin-bottom:20px;'> 
        <div class="col-md-4" style='height:35px;text-align:right;line-height:35px;'> 请输入屏蔽指标(key)</div>
        <div class="col-md-8" style='height:35px;line-height:35px;margin:0;padding:0'>
            <input id='skeymod' name='skeymod' style='width:280px;line-height:35px;height:35px;' value="">
            <font>|分隔&nbsp;(留空屏蔽所有告警)</font>
        </div>
    </div>

    <div class="col-md-12" style='height:35px;line-height:35px;'> 
        <div class="col-md-4" style='height:35px;text-align:right;line-height:35px;'> 屏蔽周期&nbsp;<span style='color:red'>*</span></div>
        <div class="col-md-8" style='height:35px;line-height:35px;margin:0;padding:0'>
            <select id='speriodicmod' name='speriodicmod' class='form-control select2'  style='height:35px;line-height:35px;width:280px;'>
            <option value='30M'>半小时</option>
            <option value='3h'>3小时</option>
            <option value='8h'>12小时</option>
            <option value='1d'>1天</option>
            <option value='3d'>3天</option>
            <option value='7d'>1周</option>
            <option value='14d'>2周</option>
            <option value='1m'>1月</option>
            <option value='3m'>3月</option>
            <option value='6m'>6月</option>
            <option value='1y'>1年</option>
            <option value='3y'>2年</option>
            </select>
        </div>
    </div>
    <div class="col-md-12" style='height:35px;margin-top:20px'> 
        <div class="col-md-4" style='height:35px;text-align:right;line-height:35px;'> 请输入屏蔽原因&nbsp;<span style='color:red'>*</span></div>
        <textarea class="col-md-8" style='height:80px;width:280px' id='reasonmod' name='reasonmod'></textarea>
    </div>
</div>
