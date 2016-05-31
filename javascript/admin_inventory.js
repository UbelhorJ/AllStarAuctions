$(document).ready(function() {
    function getURL(pageNo) {
        // set base URL
        var domain = document.domain
        var url = "https://" + domain + window.location.pathname + "?";
        
        // get status selection
        if ($("#display").is(":checked")) url += "&display=on";
        if ($("#hidden").is(":checked")) url += "&hidden=on";
        if ($("#sold").is(":checked")) url += "&sold=on";
        
        // get OIRDER BY options
        var order_by = $("#items_filter input[type='radio']:checked").val();
        var direction = $("#direction option:selected").val();
        url += "&order_by=" + order_by + "&direction=" + direction;
        
        // add page number
        url += "&pageNo=" + pageNo;
        return url;
    }
    
    $("#firstPage").click(function(){
        var pageNo = 1;
        var url = getURL(pageNo);
        
        window.location.href = url;
    });
    
    $("#previousPage").click(function(){
        var pageNo = parseInt($("#pageNo").val()) - 1;
        
        if (pageNo === 0) {
            pageNo = 1;
        }
        
        var url = getURL(pageNo);
        
        window.location.href = url;
    });
    
    $("#pageList").change(function(){
        var currentPage = parseInt($("#pageNo"));
        var pageNo = parseInt($("#pageList option:selected").val());
        var url = getURL(pageNo);
        
        window.location.href = url;
    });
    
    $("#nextPage").click(function(){
        var pageNo = parseInt($("#pageNo").val()) + 1;
        var url = getURL(pageNo);
        
        window.location.href = url;
    });
        
    $("#lastPage").click(function(){
        var pageNo = parseInt($("#totalPages").val());
        var url = getURL(pageNo);
        
        window.location.href = url;
    });
    
    $(".select_status").change(function(){
        var itemNo = $(this).next().val();
        var formID = "#" + itemNo + "_status_form";
        var formSaveSpan = "#" + itemNo + "_save_message"; 
        var formData = $(formID).serializeArray();
        var URL = $(formID).attr("action");
        
        $.ajax({
            url: URL,
            type: "POST",
            data: formData,
            success: function(success){
                $(formSaveSpan).text(success);
            }
        });
    });
});    