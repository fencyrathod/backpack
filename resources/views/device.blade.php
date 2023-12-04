
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

    <div class="row d-flex">
        <div class="col">
            <label>Device Type</label>
            <select id="device_type" class="form-control" name="Device_Type">

            </select>

    </div>
    <div class="col">
        <label>Device Brand</label>
    <select id="device_brand"  class="form-control" name="Device_Brand">
        
    </select>
</div>
</div>
<script>
    $.ajax({
        url:"/device_brand",
        type:"get",
        success:function(data)
        {
           var print=JSON.parse(data);
            var tblprint="";
            tblprint+=`<option selected disabled>--Select Device Type--</option>`;
           $.each(print,function(key,value){
                tblprint+=`<option value='${value["id"]}'>${value["name"]}</option>`;
           });

           $("#device_type").html(tblprint);
        }
    });


    

    console.log($("#device_type").val());

    $('#device_type').change(function(){
        var id = $(this).val();

        $.ajax({
            url:"/fetch_device_type",
            type:"get",
            data:{"id":id},
            success:function(data)
            {
                var print=JSON.parse(data);
                var tblprint="";
                $.each(print,function(key,value){
                        tblprint+=`<option value='${value["id"]}'>${value["name"]}</option>`;
                });

                $("#device_brand").html(tblprint);
            }

        });

    });

</script>
