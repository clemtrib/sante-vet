$(function () {
    var table = $("#products")[0];
    
    var dir = []; // Utilisé pour savoir dans quel sens on doit réordonner la colonne
    $( "thead tr td" ).each(function() {
        dir.push("1");
    });
    
    $("thead tr td").on("click", function (event) {
        var column = $(this).attr('class');
        if (column.substring(0, 7) !== "orderBy") {
            // La colonne ne peut pas être réordonnée
            return false;
        }
        var type =  $(this).attr("data-type");
        var columnId = column.substring(7, column.length);
        // On réordonne le tableau
        sortTable(
            table, 
            columnId, 
            dir[columnId] = 1 - dir[columnId], 
            type
        );
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
