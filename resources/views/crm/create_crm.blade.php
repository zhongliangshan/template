<form  class="form-horizontal form-validator " role='form' method='post' action='/crm/create_crm'>
    <div class="modal-content">
     <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title" id="myModalLabel">
            新建工单
         </h4>
     </div>
     <div class="modal-body" style='line-height:35px;'>
          <div class="form-group">
              <label class="col-sm-2 control-label">工单标题</label>
              <div class="col-sm-9">
                  <input type='text' name='crm_title' class='form-control' placeholder="请填写工单标题"/>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">工单类型</label>
              <div class="col-sm-9">
                  <select  name='type' class="form-control select2">
                    <option value='-1'>请选择工单类型</option>
                    @foreach($types as $key => $val)
                      <option value="{{ $key }}"> {{ $val }}</option>
                    @endforeach
                  </select>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">报障人</label>
              <div class="col-sm-9">
                  <select name='report_name' class="form-control select2">
                    <option value=''>请选择报障人</option>
                    @foreach($users as $item)
                      <option value="{{ $item['rtxname'] }}"> {{ $item['name'] }}</option>
                    @endforeach
                  </select>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">报障时间</label>
              <div class="col-sm-9">
                  <input type='text' name='report_time' class='form-control datetime-picker' placeholder="请填写报障时间"/>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">当前处理人</label>
              <div class="col-sm-9">
                  <select name='now_deal_name' class="form-control select2">
                    <option value='-1'>请选择报障人</option>
                    @foreach($users as $item)
                      <option value="{{ $item['rtxname'] }}"> {{ $item['name'] }}</option>
                    @endforeach
                  </select>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">关注人</label>
              <div class="col-sm-9">
                  <select name='attention_name[]' class="form-control select2" multiple="">
                    @foreach($users as $item)
                      <option value="{{ $item['rtxname'] }}"> {{ $item['name'] }}</option>
                    @endforeach
                  </select>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">工单级别</label>
              <div class="col-sm-9">
                  <select name='level' class="form-control select2">
                    <option value='-1'>请选择工单级别</option>
                    @foreach($levels as $key => $val)
                      <option value="{{ $key }}"> {{ $val }}</option>
                    @endforeach
                  </select>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">模块</label>
              <div class="col-sm-9">
                  <select name='module[]' class="form-control select2" multiple="">
                    <option value=''>请选择模块</option>
                    @foreach($modules as  $val)
                      <option value="{{ $val['id'] }}"> {{ $val['name'] }}</option>
                    @endforeach
                  </select>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">工单内容</label>
              <div class="col-sm-9">
                  <textarea name="content" class='form-control' id='ckeditor' cols="20" rows="20"></textarea>
              </div>
          </div>
     </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消
        </button>
        <button type="button" class="btn btn-primary">
            提交
        </button>
     </div>
    </div>
</form>
