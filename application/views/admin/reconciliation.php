<?php
$this->load->view('admin/header');
?>
<body>
<!--_header 作为公共模版分离出去-->
<?php
$this->load->view('admin/navbar');
?>
<!--/_header 作为公共模版分离出去-->

<!--_menu 作为公共模版分离出去-->
<?php
$this->load->view('admin/side_menu');
?>
<!--/_menu 作为公共模版分离出去-->

<section class="Hui-article-box">
    <!--<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        表
        <span class="c-gray en">&gt;</span>
        表original
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    -->
    <div class="Hui-article">
        <article class="cl pd-20">

            <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l pd-5">

                    <input type="number" id="debitid" placeholder="Loan Reference No." style="width:250px" class="input-text">
                    <input type="number" id="userid" placeholder="User ID" style="width:250px" class="input-text">
<!--                    <input type="number" id="type" placeholder="type" style="width:250px" class="input-text">-->

                </span>

                <div class="l pd-5">
                    <input type="text" placeholder="AuditTime" id="start_time" style="width: 200px;" onfocus="WdatePicker()"
                           class="input-text Wdate"/>
                    -
                    <input type="text" placeholder="AuditTime" id="end_time" style="width: 200px;" onfocus="WdatePicker()"
                           class="input-text Wdate"/>
                </div>
                <div class="l pd-5">
                    <input type="text" placeholder="Release time" id="releaseLoanTimeStart" style="width: 200px;" onfocus="WdatePicker()"
                           class="input-text Wdate"/>
                    -
                    <input type="text" placeholder="Release time" id="releaseLoanTimeEnd" style="width: 200px;" onfocus="WdatePicker()"
                           class="input-text Wdate"/>
                </div>

                <span class="l pd-5">
                    <span class="select-box inline">
                        <select id="type" name="type" class="select">
                            <option value="">type</option>
                            <option value="1">Payback</option>
                            <option value="2">Extend</option>
                            <option value="3">Duitku Extend</option>
                            <option value="4">Duitku Payback</option>
                        </select>
                    </span>

                    <button id="search" class="btn btn-success"><i class="Hui-iconfont"></i>Query</button>
                    <button id="reset" onclick="reset();" class="btn btn-error">Reset</button>
                </span>
            </div>

            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-hover table-sort">
                    <thead>
                    <tr class="text-c">
                        <!--<th>UserID</th>
                        <th>提交时间</th>
                        <th>审核时间</th>
                        <th>操作者</th>
                        <th>凭证</th>
                        <th>借款ID</th>
                        <th>类型</th>
                        <th>到帐金额</th>
                        <th>放款时间</th>
                        <th>应还款时间</th>
                        <th>Options</th>-->
                        <th>UserID</th>
                        <th>Upload time</th>
                        <th>Audit time</th>
                        <th>Auditor</th>
                        <th>Receipt</th>
                        <th>Load ID</th>
                        <th>Type</th>
                        <th>Paid Amount</th>
                        <th>Release time</th>
                        <th>Payback time</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </article>
    </div>
</section>

<!--_footer 作为公共模版分离出去-->
<?php
$this->load->view('admin/footer');
?>
<!--/_footer /作为公共模版分离出去-->


