@include('common.header')


<link rel="stylesheet" href="/aliyunoss/webuploader.css">
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
                <div class="col-md-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">基本信息</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-remove"></i></button>
                            </div>
                        </div>
                    <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ID</label>
                                        <label class="form-control" disabled>{{$user->id}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <label class="form-control" disabled>{{$user->username}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>手机号</label>
                                        <label class="form-control" disabled>{{ $user->mobile }}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>APPID</label>
                                        <label class="form-control" disabled>{{$user->appid}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>APPSECRET</label>
                                        <label class="form-control" disabled>{{$user->appsecret}}</label>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>AT总量</label>
                                        <label class="form-control" disabled>{{ $user->at+$user->frozen_at }}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>AT可用</label>
                                        <label class="form-control" disabled>{{ $user->at }}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>AT冻结</label>
                                        <label class="form-control" disabled>{{ $user->frozen_at }}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>创建时间</label>
                                        @if($user->created_at)
                                            <label class="form-control" disabled>{{ $user->created_at }}</label>
                                        @else
                                            <label class="form-control" disabled></label>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>更新时间</label>
                                        @if($user->updated_at)
                                            <label class="form-control" disabled>{{ $user->updated_at }}</label>
                                        @else
                                            <label class="form-control" disabled></label>
                                        @endif
                                    </div>

                                </div>

                                <div class="form-group">
                                    <form class="form-horizontal" id="logo" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label">上传LOGO</label>
                                            <div class="col-sm-4">
                                                <input type="file" class="form-control" name="photo" id="photo">

                                                <div class="img-wrap">
                                                    <img src="{{ $user->logo }}" name="imglogo" id="imglogo" alt="" style="width: 100px;height: 100px;">
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                    </form>
                                </div>


                            </div>
                            <!-- /.row -->


                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <form class="data-form" action="" method="post">
                        {{ csrf_field() }}
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">账户信息</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-remove"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="input-group">
                                <label for="txt_departmentname">AT总额</label>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <input type="text" class="form-control timepicker" name="at" value="{{ $user->at+$user->frozen_at }}" disabled>
                                    </div>
                                    <div class="col-xs-3">
                                        <select name="at_type" class="form-control">
                                            <option value="+">+</option>
                                            <option value="-">-</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-5">
                                        <input name="at_num" type="text" class="form-control" placeholder="请填写数字">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>平台登录URL</label>
                                <div class="form-group">
                                    <input id="login_url" type="text" class="form-control" name="login_url"  value="{{ $user->login_url }}" required>
                                </div>
                            </div>

                            <br>
                            <div class="form-group">
                                <label>平台商品兑换URL</label>
                                <div class="form-group">
                                    <input id="exchange_url" type="text" class="form-control" name="exchange_url"  value="{{ $user->exchange_url }}" required>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>是否锁定</label>
                                <select class="form-control" name="islock">
                                    <option @if($user->islock) selected @endif value="1">是</option>
                                    <option @if(!$user->islock) selected @endif value="0">否</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="box-tools pull-right">
                                <a href="javascript:history.go(-1)" class="btn btn-default">返回</a>
                                <a id="btn_submit" class="btn btn-primary">提交</a>
                                <input type="hidden" name="id" value="{{ $user->id }}">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>


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


<script>

    $("#photo").change(function(){

        var formData = new FormData($("#logo")[0]);
        $.ajax({

            type: 'POST',
            url: '/uploadlogo' ,
            data: formData ,
            async:false,
            cache: false,
            contentType: false,
            processData:false,

            success:function(data){
                if(data.code == 0)
                {
                    $('#editMoney').modal('show');
                    $('#editMoney').on('hide.bs.modal', function () {
                        $('#imglogo').attr('src',data.msg);
                    })
                }
                else
                {
                    $('#editMoney .modal-body').html(data.msg);
                    $('#editMoney').modal('show');
                }
            },
            error:function(err){
                console.log(err);
            }
        });
    })


    $(function () {

        $('#btn_submit').click(function () {
            $.ajax({
                url:'platformEdit',
                type:'POST', //GET
                data:$('.data-form').serialize(),//form
                dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
                success:function(data){
                    if(data.code == 0)
                    {
                        $('#editMoney').modal('show');
                        $('#editMoney').on('hide.bs.modal', function () {
                            window.location.reload();
                        })
                    }
                    else
                    {
                        $('#editMoney .modal-body').html(data.msg);
                        $('#editMoney').modal('show');
                    }
                }
            });
        })



    })
</script>