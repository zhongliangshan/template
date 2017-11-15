@extends('include.common')
@section('content')
<div class="row-fluid">
<div class="span6 responsive" data-tablet="span12 fix-offset" data-desktop="span6">
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption"><i class="icon-user"></i>Table</div>
        <div class="actions">
            <a href="#" class="btn blue"><i class="icon-pencil"></i> Add</a>
            <div class="btn-group">
                <a class="btn green" href="#" data-toggle="dropdown">
                <i class="icon-cogs"></i> Tools
                <i class="icon-angle-down"></i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
                    <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                    <li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="i"></i> Make admin</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover" id="sample_2">
            <thead>
                <tr>
                    <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                    <th>Username</th>
                    <th class="hidden-480">Email</th>
                    <th class="hidden-480">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>shuxer</td>
                    <td class="hidden-480"><a href="mailto:shuxer@gmail.com">shuxer@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>looper</td>
                    <td class="hidden-480"><a href="mailto:looper90@gmail.com">looper90@gmail.com</a></td>
                    <td><span class="label label-warning">Suspended</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>userwow</td>
                    <td class="hidden-480"><a href="mailto:userwow@yahoo.com">userwow@yahoo.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>user1wow</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">userwow@gmail.com</a></td>
                    <td><span class="label label-inverse">Blocked</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>restest</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">test@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>foopl</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>weep</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>coop</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>pppol</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>test</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>userwow</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">userwow@gmail.com</a></td>
                    <td><span class="label label-inverse">Blocked</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>test</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">test@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
</div>
<div class="span6 responsive" data-tablet="span12 fix-offset" data-desktop="span6">
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box purple">
    <div class="portlet-title">
        <div class="caption"><i class="icon-cogs"></i>Table</div>
        <div class="actions">
            <a href="#" class="btn green"><i class="icon-plus"></i> Add</a>
            <a href="#" class="btn yellow"><i class="icon-print"></i> Print</a>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover" id="sample_3">
            <thead>
                <tr>
                    <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>
                    <th>Username</th>
                    <th class="hidden-480">Email</th>
                    <th class="hidden-480">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>shuxer</td>
                    <td class="hidden-480"><a href="mailto:shuxer@gmail.com">shuxer@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>looper</td>
                    <td class="hidden-480"><a href="mailto:looper90@gmail.com">looper90@gmail.com</a></td>
                    <td><span class="label label-warning">Suspended</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>userwow</td>
                    <td class="hidden-480"><a href="mailto:userwow@yahoo.com">userwow@yahoo.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>user1wow</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">userwow@gmail.com</a></td>
                    <td><span class="label label-inverse">Blocked</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>restest</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">test@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>foopl</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>weep</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>coop</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>pppol</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>test</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>userwow</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">userwow@gmail.com</a></td>
                    <td><span class="label label-inverse">Blocked</span></td>
                </tr>
                <tr class="odd gradeX">
                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                    <td>test</td>
                    <td class="hidden-480"><a href="mailto:userwow@gmail.com">test@gmail.com</a></td>
                    <td><span class="label label-success">Approved</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@stop
