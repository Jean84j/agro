//Удаление картинки
function removeImageStock(id, land) {
    $.ajax({
        type: "get",
        url: "/admin/"+ land +"/product/remove-image",
        data: {id: id},
        success: function (data) {
            $("#images-table").load(window.location.href + ' #images-table > *');
        },
        error: function (data) {
            console.log('Error!', data);
        }
    })
}

//Удаление
function removeWordStock(id, land) {
    $.ajax({
        type: "get",
        url: "/admin/"+ land +"/product/remove-word",
        data: {id: id},
        success: function (data) {
            $("#words-table").load(window.location.href + ' #words-table > *');
        },
        error: function (data) {
            console.log('Error!', data);
        }
    })
}

//Удаление
function removeVariantStock(id, land) {
    $.ajax({
        type: "get",
        url: "/admin/"+ land +"/product/remove-variant",
        data: {id: id},
        success: function (data) {
            $("#variant-table").load(window.location.href + ' #variant-table > *');
        },
        error: function (data) {
            console.log('Error!', data);
        }
    })
}