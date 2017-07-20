$(document).ready(function() {
	$("#submit-1").on('click',function(form){
		form.preventDefault();
		var tmp=$("input[name='year']").val();
		$.ajax({ 
		    type: "POST", 	
			url: "./work.php",
			data: {
				type: 'AddMember',
				name: $("#tabs-1 input[name='name']").val(), 
				part: $("#tabs-1 input[name='part']").val(), 
				job: $("#tabs-1 input[name='job']").val(),
				year: $("#tabs-1 input[name='year']").val(),
				class: $("#tabs-1 input[name='class']").val(),
				qq: $("#tabs-1 input[name='qq']").val(),
				sex: $("#tabs-1 input[name='sex']:checked").val()
			},
			dataType: "json",
			success: function(data){
				if (data!='false'&&data!=false&&data.stat!=false) { 
					var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"success",
				        text:"成功"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:":"+data.name+'记录成功，获取到的uID为：'+data.uID
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
				} else {
					var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"fail",
				        text:"失败"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:":"+data.name+'记录失败，错误信息：'+data.error
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
				}  
			},
			error: function(jqXHR){
				console.log(jqXHR);
			   var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"error",
				        text:"错误"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:':记录发生错误，错误信息：'+jqXHR.responseText
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
			},     
		});
		$('input[type=text]').val('');
		$('#name').focus()
		$("input[type=text][name=year]").val(tmp);
	});
	//
	$("#submit-2").on('click',function(form){
		form.preventDefault();
		var tmp=$("input[name='year']").val();
		$.ajax({ 
		    type: "POST", 	
			url: "./work.php",
			data: {
				type: 'AddEvent',
				eventType: $("#tabs-2 select").val(), 
				A: $("#tabs-2 input[name='A']").val(), 
				B: $("#tabs-2 input[name='B']").val(),
				Alink: $("#tabs-2 input[name='Alink']").val(),
				Blink: $("#tabs-2 input[name='Blink']").val(),
				date: $("#tabs-2 input[name='date']").val()
			},
			dataType: "json",
			success: function(data){
				if (data!='false'&&data!=false&&data.stat!=false) { 
					var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"success",
				        text:"成功"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:':历史事件记录成功'
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
				} else {
					var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"fail",
				        text:"失败"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:':记录失败，错误信息：'+data.error
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
				}  
			},
			error: function(jqXHR){
				console.log(jqXHR);
			   var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"error",
				        text:"错误"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:':记录发生错误，错误信息：'+jqXHR.responseText
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
			},     
		});
		$('input[type=text]').val('');
		$('#name').focus()
		$("input[type=text][name=year]").val(tmp);
	});
	$("#submit-3").on('click',function(form){
		form.preventDefault();
		$.ajax({ 
		    type: "POST", 	
			url: "./work.php",
			data: {
				type: 'ChangeMember',
				uID: $("#tabs-3 input[name='uID']").val(), 
				name: $("#tabs-3 input[name='name']").val(), 
				part: $("#tabs-3 input[name='part']").val(), 
				job: $("#tabs-3 input[name='job']").val(),
				year: $("#tabs-3 input[name='year']").val(),
				class: $("#tabs-3 input[name='class']").val(),
				qq: $("#tabs-3 input[name='qq']").val(),
				sex: $("#tabs-3 input[name='sex']:checked").val()
			},
			dataType: "json",
			success: function(data){
				if (data!='false'&&data!=false&&data.stat!=false) { 
					var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"success",
				        text:"成功"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:":"+data.name+'修改成功'
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
				} else {
					var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"fail",
				        text:"失败"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:":"+data.name+'修改失败，错误信息：'+data.error
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
				}  
			},
			error: function(jqXHR){
				console.log(jqXHR);
			   var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"error",
				        text:"错误"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:':修改发生错误，错误信息：'+jqXHR.responseText
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
			},     
		});
		$('input[type=text]').val('');
		$('#name').focus()
	});
	$("#submit-4").on('click',function(form){
		form.preventDefault();
		$.ajax({ 
		    type: "POST", 	
			url: "./work.php",
			data: {
				type: 'giveTitle',
				uID: $("#giveTitle input[name='uID']").val(), 
				title: $("#giveTitle input[name='title']").val()
			},
			dataType: "json",
			success: function(data){
				if (data!='false'&&data!=false&&data.stat!=false) { 
					var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"success",
				        text:"成功"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:":"+data.name+'授衔成功'
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
				} else {
					var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"fail",
				        text:"失败"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:":"+data.name+'授衔失败，错误信息：'+data.error
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
				}  
			},
			error: function(jqXHR){
				console.log(jqXHR);
			   var msg=$('<div />',{
				        class:"message",
				    });
				    $('<span />',{
				        class:"error",
				        text:"错误"
				    }).appendTo(msg);
				    $('<span />',{
				        class:"message-body",
				        text:':授衔发生错误，错误信息：'+jqXHR.responseText
				    }).appendTo(msg);
				    $('#msg-content').prepend(msg);
				    msg.hide();
				    msg.slideDown();
			},     
		});
		$('input[type=text]').val('');
		$('#name').focus()
	});
});