    
    
            // 删除选择的
            $('#data-input').on('click','.deleteInput', function(){
                if(confirm("是否确认删除？")){
                    $(this.parentNode.parentNode).remove();
                    calMoney();
                }
            });
            
            父元素的选择，先用 parentNode 在 $() 包裹进行操作
         
         
            
              // 数组的遍历
              
             for(var i = 0, l = result.data.length; i < l; i ++){
                // 对象的遍历
                for(var key in resualt.data[i]) {
                   console.log(ressult.data[i][key];
                }
             }
             
             for(var key in jsonObj) {
                console.log(key + '=>' + jsonObj[key]);
             }
             for(var i = 0; i < jsonArr.lenght; i ++) {
                console.log(i + '=>' + jsonArr[i];
             }
             
             // 数组添加
             json.push({
                                 "p_id":p_id,
                                 "number":number,
                                 "marketPrice":marketPrice,
                                 "samplePrice":samplePrice
                             });
                             
                             
                             
        // parseFloat  字符串 转 数字
        
        
        
 ## ajax文件上传
 
             /**
              * 上传图片
              * @type {string}
              */
             $('#file').fileupload({
                 url: "{{ path('uploadPic') }}",  //文件上传地址，当然也可以直接写在input的data-url属性内
                 dataType: 'json',
                // 好像会造成多次提交？？？
                add: function (e, data) {
                    data.context = $('#file').click(function () {
                        var productCode = $("#productCode").val();
                        if (productCode == "") {
                            alert('产品编码未填写!');
                            return;
                        } else {
                            data.submit(); // ??? 原因
                        }
                    });
                },
                
                 done: function (e, data) {
                     var result = data._response.result; // json 对象
                     if(result.errCode != 0) {
                         alert(result.errMsg);
                     }else{
                         $('<img src="' + result.data.url + '" >').appendTo('#imageShow');
                     }
                 }
             });
 
             //文件上传前触发事件
             $('#file').bind('fileuploadsubmit', function (e, data) {
                 data.formData = { productCode: $("#productCode").val() };  //如果需要额外添加参数可以在这里添加
             });
             
             
### 搜索多选框
            $('.single_select').chosen({
                "allow_single_deselect": true,
                "no_results_text": "没有相关搜索项",
                "search_contains": true
            });
            
            $("#platformId").trigger("chosen:updated");
            
            
 ### 上传文件
    // 必须文档加载完成
   $(function(){
      $('#inputImport').change(function(){
         var formData = new FormData();
         formData.append("excel", $("#inputImport")[0].files[0]);
         formData.append("id", {{ VipPickOrder.id }});
         $("#inputImport").val('');
         $.ajax({
             url: "{{path('vip_import')}}",
             type: 'POST',
             data: formData,
             cache: false,
             processData : false,
             contentType : false,
             success: function(data) {}
          })
       }
   });
   // Html
   <label for="inputImport" class="btn btn-info">导入供货信息</label>
   <input style="display:none" type="file" name="inputImport" id="inputImport">
   
  