// Class to create Objects to control the table records in Credits and Events
class TableRecords {
  #isCheckedFilterOn = false
  
  constructor(tableID) {
    this.tableID = tableID
    this.table = document.getElementById(tableID)
    this.checkBoxes = this.table.querySelectorAll('input[type="checkbox"]');
    console.log(this.checkBoxes)
  }

  get isAllChecked() {
    return this.table.querySelectorAll('input[type="checkbox"]:checked').length === this.checkBoxes.length
  }

  get isAnythingChecked() {
    return this.table.querySelectorAll('input[type="checkbox"]:checked').length > 0
  }

  checkAllRecords() {
    this.checkBoxes.forEach(checkbox => (checkbox.checked) ? null : checkbox.click());
  }

  deCheckAllRecords() {
    this.checkBoxes.forEach(checkbox => (!checkbox.checked) ? null : checkbox.click());
  }


  toggleCheckedFilter() {
    this.isCheckedFilterOn ? this.#removeCheckedFilter() : this.#addCheckedFilter()
    this.isCheckedFilterOn = !this.isCheckedFilterOn
  }

  #addCheckedFilter() {
    this.checkBoxes.forEach(checkbox => {
      if(checkbox.checked) return
      const trEl = checkbox.parentElement.parentElement
      trEl.style.display = 'none'
    })
  }

  #removeCheckedFilter() {
    this.checkBoxes.forEach(checkbox => {
      const trEl = checkbox.parentElement.parentElement
      trEl.style.display = 'block'
    })
  }
}