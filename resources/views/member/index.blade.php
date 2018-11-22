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

                        <!-- find-->
                        <div class="box-body">
                            <div class="col-sm-8">
                                <div style="padding: 10px 100px 10px;">
                                    <form class="bs-example bs-example-form" role="form" action="/member" method="post">
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="col-lg-18">
                                                <div class="input-group">

                                                    <select class="form-control" name="findk" style="">
                                                        <option  value="username">用户名</option>
                                                        <option  value="mobile">手机号</option>
                                                    </select>
                                                    <span class="input-group-btn">

                                                    </span>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="findv" >
                                                        <span class="input-group-btn">
                                                        <button class="btn btn-default" type="submit" id="btn_submit">搜索</button>
                                                    </span>
                                                    </div>
                                                </div><!-- /input-group -->
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                    </form>
                                </div>
                            </div><!-- /.row -->
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>手机号</th>
                                    <th>所属平台</th>
                                    <th>所属平台标识</th>
                                    <th>AT</th>
                                    <th>金额</th>
                                    <th>创建时间</th>
                                    {{--<th>操作</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->username}}</td>
                                    <td>{{$v->mobile}}</td>
                                    <td>{{$v->platform}}</td>
                                    <td>{{$v->platform_mid}}</td>
                                    <td>{{$v->at}}</td>
                                    <td>{{$v->money}}</td>
                                    <td>
                                        @if($v->created_at)
                                        {{$v->created_at}}
                                        @endif
                                    </td>
                                    {{--<td>--}}
                                        {{--<a href="memberEdit?id={{$v->id}}" class="btn btn-default"><i class="fa fa-edit"></i></a>--}}
                                        {{--@if(!$v->islock)--}}
                                            {{--<a class="btn btn-danger user-islock" data-id="{{$v->id}}"><i class="fa fa-unlock-alt"></i></a>--}}
                                        {{--@else--}}
                                            {{--<a class="btn btn-success user-islock" data-id="{{$v->id}}"><i class="fa fa-unlock"></i></a>--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
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
{{--<script src="/static/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>--}}
<script src="/static/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(function () {
        var btn = true;
        $('.user-islock').click(function () {
            if(!btn){
                $('#editMoney .modal-body').html('您操作过快，请稍后再试');
                $('#editMoney').modal('show');
                return;
            }

            btn = false;
            var id = $(this).data('id');
            if($(this).find('i').hasClass('fa-unlock')){
                var islock = 0;
            }else{
                var islock = 1;
            }
            $.ajax({
                url:'memberEdit',
                type:'POST', //GET
                headers: {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },
                data:{id:id,islock:islock},//form
                dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
                success:function(data){
                    if(data.code == 0)
                    {
                        if($('.user-islock[data-id='+id+'] i').hasClass('fa-unlock')){
                            $('.user-islock[data-id='+id+']').html('<i class="fa fa-unlock-alt"></i>');
                            $('.user-islock[data-id='+id+']').removeClass('btn-success');
                            $('.user-islock[data-id='+id+']').addClass('btn-danger');
                        }else{
                            $('.user-islock[data-id='+id+']').html('<i class="fa fa-unlock"></i>');
                            $('.user-islock[data-id='+id+']').removeClass('btn-danger');
                            $('.user-islock[data-id='+id+']').addClass('btn-success');
                        }
                    }
                    $('#editMoney .modal-body').html(data.msg);
                    $('#editMoney').modal('show');
                    btn = true;
                }
            });
        })

    })
</script>
