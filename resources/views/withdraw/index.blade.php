@include('common.header')
<!-- DataTables -->
<link rel="stylesheet" href="/static/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$breadCrumb[2]}}
                <small>{{$breadCrumb[1]}}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i> {{$breadCrumb[0]}}</a></li>
                <li><a href="#">{{$breadCrumb[1]}}</a></li>
                <li class="active">{{$breadCrumb[2]}}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">

                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>平台名称</th>
                                    <th>兑换AT量</th>
                                    <th>兑换比率(%)</th>
                                    <th>现金</th>
                                    <th>提现方式</th>
                                    <th>银行名称</th>
                                    <th>账号</th>
                                    <th>姓名</th>
                                    <th>手机号</th>
                                    <th>状态</th>
                                    <th>操作人名称</th>
                                    <th>备注</th>
                                    <th>申请日期</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->platform_username}}</td>
                                    <td>{{$v->total_num}}</td>
                                    <td>{{$v->rate}}</td>
                                    <td>{{$v->money}}</td>
                                    <td>{{$v->method_name}}</td>
                                    <td>
                                        {{$v->bank_name}}
                                    </td>
                                    <td>
                                        {{$v->account_num}}
                                    </td>
                                    <td>{{$v->full_name}}</td>
                                    <td>{{$v->bank_mobile}}</td>
                                    <td>{{$v->status_name}}</td>
                                    <td>{{$v->operator_name}}</td>
                                    <td>{{$v->msg}}</td>
                                    <td>{{date('Y-m-d',strtotime($v->created_at))}}</td>
                                    <td>
                                        @if( $v->status === 0)
                                            <a href="javascript:void(0)" data-id="{{$v->id}}"  class="btn btn-default agreewithdraw"><i class="fa">审核通过</i></a>
                                            <a href="javascript:void(0)" data-id="{{$v->id}}"  class="btn btn-default refusewithdraw"><i class="fa">审核拒绝</i></a>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<div class="modal fade" id="editMoney" tabindex="-1" role="dialog" aria-labelledby="editMoneyLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">消息</h4>
            </div>
            <div class="modal-body">操作成功</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
@include('common.footer')
<!-- DataTables -->
<script src="/static/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/static/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(function () {
        var btn = true;
        $('.agreewithdraw').click(function () {
            if(!btn){
                $('#editMoney .modal-body').html('您操作过快，请稍后再试');
                $('#editMoney').modal('show');
                return;
            }

            btn = false;
            var id = $(this).data('id');

            if(confirm("确认审核通过吗?")){
                $.ajax({
                    url:'/agreewithdraw',
                    type:'post', //GET
                    headers: {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                    },
                    data:{id:id},
                    dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
                    success:function(data){
                        if(data.code == 0)
                        {
                            $('#editMoney .modal-body').html(data.msg);
                            $('#editMoney').modal('show');
                            window.location.reload();
                        }

                        btn = true;
                    }
                });
            }else {

                btn= true;

            }

        })

        $('.refusewithdraw').click(function () {
            if(!btn){
                $('#editMoney .modal-body').html('您操作过快，请稍后再试');
                $('#editMoney').modal('show');
                return;
            }

            btn = false;
            var id = $(this).data('id');

            if(confirm("确认审核拒绝吗?")){
                $.ajax({
                    url:'/refusewithdraw',
                    type:'post',
                    headers: {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                    },
                    data:{id:id},
                    dataType:'json',
                    success:function(data){
                        if(data.code == 0)
                        {
                            $('#editMoney .modal-body').html(data.msg);
                            $('#editMoney').modal('show');
                            window.location.reload();
                        }

                        btn = true;
                    }
                });
            }else {
                btn= true;
            }

        })


    })
</script>
