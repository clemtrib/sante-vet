$(function () {
    var table = $("#products")[0];
    
    var currPage = 1;
    
    var dir = []; // Utilisé pour savoir dans quel sens on doit réordonner la colonne
    $( "thead tr td" ).each(function() {
        dir.push("1");
    });
    
    function reorderEvent(obj) {
        var column = obj.attr('class');
        if (column.substring(0, 7) !== "orderBy") {
            // La colonne ne peut pas être réordonnée
            return false;
        }
        var type =  obj.attr("data-type");
        var columnId = column.substring(7, column.length);
        // On réordonne le tableau
        sortTable(
            table, 
            columnId, 
            dir[columnId] = 1 - dir[columnId], 
            type
        );
    }
    
    function paginationEvent(obj) {
        var nbResPage = obj.val(),
            i = 0,
            limitInf = nbResPage * (currPage - 1),
            limitSup = (nbResPage * currPage) - 1,
            pagerHtml = "";
        
        $( "tbody tr" ).each(function() {
            $(this).hide();
            if((i >= limitInf && i <= limitSup) || nbResPage === "T") {
                $(this).show();
            }
            i++;
        });

        if (nbResPage !== "T") {
            var nbPages = (i - 1) / nbResPage;
            for (var j = 1; j <= Math.ceil(nbPages); j++) {
                pagerHtml += "&nbsp;&nbsp;&nbsp;&nbsp;<a href='' id='pl_" + j + "' class='pagination_link'>" + j + "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            }
        }
        $(".pagination_pager").html(pagerHtml);
        
    }
    
    $("thead tr td, tfoot tr td").on("click", function () {
        currPage = 1;
        $(".pagination_select").val('T');
        paginationEvent($(".pagination_select"));
        reorderEvent($(this));
    });
    
    $(".pagination_select").on("change", function () {
        currPage = 1;
        paginationEvent($(this));
    });
    
    $("#container").delegate(".pagination_link", "click", function (e) {
        event.preventDefault();
        currPage = $(this).attr('id').substring(3, $(this).attr('id').length);
        paginationEvent($(".pagination_select"));
    });
    
});

/**
 * 
 * @param String type
 * @param String textContentA
 * @param String textContentB
 * @returns {Number}
 */
function evaluateExpressions(type, textContentA, textContentB) {
    var returnValue;
    switch (type) {
        case 'price' :
            textContentA = textContentA ? textContentA : "0";
            textContentA = parseInt(textContentA.replace(".", "").replace("€", "").replace(" ", "").replace(",", "."));
            textContentB = textContentB ? textContentB : "0";
            textContentB = parseInt(textContentB.replace(".", "").replace("€", "").replace(" ", "").replace(",", "."));
            returnValue = textContentA < textContentB ? -1 : 1;
            break;
        default :
            returnValue = textContentA.localeCompare(textContentB);
            break;
    }
    return returnValue;
}

/**
 * 
 * @param Object table
 * @param Int col
 * @param {type} reverse
 * @param {type} type
 * @returns {undefined}
 */
function sortTable(table, col, reverse, type) {
    var tb = table.tBodies[0],
            tr = Array.prototype.slice.call(tb.rows, 0),
            i,
            reverse = -((+reverse) || -1);
    tr = tr.sort(function (a, b) {
        var textContentA = a.cells[col].textContent.trim(),
                textContentB = b.cells[col].textContent.trim(),
                returnValue;
        returnValue = evaluateExpressions(type, textContentA, textContentB);
        return reverse * (returnValue);
    });
    for (i = 0; i < tr.length; ++i) {
        tb.appendChild(tr[i]);
    }
}
