import TableRecords from "./TableRecords.js"

const tableID = document.getElementsByClassName('table_records')[0].id
const tableRecords = new TableRecords(tableID)

const selectAllBtn = document.getElementById('select_all_btn')
const deSelectAllBtn = document.getElementById('deselect_all_btn')
const submitBtn = /** @type {HTMLInputElement} */ (document.querySelector('#edit input[type="submit"]'))
const deleteBtn = /** @type {HTMLButtonElement} */ (document.getElementById('delete_btn'))

tableRecords.setupEvents({selectAllBtn, deSelectAllBtn, deleteBtn, submitBtn})