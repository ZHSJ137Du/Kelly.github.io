/**
 * main.js
 * 
 * @authors EMPTY CHEN (23989902@qq.com)
 * @date    2016-03-29 12:59:54
 * @version $Id$
 */
 
$(function() {
  bootbox.setDefaults("locale","zh_CN"); 
	//$('#main').attr('css','height:100%')
	//$('#menu').attr('css','height:100%')
	$('#tabs').addtabs({monitor:'.menu'});
              
    
})

function logout(){
   bootbox.confirm('确定退出系统吗？',function (result) {
      if(result) { 
        location.href = './index.php?c=login&a=logout';
      }
   });
}

function tabreload() {
  // body...
  location.reload();
}

function panelmodal(title,cont,url,callback) {
  // body...
    $('#myModaltitle').html(title); 
    if(url!="") { $("#myModal").modal({remote: url});}
    $("#myModal").modal("show");
}

function panelmodal_c() {
  // body...  
  $("#myModal").hide();
}
function link(url) {
  // body...
  if(url=='') return;
  else
    location.href= url;
}

//手机验证
function ismobile(mobile) {
  // body...
  if(!(/^1[3|4|5|7|8]\d{9}$/.test(mobile))){ 
      return false; 
   }else return true;
}

//邮箱
function isemail(email) {
  // body...
  var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
      if(!myreg.test(email)){ return false;}
        else return true;
}

/*ajaxpost post */
function ajaxpost(mydata,scallback){
  var acurl = $('#form').attr("action");
  if(!acurl) acurl = $('#acurl').val();
  if(!acurl) bootbox.alert('找不到数据提交地址！');
  $.ajax({
          type:"POST",//使用get方法访问后台
          dataType:"json",//返回json格式的数据
          url:acurl,
          data:mydata,
          beforeSend:function(XMLHttpRequest){
              //alert('远程调用开始...');             
              loading('show');
          },
          success:function(msg){
            if(msg.status=="0"){ 
              //成功
              if(msg.callback){
                eval(msg.callback+'("'+msg.pram+'")');
              }             
              if(scallback=='msg') {bootbox.alert(msg.info);}
              else {eval(scallback)}
            }
            else{ 
              if(msg.callback){
                eval(msg.callback+'("'+msg.pram+'")');
              }
              bootbox.alert(msg.info);             
              //alert(msg.info);             
            }
          },
          complete:function(XMLHttpRequest,textStatus){
              // alert('远程调用成功，状态文本值：'+textStatus);
             loading('hide');
          },
          error:function(XMLHttpRequest,textStatus,errorThrown){
             bootbox.alert('加载出错，可能网络有问题！');
             loading('hide');
          }
        });

}


function loading(t) {
  // body...
  var str='<div id="loading"><p class="pd20 clear"></p><p class="pd20 clear"></p><p class="pd20 clear"></p><p class="pd20 clear"></p><p class="center"><img src="images/loading.gif" style="width:15px; margin-right:10px;>loading...</p></div>'
  if(t=='show'){
    $('body').append(str);
    $('#loading').show();
  }else{
    $('#loading').hide();
  }
}

function clearform() {
  // body...
  $('#form')[0].reset();
}

 function checkNum(num) {
     //检查是否是非数字值
     //JS版
    //将传入数据转换为字符串,并清除字符串中非数字与.的字符
    //按数字格式补全字符串

  //num = obj.value;
    num += '';
    num = num.replace(/[^0-9|\.]/g, ''); //清除字符串中的非数字非.字符
    
    if(/^0+/) //清除字符串开头的0
        num = num.replace(/^0+/, '');
    if(!/\./.test(num)) //为整数字符串在末尾添加.00
        num += '.00';
    if(/^\./.test(num)) //字符以.开头时,在开头添加0
        num = '0' + num;
    num += '00';        //在字符串末尾补零
    num = num.match(/\d+\.\d{2}/)[0];
    return num;
 
 }