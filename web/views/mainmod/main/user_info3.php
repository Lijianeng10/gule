
<div style="width:100%;height:90%;">
    <ul>
        <li><span id="total" style="font-weight:500;font-size: 18px"></span></li>
        <li><br></li>
    </ul>
    <div class="dgdiv">
        <table id="datagrid"></table>
    </div>
</div>
<script>
    $(function() {
        $('#datagrid').datagrid({
            url: '/centermod/center/get-center-list',
            fit: true,
            pagination: true,
            singleSelect:true,
            fitColumns: true,
            rownumbers: true,
            loadMsg: '数据加载中...',
            toolbar: '#tb',
            columns: [
                [ {
                    field: 'center_name',
                    title: '中心名称',
                    width: 50,
                    sortable: true
                }, {
                    field: 'center_type',
                    title: '所属省/市',
                    width: 50,
                    align: 'center',
                    sortable: true,
                    formatter: typeFormatter
                },{
                    field: 'status',
                    title: '状态',
                    width: 50,
                    align: 'center',
                    formatter: statusFormatter
                }]
            ],
            onLoadSuccess:function(data){
                $("#total").html("总入驻中心："+data.total+"(家)")
            }
        });
        function typeFormatter(value, row) {
            if(value==1){
                return "市级";
            }else if(value==2){
                return "省级";
            }
        }
        function statusFormatter(value,row){
            var str= "";
            if(row.status ==0){
                str ="禁用"
            }else if(row.status == 1){
                str ="启用"
            }
            return str;
        }
    });
</script>
