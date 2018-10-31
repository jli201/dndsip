function addRow() {
    var table = document.getElementById("weaponTable");
    var row = table.insertRow(table.rows.length);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var box1 = document.createElement("INPUT");
    	box1.setAttribute("type", "text");
    var box2 = document.createElement("INPUT");
    	box2.setAttribute("type", "text");
    var box3 = document.createElement("INPUT");
    	box3.setAttribute("type", "text");
    cell1.appendChild(box1);
    cell2.appendChild(box2);
    cell3.appendChild(box3);
}
function deleteRow() {
	var table = document.getElementById("myTable");
    if(table.rows.length > 2){
    	table.deleteRow(table.rows.length - 1);
    }
}
