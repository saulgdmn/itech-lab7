
var ajax = new XMLHttpRequest();

function XML2Array(xml) {
    try {
        var obj = {};
        if (xml.children.length > 0) {
          for (var i = 0; i < xml.children.length; i++) {
            var item = xml.children.item(i);
            var nodeName = item.nodeName;
    
            if (typeof (obj[nodeName]) == "undefined") {
              obj[nodeName] = XML2Array(item);
            } else {
              if (typeof (obj[nodeName].push) == "undefined") {
                var old = obj[nodeName];
    
                obj[nodeName] = [];
                obj[nodeName].push(old);
              }
              obj[nodeName].push(XML2Array(item));
            }
          }
        } else {
          obj = xml.textContent;
        }
        return obj;
      } catch (e) {
          console.log(e.message);
      }
}

function createTable(myArray) {
    var result = "<table border=1>";
    for(var i=0; i<myArray.length; i++) {
        result += "<tr>";
        for(var j=0; j<myArray[i].length; j++){
            result += "<td>"+myArray[i][j]+"</td>";
        }
        result += "</tr>";
    }
    result += "</table>";

    return result;
}


function buildHtmlTable(arr) {
  var table = document.createElement('table'),
    columns = addAllColumnHeaders(arr, table);
  for (var i = 0, maxi = arr.length; i < maxi; ++i) {
    var tr = document.createElement('tr');
    for (var j = 0, maxj = columns.length; j < maxj; ++j) {
      var td = document.createElement('td').cloneNode(false);
      var cellValue = arr[i][columns[j]];
      td.appendChild(document.createTextNode(arr[i][columns[j]] || ''));
      tr.appendChild(td);
    }
    table.appendChild(tr);
  }
  return table;
}

function addAllColumnHeaders(arr, table) {
  var columnSet = [],
    tr = document.createElement('tr');
  for (var i = 0, l = arr.length; i < l; i++) {
    for (var key in arr[i]) {
      if (arr[i].hasOwnProperty(key) && columnSet.indexOf(key) === -1) {
        columnSet.push(key);
        var th = document.createElement('th').cloneNode(false);
        th.appendChild(document.createTextNode(key));
        tr.appendChild(th);
      }
    }
  }
  table.appendChild(tr);
  return columnSet;
}


function func1() {
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                console.dir(ajax.responseText);
                document.getElementById("content").innerHTML = ajax.response;
            }
        }
    }
    
    ajax.open("get", "items.php?type=vendor");
    ajax.send();
}

 function func2() {
    ajax.open("get","items.php?type=out_of_stock");
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                let arr = XML2Array(ajax.responseXML)["data"];
                document.getElementById("content").appendChild(buildHtmlTable(Object.keys(arr).map((key) => arr[key])));
            }
        }
    }   
    ajax.send();
 }

function func3() {
    ajax.onreadystatechange = function(){
    if (ajax.readyState === 4) {
        if (ajax.status === 200) {
            console.dir(ajax);
            var data = JSON.parse(ajax.responseText);
            document.getElementById("content").appendChild(buildHtmlTable(data));
        }
    }
    };
    var price_low = document.getElementById("price_low").value;
    var price_high = document.getElementById("price_high").value;
    ajax.open("get", "items.php?type=price&price_low=" + price_low + "&price_high=" + price_high);
    ajax.send();
}