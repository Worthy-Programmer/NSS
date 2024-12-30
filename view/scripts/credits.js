// Don't forget to include: TableRecords from "./TableRecords";
const tableRecords = new TableRecords('credits_sheet')

const selectAllBtn = document.getElementById('select_all_btn')
const deSelectAllBtn = document.getElementById('deselect_all_btn')

selectAllBtn.addEventListener('click', e => tableRecords.checkAllRecords()) // select all button 
deSelectAllBtn.addEventListener('click', e => tableRecords.deCheckAllRecords()) //  deselect all button 

// Atleast one record should be checked
tableRecords.table.addEventListener('change', e => {
  /** @type {HTMLInputElement} */
  const submitBtn = document.querySelector('#edit input[type="submit"]')
  submitBtn.disabled = !tableRecords.isAnythingChecked
})