<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="<?= base_url() ?>static/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>static/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>static/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    var deleteUrl = "<?=site_url('Admin/bookDel')?>";
    /*var statusEnum = {
        "-2" : "还款申请不通通（重新还款）",
        "-1":"贷款申请不通过（重新申请）",
        "0":"申请贷款（待审核）",
        "1":"审核通过（已放款）",
        "2":"还款申请（申请还款）",
        "3" : "还款审核通过（已还款）",
        "4" : "已逾期（去还款）",
        "5" : "资料审核通过（未放款）"
    }*/
    var statusEnum = {
        "-2" : "Repayment has not been approved",
        "-1":"Loan application has not been approved",
        "0":"Apply for loan",
        "1":"Approved",
        "2":"Repayment has been applied",
        "3" : "Repayment has been approved",
        "4" : "overdue",
        "5" : "approved"
    }
    var colorEnum = {
        "-2" : "red",
        "-1":"red",
        "0":"#ffd126",
        "1":"green",
        "2":"#ffd126",
        "3" : "green",
        "4" : "red",
        "5" : "green"
    }
    var table = $('.table-sort').dataTable({
        "aaSorting": [[1, "desc"]],//默认第几个排序
        bSort: false,//是否允许排序
        bLengthChange: false,//是否显示每页大小的下拉框
        searching: false,//是否显示搜索框
        "bStateSave": false,//状态保存
        serverSide: true,
        fnServerParams: function (aoData) {
            aoData._rand = Math.random();
            aoData.userid = $('#userid').val();
            aoData.debitid = $('#debitid').val();
            aoData.type = $('#type').val();
            aoData.startTime = $('#start_time').val();
            aoData.endTime = $('#end_time').val();
            aoData.releaseLoanTimeStart = $('#releaseLoanTimeStart').val();
            aoData.releaseLoanTimeEnd = $('#releaseLoanTimeEnd').val();
        },
        "createdRow": function (row, data, dataIndex) {
            $(row).children('td').attr('style', 'text-align: center;')
        },
        "aoColumnDefs": [],
        ajax: "<?=site_url('export/reconciliation')?>",
        columns: [
            {data: "UserId"},
            {data: "paybackCreateTime"},
            {data: "paybackStatusTime"},
            {data: "realname"},
            {data: "certificateUrl",render: function (val) {
                    return '<a target="_blank" href="'+val+'">Click to view</a>';
                }},
            {data: "DebitId"},
            {data: "type", render:function (val) {
                    if(val == 1){
                        return 'Payback';
                    }
                    if(val == 2){
                        return 'Extend';
                    }
                    if(val == 3){
                        return 'Duitku Extend';
                    }
                    if(val == 4){
                        return 'Duitku Payback';
                    }
                    return '';
                }},
            {data: 'money'},
            {data: 'releaseLoanTime'},
            {data: 'payBackDayTime'},
            {data: ''}
        ],
        "aoColumnDefs": [
            {
                "targets": -1,
                "data": 'id',
                "mRender": function (data, type, full) {
                    return '<a style="text-decoration:none" class="ml-5" onclick="check(' + full.DebitId + ')" href="javascript:;" title="审核"><i class="Hui-iconfont">&#xe6df;View</i></a>';
                }
            }
        ],
        "sPaginationType": "full_numbers",
        iDisplayLength: 10,
        "oLanguage": {
            "sProcessing": "正在加载中......",
            "sLengthMenu": "每页显示 _MENU_ 条记录",
            "sZeroRecords": "对不起，查询不到相关数据！",
            "sInfoEmpty":"No data",
            "sEmptyTable": "No data in the report",
            "sInfo": "current display lasts for _START_-_END_ records,in total there will be _MAX_ records",
            "sInfoFiltered": "数据表中共为 _MAX_ 条记录",
            "sSearch": "搜索",
            "oPaginate": {
                "sFirst": "First",
                "sPrevious": "Pre",
                "sNext": "Next",
                "sLast": "Last"
            }
        }
    });

    $(function () {
        $('#search').bind("click", function () { //按钮 触发table重新请求服务器
            table.fnDraw();
        });
    })

    function check(id) {
        layer_show('Audit', "<?=site_url('admin/overdueCheck/')?>" + id, null, null);
    }



    function bookUpdate(id) {
        layer_show('新书上架', "<?=site_url('admin/bookUpdate')?>/" + id, null, null);
    }

    function layer_show(title, url, w, h) {
        if (title == null || title == '') {
            title = false;
        }
        ;
        if (url == null || url == '') {
            url = "404.html";
        }
        ;
        if (w == null || w == '') {
            w = 1100;
        }
        ;
        if (h == null || h == '') {
            h = ($(window).height() - 100);
        }
        ;
        layer.open({
            type: 2,
            area: [w + 'px', h + 'px'],
            fix: false, //不固定
            maxmin: true,
            shade: 0.4,
            title: title,
            content: url
        });
    }

    function reset() {
        $(':input').val('');
    }
</script>
<!--/请在上方写此页面业务相关的脚本-->

</body>
</html>