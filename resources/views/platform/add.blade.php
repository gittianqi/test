@include('common.header')
{{--<!-- daterange picker -->--}}
{{--<link rel="stylesheet" href="/static/bower_components/bootstrap-daterangepicker/daterangepicker.css">--}}
{{--<!-- bootstrap datepicker -->--}}
{{--<link rel="stylesheet" href="/static/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">--}}
{{--<!-- iCheck for checkboxes and radio inputs -->--}}
{{--<link rel="stylesheet" href="/static/plugins/iCheck/all.css">--}}
{{--<!-- Bootstrap Color Picker -->--}}
{{--<link rel="stylesheet" href="/static/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">--}}
{{--<!-- Bootstrap time Picker -->--}}
{{--<link rel="stylesheet" href="/static/plugins/timepicker/bootstrap-timepicker.min.css">--}}
{{--<!-- Select2 -->--}}
{{--<link rel="stylesheet" href="/static/bower_components/select2/dist/css/select2.min.css">--}}
{{--<!-- Theme style -->--}}
{{--<link rel="stylesheet" href="/static/dist/css/AdminLTE.min.css">--}}


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
                                <label for="txt_departmentname">用户名</label>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control" name="username"  maxlength="19"  value="" >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="input-group">
                                <label for="txt_departmentname">密码</label>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="password" class="form-control" name="password"  maxlength="32"  value="" >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="input-group">
                                <label for="txt_departmentname">手机号码</label>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control" name="mobile"  maxlength="19"  value="{{ $user->mobile }} " >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="input-group">
                                <label for="txt_departmentname">AT余额</label>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control timepicker" name="at" value="{{ $user->at }}" >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>平台登录URL</label>
                                <div class="form-group">
                                    <input id="login_url" type="text" class="form-control" name="login_url"  value="" required>
                                </div>
                            </div>

                            <br>
                            <div class="form-group">
                                <label>平台商品兑换URL</label>
                                <div class="form-group">
                                    <input id="exchange_url" type="text" class="form-control" name="exchange_url"  value="" required>
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
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="box-tools pull-right">
                                <a href="javascript:history.go(-1)" class="btn btn-default">返回</a>
                                <a id="btn_submit" class="btn btn-primary">提交</a>
                                {{--<input type="hidden" name="id" value="{{ $user->id }}">--}}
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
<!-- Select2 -->
{{--<script src="/static/bower_components/select2/dist/js/select2.full.min.js"></script>--}}
{{--<!-- InputMask -->--}}
{{--<script src="/static/plugins/input-mask/jquery.inputmask.js"></script>--}}
{{--<script src="/static/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>--}}
{{--<script src="/static/plugins/input-mask/jquery.inputmask.extensions.js"></script>--}}
{{--<!-- date-range-picker -->--}}
{{--<script src="/static/bower_components/moment/min/moment.min.js"></script>--}}
{{--<script src="/static/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>--}}
{{--<!-- bootstrap datepicker -->--}}
{{--<script src="/static/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>--}}
{{--<!-- bootstrap color picker -->--}}
{{--<script src="/static/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>--}}
{{--<!-- bootstrap time picker -->--}}
{{--<script src="/static/plugins/timepicker/bootstrap-timepicker.min.js"></script>--}}
{{--<!-- iCheck 1.0.1 -->--}}
{{--<script src="/static/plugins/iCheck/icheck.min.js"></script>--}}
<!-- Page script -->
<script>

    $(function () {
        $('#btn_submit').click(function () {
            $.ajax({
                url:'platformAdd',
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

        // //Initialize Select2 Elements
        // $('.select2').select2()
        //
        // //Datemask dd/mm/yyyy
        // $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        // //Datemask2 mm/dd/yyyy
        // $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        // //Money Euro
        // $('[data-mask]').inputmask()
        //
        // //Date range picker
        // $('#reservation').daterangepicker()
        // //Date range picker with time picker
        // $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
        // //Date range as a button
        // $('#daterange-btn').daterangepicker(
        //     {
        //         ranges   : {
        //             'Today'       : [moment(), moment()],
        //             'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //             'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        //             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        //             'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        //             'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        //         },
        //         startDate: moment().subtract(29, 'days'),
        //         endDate  : moment()
        //     },
        //     function (start, end) {
        //         $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        //     }
        // )
        //
        // //Date picker
        // $('#datepicker').datepicker({
        //     autoclose: true
        // })
        //
        // //iCheck for checkbox and radio inputs
        // $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        //     checkboxClass: 'icheckbox_minimal-blue',
        //     radioClass   : 'iradio_minimal-blue'
        // })
        // //Red color scheme for iCheck
        // $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        //     checkboxClass: 'icheckbox_minimal-red',
        //     radioClass   : 'iradio_minimal-red'
        // })
        // //Flat red color scheme for iCheck
        // $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        //     checkboxClass: 'icheckbox_flat-green',
        //     radioClass   : 'iradio_flat-green'
        // })
        //
        // //Colorpicker
        // $('.my-colorpicker1').colorpicker()
        // //color picker with addon
        // $('.my-colorpicker2').colorpicker()
        //
        // //Timepicker
        // $('.timepicker').timepicker({
        //     showInputs: false
        // })
    })
</script>