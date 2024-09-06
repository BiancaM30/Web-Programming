// store row data arrays for easy sorting
var rowData = $('tr').map(function(rIdx, row) {
  return [$(row).children('td').map(function(cIdx, cell) {
    // store col # on each cell to use later for matching column sort order
    $(cell).data('col', cIdx + 1);
    // these objects used to keep original column numbers with sorted text
    return {
      col: cIdx + 1,
      text: cell.textContent
    }
  }).get()];
}).get();

var $th=$('#myTable th'),
  $rows = $('#myTable tr');


$th.click(function() {
   var $cell = $(this),
   rIdx = $cell.parent().index(),
   isSorted = $cell.hasClass('sorted'),
   dir = isSorted ? $cell.hasClass('asc') ? 'dsc':'asc' :'asc';
   
   $cell.removeClass('asc dsc').addClass('sorted '+ dir);  
  
   $th.not(this).removeClass('sorted asc dsc');  
 
  $rows.each(function() {
    var sortedCells = $(this).children('td').sort(rowCellSorter(rIdx, dir));
    $(this).append(sortedCells)
  });
});

function rowCellSorter(rIdx, dir) {
  var sortOrder = getSorterOrder(rIdx, dir);
  return function(a, b) {
    var aCol = $(a).data('col'),
      bCol = $(b).data('col')
    return sortOrder[aCol] - sortOrder[bCol]
  }
}

function getSorterOrder(rIdx, dir) {
  var dataRow = rowData[rIdx].slice().sort(dataRowSorter);
  
  if(dir === 'dsc'){
      dataRow.reverse()
  }
  // object with column num as keys, sort index as values
  return dataRow.reduce(function(a, c, i) {
    a[c.col] = i;
    return a;
  }, {});

}

function dataRowSorter(a, b) {
  if (isNaN(a.text)) { // text sort
    return a.text.localeCompare(b.text)
  } else { // num sort
    return a.text - b.text
  }
}
.asc:after{
  content:' > '
}

.dsc:after{
  content:' < '
}