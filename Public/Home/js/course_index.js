
//changing background-color of nav
var nav= $('#getNav').val();
$(".control_nav li").removeClass('active');
switch(nav){
  case 'course': $(".control_nav li").eq(1).addClass("active");break;
  case 'student_num': $(".control_nav li").eq(2).addClass("active");break;
  default: $(".control_nav li").eq(0).addClass("active");break;
}

//changing color: newnavbox >active1 regisnation
//var order="{$getOrder}"; 只能用于内部式JS中
var order= $('#getOrder').val()
$(".set_newnavbox li").removeClass('active1');
switch(order){
  case 'create_time': $(".set_newnavbox li").eq(1).addClass("active1");break;
  case 'student_num': $(".set_newnavbox li").eq(2).addClass("active1");break;
  default: $(".set_newnavbox li").eq(0).addClass("active1");break;
}