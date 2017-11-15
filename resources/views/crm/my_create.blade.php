@extends('include.common')
@section('content')
<div class="row-fluid">
  <div class="span12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <form class="form-search">
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">开始时间</label>
                            <input class="form-control datetime-picker" type="text" name="start_time">
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label">结束时间</label>
                            <input class="form-control datetime-picker" type="text" name="end_time">
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label">工单状态</label>
                            <select name='status' class="form-control select2" data-placeholder="请选择工单状态..">
                                <option value='-1'>请选择工单状态</option>
                                @foreach($status as $key => $val)
                                  <option value="{{ $key }}"> {{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label">工单级别</label>
                            <select name='level' class="form-control select2" data-placeholder="请选择工单级别..">
                               <option value='-1'>请选择工单级别</option>
                                @foreach($levels as $key => $val)
                                  <option value="{{ $key }}"> {{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label">工单类型</label>
                            <select name='type' class="form-control select2" data-placeholder="请选择工单类型..">
                                <option value='-1'>请选择工单类型</option>
                                @foreach($types as $key => $val)
                                  <option value="{{ $key }}"> {{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label">当前处理人</label>
                            <select name='now_deal_name' class="form-control select2" data-placeholder="请选择当前处理人..">
                                <option value=''>请选择当前处理人</option>
                                @foreach($users as $item)
                                  <option value="{{ $item['rtxname'] }}"> {{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label">搜索</label>
                            <input class="form-control" type="text" name="search" placeholder="模糊搜素">
                        </div>
                        <div class="col-sm-1 ">
                            <label>&nbsp;</label>
                            <button class="form-control btn green" data-id="0" type="submit">查询</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="portlet-title pull-right">
                <a data-toggle="modal" data-target="#create_crm"  data-remote='{{ url_param("/crm/create_crm")}}' class="btn green">创建工单</a>
                <a data-toggle="modal" data-target="#batch_turn_crm"  data-remote='{{ url_param("/crm/batch_turn_crm")}}' class="btn green">批量转单</a>
                <a data-toggle="modal" data-target="#batch_end_crm"  data-remote='{{ url_param("/crm/batch_end_crm")}}' class="btn green">批量结单</a>
            </div>
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-reorder"></i>
                    <span class="hidden-480">搜索结果</span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-full-width" id="datalist">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class='first_checkable'></th>
                            <th>工单号</th>
                            <th>工单标题</th>
                            <th>工单类型</th>
                            <th>工单级别</th>
                            <th>当前状态</th>
                            <th>建单人</th>
                            <th>建单时间</th>
                            <th>SLA超时时间</th>
                            <th>OLA超时时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($page as $item)
                            <tr>
                                <td><input name="check_sum" type="checkbox" value='{{ A($item , "id")}}'></td>
                                <td>{{ A($item , 'crm_number')}}</td>
                                <td>{{ A($item , 'crm_title')}}</td>
                                <td>{{ A($types , A($item , 'type')) }}</td>
                                <td>{{ A($levels , A($item , 'level')) }}</td>
                                <td>{{ A($status , A($item , 'status')) }}</td>
                                <td>{{ A($item , 'create_name')}}</td>
                                <td>{{ date('Y-m-d H:i:s' , A($item , 'create_time')) }}</td>
                                <td>{{ date('Y-m-d H:i:s' , A($item , 'create_time')) }}</td>
                                <td>{{ date('Y-m-d H:i:s' , A($item , 'create_time')) }}</td>
                                <td>
                                    <a target='_blank' href='/crm/crm_details?id={{ A($item , "id") }}' class='btn btn-info btn-sm'><i class='icon-edit'>工单明细</a>
                                    <a data-toggle="modal" data-target="#batch_turn_crm"  data-remote='{{ url_param("/crm/turn_crm?id=".A($item,"id"))}}' class='btn btn-info btn-sm blue'><i class='icon-edit'></i>修改</a>
                                    <a data-toggle="modal" data-target="#batch_turn_crm"  data-remote='{{ url_param("/crm/turn_crm?id=".A($item,"id"))}}' class='btn btn-info btn-sm blue'><i class='icon-edit'>转单</a>
                                    <a data-toggle="modal" data-target="#batch_turn_crm"  data-remote='{{ url_param("/crm/turn_crm?id=".A($item,"id"))}}' class='btn btn-info btn-sm blue'><i class='icon-edit'>处理</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @include('include.page')
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-850" id="create_crm" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                </div>
        </div>
</div>

<div class="modal fade modal-850" id="batch_turn_crm" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                </div>
        </div>
</div>

<div class="modal fade modal-850" id="batch_end_crm" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                </div>
        </div>
</div>
@stop
