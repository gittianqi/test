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

                <a href="platformAdd" class="btn btn-default"><i class="fa fa-plus"></i>添加合作平台</a>
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
                                    <th>用户名</th>
                                    <th>手机号码</th>
                                    <th>APPID</th>
                                    <th>APPSECRET</th>
                                    <th>AT总额</th>
                                    <th>注册时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->username}}</td>
                                    <td>{{$v->mobile}}</td>
                                    <td>{{$v->appid}}</td>
                                    <td>{{$v->appsecret}}</td>
                                    <td>{{$v->at+$v->frozen_at}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>
                                        <a class="btn btn-danger user-del" data-id="{{$v->id}}"><i class="fa fa-remove"></i></a>
                                        <a href="platformEdit?id={{$v->id}}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        @if($v  &&  !$v->islock)
                                            {{--<a class="btn btn-danger user-islock" data-id="{{$v->id}}" onclick="islockclick(this, {{$v->id}})"><i id="rowlock"  class="fa fa-unlock-alt"></i></a>--}}
                                            <a class="btn btn-danger user-islock" data-id="{{$v->id}}" ><i id="rowlock"  class="fa fa-unlock-alt"></i></a>
                                        @else
                                            {{--<a class="btn btn-success user-islock" data-id="{{$v->id}}" onclick="islockclick(this, {{$v->id}})"><i id="rowlock"  class="fa fa-unlock"></i></a>--}}
                                            <a class="btn btn-success user-islock" data-id="{{$v->id}}" ><i id="rowlock"  class="fa fa-unlock"></i></a>
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

{{--<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModelLabel">--}}
    {{--<div class="modal-dialog" role="document">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                {{--<h4 class="modal-title" id="myModalLabel">消息</h4>--}}
            {{--</div>--}}
            {{--<div class="modal-body">确认删除该平台会员数据吗？</div>--}}
            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>--}}
                {{--<button type="button" class="btn btn-primary" id='confirmOk' >确认删除</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

@include('common.footer')
<!-- DataTables -->
<script src="/static/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/static/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    var btn = true;
    $(function () {

        $('.user-islock').click(function () {
        //function islockclick() {
            if (!btn) {
                $('#editMoney .modal-body').html('您操作过快，请稍后再试');
                $('#editMoney').modal('show');
                return;
            }

            btn = false;
            var id = $(this).data('id');
            if ($(this).find('i').hasClass('fa-unlock')) {
                var islock = 0;
            } else {
                var islock = 1;
            }
            $.ajax({
                url: 'platformEdit',
                type: 'POST', //GET
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id, islock: islock},//form
                dataType: 'json',    //返回的数据格式：json/xml/html/script/jsonp/text
                success: function (data) {
                    if (data.code == 0) {
                        if ($('.user-islock[data-id=' + id + '] i').hasClass('fa-unlock')) {
                            $('.user-islock[data-id=' + id + ']').html('<i class="fa fa-unlock-alt"></i>');
                            $('.user-islock[data-id=' + id + ']').removeClass('btn-success');
                            $('.user-islock[data-id=' + id + ']').addClass('btn-danger');
                        } else {
                            $('.user-islock[data-id=' + id + ']').html('<i class="fa fa-unlock"></i>');
                            $('.user-islock[data-id=' + id + ']').removeClass('btn-danger');
                            $('.user-islock[data-id=' + id + ']').addClass('btn-success');
                        }
                    }
                    $('#editMoney .modal-body').html(data.msg);
                    $('#editMoney').modal('show');
                    btn = true;
                }
            });
        });


        //平台会员删除过程
        $('.user-del').click(function(){

            if(!btn){
                $('#editMoney .modal-body').html('您操作过快，请稍后再试');
                $('#editMoney').modal('show');
                return;
            }

            btn = false;
            var id = $(this).data('id');

            if(confirm("确认删除该用户吗?")){
                $.ajax({
                    url:'platformDel',
                    type:'POST', //GET
                    headers: {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                    },
                    data:{id:id},//form
                    dataType:'json',
                    success:function(data){
                        if(data.code == 0)
                        {
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }

                        $('#editMoney .modal-body').html(data.msg);
                        $('#editMoney').modal('show');
                        btn = true;

                    }
                });

            }else {

                btn= true;

            }

        })

    })


</script>
