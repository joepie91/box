function preview_markdown(element)
{
	$.post("/markdown.php", {data: element.val()}, function(response){
		$.fancybox.open([{
			content: response,
			title: "Preview"
		}], 
		{
			padding: 24,
			autoSize: false,
			width: 650,
			height: 550,
			openEffect: "elastic",
			closeEffect: "fade"
		});
	});
}

$(function(){
	$('.markdown-preview').click(function(event){
		var source_element = $(this).data("preview-source");
		preview_markdown($("#" + source_element));
	});
	
	$('a.thanks').click(function(event){
		var csrf_form = $("#csrf_form_" + $(this).data("id"));
		var csrf_key = csrf_form.children("input[name=_CPHP_CSRF_KEY]").val();
		var csrf_token = csrf_form.children("input[name=_CPHP_CSRF_TOKEN]").val();
		
		console.log(csrf_key, csrf_token);
		$.post("/forums/thank/" + $(this).data("id"), {
			"_CPHP_CSRF_KEY": csrf_key,
			"_CPHP_CSRF_TOKEN": csrf_token
		});
		
		$(this).html("Thanked!");
		$(this).removeAttr("href");
		$(this).css({color: "gray"});
		$(this).unbind("click");
		
		return false;
	});
	
	$('a.flag').click(function(event){
		$.fancybox.open([{
			href: "/forums/flag/" + $(this).data("id")
		}], 
		{
			padding: 4,
			autoSize: false,
			width: 550,
			height: 400,
			openEffect: "fade",
			closeEffect: "fade",
			type: "iframe"
		});
		
		return false;
	});
});
