

@if(isset($page))
<div class="row-fluid">
    <div class="span6">
        <div class="dataTables_info" id="sample_1_info">
                总共 <font color='blue'>{{ $page->total() }}</font> 条数据
        </div>
    </div>
    <div class="span6">
        <div class="dataTables_paginate paging_bootstrap pagination">
            {!! $page->appends(\Input::get())->links() !!}
        </div>
    </div>
</div>
@endif
