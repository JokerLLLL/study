    
    
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