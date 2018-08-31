


// setTimeout(layer.closeAll(),5000);

$("#scan").bind('click',function () {
    wx.scanQRCode({
        needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
        scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
        success: function (res) {
            $("#code").val(res.resultStr);
            $("#scan").text("1.已获得机器码");
            $("#scan").addClass('weui-btn_disabled');
            $("#scan").removeClass('weui-btn_primary');
            $("#scan").addClass('weui-btn_default');
            $("#sacn").attr("disabled");
            var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
            //触发协议
            setTimeout($.alert("同意协议后，即可领取","温馨提示",function () {
                $("#agree").trigger("click");
            }),3000);
            $("#scan").unbind("click");
        }
    });
});

function ad() {
    var id =  layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
        shadeClose: true,
        skin: 'yourclass',
        content: '这是一个广告',
        time:5000 ,
    });
    //手动关闭
    // setTimeout(layer.close(id),5000);
}

/**判断是否同意协议
 *
 */

$(function () {
    $("#switchCP").bind("click", function () {

        if($("#btn").val()=="off"){

            $("#btn").val("on");
            $("#subinfo").text('2.点击领取纸巾哦');

            $("#submit").removeClass('weui-btn_disabled');
            $("#submit").removeClass('weui-btn_warn');
            $("#submit").addClass('weui-btn_primary');

        }else{

            $("#btn").val("off");
            $("#subinfo").text('2.请您先同意协议');
            $("#submit").addClass('weui-btn_disabled');
            $("#submit").addClass('weui-btn_warn');
        }
    });
    /**
     * 提交检查
     */
    $("#submit").bind("click",function () {
        if ($("#submit").hasClass('weui-btn_disabled')) {
            if ($("#btn").val()=="off"){
                $.alert('您未同意协议，无法领取纸巾');
            }
        }else {
            if($("#btn").val()=="on" && $("#code").val()){
                $("#submit").addClass('weui-btn_disabled');
                let code = $("#code").val();
                $.showLoading("请稍等");
                $.get('getpaper',{echostr:code},function (message) {

                    $.hideLoading();

                    setTimeout(function() {
                        if (message.code != 0) {

                            $.toast("出纸成功", function() {
                                console.log(message);
                                console.log('请求成功');
                                $("#get").hide();
                                $("#finish_getpaper").show();

                            });
                        }else {
                            console.log(message);
                            $.alert(message.msg, "forbidden");

                            $("#submit").removeClass('weui-btn_disabled');

                        }
                    }, 1)
                });
            }else {
                $.alert("请点击按钮扫描二维码", "温馨提示", function() {
                    //点击确认后的回调函数

                });
            }
        }
    });

    $("#get_show").bind("click",function () {
        $.alert("开发中，请稍等");
    });
});